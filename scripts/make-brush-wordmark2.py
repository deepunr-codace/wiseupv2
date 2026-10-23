"""Traces the new brush "Wise Up" logo (brush2) into one SVG path per letter, same output contract as
make-brush-wordmark.py (id="hb-<letter>" per path, class hero-logo__ch) so it's a drop-in for heroType().

Input:  a white-on-black PNG of the logo (default: brush2-src.png next to this script's CWD).
Output: public/brand/hero-wiseup-brush2.svg

Unlike the original logo, this artwork's touching pairs (i|s, U|p) have no documented cut geometry, so
instead of hand-picked line equations the split is automatic: erode the merged blob until it breaks into
exactly two pieces (the thinnest neck gives first), then grow each piece back out to the full blob via
nearest-seed (watershed-style) assignment. Verified by eye against this specific source image.
"""
import sys, os
import numpy as np
from PIL import Image, ImageFilter
from scipy import ndimage as ndi

SRC = sys.argv[1] if len(sys.argv) > 1 else 'brush2-src.png'
S = 4
OUT = os.path.join(os.path.dirname(__file__), '..', 'public', 'brand')

im = Image.open(SRC).convert('L')
big = im.resize((im.width * S, im.height * S), Image.LANCZOS).filter(ImageFilter.GaussianBlur(S * 1.0))
mask = np.array(big) > 128
H, W = mask.shape
ys, xs = np.mgrid[0:H, 0:W]
X, Y = xs / S, ys / S

lab, n = ndi.label(mask)
objs = ndi.find_objects(lab)
sizes = ndi.sum(mask, lab, range(1, n + 1))
blobs = [(i + 1, int(sz), o) for i, (sz, o) in enumerate(zip(sizes, objs)) if sz > 2000 * S * S / 9]
blobs.sort(key=lambda b: -b[1])
blobs = blobs[:5]  # drop stray paint flecks below the five real letter blobs
assert len(blobs) == 5, f'unexpected blob layout: {len(blobs)} blobs'
b_Up = max(blobs, key=lambda b: b[1])[0]       # the biggest blob: U+p merged
b_dot = min(blobs, key=lambda b: b[1])[0]      # the smallest blob: the i dot
rest = sorted((b for b in blobs if b[0] not in (b_Up, b_dot)), key=lambda b: (b[2][1].start + b[2][1].stop) / 2)
b_W, b_is, b_e = (b[0] for b in rest)          # the other three, left to right: W, i+s merged, e

