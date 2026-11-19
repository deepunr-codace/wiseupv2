"""Paints the Media Buying hero background (road by Kerala paddy fields at dusk) as a textured raster.
Coordinates match the SVG viewBox 800x560 at 2x (1600x1120). Output: WebP for the plugin."""
import sys, math, random
import numpy as np
from PIL import Image, ImageDraw, ImageFilter

W, H = 1600, 1120
S = 2  # scale from viewBox units
rng = np.random.default_rng(7)
random.seed(7)

def noise(h, w, scale, octaves=4):
    out = np.zeros((h, w), np.float32)
    amp, tot = 1.0, 0.0
    for o in range(octaves):
        sh, sw = max(2, int(h / scale) + 2), max(2, int(w / scale) + 2)
        g = rng.random((sh, sw)).astype(np.float32)
        im = Image.fromarray((g * 255).astype(np.uint8)).resize((w, h), Image.BICUBIC)
        out += np.asarray(im, np.float32) / 255 * amp
        tot += amp; amp *= .5; scale /= 2
    return out / tot

img = np.zeros((H, W, 3), np.float32)
ys = np.arange(H)[:, None]

# sky: dusk, deep olive at top to warm lime haze at the horizon
top, hor = np.array([10, 13, 8]), np.array([58, 70, 28])
t = np.clip(ys / (262 * S), 0, 1) ** 1.6
img[:] = top * (1 - t)[..., None] + hor * t[..., None]
# sun glow
cx, cy = 330 * S, 120 * S
xx = np.arange(W)[None, :]
d = np.sqrt((xx - cx) ** 2 + (ys - cy) ** 2)
img += (np.exp(-(d / (150 * S)) ** 2) * 70)[..., None] * np.array([.75, .85, .32])
img += (d < 34 * S)[..., None] * (np.array([200, 222, 110]) - img) * .95
# sky grain
img += (noise(H, W, 40) - .5)[..., None] * 10

pil = Image.fromarray(np.clip(img, 0, 255).astype(np.uint8))
dr = ImageDraw.Draw(pil, 'RGBA')

# distant hills, two layers
for base, col, amp, seed in [(250, (24, 32, 16), 22, 1), (262, (17, 24, 11), 14, 2)]:
    r = random.Random(seed)
    pts = [(0, H)]
    ph = [r.random() * 6 for _ in range(3)]
    for x in range(0, W + 8, 8):
        y = base * S - amp * S * (.6 * math.sin(x / 260 + ph[0]) + .3 * math.sin(x / 110 + ph[1]) + .1 * math.sin(x / 40 + ph[2]))
        pts.append((x, y))
    pts.append((W, H))
    dr.polygon(pts, fill=col)

# coconut palms (silhouettes with drooping fronds)
def palm(x, y, h, lean, col):
    r = random.Random(int(x * 3 + y))
    tx, ty = x, y
    seg = 18
    top = None
    for i in range(seg):
        k = i / seg
        nx = x + lean * h * k * k
        ny = y - h * k
        w = (9 - 5 * k) * S * .9
        dr.line([(tx, ty), (nx, ny)], fill=col, width=int(w))
        tx, ty = nx, ny
    top = (tx, ty)
    for a in range(9):
        ang = -math.pi / 2 + (a - 4) * .42 + r.uniform(-.12, .12)
        L = h * r.uniform(.42, .58)
        pts = []
        for j in range(16):
            k = j / 15
            px = top[0] + math.cos(ang) * L * k
            py = top[1] + math.sin(ang) * L * k + (L * .55) * k * k * (1 if abs(math.cos(ang)) > .2 else .3)
            pts.append((px, py))
        for j in range(1, len(pts)):
            dr.line([pts[j - 1], pts[j]], fill=col, width=max(2, int((4.5 - 3 * j / 16) * S)))
            # leaflets
            if j % 2 == 0:
                lx, ly = pts[j]
                for sgn in (-1, 1):
                    dr.line([(lx, ly), (lx + sgn * 7 * S * (1 - j / 18), ly + 9 * S * (1 - j / 22))], fill=col, width=max(1, int(1.6 * S)))
for (x, y, h, lean, c) in [(60, 272, 150, .12, (20, 27, 13)), (128, 268, 120, -.1, (22, 30, 14)), (230, 266, 100, .08, (25, 33, 16)),
                           (300, 270, 158, -.14, (19, 26, 12)), (395, 266, 104, .1, (24, 32, 15)), (470, 264, 82, -.06, (27, 35, 17)),
                           (760, 268, 128, -.12, (20, 27, 13))]:
    palm(x * S, y * S, h * S, lean, c)

