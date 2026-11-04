(function () {
  "use strict";
  var D = window.EO;
  var $ = function (s, r) { return (r || document).querySelector(s); };

  // ---------- State ----------
  var params = new URLSearchParams(location.search);
  var state = {
    lang: pick(params.get("lang") || params.get("sprache"), D.LANGS.map(function (l) { return l.code; }), "it"),
    edition: pick(params.get("ausgabe") || params.get("edition"), ["frank", "wort"], "frank"),
    setFormat: "print",
    giftAudio: "online",
    bookFormat: {}
  };
  function pick(v, list, def) { return list.indexOf(v) >= 0 ? v : def; }
  function L() { return D.LANGS.filter(function (l) { return l.code === state.lang; })[0]; }
  function E(id) { return D.editions[id || state.edition]; }

  // ---------- Helpers ----------
  function eur(n) { return n.toFixed(2).replace(".", ",") + "\u00a0€"; }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); }
  function fmt(key) { return D.formats.filter(function (f) { return f.key === key; })[0]; }

  // UTM / fbclid aus der Anzeige an den Shop weiterreichen
  var passKeys = ["utm_source", "utm_medium", "utm_campaign", "utm_content", "utm_term", "fbclid"];
  function passthrough() {
    var out = [];
    passKeys.forEach(function (k) { var v = params.get(k); if (v) out.push(k + "=" + encodeURIComponent(v)); });
    return out.length ? "&" + out.join("&") : "";
  }
  function cartUrlVariation(parentId, variationId, formatKey) {
    return D.shop + D.cartPath + "?add-to-cart=" + parentId + "&variation_id=" + variationId +
      "&attribute_pa_buch-ebook=" + fmt(formatKey).slug + passthrough();
  }
  function cartUrlSimple(id) { return D.shop + D.cartPath + "?add-to-cart=" + id + passthrough(); }

  var cartIcon = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9h16l-1.4 11H5.4L4 9zm4 0V7a4 4 0 018 0v2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>';

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

  // Kauf-Klick: Pixel-Event, dann zum Shop
  function wireBuy(a, info) {
    a.addEventListener("click", function () {
      track("AddToCart", { content_ids: [String(info.id)], content_name: info.name, content_type: "product", value: info.value, currency: "EUR" });
    });
  }

  // ---------- Language tabs (3 synchronised groups) ----------
  function renderTabs(el) {
    el.innerHTML = D.LANGS.map(function (l) {
      return '<button class="langtab" type="button" role="tab" data-lang="' + l.code + '" style="--c:' + l.color + '" aria-selected="' + (l.code === state.lang) + '">' +
        '<span class="langtab__dot">' + l.code + '</span>' + esc(l.name) + ' <small lang="' + l.code + '">' + esc(l.greeting) + '</small></button>';
    }).join("");
    el.addEventListener("click", function (e) {
      var b = e.target.closest("[data-lang]");
      if (!b) return;
      setLang(b.getAttribute("data-lang"));
    });
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

  // ---------- Edition switch ----------
  function renderEdSwitch() {
    $("#edswitch").innerHTML = ["frank", "wort"].map(function (id) {
      var e = E(id);
      return '<button class="edopt" type="button" role="radio" data-ed="' + id + '" aria-checked="' + (id === state.edition) + '">' +
        '<span class="edopt__top"><span class="edopt__name">' + e.name + '</span><span class="edopt__lvl">' + e.level + '</span></span>' +
        '<span class="edopt__line">' + e.line + '</span></button>';
    }).join("");
  }

  // ---------- Set card ----------
  function renderSet() {
    var l = L(), e = E(), prices = D.setPrices[state.edition], set = l.set[state.edition];
    var price = prices[state.setFormat];
    var isDigital = state.setFormat === "pdf" || state.setFormat === "epub";
    var shipTxt = isDigital ? '<span class="ship">Sofort als Download, ohne Versandkosten</span>'
      : (price > D.freeShippingFrom ? '<span class="ship">✓ Versandkostenfrei in der EU</span>' : '<span class="ship ship--no">zzgl. 6,90 € Versand</span>');
    var url = cartUrlVariation(set.id, set.vars[state.setFormat], state.setFormat);
    $("#setcard").innerHTML =
      '<div class="setcard__img"><img src="img/set-' + l.code + '-' + state.edition + '.webp" alt="' + esc(l.setName) + ' – ' + e.name + ' ' + e.level + ', drei Bücher" width="900" height="900"></div>' +
      '<div class="setcard__body">' +
        '<p class="badge">Set · 3 Bücher · 30 Geschichten</p>' +
        '<h3>' + esc(l.setName) + '</h3>' +
        '<p class="setcard__claim">' + esc(l.claim) + '</p>' +
        '<p class="setcard__meta">' + esc(l.places) + ' · ' + e.name + ' ' + e.level + '</p>' +
        '<fieldset class="formats"><legend>Format</legend>' +
          D.formats.map(function (f) {
            return '<label class="fmt"><input type="radio" name="setfmt" id="setfmt-' + f.key + '" value="' + f.key + '"' + (f.key === state.setFormat ? " checked" : "") + '>' +
              '<span>' + f.label + ' <b>' + eur(prices[f.key]) + '</b></span></label>';
          }).join("") +
        '</fieldset>' +
        '<div class="buy">' +
          '<div class="price"><span class="price__v">' + eur(price) + '</span>' + shipTxt + '</div>' +
          '<a class="btn btn--lang" id="set-buy" href="' + url + '">' + cartIcon + 'In den Warenkorb</a>' +
          '<p class="buy__hint">Weiter zum Warenkorb auf easyoriginal.com</p>' +
        '</div>' +
      '</div>';
    wireBuy($("#set-buy"), { id: set.vars[state.setFormat], name: l.setName + " " + e.name, value: price });
  }

  // ---------- Single books ----------
  function renderBooks() {
    var l = L(), e = E(), prices = D.bookPrices[state.edition];
    $("#single-head").textContent = "Oder einzeln: E-Book " + eur(prices.pdf) + ", Taschenbuch " + eur(prices.print);
    var host = $("#books");
    host.innerHTML = l.books.map(function (b, i) {
      var fk = state.bookFormat[b.key] || "print";
      var p = b[state.edition];
      return '<article class="book">' +
        '<div class="book__cover"><img loading="lazy" src="img/cover-' + l.code + '-' + b.key + '-' + state.edition + '.webp" alt="Cover: ' + esc(b.title) + ' – ' + esc(b.de) + ', ' + e.level + '" width="520" height="780"></div>' +
        '<div class="book__body">' +
          '<p class="book__place">Band ' + (i + 1) + ' · ' + esc(b.place) + '</p>' +
          '<h4 lang="' + l.code + '">' + esc(b.title) + '</h4>' +
          '<p class="book__de">' + esc(b.de) + '</p>' +
          '<p class="book__hook">' + esc(b.hook) + '</p>' +
          '<div class="book__row"><span class="book__price" id="bp-' + b.key + '">' + eur(prices[fk]) + '</span></div>' +
          '<div class="book__row">' +
            '<select id="bf-' + b.key + '" data-book="' + b.key + '" aria-label="Format für ' + esc(b.title) + '">' +
              D.formats.map(function (f) { return '<option value="' + f.key + '"' + (f.key === fk ? " selected" : "") + '>' + f.label + ' – ' + eur(prices[f.key]) + '</option>'; }).join("") +
            '</select>' +
            '<a class="btn btn--lang" id="bb-' + b.key + '" href="' + cartUrlVariation(p.id, p.vars[fk], fk) + '">' + cartIcon + 'Kaufen</a>' +
          '</div>' +
        '</div></article>';
    }).join("");
    l.books.forEach(function (b) {
      var a = $("#bb-" + b.key);
      wireBuy(a, { get id() { return b[state.edition].vars[state.bookFormat[b.key] || "print"]; }, name: b.title, get value() { return D.bookPrices[state.edition][state.bookFormat[b.key] || "print"]; } });
    });
  }
  function onBookFormat(sel) {
    var key = sel.getAttribute("data-book"), fk = sel.value, l = L();
    state.bookFormat[key] = fk;
    var b = l.books.filter(function (x) { return x.key === key; })[0], p = b[state.edition];
    $("#bp-" + key).textContent = eur(D.bookPrices[state.edition][fk]);
    $("#bb-" + key).href = cartUrlVariation(p.id, p.vars[fk], fk);
  }

  // ---------- Sample pages ----------
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
        '<button class="play" type="button" data-audio="' + id + '" aria-pressed="false"><span class="play__i"><svg viewBox="0 0 16 16" aria-hidden="true"><path d="M4 2.5v11l9-5.5z" fill="currentColor"/></svg></span><span class="play__t">Hörprobe anhören</span></button>' +
        '<ul class="page__pts">' + e.points.map(function (t) { return '<li>' + esc(t) + '</li>'; }).join("") + '</ul>' +
        '<p class="page__fit"><b>Passt, wenn …</b>' + esc(e.fit) + '</p>' +
        '<div class="page__price"><span>Set ab ' + eur(p.pdf) + ' · Einzelband ab ' + eur(D.bookPrices[id].pdf) + '</span>' +
        '<a href="#buecher" data-pick-ed="' + id + '">Diese Ausgabe wählen →</a></div>' +
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
    }).catch(function () {
      btn.querySelector(".play__t").textContent = "Hörprobe nicht verfügbar";
    });
  }
  audio.addEventListener("ended", stopAudio);

  // ---------- Gift ----------
  function renderGift() {
    var l = L(), e = E(), gp = D.giftPrices[state.edition], gid = l.gift[state.edition][state.giftAudio];
    var price = gp[state.giftAudio];
    $("#gift").innerHTML =
      '<div class="gift__img"><img loading="lazy" src="img/gift-' + l.code + '-' + state.edition + '.webp" alt="Geschenkset ' + esc(l.setName) + ' mit drei Büchern und Schreibset ' + esc(l.gift.schreibset) + '" width="900" height="900"></div>' +
      '<div class="gift__body">' +
        '<p class="badge">Geschenkset · ' + e.name + ' ' + e.level + '</p>' +
        '<h3>' + esc(l.setName) + ' + Notiz\u2011Set</h3>' +
        '<ul class="gift__list">' + D.giftContents.map(function (t) { return '<li>' + esc(t) + '</li>'; }).join("") + '</ul>' +
        '<div class="gift__set"><img loading="lazy" src="' + l.gift.schreibsetImg + '" alt="Schreibset ' + esc(l.gift.schreibset) + ' Deluxe" width="900" height="900">' +
          '<p><b>Schreibset „' + esc(l.gift.schreibset) + '“ Deluxe</b>Zwei Notizbücher, ein Notizheft, Lesezeichen und Stifte im passenden Design – für neue Wörter und Leseeindrücke.</p></div>' +
        '<div class="edswitch edswitch--gift" role="radiogroup" aria-label="Ausgabe im Geschenkset" style="margin:0">' +
          ["frank", "wort"].map(function (id) {
            var x = E(id);
            return '<button class="edopt" type="button" role="radio" data-ed="' + id + '" aria-checked="' + (id === state.edition) + '"><span class="edopt__top"><span class="edopt__name">' + x.name + '</span><span class="edopt__lvl">' + x.level + '</span></span></button>';
          }).join("") +
        '</div>' +
        '<fieldset class="formats seg"><legend>Audio</legend>' +
          '<label class="fmt"><input type="radio" name="giftaudio" id="giftaudio-online" value="online"' + (state.giftAudio === "online" ? " checked" : "") + '><span>Audio-Online <small>' + eur(gp.online) + '</small></span></label>' +
          '<label class="fmt"><input type="radio" name="giftaudio" id="giftaudio-cd" value="cd"' + (state.giftAudio === "cd" ? " checked" : "") + '><span>Mit Audio-CDs <small>' + eur(gp.cd) + '</small></span></label>' +
        '</fieldset>' +
        '<div class="buy">' +
          '<div class="price"><span class="price__v">' + eur(price) + '</span><span class="ship">✓ Versandkostenfrei in der EU</span></div>' +
          '<a class="btn btn--lang" id="gift-buy" href="' + cartUrlSimple(gid) + '">' + cartIcon + 'Geschenkset in den Warenkorb</a>' +
          '<p class="buy__hint">Weiter zum Warenkorb auf easyoriginal.com</p>' +
        '</div>' +
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
    var now = new Date();
    var eve = new Date(now.getFullYear(), 11, 24);
    if (now > new Date(now.getFullYear(), 11, 26)) eve = new Date(now.getFullYear() + 1, 11, 24);
    var days = Math.ceil((eve - new Date(now.getFullYear(), now.getMonth(), now.getDate())) / 864e5);
    var t = days > 1 ? "Noch " + days + " Tage bis Heiligabend" : days === 1 ? "Morgen ist Heiligabend" : "Frohe Weihnachten!";
    $("#xmas-count").textContent = t;
    $("#xmas-count-2").textContent = days > 1 ? t + " – genug Zeit, um noch ein paar Geschichten zu lesen." : t;
  }

  // ---------- Render all ----------
  function renderAll() {
    document.documentElement.style.setProperty("--lang", L().color);
    ["#langtabs", "#langtabs2", "#langtabs3"].forEach(function (id) {
      Array.prototype.forEach.call($(id).children, function (b) { b.setAttribute("aria-selected", String(b.getAttribute("data-lang") === state.lang)); });
    });
    renderEdSwitch();
    renderSet();
    renderBooks();
    renderPages();
    renderGift();
  }

  // ---------- Events ----------
  document.addEventListener("click", function (e) {
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
    if (t.name === "setfmt") { state.setFormat = t.value; renderSet(); var el = $("#setfmt-" + t.value); if (el) el.focus(); }
    else if (t.name === "giftaudio") { state.giftAudio = t.value; renderGift(); var g = $("#giftaudio-" + t.value); if (g) g.focus(); }
    else if (t.hasAttribute && t.hasAttribute("data-book")) onBookFormat(t);
  });

  // Mobile Leiste erst nach dem Hero zeigen, im Kaufbereich ausblenden
  function initMbar() {
    var bar = $("#mbar"), hero = $(".hero"), books = $("#buecher"), gift = $("#geschenksets");
    if (!("IntersectionObserver" in window)) { bar.classList.add("is-on"); return; }
    var vis = { hero: true, buy: false };
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.target === hero) vis.hero = en.isIntersecting;
        else vis.buy = en.isIntersecting;
      });
      bar.classList.toggle("is-on", !vis.hero && !vis.buy);
    }, { threshold: 0.05 });
    io.observe(hero); io.observe(books); io.observe(gift);
  }

  // ---------- Init ----------
  renderTabs($("#langtabs"));
  renderTabs($("#langtabs2"));
  renderTabs($("#langtabs3"));
  renderFaq();
  renderCountdown();
  renderAll();
  initMbar();
  initConsent();

  // Direktlink aus der Anzeige: ?lang=fr#geschenksets usw.
  if (params.get("lang") && !location.hash) {
    var target = params.get("ziel") === "geschenk" ? "#geschenksets" : "#buecher";
    setTimeout(function () { var el = $(target); if (el) el.scrollIntoView(); }, 50);
  }
})();
