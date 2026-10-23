#!/usr/bin/env python3
"""Refresh the podcast page's Latest Episodes from the WiseUp Podcast YouTube channel.

Reads the channel's long-form uploads feed (playlist UULF..., Shorts excluded), cleans each title, saves the
thumbnail to public/podcast/ep/<id>.webp (640x360) and <id>-sm.webp (360x203), and writes src/data/episodes.json
(newest first), plus the most-viewed Shorts to src/data/shorts.json (vertical thumbs in public/podcast/shorts).
Like counts come from the feed's media:starRating. Run:  python3 scripts/fetch-episodes.py   (needs Pillow)."""
import html, io, json, re, urllib.request
from pathlib import Path
from PIL import Image

CHANNEL = 'UCIHnTsb0TL3SRnWYorgcdpw'
FEED = f'https://www.youtube.com/feeds/videos.xml?playlist_id=UULF{CHANNEL[2:]}'
SHORTS_FEED = f'https://www.youtube.com/feeds/videos.xml?playlist_id=UUSH{CHANNEL[2:]}'
ROOT = Path(__file__).resolve().parent.parent
OUT_IMG = ROOT / 'public/podcast/ep'
OUT_JSON = ROOT / 'src/data/episodes.json'
OUT_SHORTS = ROOT / 'public/podcast/shorts'
OUT_SHORTS_JSON = ROOT / 'src/data/shorts.json'
BRAND = re.compile(r'^(wise ?up( podcast)?|malayalam busines+ podcast|malayalam podcast|startup & business strategy podcast)$', re.I)

def get(url):
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, timeout=30) as r:
        return r.read()

def split_title(raw):
    parts = [p.strip() for p in re.split(r'\s*\|\s*', html.unescape(raw)) if p.strip()]
    parts = [p for p in parts if not BRAND.match(p)]
    title, rest = parts[0], parts[1:]
    tag = ' · '.join(rest[:2])
    return title, tag

def thumb(vid):
    for name in ('maxresdefault', 'sddefault', 'hqdefault'):
        try:
            im = Image.open(io.BytesIO(get(f'https://i.ytimg.com/vi/{vid}/{name}.jpg'))).convert('RGB')
        except Exception:
            continue
        w, h = im.size
        th = round(w * 9 / 16)  # crop the 4:3 letterbox variants to 16:9
        if th < h:
            top = (h - th) // 2
            im = im.crop((0, top, w, top + th))
        return im
    return None

def main():
    xml = get(FEED).decode('utf-8')
    OUT_IMG.mkdir(parents=True, exist_ok=True)
    eps = []
    for e in re.findall(r'<entry>(.*?)</entry>', xml, re.S):
        vid = re.search(r'<yt:videoId>(.*?)<', e).group(1)
        title, tag = split_title(re.search(r'<title>(.*?)</title>', e).group(1))
        views = int((re.search(r'views="(\d+)"', e) or [0, 0])[1])
        likes = int((re.search(r'starRating count="(\d+)"', e) or [0, 0])[1])
        date = re.search(r'<published>(.*?)<', e).group(1)[:10]
        im = thumb(vid)
        if not im:
            continue
        im.resize((640, 360), Image.LANCZOS).save(OUT_IMG / f'{vid}.webp', quality=80, method=6)
        im.resize((360, 203), Image.LANCZOS).save(OUT_IMG / f'{vid}-sm.webp', quality=78, method=6)
        eps.append({'videoId': vid, 'title': title, 'tag': tag, 'views': views, 'likes': likes, 'date': date,
                    'img': f'/podcast/ep/{vid}.webp'})
    OUT_JSON.write_text(json.dumps(eps, ensure_ascii=False, indent=2) + '\n')
    print(f'{len(eps)} episodes -> {OUT_JSON.relative_to(ROOT)}')

    # Shorts: keep the 10 most viewed, with a vertical (9:16) thumbnail
    xml = get(SHORTS_FEED).decode('utf-8')
    OUT_SHORTS.mkdir(parents=True, exist_ok=True)
    shorts = []
    for e in re.findall(r'<entry>(.*?)</entry>', xml, re.S):
        vid = re.search(r'<yt:videoId>(.*?)<', e).group(1)
        title, _ = split_title(re.search(r'<title>(.*?)</title>', e).group(1))
        views = int((re.search(r'views="(\d+)"', e) or [0, 0])[1])
        likes = int((re.search(r'starRating count="(\d+)"', e) or [0, 0])[1])
        shorts.append({'videoId': vid, 'title': title, 'views': views, 'likes': likes, 'img': f'/podcast/shorts/{vid}.webp'})
    shorts = sorted(shorts, key=lambda x: -x['views'])[:10]
    for sh in shorts:
        try:
            im = Image.open(io.BytesIO(get(f"https://i.ytimg.com/vi/{sh['videoId']}/oar2.jpg"))).convert('RGB')
        except Exception:
            im = thumb(sh['videoId'])
        im.resize((216, 384), Image.LANCZOS).save(OUT_SHORTS / f"{sh['videoId']}.webp", quality=78, method=6)
    OUT_SHORTS_JSON.write_text(json.dumps(shorts, ensure_ascii=False, indent=2) + '\n')
    print(f'{len(shorts)} shorts -> {OUT_SHORTS_JSON.relative_to(ROOT)}')

if __name__ == '__main__':
    main()
