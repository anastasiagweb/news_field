/* easyOriginal – Redesign 2026: gemeinsames Verhalten aller Seiten. Kein Framework nötig. */
(function () {
  'use strict';

  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

  var LANGS = {
    en: { name: 'Englisch', code: 'EN' },
    fr: { name: 'Französisch', code: 'FR' },
    it: { name: 'Italienisch', code: 'IT' },
    es: { name: 'Spanisch', code: 'ES' },
    ru: { name: 'Russisch', code: 'RU' },
    de: { name: 'Deutsch', code: 'DE' }
  };
  var LOCAL_PAGES = {
    'https://easyoriginal.com/shop/franzoesisch-deutsch/arsene-lupin-1-larrestation-darsene-lupin-die-verhaftung-von-arsene-lupin/': 'produkt-arsene-lupin.html'
  };

  var store = {
    get: function (k) { try { return window.localStorage.getItem(k); } catch (e) { return null; } },
    set: function (k, v) { try { window.localStorage.setItem(k, v); } catch (e) { /* privat */ } }
  };

  function euro(n) {
    return n.toLocaleString('de-AT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
  }
  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  /* ---------- Produktkarte ---------- */
  function cardHTML(p, opts) {
    opts = opts || {};
    var href = LOCAL_PAGES[p.url] || p.url;
    var lang = LANGS[p.lang];
    var tags = '';
    if (opts.showLang !== false && lang) tags += '<span class="chip chip--lang lang-' + p.lang + '" title="' + lang.name + '">' + lang.code + '</span>';
    if (p.level) tags += '<span class="chip chip--level">' + esc(p.level) + '</span>';
    else if (p.series === 'Klassiker') tags += '<span class="chip chip--level">Original</span>';
    var badges = p.sale ? '<span class="chip chip--sale">Set-Preis</span>' : '';
    var meta = [];
    if (p.author) meta.push(esc(p.author));
    else if (opts.showSeries && p.series) meta.push(esc(p.series));
    var price = p.from == null ? '' :
      (p.to && p.to !== p.from ? '<small>ab</small> ' + euro(p.from) : euro(p.from));
    var ext = href.indexOf('http') === 0 ? ' target="_blank" rel="noopener"' : '';
    return '' +
      '<article class="card' + (p.lang ? ' lang-' + p.lang : '') + '"' + (p.c ? ' style="--c:' + esc(p.c) + '"' : '') + '>' +
        '<div class="card__media' + (p.square ? ' card__media--square' : '') + '">' +
          (badges ? '<div class="card__badges">' + badges + '</div>' : '') +
          (p.img ? '<img src="' + esc(p.img) + '" alt="" loading="lazy" decoding="async">' : '') +
        '</div>' +
        '<div class="card__body">' +
          ((tags || meta.length) ? '<div class="card__meta">' + tags + (meta.length ? '<span>' + meta.join(' · ') + '</span>' : '') + '</div>' : '') +
          '<h3 class="card__title"><a class="card__link" href="' + esc(href) + '"' + ext + '>' + esc(p.title) + '</a></h3>' +
          (p.de ? '<p class="card__de">' + esc(p.de) + '</p>' : '') +
          '<div class="card__price">' + price + '</div>' +
        '</div>' +
      '</article>';
  }
  window.EO_cardHTML = cardHTML;

  /* ---------- Header ---------- */
  var header = $('.header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Mega-Menüs: Hover auf Desktop, Klick/Tastatur überall
  $$('.nav__item[data-menu]').forEach(function (item) {
    var btn = $('.nav__link', item);
    var closeTimer;
    function open(v) {
      $$('.nav__item.is-open').forEach(function (o) { if (o !== item) { o.classList.remove('is-open'); $('.nav__link', o).setAttribute('aria-expanded', 'false'); } });
      item.classList.toggle('is-open', v);
      btn.setAttribute('aria-expanded', String(v));
    }
    var hoverOpenedAt = 0;
    btn.addEventListener('click', function () {
      // Wurde das Menü gerade erst per Hover geöffnet, soll der Klick es nicht sofort wieder schließen.
      if (Date.now() - hoverOpenedAt < 600) { open(true); return; }
      open(!item.classList.contains('is-open'));
    });
    item.addEventListener('mouseenter', function () {
      if (!window.matchMedia('(hover: hover)').matches) return;
      clearTimeout(closeTimer);
      if (!item.classList.contains('is-open')) hoverOpenedAt = Date.now();
      open(true);
    });
    item.addEventListener('mouseleave', function () { if (window.matchMedia('(hover: hover)').matches) closeTimer = setTimeout(function () { open(false); }, 120); });
    item.addEventListener('keydown', function (e) { if (e.key === 'Escape') { open(false); btn.focus(); } });
    item.addEventListener('focusout', function (e) { if (!item.contains(e.relatedTarget)) open(false); });
  });
  document.addEventListener('click', function (e) {
    $$('.nav__item.is-open').forEach(function (o) {
      if (!o.contains(e.target)) { o.classList.remove('is-open'); $('.nav__link', o).setAttribute('aria-expanded', 'false'); }
    });
  });

  // Mobile Drawer
  var drawer = $('#drawer');
  if (drawer) {
    var lastFocus;
    var setDrawer = function (v) {
      drawer.classList.toggle('is-open', v);
      drawer.setAttribute('aria-hidden', String(!v));
      document.body.style.overflow = v ? 'hidden' : '';
      if (v) { lastFocus = document.activeElement; setTimeout(function () { $('.drawer__close', drawer).focus(); }, 50); }
      else if (lastFocus) lastFocus.focus();
    };
    $$('[data-drawer-open]').forEach(function (b) { b.addEventListener('click', function () { setDrawer(true); }); });
    $$('[data-drawer-close]', drawer).forEach(function (b) { b.addEventListener('click', function () { setDrawer(false); }); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && drawer.classList.contains('is-open')) setDrawer(false); });
  }

  /* ---------- Warenkorb (Demo) & Toast ---------- */
  var cartCount = parseInt(store.get('eo-cart') || '0', 10) || 0;
  function renderCart() { $$('.cart-count').forEach(function (el) { el.textContent = cartCount; el.setAttribute('data-count', cartCount); }); }
  renderCart();
  var toast = $('#toast'), toastTimer;
  function showToast(html) {
    if (!toast) return;
    toast.innerHTML = html;
    toast.classList.add('is-visible');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { toast.classList.remove('is-visible'); }, 3200);
  }
  window.EO_addToCart = function (qty, label) {
    cartCount += qty;
    store.set('eo-cart', String(cartCount));
    renderCart();
    showToast('✓ ' + esc(label) + ' liegt im Warenkorb <a href="#">Zur Kasse</a>');
  };

  /* ---------- Regal mit Tabs (Startseite) ---------- */
  var shelf = $('#shelf');
  if (shelf && window.EO_HOME) {
    var track = $('.shelf__track', shelf);
    var prev = $('[data-shelf-prev]'), next = $('[data-shelf-next]');
    var renderShelf = function (key) {
      track.innerHTML = window.EO_HOME[key].map(function (p) { return cardHTML(p); }).join('');
      track.scrollLeft = 0;
      updateArrows();
    };
    var updateArrows = function () {
      if (!prev) return;
      prev.disabled = track.scrollLeft < 8;
      next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 8;
    };
    $$('.shelf-tabs [role="tab"]').forEach(function (tab) {
      tab.addEventListener('click', function () {
        $$('.shelf-tabs [role="tab"]').forEach(function (t) { t.setAttribute('aria-selected', String(t === tab)); });
        renderShelf(tab.getAttribute('data-key'));
      });
    });
    var step = function (dir) { track.scrollBy({ left: dir * track.clientWidth * 0.8, behavior: 'smooth' }); };
    if (prev) { prev.addEventListener('click', function () { step(-1); }); next.addEventListener('click', function () { step(1); }); }
    track.addEventListener('scroll', updateArrows, { passive: true });
    renderShelf('bestseller');
  }

  /* ---------- Frank-Leser: Hilfen an/aus + Audio ---------- */
  $$('.reader').forEach(function (reader) {
    $$('[data-mode]', reader).forEach(function (b) {
      if (b === reader) return;
      b.addEventListener('click', function () {
        reader.setAttribute('data-mode', b.getAttribute('data-mode'));
        $$('.toggle [data-mode]', reader).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
      });
    });
    var btn = $('.audio-btn', reader);
    var audio = $('audio', reader);
    if (btn && audio) {
      var bar = $('.audio-btn__bar span', btn);
      var label = $('.audio-btn__label', btn);
      btn.addEventListener('click', function () {
        if (audio.paused) {
          audio.play().catch(function () { label.textContent = 'Audio nicht verfügbar'; });
        } else audio.pause();
      });
      audio.addEventListener('play', function () { btn.classList.add('is-playing'); label.textContent = 'Pause'; btn.setAttribute('aria-pressed', 'true'); });
      audio.addEventListener('pause', function () { btn.classList.remove('is-playing'); label.textContent = 'Anhören'; btn.setAttribute('aria-pressed', 'false'); });
      audio.addEventListener('timeupdate', function () { if (audio.duration) bar.style.width = (audio.currentTime / audio.duration * 100) + '%'; });
    }
  });

  /* ---------- Katalog: Filter, Suche, Sortierung ---------- */
  var catalog = $('#catalog');
  if (catalog && window.EO_CATALOG_EN) {
    var all = window.EO_CATALOG_EN.map(function (p, i) { p.rank = i; p.lang = 'en'; return p; });
    var grid = $('#catalog-grid');
    var countEl = $('#result-count');
    var params = new URLSearchParams(window.location.search);
    var state = {
      level: params.get('niveau') || 'alle',
      series: params.getAll('reihe'),
      q: params.get('q') || '',
      sale: params.get('angebote') === '1',
      sort: params.get('sort') || 'beliebt'
    };
    var levelOf = function (p) { return p.series === 'Klassiker' ? 'original' : (p.level || 'sets'); };

    // Zähler an den Niveau-Buttons
    $$('[data-level]', catalog).forEach(function (b) {
      var lv = b.getAttribute('data-level');
      var n = all.filter(function (p) { return lv === 'alle' || levelOf(p) === lv; }).length;
      var s = document.createElement('small'); s.textContent = n; b.appendChild(s);
    });

    var syncUI = function () {
      $$('[data-level]', catalog).forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-level') === state.level)); });
      $$('input[name="reihe"]', catalog).forEach(function (c) { c.checked = state.series.indexOf(c.value) > -1; });
      $('#only-sale').checked = state.sale;
      $('#sort').value = state.sort;
      $('#q').value = state.q;
    };
    var writeURL = function () {
      var p = new URLSearchParams();
      if (state.level !== 'alle') p.set('niveau', state.level);
      state.series.forEach(function (s) { p.append('reihe', s); });
      if (state.q) p.set('q', state.q);
      if (state.sale) p.set('angebote', '1');
      if (state.sort !== 'beliebt') p.set('sort', state.sort);
      var qs = p.toString();
      history.replaceState(null, '', qs ? '?' + qs : window.location.pathname);
    };
    var render = function () {
      var q = state.q.trim().toLowerCase();
      var list = all.filter(function (p) {
        if (state.level !== 'alle' && levelOf(p) !== state.level) return false;
        if (state.series.length && state.series.indexOf(p.series) === -1) return false;
        if (state.sale && !p.sale) return false;
        if (q && [p.title, p.de, p.author, p.series].join(' ').toLowerCase().indexOf(q) === -1) return false;
        return true;
      });
      var by = {
        beliebt: function (a, b) { return a.rank - b.rank; },
        preis_auf: function (a, b) { return a.from - b.from; },
        preis_ab: function (a, b) { return b.from - a.from; },
        titel: function (a, b) { return a.title.localeCompare(b.title, 'de'); }
      }[state.sort];
      list.sort(by);
      countEl.innerHTML = '<strong>' + list.length + '</strong> ' + (list.length === 1 ? 'Buch' : 'Bücher');
      if (!list.length) {
        grid.innerHTML = '<div class="empty"><strong>Keine Treffer</strong>Versuchen Sie ein anderes Niveau oder entfernen Sie Filter.<br><br><button class="btn btn--ghost" type="button" id="reset">Alle Filter zurücksetzen</button></div>';
        $('#reset').addEventListener('click', function () { state = { level: 'alle', series: [], q: '', sale: false, sort: 'beliebt' }; syncUI(); render(); writeURL(); });
        return;
      }
      var html = list.map(function (p) { return cardHTML(p, { showLang: false, showSeries: !p.author }); });
      var firstSet = list.findIndex(function (p) { return p.series === 'Bücher-Sets'; });
      if (firstSet > -1 && state.series.length !== 1) {
        html.splice(firstSet, 0, '<div class="set-banner"><span><strong>Bücher-Sets</strong> – bis zu 40 % günstiger als einzeln</span><span>Ideal zum Verschenken ✦</span></div>');
      }
      grid.innerHTML = html.join('');
    };

    $$('[data-level]', catalog).forEach(function (b) {
      b.addEventListener('click', function () { state.level = b.getAttribute('data-level'); syncUI(); render(); writeURL(); });
    });
    $$('input[name="reihe"]', catalog).forEach(function (c) {
      c.addEventListener('change', function () {
        state.series = $$('input[name="reihe"]:checked', catalog).map(function (x) { return x.value; });
        render(); writeURL();
      });
    });
    $('#only-sale').addEventListener('change', function (e) { state.sale = e.target.checked; render(); writeURL(); });
    $('#sort').addEventListener('change', function (e) { state.sort = e.target.value; render(); writeURL(); });
    var qTimer;
    $('#q').addEventListener('input', function (e) { clearTimeout(qTimer); qTimer = setTimeout(function () { state.q = e.target.value; render(); writeURL(); }, 150); });
    $$('[data-jump-series]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        state.series = [a.getAttribute('data-jump-series')]; state.level = 'alle';
        syncUI(); render(); writeURL();
        catalog.scrollIntoView({ behavior: 'smooth' });
      });
    });
    syncUI();
    render();
  }

  /* ---------- Produktseite: Format & Menge ---------- */
  var buy = $('#buy-form');
  if (buy) {
    var priceEl = $('#price'), stickyPrice = $('#sticky-price'), stickyFormat = $('#sticky-format');
    var qty = $('#qty');
    var ebookType = $('.ebook-type', buy);
    var current = function () { return $('input[name="format"]:checked', buy); };
    var update = function () {
      var f = current();
      var total = parseFloat(f.getAttribute('data-price')) * (parseInt(qty.value, 10) || 1);
      priceEl.textContent = euro(total);
      if (stickyPrice) { stickyPrice.textContent = euro(total); stickyFormat.textContent = f.getAttribute('data-label'); }
      ebookType.classList.toggle('is-visible', f.value === 'ebook');
    };
    $$('input[name="format"]', buy).forEach(function (r) { r.addEventListener('change', update); });
    $$('[data-qty]', buy).forEach(function (b) {
      b.addEventListener('click', function () {
        var v = Math.min(99, Math.max(1, (parseInt(qty.value, 10) || 1) + parseInt(b.getAttribute('data-qty'), 10)));
        qty.value = v; update();
      });
    });
    qty.addEventListener('input', update);
    buy.addEventListener('submit', function (e) {
      e.preventDefault();
      var f = current();
      var label = f.getAttribute('data-label');
      if (f.value === 'ebook') label = 'E-Book (' + $('input[name="ebook"]:checked', buy).value + ')';
      window.EO_addToCart(parseInt(qty.value, 10) || 1, label);
    });
    var stickyBtn = $('#sticky-add');
    if (stickyBtn) stickyBtn.addEventListener('click', function () { buy.requestSubmit ? buy.requestSubmit() : buy.dispatchEvent(new Event('submit', { cancelable: true })); });
    var sticky = $('.sticky-buy');
    if (sticky && 'IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        var on = !entries[0].isIntersecting && entries[0].boundingClientRect.top < 0;
        sticky.classList.toggle('is-visible', on);
        document.body.classList.toggle('has-sticky-buy', on && window.matchMedia('(max-width: 960px)').matches);
      }).observe($('.buy', buy));
    }
    update();
  }
  $$('[data-expand]').forEach(function (b) {
    b.addEventListener('click', function () {
      var box = b.closest('.review-card');
      var on = box.classList.toggle('is-expanded');
      b.textContent = on ? 'Weniger anzeigen' : 'Ganze Rezension lesen';
      b.setAttribute('aria-expanded', String(on));
    });
  });

  /* ---------- Newsletter (Demo) ---------- */
  $$('.newsletter form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      form.closest('.newsletter').classList.add('is-done');
    });
  });

  /* ---------- Design-Varianten (Prototyp) ---------- */
  var root = document.documentElement;
  var setSkin = function (v) {
    root.setAttribute('data-skin', v);
    store.set('eo-skin', v);
    $$('[data-skin-set]').forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-skin-set') === v)); });
    try {
      var u = new URL(window.location.href);
      u.searchParams.set('v', v);
      history.replaceState(null, '', u.pathname + u.search + u.hash);
    } catch (e) { /* file:// */ }
  };
  $$('[data-skin-set]').forEach(function (b) {
    b.setAttribute('aria-pressed', String(b.getAttribute('data-skin-set') === root.getAttribute('data-skin')));
    b.addEventListener('click', function () { setSkin(b.getAttribute('data-skin-set')); });
  });
  // Interne Links behalten die gewählte Variante
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a[href$=".html"], a[href*=".html?"], a[href*=".html#"]');
    if (!a || a.target) return;
    var v = root.getAttribute('data-skin');
    if (v === 'buch') return;
    var href = a.getAttribute('href');
    if (/[?&]v=/.test(href)) return;
    var parts = href.split('#');
    a.setAttribute('href', parts[0] + (parts[0].indexOf('?') > -1 ? '&' : '?') + 'v=' + v + (parts[1] ? '#' + parts[1] : ''));
  }, true);

  var SC = window.EO_SHOWCASE;

  /* ---------- Bücherregal: Buchrücken ---------- */
  var spinesEl = $('#spines');
  if (spinesEl && SC) {
    var ink = function (hex) {
      var n = parseInt(hex.slice(1), 16), r = n >> 16, g = (n >> 8) & 255, b = n & 255;
      return (0.299 * r + 0.587 * g + 0.114 * b) > 150 ? '#1e1b17' : '#fff8ec';
    };
    spinesEl.innerHTML = SC.spines.map(function (p) {
      var href = LOCAL_PAGES[p.url] || p.url;
      var lang = LANGS[p.lang] || { code: '' };
      var label = p.title + (p.author ? ' – ' + p.author : '') + (p.de ? ' (' + p.de + ')' : '');
      return '<a class="spine lang-' + p.lang + '" href="' + esc(href) + '"' + (href.indexOf('http') === 0 ? ' target="_blank" rel="noopener"' : '') +
        ' style="--c:' + p.c + ';--spine-ink:' + ink(p.c) + ';--w:' + p.w + 'px;--h:' + p.h + 'px" aria-label="' + esc(label) + '">' +
        '<span class="spine__title">' + esc(p.title) + '</span><span class="spine__code">' + lang.code + '</span>' +
        '<span class="spine__peek" aria-hidden="true"><img src="' + esc(p.img) + '" alt="" loading="lazy"><small>' + esc(p.title) + (p.from ? ' · ab ' + euro(p.from) : '') + '</small></span></a>';
    }).join('');
  }

  /* ---------- Cover-Laufband ---------- */
  $$('[data-marquee]').forEach(function (row) {
    if (!SC) return;
    var half = Math.ceil(SC.marquee.length / 2);
    var list = row.getAttribute('data-marquee') === '0' ? SC.marquee.slice(0, half) : SC.marquee.slice(half);
    var html = list.map(function (p) {
      return '<a href="' + esc(LOCAL_PAGES[p.url] || p.url) + '" tabindex="-1" target="_blank" rel="noopener"><img src="' + esc(p.img) + '" alt="" loading="lazy"></a>';
    }).join('');
    row.innerHTML = html + html; // doppelt für nahtlose Schleife
  });

  /* ---------- Audio-Wellenform (Dekor) ---------- */
  $$('.wave').forEach(function (w) {
    var h = [10, 18, 26, 14, 30, 22, 12, 28, 34, 20, 16, 26, 12, 22, 30, 18, 10, 24, 32, 16, 26, 14, 20, 28, 12, 18, 24, 10];
    w.innerHTML = h.map(function (x) { return '<span style="height:' + x + 'px"></span>'; }).join('');
  });

  /* ---------- Einblenden beim Scrollen ---------- */
  var revealEls = $$('[data-reveal]');
  if ('IntersectionObserver' in window && revealEls.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-in'); });
  }

  /* ---------- 3D-Neigung der Cover (nur Maus) ---------- */
  if (window.matchMedia('(hover: hover) and (prefers-reduced-motion: no-preference)').matches) {
    document.addEventListener('pointermove', function (e) {
      var m = e.target.closest && e.target.closest('.card__media');
      if (!m) return;
      var r = m.getBoundingClientRect();
      m.style.setProperty('--ry', ((e.clientX - r.left) / r.width - 0.5) * 14 + 'deg');
      m.style.setProperty('--rx', (0.5 - (e.clientY - r.top) / r.height) * 10 + 'deg');
    });
    document.addEventListener('pointerout', function (e) {
      var m = e.target.closest && e.target.closest('.card__media');
      if (m && !m.contains(e.relatedTarget)) { m.style.setProperty('--ry', '0deg'); m.style.setProperty('--rx', '0deg'); }
    });
  }

  /* ---------- Cookie-Hinweis ---------- */
  var consent = $('#consent');
  if (consent && !store.get('eo-consent')) {
    consent.classList.add('is-visible');
    $$('[data-consent]', consent).forEach(function (b) {
      b.addEventListener('click', function () { store.set('eo-consent', b.getAttribute('data-consent')); consent.classList.remove('is-visible'); });
    });
  }
})();
