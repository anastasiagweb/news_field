(function () {
  "use strict";
  var D = window.EO;
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var reduceMotion = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // ---------- State ----------
  var params = new URLSearchParams(location.search);
  var codes = D.LANGS.map(function (l) { return l.code; });
  var state = {
    lang: pick(params.get("lang") || params.get("sprache"), codes, "it"),
    edition: pick(params.get("ausgabe") || params.get("edition"), ["frank", "wort"], "frank"),
    setFormat: "print",
    giftAudio: "online",
    bookFormat: {}
  };
  function pick(v, list, def) { return list.indexOf(v) >= 0 ? v : def; }
  function L() { return D.LANGS.filter(function (l) { return l.code === state.lang; })[0]; }
  function E(id) { return D.editions[id || state.edition]; }

  // ---------- Helpers ----------
  function eur(n) { return n.toFixed(2).replace(".", ",") + " €"; }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); }
  function fmt(key) { return D.formats.filter(function (f) { return f.key === key; })[0]; }
  var ICON_CART = '<svg aria-hidden="true"><use href="#i-cart"/></svg>';
  var ICON_CHEV = '<svg aria-hidden="true"><use href="#i-chev"/></svg>';
  var ICON_PLAY = '<svg aria-hidden="true"><use href="#i-play"/></svg>';

  // UTM / fbclid aus der Anzeige an den Shop weiterreichen
  var passKeys = ["utm_source", "utm_medium", "utm_campaign", "utm_content", "utm_term", "fbclid"];
  function passthrough() {
    var out = [];
    passKeys.forEach(function (k) { var v = params.get(k); if (v) out.push(k + "=" + encodeURIComponent(v)); });
    return out.length ? "&" + out.join("&") : "";
  }
  function cartUrlVariation(parentId, variationId, formatKey) {
    return D.shop + D.cartPath + "?add-to-cart=" + parentId + "&variation_id=" + variationId + "&attribute_pa_buch-ebook=" + fmt(formatKey).slug + passthrough();
  }
  function cartUrlSimple(id) { return D.shop + D.cartPath + "?add-to-cart=" + id + passthrough(); }

  // ---------- Meta Pixel (nur nach Zustimmung) ----------
  var CONSENT_KEY = "eo_consent_meta";
  function getConsent() { try { return localStorage.getItem(CONSENT_KEY); } catch (e) { return null; } }
  function setConsent(v) { try { localStorage.setItem(CONSENT_KEY, v); } catch (e) {} }
  var pixelOn = false;
  function loadPixel() {
    if (pixelOn || !D.metaPixelId) return;
    pixelOn = true;
    /* eslint-disable */
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
    /* eslint-enable */
    window.fbq("init", D.metaPixelId);
    window.fbq("track", "PageView");
    window.fbq("track", "ViewContent", { content_name: "Weihnachten Landingpage", content_category: "Weihnachten", content_type: "product_group" });
  }
  var STANDARD = ["PageView", "ViewContent", "AddToCart"];
  function track(event, data) {
    if (pixelOn && window.fbq) window.fbq(STANDARD.indexOf(event) >= 0 ? "track" : "trackCustom", event, data || {});
    if (window.dataLayer) window.dataLayer.push(Object.assign({ event: "eo_" + event }, data || {}));
  }
  function initConsent() {
    var c = getConsent();
    if (c === "yes") { loadPixel(); return; }
    if (c === "no") return;
    var box = $("#consent");
    box.hidden = false;
    $("#consent-yes").addEventListener("click", function () { setConsent("yes"); box.hidden = true; loadPixel(); });
    $("#consent-no").addEventListener("click", function () { setConsent("no"); box.hidden = true; });
  }
  function wireBuy(a, info) {
    a.addEventListener("click", function () {
      var i = typeof info === "function" ? info() : info;
      track("AddToCart", { content_ids: [String(i.id)], content_name: i.name, content_type: "product", value: i.value, currency: "EUR" });
    });
  }

  // ---------- Language choice ----------
  function renderPostcards() {
    $("#postcards").innerHTML = D.LANGS.map(function (l) {
      return '<button class="postcard" type="button" role="tab" data-lang="' + l.code + '" style="--c:' + l.color + '" aria-selected="' + (l.code === state.lang) + '">' +
        '<img src="' + l.cover + '" alt="" width="520" height="780">' +
        '<span class="postcard__stamp">' + l.code + '</span>' +
        '<span class="postcard__txt"><span class="postcard__greet" lang="' + l.code + '">' + esc(l.greeting) + '</span>' +
        '<span class="postcard__name">' + esc(l.country) + '</span>' +
        '<span class="postcard__places">' + esc(l.places) + '</span></span></button>';
    }).join("");
  }
  function renderTabs(el) {
    el.innerHTML = D.LANGS.map(function (l) {
      return '<button class="langtab" type="button" role="tab" data-lang="' + l.code + '" style="--c:' + l.color + '" aria-selected="' + (l.code === state.lang) + '">' +
        '<span class="langtab__dot">' + l.code + '</span>' + esc(l.name) + '</button>';
    }).join("");
  }
  function setLang(code) {
    if (code === state.lang) return;
    state.lang = code;
    track("Sprachwahl", { sprache: L().name });
    renderAll();
  }
  function setEdition(id) {
    if (id === state.edition) return;
    state.edition = id;
    track("Ausgabewahl", { ausgabe: id });
    renderAll();
  }
  function edSwitchHtml() {
    return ["frank", "wort"].map(function (id) {
      var e = E(id);
      return '<button class="edopt" type="button" role="radio" data-ed="' + id + '" aria-checked="' + (id === state.edition) + '">' +
        '<span class="edopt__name">' + e.name + '</span><span class="edopt__lvl">' + e.level + '</span></button>';
    }).join("");
  }

  // ---------- Set card ----------
  function renderSet() {
    var l = L(), e = E(), prices = D.setPrices[state.edition], set = l.set[state.edition];
    var price = prices[state.setFormat];
    var isDigital = state.setFormat === "pdf" || state.setFormat === "epub";
    var ship = isDigital ? '<span class="ship">Als Download, ohne Versandkosten</span>'
      : (price > D.freeShippingFrom ? '<span class="ship">✓ Versandkostenfrei in der EU</span>' : '<span class="ship ship--no">zzgl. 6,90 € Versand</span>');
    var vid = set.vars[state.setFormat];
    var open = $("#setcard details") && $("#setcard details").open;
    $("#setcard").innerHTML =
      '<div class="setcard__img"><img src="img/set-' + l.code + '-' + state.edition + '.webp" alt="' + esc(l.setName) + ' – ' + e.name + ' ' + e.level + ', drei Bücher" width="900" height="900"></div>' +
      '<div class="setcard__body">' +
        '<p class="setcard__greet" lang="' + l.code + '">' + esc(l.greeting) + '</p>' +
        '<h3>' + esc(l.setName) + '</h3>' +
        '<p class="setcard__claim">' + esc(l.claim) + '</p>' +
        '<div class="chips"><span class="chip chip--lang">' + e.name + ' · ' + e.level + '</span><span class="chip">3 Bücher · 30 Geschichten</span><span class="chip">' + esc(l.places) + '</span></div>' +
        '<details class="more"' + (open ? " open" : "") + '><summary>Worum geht es im Set?' + ICON_CHEV + '</summary><div class="more__body">' +
          l.intro.map(function (p) { return '<p>' + esc(p) + '</p>'; }).join("") +
          '<p class="cast"><b>Enthalten:</b>' + l.books.map(function (b) { return '<span class="chip" lang="' + l.code + '">' + esc(b.title) + '</span>'; }).join("") + '</p>' +
        '</div></details>' +
        '<fieldset class="formats"><legend>Format</legend>' +
          D.formats.map(function (f) {
            return '<label class="fmt"><input type="radio" name="setfmt" id="setfmt-' + f.key + '" value="' + f.key + '"' + (f.key === state.setFormat ? " checked" : "") + '>' +
              '<span>' + f.label + ' <b>' + eur(prices[f.key]) + '</b></span></label>';
          }).join("") +
        '</fieldset>' +
        '<div class="buy"><div class="price"><span class="price__v">' + eur(price) + '</span>' + ship + '</div>' +
          '<a class="btn btn--lang" id="set-buy" href="' + cartUrlVariation(set.id, vid, state.setFormat) + '">' + ICON_CART + 'Set in den Warenkorb</a>' +
          '<p class="buy__hint">Weiter zum Warenkorb auf easyoriginal.com</p></div>' +
      '</div>';
    wireBuy($("#set-buy"), { id: vid, name: l.setName + " " + e.name, value: price });
  }

  // ---------- Single books ----------
  function renderBooks() {
    var l = L(), e = E(), prices = D.bookPrices[state.edition];
    $("#single-head").textContent = "Oder einzeln: E-Book " + eur(prices.pdf) + ", Taschenbuch " + eur(prices.print);
    $("#books").innerHTML = l.books.map(function (b, i) {
      var fk = state.bookFormat[b.key] || "print", p = b[state.edition];
      return '<article class="book">' +
        '<div class="book__cover"><span class="book__num" aria-hidden="true">' + (i + 1) + '</span><img loading="lazy" src="img/cover-' + l.code + '-' + b.key + '-' + state.edition + '.webp" alt="Cover: ' + esc(b.title) + ', ' + e.level + '" width="520" height="780"></div>' +
        '<div class="book__body">' +
          '<p class="book__place">Band ' + (i + 1) + ' · ' + esc(b.place) + '</p>' +
          '<h4 lang="' + l.code + '">' + esc(b.title) + '</h4>' +
          '<p class="book__de">' + esc(b.de) + '</p>' +
          '<p class="book__hook">' + esc(b.hook) + '</p>' +
        '</div>' +
        '<details class="more book__wide"><summary>Worum geht’s?' + ICON_CHEV + '</summary><div class="more__body">' +
          b.desc.map(function (t) { return '<p>' + esc(t) + '</p>'; }).join("") +
          '<p class="cast"><b>Mit:</b>' + b.cast.map(function (c) { return '<span class="chip">' + esc(c) + '</span>'; }).join("") + '</p>' +
        '</div></details>' +
        '<div class="book__buy book__wide">' +
          '<span class="book__price" id="bp-' + b.key + '">' + eur(prices[fk]) + '</span>' +
          '<select id="bf-' + b.key + '" data-book="' + b.key + '" aria-label="Format für ' + esc(b.title) + '">' +
            D.formats.map(function (f) { return '<option value="' + f.key + '"' + (f.key === fk ? " selected" : "") + '>' + f.label + '</option>'; }).join("") +
          '</select>' +
          '<a class="btn btn--lang" id="bb-' + b.key + '" href="' + cartUrlVariation(p.id, p.vars[fk], fk) + '">' + ICON_CART + 'In den Warenkorb</a>' +
        '</div></article>';
    }).join("");
    l.books.forEach(function (b) {
      wireBuy($("#bb-" + b.key), function () {
        var fk = state.bookFormat[b.key] || "print";
        return { id: b[state.edition].vars[fk], name: b.title, value: D.bookPrices[state.edition][fk] };
      });
    });
  }
  function onBookFormat(sel) {
    var key = sel.getAttribute("data-book"), fk = sel.value;
    var b = L().books.filter(function (x) { return x.key === key; })[0], p = b[state.edition];
    state.bookFormat[key] = fk;
    $("#bp-" + key).textContent = eur(D.bookPrices[state.edition][fk]);
    $("#bb-" + key).href = cartUrlVariation(p.id, p.vars[fk], fk);
  }

  // ---------- Sample spread ----------
  var audio = new Audio();
  audio.preload = "none";
  var playing = null;
  function renderPages() {
    var l = L(), s = l.sample;
    $("#sample-book").textContent = l.setName;
    var frankHtml = s.frank.map(function (seg, i) {
      var t = seg[0];
      if (i > 0 && !/^[\s.,:;!?»]/.test(t)) t = " " + t;
      return '<span class="src">' + esc(t) + '</span>' + (seg[1] ? ' <span class="gl">(' + esc(seg[1]) + ')</span>' : "");
    }).join("");
    var wortHtml = esc(s.wort).replace(/\[(\d+)\]/g, "<sup>$1</sup>");
    var notesHtml = s.notes.map(function (n, i) { return n ? '<li><sup>' + (i + 1) + '</sup>' + esc(n) + '</li>' : ""; }).join("");
    function page(id, body) {
      var e = E(id), p = D.setPrices[id];
      return '<article class="page">' +
        '<div class="page__head"><span class="page__ed">' + e.name + '</span><span class="page__lvl">' + e.level + '</span></div>' +
        '<div class="page__paper" lang="' + l.code + '"><p class="page__chap">' + esc(s.title) + '</p>' + body + '</div>' +
        '<button class="play" type="button" data-audio="' + id + '" aria-pressed="false"><span class="play__i">' + ICON_PLAY + '</span><span class="play__t">Hörprobe anhören</span></button>' +
        '<ul class="page__pts">' + e.points.map(function (t) { return '<li>' + esc(t) + '</li>'; }).join("") + '</ul>' +
        '<p class="page__fit"><b>Passt, wenn …</b>' + esc(e.fit) + '</p>' +
        '<div class="page__price"><span>Set ab ' + eur(p.pdf) + ' · Einzelband ab ' + eur(D.bookPrices[id].pdf) + '</span><a href="#buecher" data-pick-ed="' + id + '">Diese Ausgabe wählen →</a></div>' +
        '</article>';
    }
    $("#pages").innerHTML =
      page("frank", frankHtml + '<div class="page__again"><span class="page__label">Derselbe Abschnitt ohne Hilfen</span>' + esc(s.plain) + '</div>') +
      page("wort", '<p>' + wortHtml + '</p><ul class="notes">' + notesHtml + '</ul>');
    stopAudio();
  }
  function stopAudio() {
    audio.pause();
    if (playing) { playing.setAttribute("aria-pressed", "false"); playing.querySelector(".play__t").textContent = "Hörprobe anhören"; }
    playing = null;
  }
  function toggleAudio(btn) {
    if (playing === btn) { stopAudio(); return; }
    stopAudio();
    audio.src = L().sample.audio[btn.getAttribute("data-audio")];
    audio.play().then(function () {
      playing = btn; btn.setAttribute("aria-pressed", "true"); btn.querySelector(".play__t").textContent = "Pause";
      track("Hoerprobe", { sprache: L().name, ausgabe: btn.getAttribute("data-audio") });
    }).catch(function () { btn.querySelector(".play__t").textContent = "Hörprobe nicht verfügbar"; });
  }
  audio.addEventListener("ended", stopAudio);

  // ---------- Gift ----------
  function renderGift() {
    var l = L(), e = E(), gp = D.giftPrices[state.edition], gid = l.gift[state.edition][state.giftAudio], price = gp[state.giftAudio];
    var open = $("#gift details") && $("#gift details").open;
    $("#gift").innerHTML =
      '<div class="gift__img"><img loading="lazy" src="img/gift-' + l.code + '-' + state.edition + '.webp" alt="Geschenkset ' + esc(l.setName) + ' mit drei Büchern und Schreibset ' + esc(l.gift.schreibset) + '" width="900" height="900"></div>' +
      '<div class="gift__body">' +
        '<p class="badge">Geschenkset · ' + esc(l.country) + '</p>' +
        '<h3>' + esc(l.setName) + ' + Notiz‑Set</h3>' +
        '<div class="gift__set"><img loading="lazy" src="' + l.gift.schreibsetImg + '" alt="Schreibset ' + esc(l.gift.schreibset) + ' Deluxe" width="900" height="900">' +
          '<p><b>Schreibset „' + esc(l.gift.schreibset) + '“ Deluxe</b>' + esc(l.gift.schreibsetText) + '</p></div>' +
        '<details class="more"' + (open ? " open" : "") + '><summary>Was ist im Geschenkset?' + ICON_CHEV + '</summary><div class="more__body">' +
          '<ul class="gift__list">' + D.giftContents.map(function (t) { return '<li>' + esc(t) + '</li>'; }).join("") + '</ul>' +
        '</div></details>' +
        '<div class="edswitch" role="radiogroup" aria-label="Ausgabe im Geschenkset">' + edSwitchHtml() + '</div>' +
        '<fieldset class="formats seg"><legend>Audio</legend>' +
          '<label class="fmt"><input type="radio" name="giftaudio" id="giftaudio-online" value="online"' + (state.giftAudio === "online" ? " checked" : "") + '><span>Audio-Online <small>' + eur(gp.online) + '</small></span></label>' +
          '<label class="fmt"><input type="radio" name="giftaudio" id="giftaudio-cd" value="cd"' + (state.giftAudio === "cd" ? " checked" : "") + '><span>Mit Audio-CDs <small>' + eur(gp.cd) + '</small></span></label>' +
        '</fieldset>' +
        '<div class="buy"><div class="price"><span class="price__v">' + eur(price) + '</span><span class="ship">✓ Versandkostenfrei in der EU</span></div>' +
          '<a class="btn btn--lang" id="gift-buy" href="' + cartUrlSimple(gid) + '">' + ICON_CART + 'Geschenkset in den Warenkorb</a>' +
          '<p class="buy__hint">Weiter zum Warenkorb auf easyoriginal.com</p></div>' +
      '</div>';
    wireBuy($("#gift-buy"), { id: gid, name: "Geschenkset " + l.setName + " " + e.name, value: price });
  }

  // ---------- FAQ ----------
  function renderFaq() {
    $("#faq").innerHTML = D.faq.map(function (f, i) {
      return '<details' + (i === 0 ? " open" : "") + '><summary>' + esc(f.q) + '</summary><p>' + esc(f.a) + '</p></details>';
    }).join("");
  }

  // ---------- Countdown ----------
  function renderCountdown() {
    var now = new Date(), y = now.getFullYear();
    var eve = new Date(y, 11, 24);
    if (now > new Date(y, 11, 26)) eve = new Date(y + 1, 11, 24);
    var days = Math.ceil((eve - new Date(y, now.getMonth(), now.getDate())) / 864e5);
    var t = days > 1 ? "Noch " + days + " Tage bis Heiligabend" : days === 1 ? "Morgen ist Heiligabend" : "Frohe Weihnachten!";
    $("#xmas-count").textContent = t;
    $("#xmas-count-2").textContent = days > 1 ? t + " – genug Zeit für ein paar Geschichten." : t;
  }

  // ---------- Garland ----------
  var BULBS = ["#FFD36B", "#FF6B5E", "#FFF1C9", "#7FE0A0", "#FFB547"];
  function buildGarland(el, seed) {
    if (!el) return;
    var w = el.clientWidth || window.innerWidth, h = 70;
    var span = w < 600 ? 150 : 230, n = Math.max(2, Math.round(w / span)), seg = w / n;
    var wire = "", bulbs = "", k = seed || 0, gid = "glow" + (seed || 0);
    for (var i = 0; i < n; i++) {
      var x0 = i * seg, x1 = x0 + seg, cx = x0 + seg / 2, cy = 52;
      wire += "M" + x0.toFixed(1) + " 2 Q" + cx.toFixed(1) + " " + cy + " " + x1.toFixed(1) + " 2 ";
      [0.18, 0.39, 0.61, 0.82].forEach(function (t) {
        var x = (1 - t) * (1 - t) * x0 + 2 * (1 - t) * t * cx + t * t * x1;
        var y = (1 - t) * (1 - t) * 2 + 2 * (1 - t) * t * cy + t * t * 2;
        var c = BULBS[k % BULBS.length], delay = ((k * 0.73) % 3.2).toFixed(2);
        bulbs += '<g class="bulb" style="animation-delay:-' + delay + 's">' +
          '<circle cx="' + x.toFixed(1) + '" cy="' + (y + 9).toFixed(1) + '" r="13" fill="' + c + '" opacity=".3" filter="url(#' + gid + ')"/>' +
          '<rect x="' + (x - 2.5).toFixed(1) + '" y="' + (y - 1).toFixed(1) + '" width="5" height="5" rx="1" fill="#3B3221"/>' +
          '<ellipse cx="' + x.toFixed(1) + '" cy="' + (y + 9).toFixed(1) + '" rx="5" ry="7" fill="' + c + '"/>' +
          '<ellipse cx="' + (x - 1.3).toFixed(1) + '" cy="' + (y + 7).toFixed(1) + '" rx="1.2" ry="2" fill="#fff" opacity=".7"/></g>';
        k++;
      });
    }
    el.innerHTML = '<svg viewBox="0 0 ' + w + ' ' + h + '" aria-hidden="true"><defs><filter id="' + gid + '" x="-1" y="-1" width="3" height="3"><feGaussianBlur stdDeviation="4"/></filter></defs>' +
      '<path d="' + wire + '" fill="none" stroke="#6B5A36" stroke-width="1.4"/>' + bulbs + '</svg>';
  }

  // ---------- Hero slideshow ----------
  function initSlides() {
    var imgs = document.querySelectorAll("#slides img"), dots = document.querySelectorAll("[data-slide]"), cur = 0, timer = null;
    if (!imgs.length) return;
    function show(i) {
      cur = (i + imgs.length) % imgs.length;
      Array.prototype.forEach.call(imgs, function (im, k) { im.classList.toggle("is-on", k === cur); });
      Array.prototype.forEach.call(dots, function (d, k) { d.setAttribute("aria-pressed", String(k === cur)); });
    }
    function start() { if (!reduceMotion) { clearInterval(timer); timer = setInterval(function () { show(cur + 1); }, 4500); } }
    Array.prototype.forEach.call(dots, function (d) {
      d.addEventListener("click", function () { show(+d.getAttribute("data-slide")); start(); });
    });
    start();
  }
  function debounce(fn, ms) { var t; return function () { clearTimeout(t); t = setTimeout(fn, ms); }; }

  // ---------- Render all ----------
  function renderAll() {
    document.documentElement.style.setProperty("--lang", L().color);
    ["#postcards", "#langtabs2", "#langtabs3"].forEach(function (id) {
      Array.prototype.forEach.call($(id).children, function (b) { b.setAttribute("aria-selected", String(b.getAttribute("data-lang") === state.lang)); });
    });
    $("#edswitch").innerHTML = edSwitchHtml();
    renderSet(); renderBooks(); renderPages(); renderGift();
  }

  // ---------- Events ----------
  document.addEventListener("click", function (e) {
    var lb = e.target.closest("[data-lang]");
    if (lb) { setLang(lb.getAttribute("data-lang")); return; }
    var ed = e.target.closest("[data-ed]");
    if (ed) { setEdition(ed.getAttribute("data-ed")); return; }
    var pickEd = e.target.closest("[data-pick-ed]");
    if (pickEd) { setEdition(pickEd.getAttribute("data-pick-ed")); return; }
    var play = e.target.closest("[data-audio]");
    if (play) { toggleAudio(play); return; }
    var tr = e.target.closest("[data-track]");
    if (tr) track("CTA", { position: tr.getAttribute("data-track") });
  });
  document.addEventListener("change", function (e) {
    var t = e.target;
    if (t.name === "setfmt") { state.setFormat = t.value; renderSet(); var a = $("#setfmt-" + t.value); if (a) a.focus(); }
    else if (t.name === "giftaudio") { state.giftAudio = t.value; renderGift(); var g = $("#giftaudio-" + t.value); if (g) g.focus(); }
    else if (t.hasAttribute && t.hasAttribute("data-book")) onBookFormat(t);
  });

  // Mobile Leiste: nicht über dem Hero und nicht in den Kaufbereichen
  function initMbar() {
    var bar = $("#mbar"), watch = [$(".hero"), $("#buecher"), $("#geschenksets")];
    if (!("IntersectionObserver" in window)) { bar.classList.add("is-on"); return; }
    var vis = watch.map(function () { return false; });
    vis[0] = true;
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { vis[watch.indexOf(en.target)] = en.isIntersecting; });
      bar.classList.toggle("is-on", !vis.some(Boolean));
    }, { threshold: 0.02 });
    watch.forEach(function (el) { io.observe(el); });
  }

  // ---------- Init ----------
  renderPostcards();
  renderTabs($("#langtabs2"));
  renderTabs($("#langtabs3"));
  renderFaq();
  renderCountdown();
  renderAll();
  function garlands() { buildGarland($("#garland2"), 2); }
  garlands();
  window.addEventListener("resize", debounce(garlands, 200));
  initSlides();
  initMbar();
  initConsent();

  // Direktlink aus der Anzeige: ?lang=fr, ?ziel=geschenk
  if ((params.get("lang") || params.get("ziel")) && !location.hash) {
    var target = params.get("ziel") === "geschenk" ? "#geschenksets" : "#buecher";
    setTimeout(function () { var el = $(target); if (el) el.scrollIntoView(); }, 60);
  }
})();
