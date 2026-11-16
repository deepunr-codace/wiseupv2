/* Services mega menu: the panel hangs from the Services button on two rope cords (owner, 2026-11-03).
   On open it drops, bounces on the ropes and swings like a hanging sign until it settles (damped springs).
   The ropes are SVG paths redrawn every frame from the button to brass rings on the panel's top edge.
   Pointer movement over the panel gives it a small push. Reduced motion: ropes shown, no swinging. */
(function () {
  var item = document.querySelector('.hd__item--mega');
  if (!item) return;
  var wrap = item.querySelector('.hd__mega'), panel = item.querySelector('.mega'), btn = item.querySelector('.hd__link--parent');
  if (!wrap || !panel || !btn) return;
  var still = matchMedia('(prefers-reduced-motion: reduce)').matches;
  var NS = 'http://www.w3.org/2000/svg';
  var svg = document.createElementNS(NS, 'svg');
  svg.setAttribute('class', 'mega__ropes'); svg.setAttribute('aria-hidden', 'true');
  var mk = function (n, c, par) { var e = document.createElementNS(NS, n); if (c) e.setAttribute('class', c); (par || svg).appendChild(e); return e; };
  var defs = mk('defs');
  defs.innerHTML = '<radialGradient id="mg-brass" cx="35%" cy="30%" r="80%"><stop offset="0" stop-color="#f4e2a6"/><stop offset=".35" stop-color="#c9a24e"/><stop offset=".75" stop-color="#7d5f22"/><stop offset="1" stop-color="#4a3513"/></radialGradient>' +
    '<radialGradient id="mg-hole" cx="50%" cy="40%" r="60%"><stop offset="0" stop-color="#0b0804"/><stop offset=".7" stop-color="#1c140a"/><stop offset="1" stop-color="#3a2a12"/></radialGradient>';
  var ropes = [0, 1].map(function () {
    var g = mk('g');
    return {
      ring: mk('circle', 'mega__eye', g), hole: mk('circle', 'mega__hole', g),
      core: mk('path', 'mega__rope', g), sA: mk('path', 'mega__strand mega__strand--a', g), sB: mk('path', 'mega__strand mega__strand--b', g),
      sA2: mk('path', 'mega__strand mega__strand--a', g), hi: mk('path', 'mega__rope-hi', g), lip: mk('path', 'mega__lip', g)
    };
  });
  // points along a quadratic, offset sideways by a sine so two strands twist round each other
  var strand = function (P, ph, amp, per, only) {
    var d = '', pen = false, n = P.length;
    for (var i = 0; i < n; i++) {
      var q = P[i], s = Math.sin(q.l / per * 6.2832 + ph), vis = only === undefined ? true : (only ? s > 0 : s <= 0);
      if (vis) { d += (pen ? 'L' : 'M') + (q.x + q.nx * s * amp).toFixed(1) + ' ' + (q.y + q.ny * s * amp).toFixed(1); pen = true; } else pen = false;
    }
    return d;
  };
  wrap.insertBefore(svg, wrap.firstChild);

  var y = 0, vy = 0, a = 0, va = 0, raf = 0, last = 0, open = false;
  var draw = function () {
    // layout positions (untransformed): the panel's own offset inside the wrapper, the button relative to the wrapper
    var w = wrap.getBoundingClientRect(), bt = btn.getBoundingClientRect();
    var pl = panel.offsetLeft, pt = panel.offsetTop;
    var cx = bt.left + bt.width / 2 - w.left, top = bt.bottom - w.top - 6;   // anchors just under the button; also the swing pivot x
    svg.setAttribute('width', w.width); svg.setAttribute('height', Math.max(1, pt + y + 40));
    var rad = a * Math.PI / 180, spread = 74;
    ropes.forEach(function (r, i) {
      var s = i ? 1 : -1, ax = cx + s * 10, ay = top;
      var bx = cx + s * spread * Math.cos(rad), by = pt + y + 3 + s * spread * Math.sin(rad);  // ring on the panel top, after drop + swing
      var mx = (ax + bx) / 2 - a * 0.8, my = (ay + by) / 2 + 16;                                  // slight sag, trailing the swing
      var N = 64, P = [], len = 0, px = ax, py = ay;
      for (var k = 0; k <= N; k++) {
        var t = k / N, u = 1 - t, x = u * u * ax + 2 * u * t * mx + t * t * bx, yy = u * u * ay + 2 * u * t * my + t * t * by;
        var tx = 2 * u * (mx - ax) + 2 * t * (bx - mx), ty = 2 * u * (my - ay) + 2 * t * (by - my), tl = Math.hypot(tx, ty) || 1;
        if (k) len += Math.hypot(x - px, yy - py); px = x; py = yy;
        P.push({ x: x, y: yy, nx: -ty / tl, ny: tx / tl, l: len });
      }
      var d = strand(P, 0, 0, 1);
      r.core.setAttribute('d', d); r.hi.setAttribute('d', strand(P, 0, 0, 1));
      r.sA.setAttribute('d', strand(P, 0, 1.5, 13)); r.sB.setAttribute('d', strand(P, 3.1416, 1.5, 13));
      r.sA2.setAttribute('d', strand(P, 0, 1.5, 13, true));
      var ex = bx.toFixed(1), ey = (by + 2).toFixed(1);
      r.ring.setAttribute('cx', ex); r.ring.setAttribute('cy', ey); r.hole.setAttribute('cx', ex); r.hole.setAttribute('cy', ey);
      r.lip.setAttribute('d', 'M' + (bx - 6.6).toFixed(1) + ' ' + (by + 2.4).toFixed(1) + ' A6.6 6.6 0 0 0 ' + (bx + 6.6).toFixed(1) + ' ' + (by + 2.4).toFixed(1));
    });
    panel.style.transformOrigin = (cx - pl).toFixed(1) + 'px 0';
  };
  var tick = function (now) {
    var dt = last ? Math.min(.033, (now - last) / 1000) : .016; last = now;
    vy += (-170 * y - 9 * vy) * dt; y += vy * dt;          // bouncy drop
    va += (-38 * a - 3.2 * va) * dt; a += va * dt; if (a > 1.2) { a = 1.2; va = 0; } else if (a < -1.2) { a = -1.2; va = 0; } // gentle, capped          // slow, lightly damped swing
    panel.style.transform = 'translateY(' + y.toFixed(2) + 'px) rotate(' + a.toFixed(3) + 'deg)';
    draw();
    if (open && (Math.abs(y) > .05 || Math.abs(vy) > .05 || Math.abs(a) > .01 || Math.abs(va) > .01)) raf = requestAnimationFrame(tick);
    else { raf = 0; last = 0; if (!open) { panel.style.transform = ''; } else { y = a = vy = va = 0; panel.style.transform = 'none'; draw(); } }
  };
  var kick = function () { if (!raf) raf = requestAnimationFrame(tick); };
  var show = function () {
    if (open) return; open = true;
    if (still) { draw(); return; }
    y = -34; vy = 0; a = (Math.random() < .5 ? -1 : 1) * (.8 + Math.random() * .4); va = 0; kick();
  };
  var hide = function () { if (!item.matches(':hover') && !item.contains(document.activeElement)) open = false; };
  item.addEventListener('pointerenter', show);
  item.addEventListener('focusin', show);
  item.addEventListener('pointerleave', function () { setTimeout(hide, 0); });
  item.addEventListener('focusout', function () { setTimeout(hide, 0); });
  var lastX = null;
  panel.addEventListener('pointermove', function (e) {
    if (still || !open) return;
    if (lastX !== null) { va += Math.max(-1.2, Math.min(1.2, (e.clientX - lastX) * 0.04)); kick(); }
    lastX = e.clientX;
  });
  panel.addEventListener('pointerleave', function () { lastX = null; });
  addEventListener('resize', function () { if (open) draw(); });
})();
