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
  var ropes = [0, 1].map(function () {
    var g = document.createElementNS(NS, 'g');
    var base = document.createElementNS(NS, 'path'), twist = document.createElementNS(NS, 'path'), ring = document.createElementNS(NS, 'circle');
    base.setAttribute('class', 'mega__rope'); twist.setAttribute('class', 'mega__rope-twist'); ring.setAttribute('class', 'mega__ring'); ring.setAttribute('r', '5');
    g.appendChild(base); g.appendChild(twist); g.appendChild(ring); svg.appendChild(g);
    return { base: base, twist: twist, ring: ring };
  });
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
      var mx = (ax + bx) / 2 - a * 0.8, my = (ay + by) / 2 + 7;                                  // slight sag, trailing the swing
      var d = 'M' + ax.toFixed(1) + ' ' + ay.toFixed(1) + ' Q' + mx.toFixed(1) + ' ' + my.toFixed(1) + ' ' + bx.toFixed(1) + ' ' + by.toFixed(1);
      r.base.setAttribute('d', d); r.twist.setAttribute('d', d);
      r.ring.setAttribute('cx', bx.toFixed(1)); r.ring.setAttribute('cy', (by + 2).toFixed(1));
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
