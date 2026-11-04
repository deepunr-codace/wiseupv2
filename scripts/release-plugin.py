"""Release the live WordPress plugin: bump its version, build the upload zip.

Owner rule (2026-11-04): every plugin update gets a new version number.

    py -3 -I scripts/release-plugin.py            # 1.1.0 -> 1.1.1 (patch)
    py -3 -I scripts/release-plugin.py minor      # 1.1.1 -> 1.2.0
    py -3 -I scripts/release-plugin.py 2.0.0      # set exactly

Run from wiseup-site/. Updates the `Version:` header and WISEUP_VERSION in live-plugin/wiseup/wiseup.php, then writes
D:/projects/wiseup/wiseup-plugin/wiseup.zip with every entry under wiseup/ (so WordPress offers "Replace current with
uploaded" instead of installing a second copy). Backups (*.before-*) and stray zips are left out.
"""
import os
import re
import sys
import zipfile

HERE = os.path.dirname(os.path.abspath(__file__))
SRC = os.path.normpath(os.path.join(HERE, '..', 'live-plugin', 'wiseup'))
MAIN = os.path.join(SRC, 'wiseup.php')
OUT = os.path.normpath(os.path.join(HERE, '..', '..', 'wiseup-plugin', 'wiseup.zip'))


def bump(ver, how):
    if re.fullmatch(r'\d+\.\d+\.\d+', how or ''):
        return how
    major, minor, patch = (int(x) for x in ver.split('.'))
    if how == 'major':
        return f'{major + 1}.0.0'
    if how == 'minor':
        return f'{major}.{minor + 1}.0'
    return f'{major}.{minor}.{patch + 1}'


def main():
    how = sys.argv[1] if len(sys.argv) > 1 else 'patch'
    php = open(MAIN, encoding='utf-8').read()
    m = re.search(r"define\( 'WISEUP_VERSION', '(\d+\.\d+\.\d+)' \);", php)
    if not m:
        sys.exit('WISEUP_VERSION not found in wiseup.php')
    old = m.group(1)
    new = bump(old, how)
    php2 = re.sub(r"(\* Version:\s+)\d+\.\d+\.\d+", lambda x: x.group(1) + new, php, count=1)
    php2 = php2.replace(f"define( 'WISEUP_VERSION', '{old}' );", f"define( 'WISEUP_VERSION', '{new}' );", 1)
    if php2.count(new) < 2:
        sys.exit('could not update both the Version header and WISEUP_VERSION')
    open(MAIN, 'w', encoding='utf-8', newline='').write(php2)

    os.makedirs(os.path.dirname(OUT), exist_ok=True)
    n = 0
    with zipfile.ZipFile(OUT, 'w', zipfile.ZIP_DEFLATED) as z:
        for root, _dirs, files in os.walk(SRC):
            for f in files:
                if '.before-' in f or f.startswith('wiseup.zip') or f.endswith('.zip'):
                    continue
                full = os.path.join(root, f)
                z.write(full, 'wiseup/' + os.path.relpath(full, SRC).replace(os.sep, '/'))
                n += 1
    with zipfile.ZipFile(OUT) as z:
        tops = {name.split('/')[0] for name in z.namelist()}
    if tops != {'wiseup'}:
        sys.exit(f'zip has unexpected top-level entries: {tops}')
    print(f'Wiseup {old} -> {new}; {n} files -> {OUT}')


if __name__ == '__main__':
    main()
