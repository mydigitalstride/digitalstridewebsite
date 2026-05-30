/**
 * questionnaire.js — Website Quote Questionnaire (v2)
 *
 * Additive pricing model:
 *   base (business type / goal) + size add-on + product count (eCommerce)
 *   + content + integrations + add-ons → × platform multiplier
 *
 * Payment plans: 3 mo (0%), 6 mo (5%), 12 mo (10%)
 * PDF: generated client-side via jsPDF, uploaded to server, emailed to
 *      client + results@mydigitalstride.com, and offered as download.
 */
(function () {
  'use strict';

  /* ─── Pricing Tables ─────────────────────────────────────────────── */

  /** Base prices by business type (Elementor baseline, before multipliers). */
  var BASE_PRICES = {
    trades:       { min: 2500,  max: 5500  },
    contractor:   { min: 2500,  max: 5500  },
    industrial:   { min: 2500,  max: 5500  },
    other:        { min: 2500,  max: 5500  },
    ecommerce:    { min: 5000,  max: 18000 },
    trade_school: { min: 12000, max: 28000 }
  };

  /** When a non-eCommerce business picks an eCommerce/school goal, override base. */
  var GOAL_OVERRIDES = {
    sell_products:   { min: 5000,  max: 18000 },
    enroll_students: { min: 12000, max: 28000 }
  };

  /** Additive amounts for website size (step 3). */
  var SIZE_ADDONS = {
    small:   { min: 0,    max: 0     },
    medium:  { min: 1000, max: 2500  },
    large:   { min: 2000, max: 5000  },
    complex: { min: 5000, max: 10000 }
  };

  /** Per-product cost for eCommerce product count step. */
  var PER_PRODUCT = { min: 50, max: 100 };

  /** Integration add-ons (step 6). Payment gateway removed per spec. */
  var INTEGRATION_ADDONS = {
    booking:    { label: 'Online Booking / Appointment Scheduler', icon: '📅', min: 150,  max: 500  },
    crm:        { label: 'CRM / Dispatch Integration',             icon: '⚙️',  min: 1500, max: 4000 },
    customer_portal: { label: 'Customer Portal',                  icon: '🎓', min: 600,  max: 3000 },
    email_mktg: { label: 'Email Marketing Integration',            icon: '📧', min: 150,  max: 500  }
  };

  /** Local SEO pricing scales with site size. */
  var LOCAL_SEO_BY_SIZE = {
    small:   { min: 300,  max: 800  },
    medium:  { min: 500,  max: 1000 },
    large:   { min: 500,  max: 1500 },
    complex: { min: 2500, max: 4500 }
  };

  /** Other add-ons (step 7). Rush removed per spec. */
  var ADDON_PRICES = {
    local_seo: null,  // size-based — see LOCAL_SEO_BY_SIZE
    multilang: { label: 'Multi-language Support',                    icon: '🌐', min: 500, max: 1500 },
    ada:       { label: 'ADA / WCAG Accessibility Audit',            icon: '♿', min: 300, max: 800  }
  };

  /** Content add-ons (step 5). */
  var CONTENT_ADDONS = {
    copy_ds:    { label: 'DS Writes All Copy',                          icon: '📝', min: 1200, max: 3500 },
    copy_photo: { label: 'Copywriting + Professional Photography/Video', icon: '📸', min: 2000, max: 6500 }
  };

  /** Platform multipliers applied to the computed base+addons total. */
  var PLATFORM_MULT = {
    elementor: 1.0,
    custom:    1.25,
    shopify:   0.95
  };

  var PLATFORM_LABELS = {
    elementor: { name: 'WordPress + Elementor', short: 'WP Elementor',   desc: 'Flexible, easy to update'        },
    custom:    { name: 'WordPress Custom Build', short: 'WP Custom Build', desc: 'Premium, pixel-perfect design'   },
    shopify:   { name: 'Shopify',               short: 'Shopify',          desc: 'Purpose-built for eCommerce'     }
  };

  /** Tier metadata for display (scope, colour). Tier is derived from answers. */
  var TIER_META = {
    starter: {
      label: 'Starter', color: '#22c55e',
      signals: 'Small lead-gen site, single location, client-supplied content',
      includes: [
        'Up to 5 custom-designed pages', 'Mobile-responsive layout',
        'Contact &amp; lead-capture form', 'Basic on-page SEO',
        'Google Analytics integration', 'SSL &amp; speed optimisation',
        '30-day post-launch support'
      ]
    },
    professional: {
      label: 'Professional', color: '#3b82f6',
      signals: 'Multi-page service site, location pages, scheduler integration',
      includes: [
        'Up to 15 custom-designed pages', 'Service-area &amp; location pages',
        'Appointment scheduler integration', 'Mobile-first design',
        'On-page SEO for all pages', 'Lead &amp; estimate capture forms',
        'Google Analytics + Search Console', '60-day post-launch support'
      ]
    },
    ecommerce: {
      label: 'eCommerce', color: '#f59e0b',
      signals: 'Online store, product catalog, payment gateway, shipping',
      includes: [
        'Full eCommerce store setup', 'Custom product catalog',
        'Payment gateway integration', 'Inventory &amp; variant management',
        'Cart &amp; checkout optimisation', 'Basic shipping &amp; tax setup',
        'Mobile-optimised shopping experience', '60-day post-launch support'
      ]
    },
    trade_school: {
      label: 'Trade School', color: '#8b5cf6',
      signals: 'Enrollment system, LMS, financial-aid pages, multi-program',
      includes: [
        'LMS integration (LearnDash or similar)', 'Enrollment &amp; application system',
        'Financial-aid information pages', 'Student portal setup',
        'Multi-program site architecture', 'Accreditation &amp; trust-signal pages',
        'Application workflow &amp; notifications', '90-day post-launch support'
      ]
    },
    enterprise: {
      label: 'Enterprise', color: '#ef4444',
      signals: 'Multi-location + eCommerce + CRM + custom feature development',
      includes: [
        'Unlimited pages &amp; sections', 'Multi-location site architecture',
        'Custom feature development', 'Advanced CRM &amp; dispatch integration',
        'Custom admin dashboards', 'Performance-optimised infrastructure',
        'Priority support &amp; SLA', '120-day post-launch support'
      ]
    }
  };

  var PAYMENT_PLANS = [
    { months: 3,  fee: 0,    feeLabel: '0% finance fee'  },
    { months: 6,  fee: 0.05, feeLabel: '5% finance fee'  },
    { months: 12, fee: 0.10, feeLabel: '10% finance fee' }
  ];

  /* ─── Application State ──────────────────────────────────────────── */

  var state = {
    businessType:  null,
    primaryGoal:   null,
    productCount:  0,
    websiteSize:   null,
    coverage:      null,
    contentNeeds:  null,
    integrations:  [],
    addons:        [],
    platform:      null,
    timeline:      null
  };

  var currentStep  = '1';
  var TOTAL_STEPS  = 9;   // visual step count for progress bar

  // Pre-load logo as base64 so it's ready when PDF is generated
  var _logoBase64 = null;
  (function () {
    var url = window.qbData && window.qbData.logoUrl;
    if (!url) return;
    var img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = function () {
      try {
        var c = document.createElement('canvas');
        c.width = img.naturalWidth; c.height = img.naturalHeight;
        var ctx = c.getContext('2d');
        ctx.drawImage(img, 0, 0);
        _logoBase64 = c.toDataURL('image/png');
      } catch (e) { /* cross-origin canvas blocked — logo skipped */ }
    };
    img.src = url;
  }());

  /* ─── Step helpers ───────────────────────────────────────────────── */

  /** Map step ID → visual step number (for progress bar). */
  function stepToNum(s) {
    var m = { '1':1,'2':2,'2b':2,'3':3,'4':4,'5':5,'6':6,'7':7,'8':8,'9':9,'10':9,'11':9 };
    return m[String(s)] || 1;
  }

  function isEcomPath()   { return state.businessType === 'ecommerce' || state.primaryGoal === 'sell_products'; }
  function isSchoolPath() { return state.businessType === 'trade_school' || state.primaryGoal === 'enroll_students'; }

  /* ─── Pricing ────────────────────────────────────────────────────── */

  function getBasePrice() {
    if (GOAL_OVERRIDES[state.primaryGoal]) return GOAL_OVERRIDES[state.primaryGoal];
    return BASE_PRICES[state.businessType] || { min: 2500, max: 5500 };
  }

  function getTierKey() {
    if (isSchoolPath()) return 'trade_school';
    if (isEcomPath())   return 'ecommerce';
    var score = 0;
    if      (state.websiteSize === 'medium')  score += 2;
    else if (state.websiteSize === 'large')   score += 5;
    else if (state.websiteSize === 'complex') score += 9;
    if (state.coverage === 'multi_location' || state.coverage === 'national') score += 2;
    var ints = state.integrations.filter(function (i) { return i !== 'none'; });
    score += ints.length;
    if (ints.indexOf('crm') !== -1) score += 2;
    if (score >= 10) return 'enterprise';
    if (score >= 4)  return 'professional';
    return 'starter';
  }

  function calculateQuote() {
    var base = getBasePrice();
    var size = SIZE_ADDONS[state.websiteSize] || SIZE_ADDONS.small;

    var min = base.min + size.min;
    var max = base.max + size.max;

    // eCommerce: product count
    if (isEcomPath() && state.productCount > 0) {
      min += state.productCount * PER_PRODUCT.min;
      max += state.productCount * PER_PRODUCT.max;
    }

    // Content
    if      (state.contentNeeds === 'copy_ds')    { min += CONTENT_ADDONS.copy_ds.min;    max += CONTENT_ADDONS.copy_ds.max;    }
    else if (state.contentNeeds === 'copy_photo') { min += CONTENT_ADDONS.copy_photo.min; max += CONTENT_ADDONS.copy_photo.max; }

    // Integrations
    state.integrations.forEach(function (k) {
      if (INTEGRATION_ADDONS[k] && INTEGRATION_ADDONS[k].min) {
        min += INTEGRATION_ADDONS[k].min;
        max += INTEGRATION_ADDONS[k].max;
      }
    });

    // Add-ons
    if (state.addons.indexOf('local_seo') !== -1) {
      var seo = LOCAL_SEO_BY_SIZE[state.websiteSize] || LOCAL_SEO_BY_SIZE.small;
      min += seo.min;
      max += seo.max;
    }
    if (state.addons.indexOf('multilang') !== -1) { min += ADDON_PRICES.multilang.min; max += ADDON_PRICES.multilang.max; }
    if (state.addons.indexOf('ada')       !== -1) { min += ADDON_PRICES.ada.min;       max += ADDON_PRICES.ada.max;       }

    // Platform multipliers
    var tierKey  = getTierKey();
    var tierMeta = TIER_META[tierKey];
    var result   = { tierKey: tierKey, tierMeta: tierMeta, platforms: {}, baseMin: min, baseMax: max };

    ['elementor', 'custom', 'shopify'].forEach(function (p) {
      var m   = PLATFORM_MULT[p];
      var pMin = Math.round(min * m);
      var pMax = Math.round(max * m);
      result.platforms[p] = { min: pMin, max: pMax, midpoint: Math.round((pMin + pMax) / 2) };
    });

    return result;
  }

  /* ─── Helpers ────────────────────────────────────────────────────── */

  function fmt(n) { return '$' + n.toLocaleString('en-US'); }
  function el(id) { return document.getElementById(id); }
  function qs(sel, ctx)  { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return (ctx || document).querySelectorAll(sel); }

  /* ─── Progress Bar ───────────────────────────────────────────────── */

  function updateProgress(step) {
    var num   = stepToNum(step);
    var pct   = Math.round((num / TOTAL_STEPS) * 100);
    var bar   = el('qb-progress-bar');
    var label = el('qb-progress-label');
    var wrap  = qs('.qb-progress');

    if (step === '10' || step === '11') {
      if (bar)   bar.style.width  = '100%';
      if (label) label.textContent = step === '10' ? 'Almost done!' : 'Complete!';
      if (wrap)  wrap.setAttribute('aria-valuenow', 100);
    } else {
      if (bar)   bar.style.width  = pct + '%';
      if (label) label.textContent = 'Step ' + num + ' of ' + TOTAL_STEPS;
      if (wrap)  wrap.setAttribute('aria-valuenow', pct);
    }
  }

  /* ─── Live Estimate Badge ────────────────────────────────────────── */

  function updateEstimateBadge() {
    var badge = el('qb-estimate-badge');
    var range = el('qb-estimate-range');
    if (!badge || !range || !state.businessType) return;
    var quote = calculateQuote();
    var pref  = (state.platform && state.platform !== 'unsure') ? state.platform : 'elementor';
    var p     = quote.platforms[pref];
    range.textContent = fmt(p.min) + ' \u2013 ' + fmt(p.max);
    badge.hidden = false;
  }

  /* ─── Navigation ─────────────────────────────────────────────────── */

  function goToStep(next) {
    var fromEl = el('qb-step-' + currentStep);
    var toEl   = el('qb-step-' + next);
    if (!toEl) return;

    if (fromEl) fromEl.classList.remove('is-active');
    toEl.classList.add('is-active');
    setTimeout(function () { toEl.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 60);

    currentStep = String(next);
    updateProgress(currentStep);
    updateEstimateBadge();

    // When entering step 6, hide Customer Portal option for trade school paths
    if (String(next) === '6') {
      var cpCheck = qs('.qb-check input[value="customer_portal"]');
      if (cpCheck) {
        var cpRow = cpCheck.closest('.qb-check');
        if (isSchoolPath()) {
          cpRow.hidden = true;
          cpCheck.checked = false;
          cpRow.classList.remove('is-checked');
          state.integrations = state.integrations.filter(function (i) { return i !== 'customer_portal'; });
        } else {
          cpRow.hidden = false;
        }
      }
    }
  }

  function nextFromStep(step) {
    step = String(step);
    if (step === '1') {
      // eCommerce → product count step; Trade School → skip goal, go straight to size
      if (state.businessType === 'ecommerce')    return goToStep('2b');
      if (state.businessType === 'trade_school') return goToStep('3');
      return goToStep('2');
    }
    if (step === '2')  return goToStep('3');
    if (step === '2b') return goToStep('3');
    if (step === '9')  return goToStep('10');   // contact form before results
    // default: increment
    return goToStep(parseInt(step, 10) + 1);
  }

  function backFromStep(step) {
    step = String(step);
    if (step === '3') {
      if (state.businessType === 'ecommerce')    return goToStep('2b');
      if (state.businessType === 'trade_school') return goToStep('1');
      return goToStep('2');
    }
    if (step === '2b') return goToStep('1');
    if (step === '11') return goToStep('10');
    var prev = parseInt(step, 10) - 1;
    if (prev >= 1) goToStep(prev);
  }

  /* ─── Next Button State ──────────────────────────────────────────── */

  function setNextEnabled(step, enabled) {
    var btn = el('qb-next-' + step);
    if (!btn) return;
    btn.disabled = !enabled;
    btn.setAttribute('aria-disabled', enabled ? 'false' : 'true');
  }

  /* ─── Single-select Options ──────────────────────────────────────── */

  function bindSingleSelect(stepId, fieldName) {
    var stepEl = el('qb-step-' + stepId);
    if (!stepEl) return;
    qsa('[data-field="' + fieldName + '"]', stepEl).forEach(function (btn) {
      btn.addEventListener('click', function () {
        qsa('[data-field="' + fieldName + '"]', stepEl).forEach(function (b) {
          b.classList.remove('is-selected');
          b.setAttribute('aria-pressed', 'false');
        });
        btn.classList.add('is-selected');
        btn.setAttribute('aria-pressed', 'true');
        state[fieldName] = btn.getAttribute('data-value');
        setNextEnabled(stepId, true);
        updateEstimateBadge();
      });
    });
  }

  /* ─── Multi-select Checkboxes ────────────────────────────────────── */

  function bindMultiSelect(listId, stateKey) {
    var listEl = el(listId);
    if (!listEl) return;
    qsa('.qb-check', listEl).forEach(function (label) {
      var input  = qs('.qb-check__input', label);
      var isNone = label.classList.contains('qb-check--none');
      if (!input) return;
      input.addEventListener('change', function () {
        if (isNone && input.checked) {
          qsa('.qb-check:not(.qb-check--none) .qb-check__input', listEl).forEach(function (cb) {
            cb.checked = false;
            cb.closest('.qb-check').classList.remove('is-checked');
          });
        } else if (!isNone && input.checked) {
          var noneInput = qs('.qb-check--none .qb-check__input', listEl);
          if (noneInput) { noneInput.checked = false; noneInput.closest('.qb-check').classList.remove('is-checked'); }
        }
        label.classList.toggle('is-checked', input.checked);
        var selected = [];
        qsa('.qb-check__input:checked', listEl).forEach(function (cb) { selected.push(cb.value); });
        state[stateKey] = selected;
        updateEstimateBadge();
      });
    });
  }

  /* ─── Render Quote ───────────────────────────────────────────────── */

  function renderQuote() {
    var quote    = calculateQuote();
    var tierKey  = quote.tierKey;
    var tierMeta = quote.tierMeta;

    // Tier badge
    var tierBadge = el('qb-tier-badge');
    if (tierBadge) { tierBadge.textContent = tierMeta.label + ' Tier'; tierBadge.style.background = tierMeta.color; }

    var quoteSub = el('qb-quote-sub');
    if (quoteSub) quoteSub.textContent = tierMeta.signals;

    // Platform cards
    var cardsEl = el('qb-platform-cards');
    if (cardsEl) {
      var preferred    = (state.platform && state.platform !== 'unsure') ? state.platform : null;
      var recommended  = (tierKey === 'ecommerce') ? 'shopify' : 'elementor';

      cardsEl.innerHTML = ['elementor', 'custom', 'shopify'].map(function (p) {
        var prices = quote.platforms[p];
        var pl     = PLATFORM_LABELS[p];
        var isRec  = p === recommended;
        var isSel  = p === preferred;
        var cls    = 'qb-platform-card' + (isRec ? ' is-recommended' : '') + (isSel && !isRec ? ' is-selected' : '');
        var badge  = isRec
          ? '<span class="qb-platform-card__badge">Recommended</span>'
          : (isSel ? '<span class="qb-platform-card__badge" style="background:var(--qb-orange)">Your Choice</span>' : '');

        return '<div class="' + cls + '">' + badge +
          '<h4 class="qb-platform-card__name">' + pl.name + '</h4>' +
          '<p class="qb-platform-card__desc">' + pl.desc + '</p>' +
          '<div class="qb-platform-card__range">' +
            '<span class="qb-platform-card__min">' + fmt(prices.min) + '</span>' +
            '<span class="qb-platform-card__sep">&ndash;</span>' +
            '<span class="qb-platform-card__max">' + fmt(prices.max) + '</span>' +
          '</div></div>';
      }).join('');
    }

    // Scope list
    var scopeEl = el('qb-scope-list');
    if (scopeEl) {
      scopeEl.innerHTML = tierMeta.includes.map(function (item) {
        return '<li class="qb-scope-item"><span class="qb-scope-item__check" aria-hidden="true">\u2713</span>' + item + '</li>';
      }).join('');
    }

    // Selected add-ons
    var addonsBlock = el('qb-selected-addons-block');
    var addonsEl    = el('qb-selected-addons');
    var selected = buildSelectedAddonsList();

    if (selected.length === 0) {
      if (addonsBlock) addonsBlock.hidden = true;
    } else {
      if (addonsBlock) addonsBlock.hidden = false;
      if (addonsEl) {
        addonsEl.innerHTML = selected.map(function (item) {
          return '<div class="qb-addon-item">' +
            '<span class="qb-addon-item__icon">' + item.icon + '</span>' +
            '<span class="qb-addon-item__label">' + item.label + '</span>' +
            '<span class="qb-addon-item__price">+' + item.priceLabel + '</span>' +
          '</div>';
        }).join('');
      }
    }

    // Payment plans
    var initPlatform = (state.platform && state.platform !== 'unsure') ? state.platform : 'elementor';
    renderPaymentPlans(initPlatform, quote);

    // Activate matching tab
    qsa('.qb-tab[data-platform]').forEach(function (tab) {
      var active = tab.getAttribute('data-platform') === initPlatform;
      tab.classList.toggle('is-active', active);
      tab.setAttribute('aria-selected', active ? 'true' : 'false');
    });

    // Re-bind tab click handlers (clone to clear old listeners)
    qsa('.qb-tab[data-platform]').forEach(function (tab) {
      var fresh = tab.cloneNode(true);
      tab.parentNode.replaceChild(fresh, tab);
      fresh.addEventListener('click', function () {
        qsa('.qb-tab[data-platform]').forEach(function (t) { t.classList.remove('is-active'); t.setAttribute('aria-selected', 'false'); });
        fresh.classList.add('is-active');
        fresh.setAttribute('aria-selected', 'true');
        renderPaymentPlans(fresh.getAttribute('data-platform'), quote);
      });
    });
  }

  function buildSelectedAddonsList() {
    var items = [];
    if (state.contentNeeds === 'copy_ds')    items.push({ icon: '📝', label: CONTENT_ADDONS.copy_ds.label,    priceLabel: fmt(CONTENT_ADDONS.copy_ds.min)    + '\u2013' + fmt(CONTENT_ADDONS.copy_ds.max)    });
    if (state.contentNeeds === 'copy_photo') items.push({ icon: '📸', label: CONTENT_ADDONS.copy_photo.label, priceLabel: fmt(CONTENT_ADDONS.copy_photo.min) + '\u2013' + fmt(CONTENT_ADDONS.copy_photo.max) });

    state.integrations.forEach(function (k) {
      if (k !== 'none' && INTEGRATION_ADDONS[k] && INTEGRATION_ADDONS[k].min) {
        items.push({ icon: INTEGRATION_ADDONS[k].icon, label: INTEGRATION_ADDONS[k].label,
          priceLabel: fmt(INTEGRATION_ADDONS[k].min) + '\u2013' + fmt(INTEGRATION_ADDONS[k].max) });
      }
    });

    if (state.addons.indexOf('local_seo') !== -1) {
      var seo = LOCAL_SEO_BY_SIZE[state.websiteSize] || LOCAL_SEO_BY_SIZE.small;
      items.push({ icon: '📍', label: 'Local SEO Setup (GMB, Schema, Citations)', priceLabel: fmt(seo.min) + '\u2013' + fmt(seo.max) });
    }
    if (state.addons.indexOf('multilang') !== -1) items.push({ icon: ADDON_PRICES.multilang.icon, label: ADDON_PRICES.multilang.label, priceLabel: fmt(ADDON_PRICES.multilang.min) + '\u2013' + fmt(ADDON_PRICES.multilang.max) });
    if (state.addons.indexOf('ada')       !== -1) items.push({ icon: ADDON_PRICES.ada.icon,       label: ADDON_PRICES.ada.label,       priceLabel: fmt(ADDON_PRICES.ada.min)       + '\u2013' + fmt(ADDON_PRICES.ada.max)       });

    if (isEcomPath() && state.productCount > 0) {
      items.push({ icon: '🛒', label: 'Product Setup (' + state.productCount + ' products)',
        priceLabel: fmt(state.productCount * PER_PRODUCT.min) + '\u2013' + fmt(state.productCount * PER_PRODUCT.max) });
    }
    return items;
  }

  function renderPaymentPlans(platform, quote) {
    var plansEl = el('qb-payment-plans');
    if (!plansEl) return;
    var prices = quote.platforms[platform];
    var mid = prices.midpoint;

    plansEl.innerHTML = PAYMENT_PLANS.map(function (plan, idx) {
      var total   = Math.round(mid * (1 + plan.fee));
      var monthly = Math.round(total / plan.months);
      var cls     = 'qb-plan-card' + (idx === 0 ? ' qb-plan-card--popular' : '');
      return '<div class="' + cls + '">' +
        '<p class="qb-plan-card__months">' + plan.months + ' Monthly Payments</p>' +
        '<p class="qb-plan-card__fee">' + plan.feeLabel + '</p>' +
        '<div class="qb-plan-card__monthly">' + fmt(monthly) + '</div>' +
        '<p class="qb-plan-card__per">per month</p>' +
        '<hr class="qb-plan-card__divider">' +
        '<p class="qb-plan-card__total">Total: <strong>' + fmt(total) + '</strong></p>' +
      '</div>';
    }).join('');

    var note = qs('.qb-payment-note');
    if (note) {
      note.textContent = '* Based on ' + PLATFORM_LABELS[platform].name + ' midpoint of ' + fmt(mid) +
        ' (range: ' + fmt(prices.min) + '\u2013' + fmt(prices.max) + '). Final amounts confirmed at proposal.';
    }
  }

  /* ─── PDF Generation ─────────────────────────────────────────────── */

  function buildSummaryText(contact) {
    var quote   = calculateQuote();
    var tierKey = quote.tierKey;
    var lines   = [
      'DIGITAL STRIDE — WEBSITE QUOTE ESTIMATE',
      '========================================',
      'Date: ' + new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }),
      '',
      'CLIENT',
      '  Name    : ' + (contact.name     || ''),
      '  Business: ' + (contact.business || ''),
      '  Email   : ' + (contact.email    || ''),
      '  Phone   : ' + (contact.phone    || ''),
      '',
      'PROJECT OVERVIEW',
      '  Tier          : ' + TIER_META[tierKey].label,
      '  Business type : ' + (state.businessType || 'n/a'),
      '  Primary goal  : ' + (state.primaryGoal  || 'n/a'),
      '  Website size  : ' + (state.websiteSize  || 'n/a'),
      '  Coverage      : ' + (state.coverage     || 'n/a'),
      '  Content needs : ' + (state.contentNeeds || 'n/a'),
      '  Integrations  : ' + (state.integrations.join(', ') || 'none'),
      '  Add-ons       : ' + (state.addons.join(', ')       || 'none'),
      '  Platform pref : ' + (state.platform     || 'n/a'),
      '  Timeline      : ' + (state.timeline     || 'n/a'),
      (isEcomPath() && state.productCount > 0 ? '  Product count : ' + state.productCount : ''),
      '',
      'ESTIMATED INVESTMENT',
      '  WordPress + Elementor : ' + fmt(quote.platforms.elementor.min) + ' \u2013 ' + fmt(quote.platforms.elementor.max),
      '  WordPress Custom Build: ' + fmt(quote.platforms.custom.min)    + ' \u2013 ' + fmt(quote.platforms.custom.max),
      '  Shopify               : ' + fmt(quote.platforms.shopify.min)   + ' \u2013 ' + fmt(quote.platforms.shopify.max),
      '',
      'PAYMENT PLANS (based on WP Elementor midpoint: ' + fmt(quote.platforms.elementor.midpoint) + ')',
      '  3 monthly payments (0% fee) : ' + fmt(Math.round(quote.platforms.elementor.midpoint / 3))           + '/mo  |  Total: ' + fmt(quote.platforms.elementor.midpoint),
      '  6 monthly payments (5% fee) : ' + fmt(Math.round(quote.platforms.elementor.midpoint * 1.05 / 6))    + '/mo  |  Total: ' + fmt(Math.round(quote.platforms.elementor.midpoint * 1.05)),
      '  12 monthly payments (10%fee): ' + fmt(Math.round(quote.platforms.elementor.midpoint * 1.10 / 12))   + '/mo  |  Total: ' + fmt(Math.round(quote.platforms.elementor.midpoint * 1.10)),
      '',
      'NOTES',
      contact.notes || 'None provided.',
      '',
      '---',
      'This is an estimate only. Final pricing confirmed at proposal.',
      'Digital Stride | results@mydigitalstride.com'
    ].filter(function (l) { return l !== undefined && l !== null; });
    return lines.join('\n');
  }

  function generatePDF(contact) {
    if (typeof window.jspdf === 'undefined' && typeof window.jsPDF === 'undefined') {
      console.warn('jsPDF not loaded — skipping PDF generation');
      return null;
    }

    var jsPDF = window.jspdf ? window.jspdf.jsPDF : window.jsPDF;
    var doc   = new jsPDF({ unit: 'mm', format: 'a4' });
    var quote = calculateQuote();
    var tierKey  = quote.tierKey;
    var tierMeta = quote.tierMeta;

    // ── Header bar
    doc.setFillColor(29, 67, 130);
    doc.rect(0, 0, 210, 30, 'F');
    doc.setFillColor(243, 110, 33);
    doc.rect(0, 26, 210, 4, 'F');

    // Logo (if preloaded) — else fall back to text
    if (_logoBase64) {
      try { doc.addImage(_logoBase64, 'PNG', 10, 4, 60, 0); }
      catch (e) { _logoBase64 = null; } // reset so fallback text used
    }
    if (!_logoBase64) {
      doc.setTextColor(255, 255, 255);
      doc.setFontSize(18);
      doc.setFont('helvetica', 'bold');
      doc.text('Digital Stride', 14, 13);
    }
    doc.setTextColor(255, 255, 255);
    doc.setFontSize(11);
    doc.setFont('helvetica', 'normal');
    doc.text('Website Quote Estimate', 14, 22);
    doc.text(new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }), 140, 22);

    // ── Client info
    var y = 36;
    doc.setTextColor(0, 0, 0);
    doc.setFontSize(12);
    doc.setFont('helvetica', 'bold');
    doc.text('Prepared for', 14, y);
    y += 6;
    doc.setFontSize(11);
    doc.setFont('helvetica', 'normal');
    doc.text((contact.name || '') + (contact.business ? '  \u2014  ' + contact.business : ''), 14, y);
    y += 5;
    doc.setTextColor(100, 100, 100);
    doc.text((contact.email || '') + (contact.phone ? '   |   ' + contact.phone : ''), 14, y);

    // ── Tier badge
    y += 10;
    var tRgb = hexToRGB(tierMeta.color); doc.setFillColor(tRgb[0], tRgb[1], tRgb[2]);
    doc.roundedRect(14, y, 45, 8, 2, 2, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFontSize(9);
    doc.setFont('helvetica', 'bold');
    doc.text(tierMeta.label.toUpperCase() + ' TIER', 18, y + 5.5);

    y += 14;
    doc.setTextColor(80, 80, 80);
    doc.setFontSize(9);
    doc.setFont('helvetica', 'italic');
    doc.text(tierMeta.signals, 14, y, { maxWidth: 182 });

    // ── Platform investment table
    y += 10;
    doc.setTextColor(0, 0, 0);
    doc.setFontSize(12);
    doc.setFont('helvetica', 'bold');
    doc.text('Investment by Platform', 14, y);

    y += 5;
    var platforms = ['elementor', 'custom', 'shopify'];
    var colW = 60, colX = [14, 74, 134];
    var preferred = (state.platform && state.platform !== 'unsure') ? state.platform : 'elementor';

    platforms.forEach(function (p, i) {
      var isRec = (tierKey === 'ecommerce') ? p === 'shopify' : p === 'elementor';
      var isSel = p === preferred;
      var prices = quote.platforms[p];

      if (isRec) { doc.setFillColor(224, 253, 254); doc.rect(colX[i], y, colW - 2, 22, 'F'); }
      if (isSel && !isRec) { doc.setFillColor(255, 249, 245); doc.rect(colX[i], y, colW - 2, 22, 'F'); }

      doc.setDrawColor(220, 220, 220);
      doc.rect(colX[i], y, colW - 2, 22);

      doc.setTextColor(29, 67, 130);
      doc.setFontSize(8);
      doc.setFont('helvetica', 'bold');
      doc.text(PLATFORM_LABELS[p].name, colX[i] + 3, y + 6, { maxWidth: colW - 6 });

      doc.setTextColor(0, 0, 0);
      doc.setFontSize(11);
      doc.text(fmt(prices.min) + ' \u2013 ' + fmt(prices.max), colX[i] + 3, y + 16);

      if (isRec) {
        doc.setFillColor(24, 157, 167);
        doc.roundedRect(colX[i] + colW - 30, y + 1, 26, 5, 1, 1, 'F');
        doc.setTextColor(255,255,255);
        doc.setFontSize(6);
        doc.text('RECOMMENDED', colX[i] + colW - 28, y + 4.5);
      }
    });

    // ── Scope
    y += 28;
    doc.setTextColor(0, 0, 0);
    doc.setFontSize(11);
    doc.setFont('helvetica', 'bold');
    doc.text("What's Included", 14, y);
    y += 5;
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(9);
    var includesLeft  = tierMeta.includes.slice(0, Math.ceil(tierMeta.includes.length / 2));
    var includesRight = tierMeta.includes.slice(Math.ceil(tierMeta.includes.length / 2));
    var startY = y;
    includesLeft.forEach(function (item) {
      var clean = item.replace(/&amp;/g, '&');
      doc.setFillColor(34, 197, 94);
      doc.circle(15.5, y - 1.5, 1.5, 'F');
      doc.setTextColor(50, 50, 50);
      doc.text(clean, 19, y, { maxWidth: 82 });
      y += 6;
    });
    y = startY;
    includesRight.forEach(function (item) {
      var clean = item.replace(/&amp;/g, '&');
      doc.setFillColor(34, 197, 94);
      doc.circle(105.5, y - 1.5, 1.5, 'F');
      doc.setTextColor(50, 50, 50);
      doc.text(clean, 109, y, { maxWidth: 82 });
      y += 6;
    });
    y = startY + Math.ceil(tierMeta.includes.length / 2) * 6;

    // ── Add-ons
    var addonItems = buildSelectedAddonsList();
    if (addonItems.length > 0) {
      y += 4;
      doc.setTextColor(0,0,0);
      doc.setFontSize(11);
      doc.setFont('helvetica', 'bold');
      doc.text('Selected Add-ons', 14, y);
      y += 5;
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(9);
      addonItems.forEach(function (item) {
        doc.setTextColor(50,50,50);
        doc.text('\u2022 ' + item.label, 14, y, { maxWidth: 130 });
        doc.setTextColor(24, 157, 167);
        doc.setFont('helvetica', 'bold');
        doc.text('+' + item.priceLabel, 155, y);
        doc.setFont('helvetica', 'normal');
        y += 6;
      });
    }

    // ── Payment plans
    y += 4;
    if (y > 230) { doc.addPage(); y = 20; }
    doc.setTextColor(0,0,0);
    doc.setFontSize(11);
    doc.setFont('helvetica', 'bold');
    doc.text('Flexible Payment Plans  (' + PLATFORM_LABELS[preferred].name + ')', 14, y);
    y += 5;
    var prefPrices = quote.platforms[preferred];

    PAYMENT_PLANS.forEach(function (plan, idx) {
      var total   = Math.round(prefPrices.midpoint * (1 + plan.fee));
      var monthly = Math.round(total / plan.months);
      var x = 14 + idx * 62;
      var isPopular = idx === 0;

      if (isPopular) { doc.setFillColor(224, 253, 254); doc.rect(x, y, 58, 24, 'F'); }
      doc.setDrawColor(220,220,220);
      doc.rect(x, y, 58, 24);

      doc.setTextColor(100,100,100);
      doc.setFontSize(8);
      doc.setFont('helvetica', 'normal');
      doc.text(plan.months + ' payments  |  ' + plan.feeLabel, x + 3, y + 6);

      doc.setTextColor(isPopular ? 24 : 29, isPopular ? 157 : 67, isPopular ? 167 : 130);
      doc.setFontSize(14);
      doc.setFont('helvetica', 'bold');
      doc.text(fmt(monthly) + '/mo', x + 3, y + 15);

      doc.setTextColor(80,80,80);
      doc.setFontSize(8);
      doc.setFont('helvetica', 'normal');
      doc.text('Total: ' + fmt(total), x + 3, y + 21);
    });

    // ── Notes
    if (contact.notes) {
      y += 30;
      doc.setTextColor(0,0,0);
      doc.setFontSize(10);
      doc.setFont('helvetica', 'bold');
      doc.text('Additional Notes', 14, y);
      y += 5;
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(9);
      doc.setTextColor(80,80,80);
      doc.text(contact.notes, 14, y, { maxWidth: 182 });
    }

    // ── Schedule a Meeting CTA
    y += 30;
    if (y > 245) { doc.addPage(); y = 20; }
    doc.setFillColor(243, 245, 255);
    doc.roundedRect(14, y, 182, 22, 3, 3, 'F');
    doc.setTextColor(29, 67, 130);
    doc.setFontSize(11);
    doc.setFont('helvetica', 'bold');
    doc.text('Ready to take the next step?', 18, y + 8);
    doc.setFontSize(9);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(80, 80, 80);
    doc.text('Schedule a free discovery call:', 18, y + 15);
    doc.setTextColor(243, 110, 33);
    doc.textWithLink('meetings.hubspot.com/exp1st/website-cost-estimator', 68, y + 15,
      { url: 'https://meetings.hubspot.com/exp1st/website-cost-estimator' });

    // ── Footer
    doc.setFillColor(29, 67, 130);
    doc.rect(0, 277, 210, 20, 'F');
    doc.setFillColor(243, 110, 33);
    doc.rect(0, 274, 210, 3, 'F');
    doc.setTextColor(255,255,255);
    doc.setFontSize(8);
    doc.setFont('helvetica', 'normal');
    doc.text('Digital Stride  |  results@mydigitalstride.com  |  mydigitalstride.com', 14, 283);
    doc.text('This is an estimate only. Final pricing confirmed in writing at proposal.', 14, 289);
    doc.setTextColor(200, 220, 255);
    doc.textWithLink('Schedule your free call \u2192', 14, 294,
      { url: 'https://meetings.hubspot.com/exp1st/website-cost-estimator' });

    return doc;
  }

  function hexToRGB(hex) {
    var r = parseInt(hex.slice(1,3),16);
    var g = parseInt(hex.slice(3,5),16);
    var b = parseInt(hex.slice(5,7),16);
    return [r, g, b];
  }

  /* ─── Contact Form & PDF Submit ──────────────────────────────────── */

  function bindContactForm() {
    var form      = el('qb-contact-form');
    var submitBtn = el('qb-submit-btn');
    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.checkValidity()) { form.reportValidity(); return; }

      submitBtn.disabled    = true;
      submitBtn.textContent = 'Building your quote\u2026';

      var contact = {
        name:     (el('qb-name')     || {}).value || '',
        business: (el('qb-business') || {}).value || '',
        email:    (el('qb-email')    || {}).value || '',
        phone:    (el('qb-phone')    || {}).value || '',
        notes:    (el('qb-notes')    || {}).value || ''
      };

      // Generate PDF (wrapped in try-catch so a PDF failure never freezes the form)
      var pdfDoc = null;
      try { pdfDoc = generatePDF(contact); } catch (e) { console.warn('PDF generation failed:', e); }
      var pdfB64 = pdfDoc ? pdfDoc.output('datauristring') : '';
      var summary  = buildSummaryText(contact);

      var data = new FormData(form);
      data.append('action',  'qb_quote_submit');
      data.append('nonce',   (window.qbData && window.qbData.nonce) || '');
      data.append('summary', summary);
      data.append('pdf_b64', pdfB64);
      data.append('qb_tier',         getTierKey());
      data.append('qb_businessType', state.businessType  || '');
      data.append('qb_primaryGoal',  state.primaryGoal   || '');
      data.append('qb_websiteSize',  state.websiteSize   || '');
      data.append('qb_coverage',     state.coverage      || '');
      data.append('qb_contentNeeds', state.contentNeeds  || '');
      data.append('qb_integrations', state.integrations.join(', '));
      data.append('qb_addons',       state.addons.join(', '));
      data.append('qb_platform',     state.platform      || '');
      data.append('qb_timeline',     state.timeline      || '');
      data.append('qb_productCount', state.productCount  || 0);

      var ajaxUrl = (window.qbData && window.qbData.ajaxUrl) || '/wp-admin/admin-ajax.php';

      fetch(ajaxUrl, { method: 'POST', credentials: 'same-origin', body: data })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json.success) {
            // Render quote, go to results step, show download button
            renderQuote();
            goToStep('11');

            // Wire up PDF download button
            if (pdfDoc) {
              var dlBtn = el('qb-pdf-download');
              if (dlBtn) {
                dlBtn.hidden = false;
                dlBtn.addEventListener('click', function () {
                  pdfDoc.save('digital-stride-quote.pdf');
                });
              }
            }
          } else {
            alert(json.data || 'Something went wrong. Please try again.');
            submitBtn.disabled    = false;
            submitBtn.textContent = 'Get My Full Proposal \u2192';
          }
        })
        .catch(function () {
          alert('Network error. Please check your connection and try again.');
          submitBtn.disabled    = false;
          submitBtn.textContent = 'Get My Full Proposal \u2192';
        });
    });
  }

  /* ─── Restart ────────────────────────────────────────────────────── */

  function resetState() {
    state = { businessType: null, primaryGoal: null, productCount: 0,
              websiteSize: null, coverage: null, contentNeeds: null,
              integrations: [], addons: [], platform: null, timeline: null };
    qsa('.qb-option.is-selected').forEach(function (b) { b.classList.remove('is-selected'); b.removeAttribute('aria-pressed'); });
    qsa('.qb-check__input:checked').forEach(function (cb) { cb.checked = false; cb.closest('.qb-check').classList.remove('is-checked'); });
    ['1','2','2b','3','4','5','8','9'].forEach(function (s) { setNextEnabled(s, false); });
    var badge = el('qb-estimate-badge');
    if (badge) badge.hidden = true;
    var form = el('qb-contact-form');
    var btn  = el('qb-submit-btn');
    var dlBtn = el('qb-pdf-download');
    if (form)  { form.reset(); form.hidden = false; }
    if (btn)   { btn.disabled = false; btn.textContent = 'Get My Full Proposal \u2192'; }
    if (dlBtn) dlBtn.hidden = true;
    // Reset product count input
    var pcInput = el('qb-product-count');
    if (pcInput) { pcInput.value = ''; }
    setNextEnabled('2b', false);
  }

  /* ─── Initialise ─────────────────────────────────────────────────── */

  function init() {
    // Single-select steps
    bindSingleSelect('1',  'businessType');
    bindSingleSelect('2',  'primaryGoal');
    bindSingleSelect('3',  'websiteSize');
    bindSingleSelect('4',  'coverage');
    bindSingleSelect('5',  'contentNeeds');
    bindSingleSelect('8',  'platform');
    bindSingleSelect('9',  'timeline');

    // Multi-select
    bindMultiSelect('qb-integrations-list', 'integrations');
    bindMultiSelect('qb-addons-list',       'addons');

    // Product count input (step 2b)
    var pcInput = el('qb-product-count');
    if (pcInput) {
      pcInput.addEventListener('input', function () {
        var v = parseInt(pcInput.value, 10);
        state.productCount = (isNaN(v) || v < 0) ? 0 : v;
        setNextEnabled('2b', state.productCount > 0);
        updateEstimateBadge();
        // Sync preset active state
        qsa('.qb-count-preset').forEach(function (btn) { btn.classList.remove('is-active'); });
      });
    }

    // Product count preset buttons
    qsa('.qb-count-preset').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var v = parseInt(btn.getAttribute('data-value'), 10);
        state.productCount = v;
        if (pcInput) pcInput.value = v;
        qsa('.qb-count-preset').forEach(function (b) { b.classList.remove('is-active'); });
        btn.classList.add('is-active');
        setNextEnabled('2b', true);
        updateEstimateBadge();
      });
    });

    // Back buttons (data-prev on the button)
    qsa('[data-prev]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        backFromStep(btn.getAttribute('data-prev'));
      });
    });

    // Next buttons
    ['1','2','2b','3','4','5','6','7','8','9'].forEach(function (step) {
      var btn = el('qb-next-' + step);
      if (!btn) return;
      btn.addEventListener('click', function () { nextFromStep(step); });
    });

    // Restart
    var restartBtn = el('qb-restart-btn');
    if (restartBtn) {
      restartBtn.addEventListener('click', function () {
        resetState();
        goToStep('1');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }

    // Contact form
    bindContactForm();

    updateProgress('1');
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
