/* easyOriginal 2026 – Verhalten des Divi-Child-Themes. */
(function ($) {
  'use strict';

  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };
  var one = function (sel, root) { return (root || document).querySelector(sel); };
  var T = (window.EO && window.EO.i18n) || {};
  var store = {
    get: function (k) { try { return window.localStorage.getItem(k); } catch (e) { return null; } },
    set: function (k, v) { try { window.localStorage.setItem(k, v); } catch (e) { /* privat */ } }
  };

  /* ---------- Kopfzeile ---------- */
  var header = one('.header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  $$('.nav__item[data-menu]').forEach(function (item) {
    var btn = one('.nav__link', item), closeTimer, hoverOpenedAt = 0;
    var open = function (v) {
      $$('.nav__item.is-open').forEach(function (o) { if (o !== item) { o.classList.remove('is-open'); one('.nav__link', o).setAttribute('aria-expanded', 'false'); } });
      item.classList.toggle('is-open', v);
      btn.setAttribute('aria-expanded', String(v));
    };
    btn.addEventListener('click', function () {
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
    $$('.nav__item.is-open').forEach(function (o) { if (!o.contains(e.target)) { o.classList.remove('is-open'); one('.nav__link', o).setAttribute('aria-expanded', 'false'); } });
  });

  var drawer = one('#drawer');
  if (drawer) {
    var lastFocus;
    var setDrawer = function (v) {
      drawer.classList.toggle('is-open', v);
      drawer.setAttribute('aria-hidden', String(!v));
      document.body.style.overflow = v ? 'hidden' : '';
      if (v) { lastFocus = document.activeElement; setTimeout(function () { one('.drawer__close', drawer).focus(); }, 50); }
      else if (lastFocus) lastFocus.focus();
    };
    $$('[data-drawer-open]').forEach(function (b) { b.addEventListener('click', function () { setDrawer(true); }); });
    $$('[data-drawer-close]', drawer).forEach(function (b) { b.addEventListener('click', function () { setDrawer(false); }); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && drawer.classList.contains('is-open')) setDrawer(false); });
  }

  /* ---------- Leseprobe: Hilfen an/aus + Audio ---------- */
  $$('.reader').forEach(function (reader) {
    $$('.toggle [data-mode]', reader).forEach(function (b) {
      b.addEventListener('click', function () {
        reader.setAttribute('data-mode', b.getAttribute('data-mode'));
        $$('.toggle [data-mode]', reader).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
      });
    });
    var btn = one('.audio-btn', reader), audio = one('audio', reader);
    if (btn && audio) {
      var bar = one('.audio-btn__bar span', btn), label = one('.audio-btn__label', btn);
      btn.addEventListener('click', function () {
        if (audio.paused) audio.play().catch(function () { label.textContent = T.noAudio || 'Audio nicht verfügbar'; });
        else audio.pause();
      });
      audio.addEventListener('play', function () { btn.classList.add('is-playing'); label.textContent = T.pause || 'Pause'; btn.setAttribute('aria-pressed', 'true'); });
      audio.addEventListener('pause', function () { btn.classList.remove('is-playing'); label.textContent = T.listen || 'Anhören'; btn.setAttribute('aria-pressed', 'false'); });
      audio.addEventListener('timeupdate', function () { if (audio.duration) bar.style.width = (audio.currentTime / audio.duration * 100) + '%'; });
    }
  });
  $$('.wave').forEach(function (w) {
    w.innerHTML = [10, 18, 26, 14, 30, 22, 12, 28, 34, 20, 16, 26, 12, 22, 30, 18, 10, 24, 32, 16, 26, 14, 20, 28, 12, 18, 24, 10]
      .map(function (x) { return '<span style="height:' + x + 'px"></span>'; }).join('');
  });

  /* ---------- Regal mit Tabs ---------- */
  $$('#shelf').forEach(function (shelf) {
    var tabs = $$('[role="tab"]', shelf), prev = one('[data-shelf-prev]', shelf), next = one('[data-shelf-next]', shelf);
    var current = function () { return one('.shelf__track:not([hidden])', shelf); };
    var update = function () {
      var t = current(); if (!t || !prev) return;
      prev.disabled = t.scrollLeft < 8;
      next.disabled = t.scrollLeft + t.clientWidth >= t.scrollWidth - 8;
    };
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) {
          var on = t === tab;
          t.setAttribute('aria-selected', String(on));
          var panel = document.getElementById(t.getAttribute('aria-controls'));
          if (panel) { panel.hidden = !on; if (on) panel.scrollLeft = 0; }
        });
        update();
      });
    });
    $$('.shelf__track', shelf).forEach(function (t) { t.addEventListener('scroll', update, { passive: true }); });
    if (prev) {
      prev.addEventListener('click', function () { current().scrollBy({ left: -current().clientWidth * 0.8, behavior: 'smooth' }); });
      next.addEventListener('click', function () { current().scrollBy({ left: current().clientWidth * 0.8, behavior: 'smooth' }); });
    }
    update();
  });

  /* ---------- Einblenden & Neigung ---------- */
  var reveal = $$('[data-reveal]');
  if ('IntersectionObserver' in window && reveal.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    reveal.forEach(function (el) { io.observe(el); });
  } else {
    reveal.forEach(function (el) { el.classList.add('is-in'); });
  }
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

  /* ---------- Produktseite: Formate als Karten ---------- */
  $$('form.variations_form').forEach(function (form) {
    var selects = $$('table.variations select', form);
    if (selects.length !== 1) return; // nur bei genau einem Merkmal (z. B. Buchformat)
    var select = selects[0];
    var data = [];
    try { data = JSON.parse(form.getAttribute('data-product_variations') || '[]') || []; } catch (e) { data = []; }
    var attrName = select.getAttribute('data-attribute_name') || select.name;
    var priceFor = function (val) {
      for (var i = 0; i < data.length; i++) {
        var a = data[i].attributes || {};
        if (a[attrName] === val || a[attrName] === '') return data[i];
      }
      return null;
    };
    var labelEl = one('label[for="' + select.id + '"]', form);
    var fs = document.createElement('fieldset');
    fs.className = 'formats eo-formats';
    fs.innerHTML = '<legend>' + (labelEl ? labelEl.textContent.trim() : 'Format') + '</legend>';
    $$('option', select).forEach(function (opt) {
      if (!opt.value) return;
      var v = priceFor(opt.value);
      var parts = opt.textContent.trim().split(' + ');
      var lab = document.createElement('label');
      lab.className = 'format';
      lab.innerHTML = '<input type="radio" name="eo_fmt_' + select.id + '" value="' + opt.value.replace(/"/g, '&quot;') + '">' +
        '<span class="format__radio" aria-hidden="true"></span>' +
        '<span><strong></strong><small></small></span>' +
        '<span class="format__price">' + (v && v.price_html ? v.price_html.replace(/<p[^>]*>|<\/p>/g, '') : '') + '</span>';
      one('strong', lab).textContent = parts[0];
      one('small', lab).textContent = parts.length > 1 ? '+ ' + parts.slice(1).join(' + ') : '';
      if (v && v.is_in_stock === false) { lab.classList.add('is-out'); one('input', lab).disabled = true; }
      fs.appendChild(lab);
    });
    var table = one('table.variations', form);
    table.parentNode.insertBefore(fs, table);
    form.classList.add('eo-has-cards');
    var sync = function () { $$('input[type="radio"]', fs).forEach(function (r) { r.checked = r.value === select.value; }); };
    fs.addEventListener('change', function (e) {
      if (e.target.type !== 'radio') return;
      select.value = e.target.value;
      if ($) $(select).trigger('change'); else select.dispatchEvent(new Event('change', { bubbles: true }));
    });
    if ($) $(form).on('reset_data woocommerce_update_variation_values', sync);
    sync();
  });

  /* ---------- Kaufleiste mobil ---------- */
  var sticky = one('.sticky-buy'), anchor = one('#eo-buy');
  if (sticky && anchor && 'IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      var on = !entries[0].isIntersecting && entries[0].boundingClientRect.top < 0;
      sticky.classList.toggle('is-visible', on);
      document.body.classList.toggle('has-sticky-buy', on && window.matchMedia('(max-width: 960px)').matches);
    }).observe(anchor.parentNode);
  }

  /* ---------- Toast nach „In den Warenkorb“ ---------- */
  var toast = one('#toast'), toastTimer;
  if ($ && toast) {
    $(document.body).on('added_to_cart', function () {
      toast.textContent = '✓ ' + (document.documentElement.lang.indexOf('de') === 0 ? 'Im Warenkorb' : 'Added to cart');
      toast.classList.add('is-visible');
      clearTimeout(toastTimer);
      toastTimer = setTimeout(function () { toast.classList.remove('is-visible'); }, 3000);
    });
  }

  /* ---------- Katalog-Shortcode ---------- */
  $$('.eo-catalog').forEach(function (cat) {
    var items = $$('.eo-cat-item', cat), grid = one('.book-grid', cat), empty = one('.empty', cat), count = one('.result-count', cat);
    var state = { level: 'alle', series: [], q: '', sale: false, sort: 'beliebt' };
    var render = function () {
      var q = state.q.trim().toLowerCase(), shown = [];
      items.forEach(function (it) {
        var ok = (state.level === 'alle' || it.getAttribute('data-level') === state.level) &&
          (!state.series.length || state.series.some(function (s) { return it.getAttribute('data-series').indexOf('|' + s + '|') > -1; })) &&
          (!state.sale || it.getAttribute('data-sale') === '1') &&
          (!q || it.getAttribute('data-search').indexOf(q) > -1);
        it.hidden = !ok;
        if (ok) shown.push(it);
      });
      var by = {
        beliebt: function (a, b) { return a.getAttribute('data-rank') - b.getAttribute('data-rank'); },
        preis_auf: function (a, b) { return a.getAttribute('data-price') - b.getAttribute('data-price'); },
        preis_ab: function (a, b) { return b.getAttribute('data-price') - a.getAttribute('data-price'); },
        titel: function (a, b) { return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'), 'de'); }
      }[state.sort];
      items.slice().sort(by).forEach(function (it) { grid.insertBefore(it, empty); });
      empty.hidden = shown.length > 0;
      count.innerHTML = '<strong>' + shown.length + '</strong> ' + (shown.length === 1 ? (T.book || 'Buch') : (T.books || 'Bücher'));
    };
    $$('[data-level]', cat).forEach(function (b) {
      b.addEventListener('click', function () {
        state.level = b.getAttribute('data-level');
        $$('[data-level]', cat).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        render();
      });
    });
    $$('input[name="reihe"]', cat).forEach(function (c) {
      c.addEventListener('change', function () { state.series = $$('input[name="reihe"]:checked', cat).map(function (x) { return x.value; }); render(); });
    });
    var sale = one('[data-sale-only]', cat); if (sale) sale.addEventListener('change', function () { state.sale = sale.checked; render(); });
    var sort = one('[data-sort]', cat); if (sort) sort.addEventListener('change', function () { state.sort = sort.value; render(); });
    var qi = one('[data-q]', cat), qt;
    if (qi) qi.addEventListener('input', function () { clearTimeout(qt); qt = setTimeout(function () { state.q = qi.value; render(); }, 150); });
    render();
  });

  /* ---------- Varianten-Umschalter (nur Administratoren) ---------- */
  $$('[data-skin-set]').forEach(function (b) {
    b.addEventListener('click', function () {
      var v = b.getAttribute('data-skin-set');
      document.documentElement.setAttribute('data-skin', v);
      document.cookie = 'eo_skin_preview=' + v + ';path=/;max-age=2592000;SameSite=Lax';
      $$('[data-skin-set]').forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
      document.body.className = document.body.className.replace(/\beo-skin-\w+/, 'eo-skin-' + v);
    });
  });
})(window.jQuery);