arr = np.asarray(pil, np.float32)

def field(y0, y1, base, light, rows, blade_len, density, seed):
    """paddy band: noisy green, horizontal planting rows, thousands of short blades"""
    h = (y1 - y0) * S
    n = noise(h, W, 30)
    band = base * (.82 + .3 * n)[..., None]
    yy = np.arange(h)[:, None]
    if rows:
        k = (y0 * S + yy - y0 * S) / max(1, h)
        period = 10 + 26 * k  # rows get wider toward the viewer
        rowmask = (np.sin(yy / period * 2 * math.pi) > .55)
        band = np.where(rowmask[..., None], band * 1.14, band)
    arr[y0 * S:y1 * S] = band
    im = Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8))
    d2 = ImageDraw.Draw(im, 'RGBA')
    r = random.Random(seed)
    for _ in range(density):
        x = r.uniform(0, W)
        y = r.uniform(y0 * S, y1 * S)
        k = (y - y0 * S) / max(1, h)
        L = blade_len * S * (.5 + k) * r.uniform(.6, 1.3)
        a = r.uniform(-.5, .5)
        c = tuple(int(v * r.uniform(.8, 1.35)) for v in light) + (r.randint(120, 230),)
        d2.line([(x, y), (x + math.sin(a) * L, y - math.cos(a) * L)], fill=c, width=max(1, int(S * (.6 + k))))
    return np.asarray(im, np.float32)

arr = field(262, 360, np.array([42, 58, 16]), (96, 128, 36), True, 5, 9000, 3)

# road: asphalt with aggregate grain, worn tyre tracks, edges, dashed centre line
y0, y1 = 360 * S, 436 * S
h = y1 - y0
grain = rng.normal(0, 1, (h, W)).astype(np.float32)
asph = 27 + 7 * (noise(h, W, 18) - .5) + 4 * grain
yy = np.arange(h)[:, None]
for c in (.3, .72):  # tyre tracks slightly darker and smoother
    asph -= 4 * np.exp(-((yy / h - c) / .08) ** 2)
speck = rng.random((h, W)) > .985
asph = np.where(speck, asph + 22, asph)
arr[y0:y1] = np.repeat(asph[..., None], 3, 2) * np.array([1, 1, 1.06])
im = Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8))
d3 = ImageDraw.Draw(im, 'RGBA')
d3.rectangle([0, y0, W, y0 + 3 * S], fill=(58, 58, 54, 255))
d3.rectangle([0, y1 - 4 * S, W, y1], fill=(46, 46, 44, 255))
for x in range(-40 * S, W, 48 * S):
    d3.rectangle([x, 396 * S, x + 26 * S, 400 * S], fill=(196, 196, 186, 150))
arr = np.asarray(im, np.float32)
# fade dash paint with grain
arr[392 * S:404 * S] *= (1 - .18 * rng.random((12 * S, W, 1)))

arr = field(436, 560, np.array([48, 70, 18]), (118, 154, 42), False, 16, 7000, 5)
# a few taller tufts in front
im = Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8))
d4 = ImageDraw.Draw(im, 'RGBA')
r = random.Random(11)
for _ in range(260):
    x = r.uniform(0, W); y = r.uniform(470 * S, 560 * S)
    for b in range(5):
        a = r.uniform(-.6, .6); L = r.uniform(22, 46) * S
        d4.line([(x, y), (x + math.sin(a) * L, y - math.cos(a) * L)], fill=(140, 176, 52, r.randint(150, 240)), width=int(1.6 * S))

# vignette
arr = np.asarray(im, np.float32)
vx = (np.arange(W) - W / 2) / (W / 2); vy = (np.arange(H) - H / 2) / (H / 2)
v = 1 - .28 * np.clip(vx[None, :] ** 2 + vy[:, None] ** 2 - .35, 0, 1)
arr *= v[..., None]
out = Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8)).filter(ImageFilter.UnsharpMask(1.2, 40, 2))
out.save(sys.argv[1], 'WEBP', quality=82, method=6)
out.resize((W // 2, H // 2), Image.LANCZOS).save(sys.argv[1].replace('.webp', '-sm.webp'), 'WEBP', quality=80, method=6)
print('ok')