def split_two(blob_mask, min_size=400 * S * S / 9):
    for r in range(1, 80 * S // 4):
        er = ndi.binary_erosion(blob_mask, iterations=r)
        l2, n2 = ndi.label(er)
        if n2 == 0:
            continue
        sz = ndi.sum(er, l2, range(1, n2 + 1))
        big = [i + 1 for i, s in enumerate(sz) if s > min_size]
        if len(big) == 2:
            return np.where(np.isin(l2, big), l2, 0), big
        if len(big) > 2:
            raise RuntimeError(f'fragmented at r={r}: {len(big)} parts')
    raise RuntimeError('never split cleanly')

def propagate(blob_mask, seed):
    dist, inds = ndi.distance_transform_edt(seed == 0, return_indices=True)
    nearest = seed[tuple(inds)]
    return np.where(blob_mask, nearest, 0)

mask_is_blob = lab == b_is
seed_is, comps_is = split_two(mask_is_blob)
full_is = propagate(mask_is_blob, seed_is)
# left component (smaller x-centre) = i stem, right = s
cx = {c: np.mean(np.nonzero(full_is == c)[1]) for c in comps_is}
c_i, c_s = sorted(comps_is, key=lambda c: cx[c])

mask_Up_blob = lab == b_Up
seed_Up, comps_Up = split_two(mask_Up_blob)
full_Up = propagate(mask_Up_blob, seed_Up)
# U is the larger piece (keeps the shared stem), p the smaller bowl
sz_Up = {c: (full_Up == c).sum() for c in comps_Up}
c_U, c_p = sorted(comps_Up, key=lambda c: -sz_Up[c])

masks = {
    'w': lab == b_W,
    'i': full_is == c_i,
    's': full_is == c_s,
    'e': lab == b_e,
    'u': full_Up == c_U,
    'p': full_Up == c_p,
}

OVERLAP = 12
snap = {k: v.copy() for k, v in masks.items()}
for a, b in (('i', 's'), ('s', 'i'), ('u', 'p'), ('p', 'u')):
    near = ndi.distance_transform_edt(~snap[a]) <= OVERLAP * S
    masks[a] = masks[a] | (snap[b] & near)

used = np.zeros_like(mask)
for m in masks.values():
    used |= m
rest, rn = ndi.label(mask & ~used)
centres = {k: np.mean(np.nonzero(m)[1]) / S for k, m in masks.items()}
for r in range(1, rn + 1):
    rm = rest == r
    if rm.sum() < 40:
        continue
    cxr = np.mean(np.nonzero(rm)[1]) / S
    masks[min(centres, key=lambda k: abs(centres[k] - cxr))] |= rm

def smooth(m, sigma=9.5 * S, thr=0.5):
    yy, xx = np.nonzero(m)
    pad = int(sigma * 3)
    y0, y1 = max(0, yy.min() - pad), min(m.shape[0], yy.max() + pad + 1)
    x0, x1 = max(0, xx.min() - pad), min(m.shape[1], xx.max() + pad + 1)
    out = np.zeros_like(m)
    out[y0:y1, x0:x1] = ndi.gaussian_filter(m[y0:y1, x0:x1].astype(np.float32), sigma) > thr
    lab2, n2 = ndi.label(out)
    if n2 > 1:
        sizes2 = ndi.sum(out, lab2, range(1, n2 + 1))
        out = np.isin(lab2, [i + 1 for i, v in enumerate(sizes2) if v > 0.02 * sizes2.max()])
    return out

def trace(m, sigma=55.0, step=14, min_area=3500):
    import cv2
    from scipy.ndimage import gaussian_filter1d
    yy, xx = np.nonzero(m)
    y0, x0 = yy.min() - 6, xx.min() - 6
    crop = np.pad(m[max(y0, 0):yy.max() + 7, max(x0, 0):xx.max() + 7].astype(np.uint8) * 255, 6)
    y0, x0 = max(y0, 0) - 6, max(x0, 0) - 6
    cs, hier = cv2.findContours(crop, cv2.RETR_CCOMP, cv2.CHAIN_APPROX_NONE)
    f = lambda v: f'{v:.1f}'
    parts = []
    for c, h in zip(cs, hier[0]):
        pts = c[:, 0, :].astype(np.float64)
        if cv2.contourArea(c) < min_area or len(pts) < 40:
            continue
        sm = np.stack([gaussian_filter1d(pts[:, 0], sigma, mode='wrap'), gaussian_filter1d(pts[:, 1], sigma, mode='wrap')], 1)
        area = 0.5 * np.sum(sm[:, 0] * np.roll(sm[:, 1], -1) - np.roll(sm[:, 0], -1) * sm[:, 1])
        outer = h[3] < 0
        if (area > 0) != outer:
            sm = sm[::-1]
        k = sm[::step]
        n = len(k)
        if n < 4:
            continue
        P = lambda i: k[i % n]
        parts.append(f'M{f((P(0)[0] + x0) / S)} {f((P(0)[1] + y0) / S)}')
        for i in range(n):
            p0, p1, p2, p3 = P(i - 1), P(i), P(i + 1), P(i + 2)
            c1 = p1 + (p2 - p0) / 6
            c2 = p2 - (p3 - p1) / 6
            parts.append(f'C{f((c1[0] + x0) / S)} {f((c1[1] + y0) / S)} {f((c2[0] + x0) / S)} {f((c2[1] + y0) / S)} {f((p2[0] + x0) / S)} {f((p2[1] + y0) / S)}')
        parts.append('Z')
    return ''.join(parts)

order = ['w', 'i', 's', 'e', 'u', 'p']
masks = {k: smooth(masks[k]) for k in order}
paths = {k: trace(masks[k]) for k in order}
boxes = {}
for k in order:
    yy, xx = np.nonzero(masks[k])
    boxes[k] = (xx.min() / S, yy.min() / S, xx.max() / S, yy.max() / S)

pad = 12
x1 = min(b[0] for b in boxes.values()) - pad; y1 = min(b[1] for b in boxes.values()) - pad
x2 = max(b[2] for b in boxes.values()) + pad; y2 = max(b[3] for b in boxes.values()) + pad
w, h = x2 - x1, y2 - y1

os.makedirs(os.path.join(OUT, 'letters2'), exist_ok=True)
body = '\n'.join(f'<path id="hb-{k}" class="hero-logo__ch" data-ch="{k}" d="{paths[k]}"/>' for k in order)
sheen = '\n'.join(f'<use href="#hb-{k}"/>' for k in order)
svg = f'''<svg class="hero__logo hero-logo hero-logo--brush" width="{w:.0f}" height="{h:.0f}" viewBox="{x1:.2f} {y1:.2f} {w:.2f} {h:.2f}" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="WiseUp">
<title>WiseUp</title>
<defs>
<linearGradient id="hero-logo-sheen" x1="{x1 - w * 0.3:.1f}" y1="0" x2="{x1:.1f}" y2="0" gradientUnits="userSpaceOnUse">
<stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="0.5" stop-color="#fff" stop-opacity="0.95"/><stop offset="1" stop-color="#fff" stop-opacity="0"/>
</linearGradient>
</defs>
<g class="hero-logo__chars" fill="#ffffff" fill-rule="nonzero">
{body}
</g>
<g class="hero-logo__sheen" fill="url(#hero-logo-sheen)" aria-hidden="true">
{sheen}
</g>
</svg>
'''
open(os.path.join(OUT, 'hero-wiseup-brush2.svg'), 'w').write(svg)
for k in order:
    bx1, by1, bx2, by2 = boxes[k]
    lw, lh = bx2 - bx1 + 2 * pad, by2 - by1 + 2 * pad
    open(os.path.join(OUT, 'letters2', f'{k}.svg'), 'w').write(
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="{bx1 - pad:.2f} {by1 - pad:.2f} {lw:.2f} {lh:.2f}" width="{lw:.0f}" height="{lh:.0f}" role="img" aria-label="{k}">'
        f'<path fill="#ffffff" d="{paths[k]}"/></svg>\n')
print({k: len(v) for k, v in paths.items()}, round(w), round(h))
