/* WiseUp footer wordmark v3 (2026-11-03): a big "wiseup" made of dots. Idle = steady lime-to-green dots (no glow, no moving light).
   Hover = playful physics: dots swirl and spring around the pointer, a fast swipe flings them, touched dots swell and ripple
   through a pastel palette, each letter hops and tilts as the pointer crosses it, confetti sparkles trail the pointer, and a click
   or tap sets off a shockwave with a wave of hopping letters. Plain JS, no dependencies; the same file runs on the Astro site and in
   the WordPress plugin. Markup:
   <div class="ft__word" data-ft-word2><span class="ft__word-text">wiseup</span><canvas class="ft__canvas"></canvas></div> */
(function () {
  var wrap = document.querySelector('[data-ft-word2]');
  if (!wrap) return;
  var canvas = wrap.querySelector('canvas'), text = wrap.querySelector('.ft__word-text');
  if (!canvas || !text) return;
  var ctx = canvas.getContext('2d');
  var WORD = 'wiseup', LV = 12, HOT = 6, TAU = Math.PI * 2, MAXSP = 36;
  var reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
  var DPR = Math.min(window.devicePixelRatio || 1, 2);
  var isLight = function () { return document.documentElement.getAttribute('data-theme') === 'light'; };
  // real icons: Material Design (Apache 2.0) for the services, Simple Icons (CC0) for the platform logos; 24x24 paths
  var ICONS = [
    "M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z",
    "M18 11v2h4v-2h-4zm-2 6.61c.96.71 2.21 1.65 3.2 2.39.4-.53.8-1.07 1.2-1.6-.99-.74-2.24-1.68-3.2-2.4-.4.54-.8 1.08-1.2 1.61zM20.4 5.6c-.4-.53-.8-1.07-1.2-1.6-.99.74-2.24 1.68-3.2 2.4.4.53.8 1.07 1.2 1.6.96-.72 2.21-1.65 3.2-2.4zM4 9c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h1v4h2v-4h1l5 3V6L8 9H4zm11.5 3c0-1.33-.58-2.53-1.5-3.35v6.69c.92-.81 1.5-2.01 1.5-3.34z",
    "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z",
    "M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z",
    "m16 6 2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z",
    "M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 14H4v-4h11v4zm0-5H4V9h11v4zm5 5h-4V9h4v9z",
    "M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z",
    "M7 14c-1.66 0-3 1.34-3 3 0 1.31-1.16 2-2 2 .92 1.22 2.49 2 4 2 2.21 0 4-1.79 4-4 0-1.66-1.34-3-3-3zm13.71-9.37-1.34-1.34a.996.996 0 0 0-1.41 0L9 12.25 11.75 15l8.96-8.96a.996.996 0 0 0 0-1.41z",
    "M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z",
    "M3 10h11v2H3v-2zm0-2h11V6H3v2zm0 8h7v-2H3v2zm15.01-3.13.71-.71a.996.996 0 0 1 1.41 0l.71.71c.39.39.39 1.02 0 1.41l-.71.71-2.12-2.12zm-.71.71-5.3 5.3V21h2.12l5.3-5.3-2.12-2.12z",
    "M9.19 6.35c-2.04 2.29-3.44 5.58-3.57 5.89L2 10.69l4.05-4.05c.47-.47 1.15-.68 1.81-.55l1.33.26zM11.17 17s3.74-1.55 5.89-3.7c5.4-5.4 4.5-9.62 4.21-10.57-.95-.3-5.17-1.19-10.57 4.21C8.55 9.09 7 12.83 7 12.83L11.17 17zm6.48-2.19c-2.29 2.04-5.58 3.44-5.89 3.57L13.31 22l4.05-4.05c.47-.47.68-1.15.55-1.81l-.26-1.33zM9 18c0 .83-.34 1.58-.88 2.12C6.94 21.3 2 22 2 22s.7-4.94 1.88-6.12A2.996 2.996 0 0 1 9 18zm4-9c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z",
    "M9 2 7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z",
    "M12 14c1.66 0 2.99-1.34 2.99-3L15 5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z",
    "M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077",
    "M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z",
    "M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z",
    "M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z",
    "M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z",
    "M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z",
    "M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z",
    "M16.969 16.927a2.561 2.561 0 0 0 1.901.677 2.501 2.501 0 0 0 1.531-.475c.362-.235.636-.584.779-.99h2.585a5.091 5.091 0 0 1-1.9 2.896 5.292 5.292 0 0 1-3.091.88 5.839 5.839 0 0 1-2.284-.433 4.871 4.871 0 0 1-1.723-1.211 5.657 5.657 0 0 1-1.08-1.874 7.057 7.057 0 0 1-.383-2.393c-.005-.8.129-1.595.396-2.349a5.313 5.313 0 0 1 5.088-3.604 4.87 4.87 0 0 1 2.376.563c.661.362 1.231.87 1.668 1.485a6.2 6.2 0 0 1 .943 2.133c.194.821.263 1.666.205 2.508h-7.699c-.063.79.184 1.574.688 2.187ZM6.947 4.084a8.065 8.065 0 0 1 1.928.198 4.29 4.29 0 0 1 1.49.638c.418.303.748.711.958 1.182.241.579.357 1.203.341 1.83a3.506 3.506 0 0 1-.506 1.961 3.726 3.726 0 0 1-1.503 1.287 3.588 3.588 0 0 1 2.027 1.437c.464.747.697 1.615.67 2.494a4.593 4.593 0 0 1-.423 2.032 3.945 3.945 0 0 1-1.163 1.413 5.114 5.114 0 0 1-1.683.807 7.135 7.135 0 0 1-1.928.259H0V4.084h6.947Zm-.235 12.9c.308.004.616-.029.916-.099a2.18 2.18 0 0 0 .766-.332c.228-.158.411-.371.534-.619.142-.317.208-.663.191-1.009a2.08 2.08 0 0 0-.642-1.715 2.618 2.618 0 0 0-1.696-.505h-3.54v4.279h3.471Zm13.635-5.967a2.13 2.13 0 0 0-1.654-.619 2.336 2.336 0 0 0-1.163.259 2.474 2.474 0 0 0-.738.62 2.359 2.359 0 0 0-.396.792c-.074.239-.12.485-.137.734h4.769a3.239 3.239 0 0 0-.679-1.785l-.002-.001Zm-13.813-.648a2.254 2.254 0 0 0 1.423-.433c.399-.355.607-.88.56-1.413a1.916 1.916 0 0 0-.178-.891 1.298 1.298 0 0 0-.495-.533 1.851 1.851 0 0 0-.711-.274 3.966 3.966 0 0 0-.835-.073H3.241v3.631h3.293v-.014ZM21.62 5.122h-5.976v1.527h5.976V5.122Z",
    "M3.9998 22.9291C1.7908 22.9291 0 21.1383 0 18.9293s1.7908-3.9998 3.9998-3.9998 3.9998 1.7908 3.9998 3.9998-1.7908 3.9998-3.9998 3.9998zm19.4643-6.0004L15.4632 3.072C14.3586 1.1587 11.9121.5028 9.9988 1.6074S7.4295 5.1585 8.5341 7.0718l8.0009 13.8567c1.1046 1.9133 3.5511 2.5679 5.4644 1.4646 1.9134-1.1046 2.568-3.5511 1.4647-5.4644zM7.5137 4.8438L1.5645 15.1484A4.5 4.5 0 0 1 4 14.4297c2.5597-.0075 4.6248 2.1585 4.4941 4.7148l3.2168-5.5723-3.6094-6.25c-.4499-.7793-.6322-1.6394-.5878-2.4784z"
  ].map(function (d) { return new Path2D(d); });
  // original brand colours for the platform logos (the 13 service icons before them stay in the dots' green); X is white on dark, black on light
  var BRAND = [null, null, null, null, null, null, null, null, null, null, null, null, null, '#E4405F', '#0866FF', '#FF0000', '#0A66C2', 'x', '#25D366', '#E60023', '#1769FF', '#4285F4'];
  var pts = [], sparks = [], letters = [], edges = [], cw = 0, ch = 0, base = 0, gap = 6, radius = 130, cols = [], hot = [], t0 = 0, introAt = 0, on = false, raf = 0;
  var ptr = { x: -1e4, y: -1e4, vx: 0, vy: 0, on: false, t: 0 };

  var palette = function () {
    cols = []; hot = [];
    for (var k = 0; k < LV; k++) {
      var f = k / (LV - 1);
      if (isLight()) cols.push('hsl(80 ' + (10 + f * 30) + '% ' + (34 - f * 26) + '%)');
      else cols.push('hsl(' + (128 - f * 55) + ' ' + (56 + f * 26) + '% ' + (38 + f * 42) + '%)');
    }
    hot = isLight() ? ['#3f7d1a', '#4f9a22', '#5aa82a'] : ['#6fd34a', '#8fe05f', '#a8ee7e']; // icons stay in the dots' green
  };

  var build = function () {
    var cs = getComputedStyle(text), size = parseFloat(cs.fontSize);
    var font = cs.fontWeight + ' ' + size + 'px ' + cs.fontFamily;
    var probe = document.createElement('canvas').getContext('2d'); probe.font = font;
    if ('letterSpacing' in probe) probe.letterSpacing = cs.letterSpacing;
    var m = probe.measureText(WORD); base = Math.ceil(m.actualBoundingBoxAscent + size * .04);
    wrap.style.height = base + 'px';
    cw = Math.max(1, Math.round(wrap.clientWidth)); ch = base + Math.ceil(m.actualBoundingBoxDescent) + 6;
    canvas.style.height = ch + 'px'; canvas.width = cw * DPR; canvas.height = ch * DPR;
    gap = Math.max(3, Math.round(size / 84));
    radius = Math.max(120, size * .5);
    // letter boundaries (the word is centred in the canvas)
    var left = cw / 2 - m.width / 2; edges = [];
    for (var e = 0; e <= WORD.length; e++) edges.push(left + probe.measureText(WORD.slice(0, e)).width);
    letters = WORD.split('').map(function (_, i) { return { y: 0, vy: 0, r: 0, vr: 0, cd: 0, delay: -1, cs: 1, sn: 0, cx: (edges[i] + edges[i + 1]) / 2 }; });
    var off = document.createElement('canvas'); off.width = cw; off.height = ch;
    var o = off.getContext('2d', { willReadFrequently: true });
    o.font = font; if ('letterSpacing' in o) o.letterSpacing = cs.letterSpacing;
    o.fillStyle = '#fff'; o.textAlign = 'center'; o.textBaseline = 'alphabetic'; o.fillText(WORD, cw / 2, base - 2);
    var px = o.getImageData(0, 0, cw, ch).data;
    pts = []; sparks = [];
    for (var y = 0; y < ch; y += gap) for (var x = 0; x < cw; x += gap) {
      if (px[(y * cw + x) * 4 + 3] < 128) continue;
      var li = 0; for (var q = 0; q < WORD.length; q++) if (x >= edges[q]) li = q;
      pts.push({ bx: x, by: y, x: x, y: y, vx: 0, vy: 0, r: gap * (.26 + Math.random() * .14), ph: Math.random() * TAU, d: Math.random(), h: 0, li: li });
    }
    palette();
  };

  var hop = function (L, power, dir) {
    return; // letters stay put (owner: no dancing, particle movement only)
    if (L.cd > 0) return;
    L.vy = -Math.min(ch * .12, ch * .045 + power * .6); L.vr = dir * (.05 + Math.min(.06, power * .002)); L.cd = 16;
  };

  var spawn = function (x, y, n, speed, up) {
    for (var i = 0; i < n && sparks.length < MAXSP; i++) {
      var a = Math.random() * TAU, s = (.4 + Math.random()) * speed;
      sparks.push({ x: x, y: y, vx: Math.cos(a) * s, vy: Math.sin(a) * s - (up || 0), life: 1, dec: .006 + Math.random() * .006, c: (Math.random() * hot.length) | 0, r: (11 + Math.random() * 8) * Math.max(.8, gap / 4), k: (Math.random() * ICONS.length) | 0, sp: (Math.random() - .5) * .06, a: Math.random() * TAU });
    }
  };

  var frame = function (now) {
    var t = (now - t0) / 1000;
    var rect = canvas.getBoundingClientRect(), mx = ptr.x - rect.left, my = ptr.y - rect.top;
    var near = ptr.on && mx > -radius && mx < cw + radius && my > -radius && my < ch + radius;
    var intro = introAt ? Math.min(1, (now - introAt) / 2200) : 1;
    var speed = Math.sqrt(ptr.vx * ptr.vx + ptr.vy * ptr.vy);
    var buckets = []; for (var k = 0; k < LV; k++) buckets.push([]);

    // letters: spring back, hop when the pointer crosses them
    var settledL = true;
    for (var li = 0; li < letters.length; li++) {
      var L = letters[li];
      if (L.delay > 0 && --L.delay === 0) hop(L, ch * .06, li % 2 ? 1 : -1);
      if (L.cd > 0) L.cd--;
      if (near && my > -radius * .5 && my < ch + radius * .5 && mx >= edges[li] && mx < edges[li + 1] && intro >= 1) {
        hop(L, Math.min(speed * 1.2, ch * .08), ptr.vx >= 0 ? 1 : -1);
        if (li > 0) hop(letters[li - 1], speed * .4, ptr.vx >= 0 ? 1 : -1);
        if (li < letters.length - 1) hop(letters[li + 1], speed * .4, ptr.vx >= 0 ? 1 : -1);
      }
      L.vy += -L.y * .085; L.vy *= .87; L.y += L.vy;
      L.vr += -L.r * .1; L.vr *= .88; L.r += L.vr;
      L.cs = Math.cos(L.r); L.sn = Math.sin(L.r);
      if (Math.abs(L.y) + Math.abs(L.vy) + Math.abs(L.r) * 100 > .05 || L.delay > 0) settledL = false;
    }

    var anyHeat = false;
    for (var i = 0; i < pts.length; i++) {
      var p = pts[i];
      if (!reduced) {
        // target: home position moved by its letter's hop and tilt (rotated around the letter's baseline centre)
        var Lt = letters[p.li], rx = p.bx - Lt.cx, ry = p.by - base, tx = Lt.cx + rx * Lt.cs - ry * Lt.sn, ty = base + rx * Lt.sn + ry * Lt.cs + Lt.y;
        // pointer: push away, swirl around it and get flung along its motion
        var dx = p.x - mx, dy = p.y - my, d2 = dx * dx + dy * dy, R = radius;
        if (near && d2 < R * R && d2 > .01) {
          var d = Math.sqrt(d2), f0 = 1 - d / R, f = f0 * f0 * (3 - 2 * f0), ux = dx / d, uy = dy / d; // smooth falloff
          p.vx += ux * f * .9 - uy * f * .35 + ptr.vx * f * .03;
          p.vy += uy * f * .9 + ux * f * .35 + ptr.vy * f * .03;
          p.h = Math.min(1, p.h + f * .12);
        }
        p.vx += (tx - p.x) * .04; p.vy += (ty - p.y) * .04; p.vx *= .88; p.vy *= .88; p.x += p.vx; p.y += p.vy;
        if (p.h > 0) { p.h *= .965; if (p.h < .02) p.h = 0; else anyHeat = true; }
      }
      var w = .15 + .7 * (p.ph / TAU);
      var a = intro < 1 ? Math.min(1, Math.max(0, (intro * 1.6 - p.d * .6 - p.bx / cw * .4))) : 1;
      var ey = a < 1 ? (1 - a) * (1 - a) * (ch * .9 + 40) : 0;
      var rr = p.r * (.85 + w * .3) * (a < 1 ? a : 1);
      var lv = Math.min(LV - 1, Math.max(0, Math.round(w * (LV - 1))));
      buckets[lv].push(p.x, p.y + ey, rr * (1 + p.h * .45));
    }

    ctx.setTransform(DPR, 0, 0, DPR, 0, 0); ctx.clearRect(0, 0, cw, ch);
    for (var l = 0; l < LV; l++) {
      var c = buckets[l]; if (!c.length) continue; ctx.fillStyle = cols[l]; ctx.beginPath();
      for (var n = 0; n < c.length; n += 3) { if (c[n + 2] <= .05) continue; ctx.moveTo(c[n] + c[n + 2], c[n + 1]); ctx.arc(c[n], c[n + 1], c[n + 2], 0, TAU); }
      ctx.fill();
    }
    // service icons (brand, packaging, web, SEO, performance, digital, social, video, campaigns) that float up, sway and fade
    for (var s = sparks.length - 1; s >= 0; s--) {
      var sp = sparks[s]; sp.life -= sp.dec;
      if (sp.life <= 0) { sparks.splice(s, 1); continue; }
      sp.vy -= .01; sp.vx *= .97; sp.vy *= .97; sp.x += sp.vx + Math.sin(t * 2 + s) * .3; sp.y += sp.vy; sp.a += sp.sp;
      ctx.globalAlpha = Math.min(.9, sp.life * 1.4, (1 - sp.life) * 6 + .05); ctx.fillStyle = BRAND[sp.k] ? (BRAND[sp.k] === 'x' ? (isLight() ? '#000' : '#fff') : BRAND[sp.k]) : hot[sp.c];
      ctx.save(); ctx.translate(sp.x, sp.y); ctx.rotate(Math.sin(sp.a) * .5); ctx.scale(sp.r / 24, sp.r / 24); ctx.translate(-12, -12);
      ctx.fill(ICONS[sp.k]);
      ctx.restore();
    }
    ctx.globalAlpha = 1;

    ptr.vx *= .78; ptr.vy *= .78;
    // keep drawing while anything is still moving, otherwise stop until something changes
    var busy = intro < 1 || near || sparks.length || anyHeat || !settledL;
    if (!busy) for (var z = 0; z < pts.length; z += 7) { if (Math.abs(pts[z].vx) + Math.abs(pts[z].vy) > .02) { busy = true; break; } }
    raf = on && !reduced && busy ? requestAnimationFrame(frame) : 0;
  };

  var start = function () { if (!raf) raf = requestAnimationFrame(frame); };
  var move = function (x, y) {
    var now = performance.now(), dt = Math.max(8, now - ptr.t);
    if (ptr.on && ptr.t) { ptr.vx = ptr.vx * .5 + (x - ptr.x) / dt * 16 * .5; ptr.vy = ptr.vy * .5 + (y - ptr.y) / dt * 16 * .5; }
    ptr.x = x; ptr.y = y; ptr.on = true; ptr.t = now;
    if (!on) return;
    var r = canvas.getBoundingClientRect(), cx = x - r.left, cy = y - r.top, sp = Math.sqrt(ptr.vx * ptr.vx + ptr.vy * ptr.vy);
    if (cx > 0 && cx < cw && cy > 0 && cy < ch && sp > 2 && Math.random() < .12) spawn(cx, cy, 1, .5 + sp * .03, .4);
    start();
  };
  var burst = function (x, y) {
    if (!on) return;
    var r = canvas.getBoundingClientRect(), cx = x - r.left, cy = y - r.top;
    if (cx < -radius || cx > cw + radius || cy < -radius || cy > ch + radius) return;
    var R2 = radius * 2.2, hit = letters.length - 1;
    for (var i = 0; i < pts.length; i++) { // shockwave
      var p = pts[i], dx = p.x - cx, dy = p.y - cy, d = Math.sqrt(dx * dx + dy * dy) || 1;
      if (d < R2) { var f = 1 - d / R2; p.vx += dx / d * f * 7; p.vy += dy / d * f * 7; p.h = Math.min(1, p.h + f); }
    }
    spawn(cx, cy, 8, 1.6, .8);
    for (var a = 0; a < letters.length; a++) if (cx < edges[a + 1]) { hit = a; break; }
    for (var li = 0; li < letters.length; li++) letters[li].delay = 1 + Math.abs(li - hit) * 5; // a wave of hops spreading from the click
    start();
  };

  var ready = document.fonts && document.fonts.load ? document.fonts.load(getComputedStyle(text).fontWeight + ' 100px ' + getComputedStyle(text).fontFamily) : Promise.resolve();
  ready.catch(function () {}).then(function () {
    build(); t0 = performance.now();
    if (reduced) { frame(t0); return; }
    var first = true;
    new IntersectionObserver(function (es) {
      on = es[0].isIntersecting;
      if (on) { if (Math.round(wrap.clientWidth) !== cw) build(); if (first) { introAt = performance.now(); first = false; } start(); }
    }).observe(wrap);
    addEventListener('pointermove', function (e) { move(e.clientX, e.clientY); }, { passive: true });
    addEventListener('pointerdown', function (e) { ptr.x = e.clientX; ptr.y = e.clientY; ptr.on = true; ptr.t = performance.now(); burst(e.clientX, e.clientY); }, { passive: true });
    addEventListener('touchmove', function (e) { var t = e.touches[0]; if (t) move(t.clientX, t.clientY); }, { passive: true });
    document.addEventListener('pointerleave', function () { ptr.on = false; });
    addEventListener('touchend', function () { ptr.on = false; });
  });
  // Rebuild whenever the box changes width (also catches a footer that had no width yet when the script first ran).
  var rebuild = function () { if (!cw || Math.round(wrap.clientWidth) === cw) return; build(); if (reduced || !on) frame(performance.now()); };
  if ('ResizeObserver' in window) new ResizeObserver(rebuild).observe(wrap); else addEventListener('resize', rebuild);
  new MutationObserver(function () { palette(); if (reduced) frame(performance.now()); }).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
})();
