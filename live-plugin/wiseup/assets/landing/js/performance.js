/*!
 * WiseUp Performance Marketing landing page: behaviour layer
 * Plain JavaScript, no dependencies. Config comes from window.WU_CFG (set by the page template):
 *   { ajaxUrl, assets, leadEndpoint, smoothScroll }
 */
(function () {
  var CFG = window.WU_CFG || {};
  var ASSETS = CFG.assets || '';
  var DATA = {"proj":[{"name":"Smoke House","img":"assets/case-smokehouse.jpg","rows":[{"k":"Objective","v":"Increase table bookings and online orders from nearby customers."},{"k":"WiseUp’s role","v":"Campaign strategy, ad creatives, conversion tracking and monthly optimisation."},{"k":"Channels","v":"Google Search Ads, Meta Ads, Remarketing"},{"k":"Period","v":"Jan – Jun 2026 (6 months)"},{"k":"Outcome","v":"Booking enquiries up 2.4x with cost per enquiry down 38%."}],"before":[{"k":"Clicks","v":"168","bg":"#3B6CF6","fg":"#fff"},{"k":"Cost","v":"₹6,070","bg":"#E8453C","fg":"#fff"},{"k":"Avg. CPC","v":"₹36.1","bg":"#F9AB2B","fg":"#1a1a1a"},{"k":"Conversions","v":"12","bg":"#2FA058","fg":"#fff"}],"after":[{"k":"Clicks","v":"338","bg":"#3B6CF6","fg":"#fff"},{"k":"Cost","v":"₹9,230","bg":"#E8453C","fg":"#fff"},{"k":"Avg. CPC","v":"₹22.7","bg":"#F9AB2B","fg":"#1a1a1a"},{"k":"Conversions","v":"41","bg":"#2FA058","fg":"#fff"}],"pb":"Jan 2026","pa":"Jun 2026"},{"name":"Bootland","img":"assets/case-bootland.jpg","rows":[{"k":"Objective","v":"Drive qualified store visits and product enquiries."},{"k":"WiseUp’s role","v":"Search and Shopping campaigns, audience research and landing page improvements."},{"k":"Channels","v":"Google Search, Shopping, Performance Max"},{"k":"Period","v":"Mar – Aug 2026 (6 months)"},{"k":"Outcome","v":"Online sales up 1.9x with ROAS improving from 2.1x to 3.8x."}],"before":[{"k":"Clicks","v":"214","bg":"#3B6CF6","fg":"#fff"},{"k":"Cost","v":"₹7,800","bg":"#E8453C","fg":"#fff"},{"k":"Avg. CPC","v":"₹36.4","bg":"#F9AB2B","fg":"#1a1a1a"},{"k":"Conversions","v":"9","bg":"#2FA058","fg":"#fff"}],"after":[{"k":"Clicks","v":"402","bg":"#3B6CF6","fg":"#fff"},{"k":"Cost","v":"₹10,150","bg":"#E8453C","fg":"#fff"},{"k":"Avg. CPC","v":"₹25.2","bg":"#F9AB2B","fg":"#1a1a1a"},{"k":"Conversions","v":"33","bg":"#2FA058","fg":"#fff"}],"pb":"Mar 2026","pa":"Aug 2026"},{"name":"Indus Go","img":"assets/case-indusgo.jpg","rows":[{"k":"Objective","v":"Generate qualified B2B leads and demo requests."},{"k":"WiseUp’s role","v":"LinkedIn and Google campaigns, lead form setup and CRM-linked reporting."},{"k":"Channels","v":"LinkedIn Ads, Google Search, Remarketing"},{"k":"Period","v":"Apr – Sep 2026 (5 months)"},{"k":"Outcome","v":"Qualified leads up 2.1x with cost per lead down 31%."}],"before":[{"k":"Clicks","v":"96","bg":"#3B6CF6","fg":"#fff"},{"k":"Cost","v":"₹5,400","bg":"#E8453C","fg":"#fff"},{"k":"Avg. CPC","v":"₹56.2","bg":"#F9AB2B","fg":"#1a1a1a"},{"k":"Conversions","v":"4","bg":"#2FA058","fg":"#fff"}],"after":[{"k":"Clicks","v":"187","bg":"#3B6CF6","fg":"#fff"},{"k":"Cost","v":"₹7,900","bg":"#E8453C","fg":"#fff"},{"k":"Avg. CPC","v":"₹42.2","bg":"#F9AB2B","fg":"#1a1a1a"},{"k":"Conversions","v":"15","bg":"#2FA058","fg":"#fff"}],"pb":"Apr 2026","pa":"Sep 2026"}],"testi":[{"text":"WiseUp rebuilt our campaigns around qualified enquiries instead of clicks. Within a few months our cost per lead dropped and the quality of calls improved, and we finally know which ads are actually bringing in customers.","name":"Rahul Menon","meta":"Marketing Head, Smoke House · Google Ads & Meta Ads · 6 months"},{"text":"Our online sales had plateaued. The team fixed our tracking, restructured our Shopping campaigns and gave us clear monthly reports. Return on ad spend has been climbing steadily ever since.","name":"Anjali Nair","meta":"E-commerce Manager, Bootland · Google Shopping & Performance Max · 6 months"},{"text":"We needed demo requests from the right companies, not just form fills. WiseUp’s LinkedIn and Google campaigns brought in qualified leads, and the reporting tied every lead back to the campaign that produced it.","name":"Faisal Rahman","meta":"Director, Indus Go · LinkedIn Ads & Google Search · 5 months"}]};

  /* ---------- validation + lead sending (same rules as the SEO page and the server) ---------- */
  class Leads {
    lead = {};
    spam = false;
    tForm = 0;
    sid = (function () { try { var k = sessionStorage.getItem('wu_sid'); if (!k) { k = Math.random().toString(36).slice(2) + Date.now().toString(36); sessionStorage.setItem('wu_sid', k); } return k; } catch (e) { return Math.random().toString(36).slice(2); } })();

      DISPOSABLE = new Set(['mailinator.com', 'guerrillamail.com', 'guerrillamail.net', '10minutemail.com', 'tempmail.com', 'temp-mail.org', 'yopmail.com', 'trashmail.com', 'sharklasers.com', 'getnada.com', 'dispostable.com', 'maildrop.cc', 'throwawaymail.com', 'fakeinbox.com', 'mailnesia.com', 'mohmal.com', 'emailondeck.com', 'burnermail.io', 'spamgourmet.com', 'tempail.com', 'mintemail.com', 'moakt.com', 'tmpmail.org', 'discard.email', 'mailcatch.com']);

  BAD_WORDS = /^(test|testing|tester|asdf|asdfgh|qwerty|qwe|abc|abcd|xyz|fake|demo|name|admin|user|none|null|na|nil|nothing|hello|hi|sample|dummy|company|business|noname)$/i;

  digits(v) { return String(v || '').replace(/\D/g, '').replace(/^(91|0)(?=\d{10}$)/, ''); }
  mash(t) {
    t = String(t || '').toLowerCase();
    if (!/^[a-z]+$/.test(t)) return false;
    if (t.length >= 5 && !/[aeiouy]/.test(t)) return true;
    return /(asdf|qwer|zxcv|sdfg|dfgh|hjkl|ghjk|wert|erty|rtyu|tyui|yuio|uiop|xcvb|cvbn|vbnm)/.test(t);
  }

  mash(t) {
    t = String(t || '').toLowerCase();
    if (!/^[a-z]+$/.test(t)) return false;
    if (t.length >= 5 && !/[aeiouy]/.test(t)) return true;
    return /(asdf|qwer|zxcv|sdfg|dfgh|hjkl|ghjk|wert|erty|rtyu|tyui|yuio|uiop|xcvb|cvbn|vbnm)/.test(t);
  }

  parsePhone(raw, cc, label) {
    raw = String(raw || '').trim();
    let d = raw.replace(/\D/g, ''), cd = String(cc || '+91').replace(/\D/g, '');
    if (!d) return { err: 'Please enter your ' + label + '.' };
    if (raw[0] === '+') { if (/^91\d{10}$/.test(d)) { cd = '91'; d = d.slice(2); } else cd = ''; }
    else if (!/^\d{1,4}$/.test(cd)) return { err: 'Enter a valid country code.' };
    if (cd === '91') {
      d = d.replace(/^(91|0)(?=\d{10}$)/, '');
      if (!/^[6-9]\d{9}$/.test(d)) return { err: 'Enter a valid 10-digit ' + label + '.' };
    } else {
      if (cd) d = d.replace(/^0+/, '');
      if (d.length < 6 || (cd + d).length > 15) return { err: 'Enter a valid ' + label + '.' };
    }
    if (/^(\d)\1+$/.test(d) || /^(\d\d)\1{2,}$/.test(d) || /^(\d{5})\1$/.test(d) || '01234567890123456789'.includes(d) || '98765432109876543210'.includes(d)) return { err: 'That ' + label + " doesn't look real." };
    return { e164: '+' + cd + d, national: d, cc: cd };
  }

  cleanCc(v) { return '+' + String(v || '').replace(/\D/g, '').slice(0, 4); }
  vPhone(raw, label, cc) { return this.parsePhone(raw, cc, label).err || ''; }
  vEmail(v) {
    v = String(v || '').trim().toLowerCase();
    if (!v) return 'Please enter your email address.';
    if (v.length > 254 || /\.\./.test(v) || !/^[a-z0-9._%+-]{2,64}@([a-z0-9-]+\.)+[a-z]{2,24}$/.test(v)) return 'Enter a valid email address.';
    const l = v.split('@')[0], d = v.split('@')[1];
    if (this.DISPOSABLE.has(d) || /^(example|test|fake|invalid|localhost|domain|sample|email|mail)\./.test(d)) return 'Please use your real email address.';
    if (/^(test|testing|asdf|asdfgh|qwerty|abc|abcd|xyz|fake|demo|noreply|none|null|na|nil|sample|dummy|email|mail|user|admin|name)\d*$/.test(l) || /^(.)\1+$/.test(l.replace(/[^a-z0-9]/g, '')) || this.mash(l.replace(/[^a-z]/g, ''))) return 'Please use your real email address.';
    return '';
  }

  vPhone(raw, label, cc) { return this.parsePhone(raw, cc, label).err || ''; }
  vEmail(v) {
    v = String(v || '').trim().toLowerCase();
    if (!v) return 'Please enter your email address.';
    if (v.length > 254 || /\.\./.test(v) || !/^[a-z0-9._%+-]{2,64}@([a-z0-9-]+\.)+[a-z]{2,24}$/.test(v)) return 'Enter a valid email address.';
    const l = v.split('@')[0], d = v.split('@')[1];
    if (this.DISPOSABLE.has(d) || /^(example|test|fake|invalid|localhost|domain|sample|email|mail)\./.test(d)) return 'Please use your real email address.';
    if (/^(test|testing|asdf|asdfgh|qwerty|abc|abcd|xyz|fake|demo|noreply|none|null|na|nil|sample|dummy|email|mail|user|admin|name)\d*$/.test(l) || /^(.)\1+$/.test(l.replace(/[^a-z0-9]/g, '')) || this.mash(l.replace(/[^a-z]/g, ''))) return 'Please use your real email address.';
    return '';
  }

  vEmail(v) {
    v = String(v || '').trim().toLowerCase();
    if (!v) return 'Please enter your email address.';
    if (v.length > 254 || /\.\./.test(v) || !/^[a-z0-9._%+-]{2,64}@([a-z0-9-]+\.)+[a-z]{2,24}$/.test(v)) return 'Enter a valid email address.';
    const l = v.split('@')[0], d = v.split('@')[1];
    if (this.DISPOSABLE.has(d) || /^(example|test|fake|invalid|localhost|domain|sample|email|mail)\./.test(d)) return 'Please use your real email address.';
    if (/^(test|testing|asdf|asdfgh|qwerty|abc|abcd|xyz|fake|demo|noreply|none|null|na|nil|sample|dummy|email|mail|user|admin|name)\d*$/.test(l) || /^(.)\1+$/.test(l.replace(/[^a-z0-9]/g, '')) || this.mash(l.replace(/[^a-z]/g, ''))) return 'Please use your real email address.';
    return '';
  }

  vName(v) {
    v = String(v || '').trim().replace(/\s+/g, ' ');
    if (!v) return 'Please enter your name.';
    if (v.length < 2 || v.length > 60 || !/^[\p{L}][\p{L} .'’-]*$/u.test(v)) return 'Please enter your real name (letters only).';
    const letters = v.replace(/[^\p{L}]/gu, '');
    if (letters.length < 2 || /(.)\1{3,}/iu.test(letters) || this.BAD_WORDS.test(v) || v.split(' ').some(w => this.mash(w))) return 'Please enter your real name.';
    return '';
  }

  vCompany(v) {
    v = String(v || '').trim().replace(/\s+/g, ' ');
    if (!v) return '';
    if (v.length < 2 || v.length > 80 || !/[\p{L}\d]{2,}/u.test(v) || this.BAD_WORDS.test(v) || /(.)\1{4,}/u.test(v)) return 'Please enter a valid company name.';
    return '';
  }

  vHost(h) {
    const msg = "That doesn't look like a real website. Try something like yourbrand.com";
    if (!h || h.length > 253 || /^\d+(\.\d+){3}$/.test(h)) return msg;
    const parts = h.split('.');
    if (parts.length < 2 || !parts.every(p => /^[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?$/i.test(p))) return msg;
    if (!/^([a-z]{2,24}|xn--[a-z0-9-]{2,})$/i.test(parts[parts.length - 1])) return msg;
    if (/^(localhost|(www\.)?(example|test|domain|yourdomain|yoursite|yourwebsite|website|sample|abc|xyz|asdf)\.(com|org|net|in|co|co\.in))$/i.test(h)) return msg;
    return '';
  }

  rate(key, max, windowMs) {
    try {
      const now = Date.now(), a = JSON.parse(localStorage.getItem(key) || '[]').filter(t => now - t < windowMs);
      if (a.length >= max) return false;
      a.push(now); localStorage.setItem(key, JSON.stringify(a));
    } catch (e) {}
    return true;
  }

  tooFast() { return Date.now() - (this.tForm || 0) < 2000; }
  normUrl(raw) {
    let u = String(raw || '').trim().replace(/^\s+|\s+$/g, '');
    if (!/^https?:\/\//i.test(u)) u = 'https://' + u;
    try { return new URL(u).hostname.replace(/^www\./, '') || null; } catch (e) { return null; }
  }

  normUrl(raw) {
    let u = String(raw || '').trim().replace(/^\s+|\s+$/g, '');
    if (!/^https?:\/\//i.test(u)) u = 'https://' + u;
    try { return new URL(u).hostname.replace(/^www\./, '') || null; } catch (e) { return null; }
  }


    sendLead(stage, extra) {
      if (this.spam) return;
      const L = this.lead;
      const payload = Object.assign({
        sid: this.sid, stage, website: '', name: L.name || '', company: L.company || '', contact: L.contact || '', email: L.email || '', phone: L.phone || '',
        score: null, source: 'performance-marketing', page: location.href, at: new Date().toISOString()
      }, extra || {});
      const body = JSON.stringify(payload);
      if (CFG.ajaxUrl) {
        try { fetch(CFG.ajaxUrl + (CFG.ajaxUrl.indexOf('?') > -1 ? '&' : '?') + 'action=wiseup_lead', { method: 'POST', keepalive: true, credentials: 'same-origin', headers: { 'Content-Type': 'text/plain' }, body }).catch(() => {}); } catch (e) {}
      } else if (CFG.leadEndpoint) {
        try { fetch(CFG.leadEndpoint, { method: 'POST', mode: 'no-cors', keepalive: true, headers: { 'Content-Type': 'text/plain' }, body }).catch(() => {}); } catch (e) {}
      }
    }
  }
  var leads = new Leads();

  function ready(fn) { if (document.readyState !== 'loading') fn(); else document.addEventListener('DOMContentLoaded', fn); }

  ready(function () {
    var root = document.querySelector('[data-root]');
    if (!root) return;
    leads.tForm = Date.now();
    var still = matchMedia('(prefers-reduced-motion: reduce)').matches;
    var anims = [];

    /* ----- looping decorative animations ----- */
    root.querySelectorAll('[data-marquee]').forEach(function (el) {
      var rev = el.dataset.marquee === 'rev';
      var a = el.animate([{ transform: 'translateX(' + (rev ? -50 : 0) + '%)' }, { transform: 'translateX(' + (rev ? 0 : -50) + '%)' }], { duration: +el.dataset.speed || 40000, iterations: Infinity });
      el.addEventListener('mouseenter', function () { a.pause(); });
      el.addEventListener('mouseleave', function () { a.play(); });
      anims.push(a);
    });
    root.querySelectorAll('[data-blob]').forEach(function (el, i) {
      anims.push(el.animate([{ transform: 'translate(0,0) scale(1)' }, { transform: 'translate(' + (i % 2 ? -8 : 10) + 'vw,' + (i % 3 ? 6 : -6) + 'vw) scale(1.15)' }], { duration: 14000 + i * 3000, iterations: Infinity, direction: 'alternate', easing: 'ease-in-out' }));
    });
    if (!still) {
      var od = { outer: 90000, inner: 70000 }, orb = [];
      root.querySelectorAll('[data-orbit]').forEach(function (el) { var k = el.dataset.orbit, dir = k === 'inner' ? -1 : 1; orb.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(' + 360 * dir + 'deg)' }], { duration: od[k], iterations: Infinity })); });
      root.querySelectorAll('[data-counter]').forEach(function (el) { var k = el.dataset.counter, dir = k === 'inner' ? 1 : -1; orb.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(' + 360 * dir + 'deg)' }], { duration: od[k], iterations: Infinity })); });
      var w = root.querySelector('[data-orbitwrap]');
      if (w) { w.addEventListener('mouseenter', function () { orb.forEach(function (a) { a.pause(); }); }); w.addEventListener('mouseleave', function () { orb.forEach(function (a) { a.play(); }); }); }
      anims.push.apply(anims, orb);
      root.querySelectorAll('[data-bar]').forEach(function (el, i) { el.animate([{ transform: 'scaleY(0.05)' }, { transform: 'scaleY(1)' }], { duration: 900, delay: 500 + i * 70, easing: 'cubic-bezier(.2,.8,.2,1)', fill: 'backwards' }); });
      root.querySelectorAll('[data-barw]').forEach(function (el, i) { el.animate([{ transform: 'scaleX(0)' }, { transform: 'scaleX(1)' }], { duration: 1100, delay: 900 + i * 120, easing: 'cubic-bezier(.2,.8,.2,1)', fill: 'backwards' }); });
    }
    root.querySelectorAll('[data-spinfast]').forEach(function (el) { anims.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(360deg)' }], { duration: 5000, iterations: Infinity })); });
    root.querySelectorAll('[data-pulse]').forEach(function (el) { anims.push(el.animate([{ transform: 'scale(1)', opacity: .9 }, { transform: 'scale(1.55)', opacity: 0 }], { duration: 2000, iterations: Infinity, easing: 'cubic-bezier(.2,.7,.2,1)' })); });
    root.querySelectorAll('[data-blink]').forEach(function (el) { anims.push(el.animate([{ opacity: 1 }, { opacity: .25 }], { duration: 900, iterations: Infinity, direction: 'alternate' })); });
    root.querySelectorAll('[data-spin]').forEach(function (el) { anims.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(360deg)' }], { duration: 60000, iterations: Infinity })); });
    if (!still) {
      root.querySelectorAll('[data-word]').forEach(function (w, i) { w.animate([{ opacity: 0, transform: 'translateY(0.45em) rotate(2deg)', filter: 'blur(8px)' }, { opacity: 1, transform: 'none', filter: 'blur(0)' }], { duration: 900, delay: 120 + i * 110, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'backwards' }); });
      root.querySelectorAll('[data-shine]').forEach(function (el) { anims.push(el.animate([{ backgroundPosition: '100% 0' }, { backgroundPosition: '-150% 0' }], { duration: 4200, delay: 1400, iterations: Infinity, easing: 'ease-in-out' })); });
      root.querySelectorAll('[data-cue]').forEach(function (el) { anims.push(el.animate([{ transform: 'translateY(0)', opacity: 1 }, { transform: 'translateY(12px)', opacity: 0 }], { duration: 1600, iterations: Infinity, easing: 'cubic-bezier(.5,0,.5,1)' })); });
      root.querySelectorAll('[data-caret]').forEach(function (el) { anims.push(el.animate([{ opacity: 1 }, { opacity: 0 }], { duration: 900, iterations: Infinity, easing: 'steps(2,start)' })); });
    }

    /* ----- scroll reveal ----- */
    var pending = new Set(), io = null;
    function reveal(el) {
      if (!pending.has(el)) return;
      pending.delete(el);
      if (io) io.unobserve(el);
      el.style.opacity = '';
      el.animate([{ opacity: 0, transform: 'translateY(40px)' }, { opacity: 1, transform: 'none' }], { duration: 900, delay: +el.dataset.delay || 0, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'backwards' });
    }
    if (!still && 'IntersectionObserver' in window) {
      var vh0 = window.innerHeight;
      io = new IntersectionObserver(function (entries) { entries.forEach(function (e) { if (e.isIntersecting) reveal(e.target); }); }, { threshold: 0.12 });
      root.querySelectorAll('[data-reveal]').forEach(function (el) {
        if (el.getBoundingClientRect().top > vh0 * 0.95) { el.style.opacity = '0'; pending.add(el); io.observe(el); }
      });
    }

    /* ----- pointer effects (desktop only) ----- */
    if (window.matchMedia && matchMedia('(hover:hover)').matches) {
      root.querySelectorAll('[data-magnetic]').forEach(function (el) {
        el.style.transition = (el.style.transition ? el.style.transition + ',' : '') + 'translate .35s cubic-bezier(.2,.8,.2,1)';
        el.addEventListener('mousemove', function (e) {
          var r = el.getBoundingClientRect();
          el.style.translate = ((e.clientX - r.left) / r.width - .5) * 14 + 'px ' + ((e.clientY - r.top) / r.height - .5) * 12 + 'px';
        });
        el.addEventListener('mouseleave', function () { el.style.translate = '0 0'; });
      });
      root.querySelectorAll('[data-tilt]').forEach(function (el) {
        el.style.transformStyle = 'preserve-3d';
        el.style.transition = 'rotate .5s cubic-bezier(.2,.8,.2,1),scale .5s cubic-bezier(.2,.8,.2,1),box-shadow .5s';
        el.addEventListener('mousemove', function (e) {
          var r = el.getBoundingClientRect();
          var x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
          el.style.rotate = (-y).toFixed(3) + ' ' + x.toFixed(3) + ' 0 ' + (Math.hypot(x, y) * 6).toFixed(2) + 'deg';
          el.style.scale = '1.01';
        });
        el.addEventListener('mouseleave', function () { el.style.rotate = 'none'; el.style.scale = '1'; });
        if (el.parentElement) el.parentElement.style.perspective = '1200px';
      });
      root.querySelectorAll('[data-spot]').forEach(function (el) {
        if (getComputedStyle(el).position === 'static') el.style.position = 'relative';
        el.style.overflow = 'hidden';
        var s = document.createElement('span');
        s.style.cssText = 'position:absolute;inset:0;pointer-events:none;opacity:0;transition:opacity .4s;border-radius:inherit;z-index:0';
        el.prepend(s);
        Array.prototype.forEach.call(el.children, function (ch) { if (ch !== s && getComputedStyle(ch).position === 'static') { ch.style.position = 'relative'; ch.style.zIndex = '1'; } });
        el.addEventListener('mousemove', function (e) {
          var r = el.getBoundingClientRect();
          s.style.background = 'radial-gradient(320px circle at ' + (e.clientX - r.left) + 'px ' + (e.clientY - r.top) + 'px,rgba(194,247,96,.16),rgba(194,247,96,0) 70%)';
          s.style.opacity = '1';
        });
        el.addEventListener('mouseleave', function () { s.style.opacity = '0'; });
      });
    }

    /* ----- smooth wheel scrolling (mouse devices) ----- */
    if (CFG.smoothScroll !== false && matchMedia('(pointer:fine)').matches && !still) {
      var cur = scrollY, tgt = scrollY, running = false, own = false;
      var maxS = function () { return document.documentElement.scrollHeight - innerHeight; };
      var loop = function () {
        cur += (tgt - cur) * 0.085;
        if (Math.abs(tgt - cur) < 0.4) { cur = tgt; running = false; }
        own = true; window.scrollTo(0, cur);
        if (running) requestAnimationFrame(loop);
      };
      var go = function (y) { tgt = Math.max(0, Math.min(maxS(), y)); if (!running) { running = true; cur = scrollY; requestAnimationFrame(loop); } };
      window.addEventListener('wheel', function (e) {
        if (e.ctrlKey || e.defaultPrevented) return;
        var n = e.target;
        while (n && n !== document.body) { var st = getComputedStyle(n); if (/(auto|scroll)/.test(st.overflowY) && n.scrollHeight > n.clientHeight) return; n = n.parentElement; }
        e.preventDefault();
        if (!running) tgt = scrollY;
        go(tgt + e.deltaY * (e.deltaMode === 1 ? 32 : 1));
      }, { passive: false });
      window.addEventListener('scroll', function () { if (own) { own = false; return; } if (!running) { cur = tgt = scrollY; } }, { passive: true });
      root.addEventListener('click', function (e) {
        var a = e.target.closest && e.target.closest('a[href^="#"]');
        if (!a) return;
        var id = a.getAttribute('href').slice(1), el = id ? document.getElementById(id) : null;
        if (!el && id !== 'top') return;
        e.preventDefault();
        go(el ? el.getBoundingClientRect().top + scrollY - 80 : 0);
      });
    }

    /* ----- scroll-linked bits: progress bar, back-to-top, sticky nav, parallax ----- */
    var prog = root.querySelector('[data-progress]'), toTop = root.querySelector('[data-totop]'), nav = root.querySelector('[data-nav]');
    var par = [].slice.call(root.querySelectorAll('[data-parallax],[data-parallax-img]'));
    var topShown, navSolid, raf = 0;
    function tick() {
      var vh = window.innerHeight, maxS = document.documentElement.scrollHeight - vh;
      if (prog) prog.style.transform = 'scaleX(' + (maxS > 0 ? Math.min(1, scrollY / maxS).toFixed(4) : 0) + ')';
      if (toTop) {
        var show = scrollY > vh * 1.2;
        if (show !== topShown) { topShown = show; Object.assign(toTop.style, { opacity: show ? '1' : '0', transform: show ? 'none' : 'translateY(16px)', pointerEvents: show ? 'auto' : 'none' }); }
      }
      if (nav) {
        var solid = scrollY > 40;
        if (solid !== navSolid) {
          navSolid = solid;
          nav.style.background = solid ? 'rgba(8,9,6,.72)' : 'linear-gradient(180deg,rgba(0,0,0,.7),rgba(0,0,0,0))';
          nav.style.backdropFilter = solid ? 'blur(16px) saturate(1.3)' : 'blur(6px)';
          nav.style.boxShadow = solid ? '0 1px 0 rgba(255,255,255,.06),0 10px 30px -20px rgba(0,0,0,.8)' : 'none';
        }
      }
      if (pending.size) root.querySelectorAll('[data-reveal]').forEach(function (el) {
        if (el.style.opacity === '0' && el.getBoundingClientRect().top < vh) { pending.add(el); reveal(el); }
      });
      par.forEach(function (el) {
        var r = el.getBoundingClientRect(), s = +(el.dataset.parallax || el.dataset.parallaxImg);
        el.style.transform = 'translate3d(0,' + ((r.top + r.height / 2 - vh / 2) * -s).toFixed(1) + 'px,0)';
      });
    }
    var onScroll = function () { if (!raf) raf = requestAnimationFrame(function () { raf = 0; tick(); }); };
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    tick();
    setTimeout(function () { root.querySelectorAll('[data-reveal]').forEach(function (el) { if (el.style.opacity === '0' && el.getBoundingClientRect().top < innerHeight * 1.5) el.style.opacity = ''; }); }, 8000);
    setInterval(tick, 600);

    /* ----- mobile menu ----- */
    var menu = root.querySelector('[data-menu]'), menuBtn = root.querySelector('[data-menu-btn]');
    function setMenu(open) {
      if (!menu || !menuBtn) return;
      menu.hidden = !open;
      menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
      var p = menuBtn.querySelector('path'); if (p) p.setAttribute('d', open ? 'M6 6l12 12M18 6L6 18' : 'M4 7h16M4 12h16M4 17h16');
    }
    if (menuBtn) {
      menuBtn.setAttribute('aria-expanded', 'false');
      menuBtn.addEventListener('click', function () { setMenu(menu.hidden); });
      menu.addEventListener('click', function () { setMenu(false); });
    }

    /* ----- services accordion (every answer stays in the page for SEO) ----- */
    var svcBtns = root.querySelectorAll('[data-svc-t]'), svcItems = root.querySelectorAll('[data-svc-item]');
    function setSvc(open) {
      svcItems.forEach(function (it, i) {
        var on = i === open, a = it.querySelector('[data-svc-a]'), r = it.querySelector('[data-svc-rot]'), b = it.querySelector('[data-svc-t]');
        it.style.background = on ? '#C2F760' : 'transparent';
        it.style.color = on ? '#0E1206' : '#fff';
        if (a) { if (on) a.setAttribute('data-open', '1'); else a.removeAttribute('data-open'); }
        if (r) r.style.transform = on ? 'rotate(45deg)' : 'rotate(0deg)';
        if (b) b.setAttribute('aria-expanded', on ? 'true' : 'false');
      });
    }
    svcBtns.forEach(function (b) {
      b.setAttribute('aria-expanded', b.dataset.svcT === '0' ? 'true' : 'false');
      b.addEventListener('click', function () {
        var i = +b.dataset.svcT, a = root.querySelector('[data-svc-a="' + i + '"]');
        setSvc(a && a.hasAttribute('data-open') ? -1 : i);
      });
    });

    /* ----- project tabs + before / after ----- */
    var projBtns = root.querySelectorAll('[data-proj-t]');
    var tiles = [].slice.call(root.querySelectorAll('[data-tile]'));
    var tileGroups = []; tiles.forEach(function (t) { if (tileGroups.indexOf(t.parentElement) < 0) tileGroups.push(t.parentElement); });
    function fillTiles(group, arr) {
      var kids = group ? group.querySelectorAll('[data-tile]') : [];
      arr.forEach(function (t, i) {
        var k = kids[i]; if (!k) return;
        k.style.background = t.bg; k.style.color = t.fg;
        var sp = k.querySelectorAll('span'); sp[0].textContent = t.k; sp[1].textContent = t.v;
      });
    }
    function setProj(i) {
      var d = DATA.proj[i]; if (!d) return;
      projBtns.forEach(function (b) {
        var on = +b.dataset.projT === i;
        b.style.background = on ? '#C2F760' : 'transparent'; b.style.color = on ? '#0E1206' : '#fff';
      });
      var img = root.querySelector('[data-proj-img]'); if (img) img.style.backgroundImage = 'url("' + ASSETS + d.img.replace(/^assets\//, 'img/') + '")';
      var nm = root.querySelector('[data-proj-name]'); if (nm) nm.textContent = d.name;
      var rows = root.querySelectorAll('[data-proj-row]');
      d.rows.forEach(function (r, j) { var el = rows[j]; if (!el) return; var sp = el.querySelectorAll('span'); sp[0].textContent = r.k; sp[1].textContent = r.v; });
      fillTiles(tileGroups[0], d.before); fillTiles(tileGroups[1], d.after);
      var pb = root.querySelector('[data-period-b]'), pa = root.querySelector('[data-period-a]');
      if (pb) pb.textContent = d.pb; if (pa) pa.textContent = d.pa;
    }
    projBtns.forEach(function (b) { b.addEventListener('click', function () { setProj(+b.dataset.projT); }); });

    /* ----- testimonials ----- */
    var tIdx = 0, tAuto = 0;
    var tText = root.querySelector('[data-testi-text]'), tName = root.querySelector('[data-testi-name]'), tMeta = root.querySelector('[data-testi-meta]');
    var tDots = root.querySelectorAll('[data-testi-dot]');
    function setTesti(i) {
      var n = DATA.testi.length; tIdx = (i + n) % n;
      var t = DATA.testi[tIdx];
      if (tText) { tText.textContent = t.text; if (!still) tText.animate([{ opacity: 0, transform: 'translateY(10px)' }, { opacity: 1, transform: 'none' }], { duration: 500, easing: 'cubic-bezier(.2,.7,.2,1)' }); }
      if (tName) tName.textContent = t.name;
      if (tMeta) tMeta.textContent = t.meta;
      tDots.forEach(function (d, j) { d.style.width = j === tIdx ? '36px' : '16px'; d.style.background = j === tIdx ? '#C2F760' : 'rgba(255,255,255,.25)'; });
    }
    function restartAuto() { clearInterval(tAuto); if (!still) tAuto = setInterval(function () { setTesti(tIdx + 1); }, 6500); }
    var tp = root.querySelector('[data-testi-prev]'), tn = root.querySelector('[data-testi-next]');
    if (tp) tp.addEventListener('click', function () { setTesti(tIdx - 1); restartAuto(); });
    if (tn) tn.addEventListener('click', function () { setTesti(tIdx + 1); restartAuto(); });
    tDots.forEach(function (d) { d.addEventListener('click', function () { setTesti(+d.dataset.testiDot); restartAuto(); }); });
    restartAuto();

    /* ----- FAQ accordion ----- */
    var faqBtns = root.querySelectorAll('[data-faq-t]');
    function setFaq(open) {
      faqBtns.forEach(function (b) {
        var i = +b.dataset.faqT, on = i === open, a = root.querySelector('[data-faq-a="' + i + '"]');
        if (a) { if (on) a.setAttribute('data-open', '1'); else a.removeAttribute('data-open'); }
        b.setAttribute('aria-expanded', on ? 'true' : 'false');
        var ic = b.querySelector('[style*="rotate"]'); if (ic) ic.style.transform = on ? 'rotate(45deg)' : 'rotate(0deg)';
      });
    }
    faqBtns.forEach(function (b) {
      b.addEventListener('click', function () {
        var i = +b.dataset.faqT, cur = root.querySelector('[data-faq-a="' + i + '"]');
        setFaq(cur && cur.hasAttribute('data-open') ? -1 : i);
      });
    });

    /* ----- contact form ----- */
    var cWrap = root.querySelector('[data-contact-wrap]'), cForm = root.querySelector('[data-contact-form]');
    var cErr = root.querySelector('[data-contact-err]'), cSent = root.querySelector('[data-sent]');
    function cFail(m) { if (cErr) { cErr.textContent = m; cErr.hidden = false; } }
    if (cForm) {
      cForm.addEventListener('input', function () { if (cErr) cErr.hidden = true; });
      cForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var f = cForm, g = function (k) { return f[k] ? f[k].value.trim() : ''; };
        var showSent = function () { cWrap.hidden = true; cSent.hidden = false; if (cErr) cErr.hidden = true; };
        if (g('hpCheck')) { leads.spam = true; showSent(); return; }
        var name = g('name').replace(/\s+/g, ' '), email = g('email').toLowerCase(), pp = g('phone') ? leads.parsePhone(g('phone'), '+91', 'phone number') : {};
        var web = g('website'), host = web ? leads.normUrl(web) : '', msg = g('message');
        var err = leads.vName(name) || leads.vEmail(email) || pp.err || (web && leads.vHost(host)) ||
          (msg && (msg.length < 3 || /(.)\1{9,}/.test(msg) || (msg.match(/https?:\/\//gi) || []).length > 2) && 'Please check your message.');
        if (err) return cFail(err);
        if (leads.tooFast()) return cFail('Please check your details and try again.');
        if (!leads.rate('wiseup_lead_submits', 6, 3600000)) return cFail("You've already sent a few requests. Our team will be in touch.");
        leads.lead = Object.assign({}, leads.lead, { name: name, email: email, phone: pp.e164 || leads.lead.phone });
        leads.sendLead('contact-form', { website: host || '', service: g('service'), message: msg.slice(0, 1000), source: 'performance-marketing' });
        showSent();
      });
      var rs = root.querySelector('[data-reset]');
      if (rs) rs.addEventListener('click', function () { cForm.reset(); cWrap.hidden = false; cSent.hidden = true; });
    }

    /* ----- admin-bar offset for logged-in editors ----- */
    if (document.body.classList.contains('admin-bar') && nav) nav.style.top = (document.getElementById('wpadminbar') ? document.getElementById('wpadminbar').offsetHeight : 32) + 'px';
  });
})();
