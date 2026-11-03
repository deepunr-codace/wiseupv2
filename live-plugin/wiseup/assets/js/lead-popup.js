/* Lead popup for the landing pages: a plain-JS copy of the site's popup behaviour (motion/lead.ts), so the same
   popup works here without loading the site's main bundle. Sends to the Wiseup enquiry endpoint set on the form. */
(function () {
	var dlg = document.querySelector('[data-lead-modal]');
	var form = dlg && dlg.querySelector('[data-lead-form]');
	if (!dlg || !form) return;
	var note = dlg.querySelector('[data-lead-note]');
	var send = dlg.querySelector('[data-lead-send]');
	var done = dlg.querySelector('[data-lead-done]');
	var doneText = dlg.querySelector('[data-lead-done-text]');
	var fab = document.querySelector('.lead-fab');
	var SEEN = 'wu-lead-seen', DONE = 'wu-lead-done', WA = 'https://wa.me/916282434503';
	var get = function (s, k) { try { return s.getItem(k); } catch (e) { return null; } };
	var set = function (s, k, v) { try { s.setItem(k, v); } catch (e) { /* private mode */ } };
	var trigger = 'button';

	var open = function (from) {
		if (dlg.open) return;
		trigger = from;
		dlg.classList.remove('is-closing');
		dlg.showModal();
		document.documentElement.style.overflow = 'hidden';
		if (fab) fab.classList.add('is-away');
		set(sessionStorage, SEEN, '1');
		// focus the first field for keyboard and mouse users only: on a touch screen the keyboard would jump up mid-entrance
		if (matchMedia('(hover: hover) and (pointer: fine)').matches) setTimeout(function () { var n = form.querySelector('input[name="name"]'); if (n) n.focus({ preventScroll: true }); }, 350);
	};
	var close = function () {
		if (!dlg.open || dlg.classList.contains('is-closing')) return;
		dlg.classList.add('is-closing');
		setTimeout(function () { dlg.close(); dlg.classList.remove('is-closing'); }, 320);
	};
	dlg.addEventListener('close', function () { document.documentElement.style.overflow = ''; if (fab) fab.classList.remove('is-away'); });
	dlg.addEventListener('cancel', function (e) { e.preventDefault(); close(); });
	dlg.addEventListener('click', function (e) { if (e.target === dlg) close(); });
	dlg.querySelectorAll('[data-lead-close]').forEach(function (b) { b.addEventListener('click', close); });

	// capture phase: the page's own link handlers (smooth scroll) would otherwise cancel the click first
	document.addEventListener('click', function (e) {
		var t = e.target.closest && e.target.closest('[data-lead-open]');
		if (!t || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey) return;
		e.preventDefault(); e.stopPropagation();
		open(t.getAttribute('data-lead-source') || 'cta');
	}, true);

	// auto: once per visit, exit intent on desktop or ~55% read, never after a send
	var since = Date.now();
	var autoOk = function () { return !get(localStorage, DONE) && !get(sessionStorage, SEEN) && !dlg.open; };
	document.addEventListener('mouseout', function (e) { if (!e.relatedTarget && e.clientY <= 0 && Date.now() - since > 8000 && autoOk()) open('exit-intent'); });
	addEventListener('scroll', function () {
		var max = document.documentElement.scrollHeight - innerHeight;
		if (max > 0 && scrollY / max > 0.55 && Date.now() - since > 15000 && autoOk()) open('scroll');
	}, { passive: true });

	// live field feedback + mascot glance while typing
	var fieldOf = function (el) { return el.closest('.lf'); };
	var typing;
	form.addEventListener('input', function (e) {
		var f = fieldOf(e.target);
		if (f) { f.classList.remove('is-bad'); f.classList.toggle('is-good', e.target.checkValidity() && !!e.target.value); }
		dlg.classList.add('is-typing'); clearTimeout(typing); typing = setTimeout(function () { dlg.classList.remove('is-typing'); }, 700);
	});
	form.addEventListener('change', function (e) { var f = fieldOf(e.target); if (f) f.classList.toggle('is-good', !!e.target.value); });

	var setNote = function (t, state) { if (!note) return; note.textContent = t; if (state) note.dataset.state = state; else delete note.dataset.state; };
	var waHref = function (d) {
		var msg = ['Hi WiseUp, I\'m ' + d.get('name') + '.', 'I\'m interested in: ' + d.get('service') + '.', String(d.get('message') || ''),
			'Email: ' + d.get('email') + ' · Phone: ' + d.get('phone')].filter(Boolean).join('\n\n');
		return WA + '?text=' + encodeURIComponent(msg);
	};
	var finish = function (text) {
		set(localStorage, DONE, '1');
		if (doneText) doneText.textContent = text;
		if (done) done.hidden = false;
		dlg.classList.add('is-done');
		form.reset(); form.querySelectorAll('.lf').forEach(function (f) { f.classList.remove('is-good'); });
	};

	form.addEventListener('submit', function (e) {
		e.preventDefault();
		var bad = [].slice.call(form.querySelectorAll('input, select, textarea')).filter(function (el) { return el.name !== 'hp_website' && !el.checkValidity(); });
		form.querySelectorAll('.lf').forEach(function (f) { f.classList.remove('is-bad'); });
		if (bad.length) {
			bad.forEach(function (el) { var f = fieldOf(el); if (f) f.classList.add('is-bad'); });
			bad[0].focus();
			setNote(bad[0].validity.valueMissing ? 'Please fill in the highlighted fields.' : 'Please check the highlighted field.', 'error');
			return;
		}
		var d = new FormData(form);
		if (String(d.get('hp_website') || '').trim()) return;
		if (send) send.setAttribute('disabled', 'true');
		setNote('Sending…', 'sending');
		fetch(form.dataset.endpoint, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': form.dataset.nonce },
			body: JSON.stringify({ name: d.get('name'), email: d.get('email'), phone: d.get('phone'), service: d.get('service'), message: d.get('message'),
				page: location.pathname, source: form.dataset.source || trigger })
		}).then(function (res) {
			return res.json().catch(function () { return {}; }).then(function (json) { if (!res.ok || (json && json.ok === false)) throw new Error('failed'); });
		}).then(function () {
			setNote('');
			finish('The WiseUp team will reach out within 24 hours.');
		}).catch(function () {
			setNote('Couldn\'t send right now. ', 'error');
			var a = document.createElement('a');
			a.href = waHref(d); a.target = '_blank'; a.rel = 'noopener'; a.textContent = 'Send it on WhatsApp instead';
			if (note) note.append(a);
		}).then(function () { if (send) send.removeAttribute('disabled'); });
	});
})();
