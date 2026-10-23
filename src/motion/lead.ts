// Lead popup behaviour (components/LeadModal.astro).
//  - Opens from [data-lead-open], the header CTA and links to the contact section (not on /contact, where the form
//    is already on the page), plus once per visit on exit intent (desktop) or after reading ~55% of a page.
//  - Never auto-opens again after a send (localStorage) or after being closed this visit (sessionStorage).
//  - Sends JSON to window.WISEUP_LEAD / window.WISEUP_CONTACT ({ endpoint, nonce }) or the form's action;
//    with none configured, opens WhatsApp with the details filled in.
import { onPage, onScroll, stopScroll, startScroll } from '../engine';
import { site } from '../data/site';

type Backend = { endpoint: string; nonce?: string };
const SEEN = 'wu-lead-seen';
const DONE = 'wu-lead-done';
const store = {
  get: (s: Storage, k: string) => { try { return s.getItem(k); } catch { return null; } },
  set: (s: Storage, k: string, v: string) => { try { s.setItem(k, v); } catch { /* private mode */ } },
};

export function setupLead() {
  onPage(() => {
    const dlg = document.querySelector<HTMLDialogElement>('[data-lead-modal]');
    const form = dlg?.querySelector<HTMLFormElement>('[data-lead-form]');
    if (!dlg || !form) return;
    const note = dlg.querySelector<HTMLElement>('[data-lead-note]');
    const send = dlg.querySelector<HTMLButtonElement>('[data-lead-send]');
    const done = dlg.querySelector<HTMLElement>('[data-lead-done]');
    const doneText = dlg.querySelector<HTMLElement>('[data-lead-done-text]');
    const fab = document.querySelector<HTMLElement>('.lead-fab');
    const onContactPage = !!document.querySelector('[data-form]') && location.pathname.startsWith('/contact');
    let source = 'button';
    const offs: (() => void)[] = [];
    const on = <K extends keyof HTMLElementEventMap>(el: EventTarget, ev: K | string, fn: (e: any) => void, opt?: AddEventListenerOptions) => {
      el.addEventListener(ev, fn, opt); offs.push(() => el.removeEventListener(ev, fn, opt));
    };

    const open = (from: string) => {
      if (dlg.open) return;
      source = from;
      dlg.classList.remove('is-closing');
      dlg.showModal();
      stopScroll?.();
      fab?.classList.add('is-away');
      store.set(sessionStorage, SEEN, '1');
      setTimeout(() => form.querySelector<HTMLInputElement>('input[name="name"]')?.focus({ preventScroll: true }), 350);
    };
    const close = () => {
      if (!dlg.open || dlg.classList.contains('is-closing')) return;
      dlg.classList.add('is-closing');
      setTimeout(() => { dlg.close(); dlg.classList.remove('is-closing'); }, 320);
    };
    on(dlg, 'close', () => { startScroll?.(); fab?.classList.remove('is-away'); });
    on(dlg, 'cancel', (e: Event) => { e.preventDefault(); close(); });
    on(dlg, 'click', (e: MouseEvent) => { if (e.target === dlg) close(); });
    dlg.querySelectorAll('[data-lead-close]').forEach((b) => on(b, 'click', close));

    // openers: explicit buttons, the header CTA, and links to the contact section (except on /contact itself)
    on(document, 'click', (e: MouseEvent) => {
      const t = (e.target as HTMLElement).closest<HTMLElement>('[data-lead-open], .hd__cta, a[href$="#contact"], a[href$="#form"]');
      if (!t || e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey) return;
      if (!t.hasAttribute('data-lead-open') && (onContactPage || t.closest('#contact'))) return;
      e.preventDefault();
      open(t.dataset.leadSource || (t.classList.contains('hd__cta') ? 'header' : 'cta'));
    });

    // auto: once per visit, exit intent on desktop or ~55% read, never after a send or on /contact
    const autoOk = () => !onContactPage && !store.get(localStorage, DONE) && !store.get(sessionStorage, SEEN) && !dlg.open;
    const since = Date.now();
    on(document, 'mouseout', (e: MouseEvent) => { if (!e.relatedTarget && e.clientY <= 0 && Date.now() - since > 8000 && autoOk()) open('exit-intent'); });
    const offScroll = onScroll(({ y }) => {
      const max = document.documentElement.scrollHeight - innerHeight;
      if (max > 0 && y / max > 0.55 && Date.now() - since > 15000 && autoOk()) open('scroll');
    });
    offs.push(offScroll);

    // live field feedback + mascot glance while typing
    const fieldOf = (el: Element) => el.closest<HTMLElement>('.lf');
    let typing: number | undefined;
    on(form, 'input', (e: Event) => {
      const el = e.target as HTMLInputElement;
      const f = fieldOf(el); f?.classList.remove('is-bad'); f?.classList.toggle('is-good', el.checkValidity() && !!el.value);
      dlg.classList.add('is-typing'); clearTimeout(typing); typing = window.setTimeout(() => dlg.classList.remove('is-typing'), 700);
    });
    on(form, 'change', (e: Event) => { const el = e.target as HTMLSelectElement; fieldOf(el)?.classList.toggle('is-good', !!el.value); });

    const setNote = (t: string, state?: string) => { if (!note) return; note.textContent = t; if (state) note.dataset.state = state; else delete note.dataset.state; };
    const payload = (d: FormData) => ({
      name: d.get('name'), email: d.get('email'), phone: d.get('phone'), service: d.get('service'), message: d.get('message'),
      page: location.pathname, source,
    });
    const waHref = (d: FormData) => {
      const msg = [`Hi WiseUp, I'm ${d.get('name')}.`, `I'm interested in: ${d.get('service')}.`, String(d.get('message') || ''),
        `Email: ${d.get('email')} · Phone: ${d.get('phone')}`].filter(Boolean).join('\n\n');
      return `${site.whatsapp}?text=${encodeURIComponent(msg)}`;
    };
    const finish = (text: string) => {
      store.set(localStorage, DONE, '1');
      if (doneText) doneText.textContent = text;
      if (done) done.hidden = false;
      dlg.classList.add('is-done');
      form.reset(); form.querySelectorAll('.lf').forEach((f) => f.classList.remove('is-good'));
    };

    on(form, 'submit', async (e: SubmitEvent) => {
      e.preventDefault();
      const bad = [...form.querySelectorAll<HTMLInputElement>('input, select, textarea')].filter((el) => el.name !== 'hp_website' && !el.checkValidity());
      form.querySelectorAll('.lf').forEach((f) => f.classList.remove('is-bad'));
      if (bad.length) {
        bad.forEach((el) => fieldOf(el)?.classList.add('is-bad'));
        bad[0].focus();
        setNote(bad[0].validity.valueMissing ? 'Please fill in the highlighted fields.' : 'Please check the highlighted field.', 'error');
        return;
      }
      const d = new FormData(form);
      if (String(d.get('hp_website') || '').trim()) return;
      const w = window as unknown as { WISEUP_LEAD?: Backend; WISEUP_CONTACT?: Backend };
      const backend: Backend | null = w.WISEUP_LEAD || w.WISEUP_CONTACT || (form.getAttribute('action') ? { endpoint: form.getAttribute('action')! } : null);
      if (!backend) {
        // no endpoint yet: hand the lead to WhatsApp (synchronous, still inside the submit gesture, so not popup-blocked)
        window.open(waHref(d), '_blank', 'noopener');
        finish('WhatsApp opened with your details. Hit send there and the team will reply soon.');
        return;
      }
      send?.setAttribute('disabled', 'true');
      setNote('Sending…', 'sending');
      try {
        const res = await fetch(backend.endpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', ...(backend.nonce ? { 'X-WP-Nonce': backend.nonce } : {}) },
          body: JSON.stringify(payload(d)),
        });
        const json = await res.json().catch(() => ({}));
        if (!res.ok || json?.ok === false) throw new Error('failed');
        setNote('');
        finish('The WiseUp team will reach out within 24 hours.');
      } catch {
        setNote("Couldn't send right now. ", 'error');
        const a = document.createElement('a');
        a.href = waHref(d); a.target = '_blank'; a.rel = 'noopener'; a.textContent = 'Send it on WhatsApp instead';
        note?.append(a);
      } finally {
        send?.removeAttribute('disabled');
      }
    });

    return () => { offs.forEach((f) => f()); if (dlg.open) dlg.close(); };
  });
}
