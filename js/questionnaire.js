/**
 * questionnaire.js — Website Quote Questionnaire
 *
 * Multi-step quote calculator for Digital Stride.
 * Determines project tier, calculates platform pricing,
 * and renders payment plans with 0 / 5 / 10 % finance fees.
 */
(function () {
  'use strict';

  /* ─── Pricing Data ───────────────────────────────────────────────── */

  /**
   * Base price ranges per tier per platform.
   * WordPress Elementor = standard baseline.
   * WordPress Custom Build = premium (larger dev investment).
   * Shopify = best value for eCommerce, slight discount elsewhere.
   */
  var TIERS = {
    starter: {
      label: 'Starter',
      color: '#22c55e',
      signals: '5-page lead gen, single location, client-supplied content, no integrations',
      includes: [
        'Up to 5 custom-designed pages',
        'Mobile-responsive layout',
        'Contact &amp; lead capture form',
        'Basic on-page SEO',
        'Google Analytics integration',
        'SSL &amp; speed optimisation',
        '30-day post-launch support'
      ],
      elementor: { min: 3500,  max: 5500  },
      custom:    { min: 4500,  max: 7000  },
      shopify:   { min: 3000,  max: 5000  }
    },
    professional: {
      label: 'Professional',
      color: '#3b82f6',
      signals: '10–15 pages, multi-location or mobile service, DS may write copy, basic scheduler',
      includes: [
        'Up to 15 custom-designed pages',
        'Service-area &amp; location pages',
        'Appointment scheduler integration',
        'Mobile-first design',
        'On-page SEO for all pages',
        'Lead &amp; estimate capture forms',
        'Google Analytics + Search Console',
        '60-day post-launch support'
      ],
      elementor: { min: 6500,  max: 12000 },
      custom:    { min: 8500,  max: 15000 },
      shopify:   { min: 6000,  max: 11000 }
    },
    ecommerce: {
      label: 'eCommerce',
      color: '#f59e0b',
      signals: 'Online store, up to 200 SKUs, payment gateway, basic shipping',
      includes: [
        'Full eCommerce store setup',
        'Up to 200 product SKUs',
        'Payment gateway integration',
        'Inventory &amp; variant management',
        'Cart &amp; checkout optimisation',
        'Basic shipping &amp; tax setup',
        'Mobile-optimised shopping experience',
        '60-day post-launch support'
      ],
      elementor: { min: 8000,  max: 18000 },
      custom:    { min: 10000, max: 22000 },
      shopify:   { min: 7500,  max: 16000 }
    },
    trade_school: {
      label: 'Trade School',
      color: '#8b5cf6',
      signals: 'LMS integration, enrollment system, financial-aid pages, multi-program',
      includes: [
        'LMS integration (LearnDash or similar)',
        'Program enrollment &amp; application system',
        'Financial-aid information pages',
        'Student portal setup',
        'Multi-program site architecture',
        'Accreditation &amp; trust-signal pages',
        'Application workflow &amp; notifications',
        '90-day post-launch support'
      ],
      elementor: { min: 15000, max: 35000 },
      custom:    { min: 18000, max: 42000 },
      shopify:   { min: 13000, max: 30000 }
    },
    enterprise: {
      label: 'Enterprise',
      color: '#ef4444',
      signals: 'Multi-location + eCommerce + CRM integration + custom features',
      includes: [
        'Unlimited pages &amp; sections',
        'Multi-location site architecture',
        'Custom feature development',
        'Advanced CRM &amp; dispatch integration',
        'Custom admin dashboards &amp; reporting',
        'Performance-optimised infrastructure',
        'Priority support &amp; SLA',
        '120-day post-launch support'
      ],
      elementor: { min: 25000, max: 45000 },
      custom:    { min: 30000, max: 55000 },
      shopify:   { min: 22000, max: 40000 }
    }
  };

  /** Add-on price ranges added on top of the base tier. */
  var ADDONS = {
    copy_ds: {
      label: 'DS Writes All Copy',
      icon: '📝',
      min: 1200, max: 3500
    },
    copy_photo: {
      label: 'Copywriting + Professional Photography / Video',
      icon: '📸',
      min: 2000, max: 6500
    },
    crm: {
      label: 'CRM / Dispatch Integration (Jobber, ServiceTitan)',
      icon: '⚙️',
      min: 1500, max: 4000
    },
    local_seo: {
      label: 'Local SEO Setup (GMB, Schema, Citations)',
      icon: '📍',
      min: 800,  max: 2000
    },
    ada: {
      label: 'ADA / WCAG Accessibility Audit + Remediation',
      icon: '♿',
      min: 600,  max: 1800
    },
    multilang: {
      label: 'Multi-language Support',
      icon: '🌐',
      min: 800,  max: 2000
    }
  };

  /**
   * Payment plan definitions.
   * fee = finance fee applied to the total project investment.
   * e.g. fee: 0.05 means the client pays 5% more when spreading over 6 months.
   */
  var PAYMENT_PLANS = [
    { months: 3,  fee: 0,    feeLabel: '0% finance fee'  },
    { months: 6,  fee: 0.05, feeLabel: '5% finance fee'  },
    { months: 12, fee: 0.10, feeLabel: '10% finance fee' }
  ];

  var PLATFORM_LABELS = {
    elementor: { name: 'WordPress + Elementor', short: 'WP Elementor', desc: 'Flexible, easy to update' },
    custom:    { name: 'WordPress Custom Build', short: 'WP Custom',    desc: 'Premium, pixel-perfect'  },
    shopify:   { name: 'Shopify',               short: 'Shopify',       desc: 'Purpose-built for eCommerce' }
  };

  /* ─── Application State ──────────────────────────────────────────── */

  var state = {
    businessType:  null,
    primaryGoal:   null,
    websiteSize:   null,
    coverage:      null,
    contentNeeds:  null,
    integrations:  [],
    addons:        [],
    platform:      null,
    timeline:      null
  };

  var currentStep = 1;
  var TOTAL_STEPS = 9;

  /* ─── Tier Determination ─────────────────────────────────────────── */

  function determineTier() {
    // Hard overrides first — these always win regardless of other signals
    if (state.businessType === 'trade_school') return 'trade_school';
    if (state.primaryGoal  === 'enroll_students') return 'trade_school';
    if (state.integrations.indexOf('lms') !== -1) return 'trade_school';

    // eCommerce path
    var isEcom = state.businessType === 'ecommerce' ||
                 state.primaryGoal  === 'sell_products' ||
                 state.integrations.indexOf('payment') !== -1;

    // Build a complexity score for lead-gen / service businesses
    var score = 0;

    // Size
    if      (state.websiteSize === 'medium')  score += 2;
    else if (state.websiteSize === 'large')   score += 5;
    else if (state.websiteSize === 'complex') score += 9;

    // Coverage
    if (state.coverage === 'multi_location' || state.coverage === 'national') score += 2;

    // Content
    if      (state.contentNeeds === 'copy_ds')    score += 1;
    else if (state.contentNeeds === 'copy_photo') score += 2;

    // Integrations
    var ints = state.integrations.filter(function (i) { return i !== 'none'; });
    score += ints.length;
    if (ints.indexOf('crm') !== -1)    score += 2;
    if (ints.indexOf('payment') !== -1) score += 2;

    // Resolve tier
    if (isEcom) {
      return score >= 8 ? 'enterprise' : 'ecommerce';
    }

    if (score >= 10) return 'enterprise';
    if (score >= 4)  return 'professional';
    return 'starter';
  }

  /* ─── Quote Calculation ──────────────────────────────────────────── */

  function calculateQuote() {
    var tier     = determineTier();
    var tierData = TIERS[tier];
    var isRush   = state.timeline === 'rush' ||
                   state.addons.indexOf('rush') !== -1;

    var result = { tier: tier, tierData: tierData, isRush: isRush, platforms: {} };

    ['elementor', 'custom', 'shopify'].forEach(function (p) {
      var base = tierData[p];
      var min  = base.min;
      var max  = base.max;

      // Content add-ons
      if      (state.contentNeeds === 'copy_ds')    { min += ADDONS.copy_ds.min;    max += ADDONS.copy_ds.max;    }
      else if (state.contentNeeds === 'copy_photo') { min += ADDONS.copy_photo.min; max += ADDONS.copy_photo.max; }

      // CRM integration
      if (state.integrations.indexOf('crm') !== -1) { min += ADDONS.crm.min; max += ADDONS.crm.max; }

      // Selected add-ons
      if (state.addons.indexOf('local_seo') !== -1) { min += ADDONS.local_seo.min; max += ADDONS.local_seo.max; }
      if (state.addons.indexOf('ada')       !== -1) { min += ADDONS.ada.min;       max += ADDONS.ada.max;       }
      if (state.addons.indexOf('multilang') !== -1) { min += ADDONS.multilang.min; max += ADDONS.multilang.max; }

      // Rush premium
      if (isRush) { min = Math.round(min * 1.15); max = Math.round(max * 1.25); }

      result.platforms[p] = {
        min:      min,
        max:      max,
        midpoint: Math.round((min + max) / 2)
      };
    });

    return result;
  }

  /* ─── Helpers ────────────────────────────────────────────────────── */

  function fmt(n) {
    return '$' + n.toLocaleString('en-US');
  }

  function el(id) { return document.getElementById(id); }

  function qs(selector, ctx) { return (ctx || document).querySelector(selector); }

  function qsa(selector, ctx) { return (ctx || document).querySelectorAll(selector); }

  /* ─── Progress Bar ───────────────────────────────────────────────── */

  function updateProgress(step) {
    var pct   = Math.round((step / TOTAL_STEPS) * 100);
    var bar   = el('qb-progress-bar');
    var label = el('qb-progress-label');
    var wrap  = qs('.qb-progress');

    if (bar)   bar.style.width  = pct + '%';
    if (label) label.textContent = 'Step ' + step + ' of ' + TOTAL_STEPS;
    if (wrap)  wrap.setAttribute('aria-valuenow', pct);
  }

  /* ─── Live Estimate Badge ────────────────────────────────────────── */

  function updateEstimateBadge() {
    var badge = el('qb-estimate-badge');
    var range = el('qb-estimate-range');
    if (!badge || !range) return;

    if (!state.businessType) return;

    var quote = calculateQuote();
    var pref  = (state.platform && state.platform !== 'unsure') ? state.platform : 'elementor';
    var p     = quote.platforms[pref];

    range.textContent = fmt(p.min) + ' \u2013 ' + fmt(p.max);
    badge.hidden      = false;
  }

  /* ─── Step Navigation ────────────────────────────────────────────── */

  function goToStep(next) {
    var fromEl = el('qb-step-' + currentStep);
    var toEl   = el('qb-step-' + next);
    if (!toEl) return;

    if (fromEl) fromEl.classList.remove('is-active');
    toEl.classList.add('is-active');

    // Smooth scroll to top of the step card
    setTimeout(function () {
      toEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 60);

    currentStep = next;

    if (next <= TOTAL_STEPS) {
      updateProgress(next);
    } else {
      // Results step — mark 100 %
      var bar   = el('qb-progress-bar');
      var label = el('qb-progress-label');
      var wrap  = qs('.qb-progress');
      if (bar)   bar.style.width  = '100%';
      if (label) label.textContent = 'Complete!';
      if (wrap)  wrap.setAttribute('aria-valuenow', 100);
    }

    updateEstimateBadge();
  }

  /* ─── Next Button State ──────────────────────────────────────────── */

  function setNextEnabled(step, enabled) {
    var btn = el('qb-next-' + step);
    if (!btn) return;
    btn.disabled               = !enabled;
    btn.setAttribute('aria-disabled', enabled ? 'false' : 'true');
  }

  /* ─── Single-select Options ──────────────────────────────────────── */

  function bindSingleSelect(step, fieldName) {
    var stepEl = el('qb-step-' + step);
    if (!stepEl) return;

    qsa('[data-field="' + fieldName + '"]', stepEl).forEach(function (btn) {
      btn.addEventListener('click', function () {
        // Deselect siblings
        qsa('[data-field="' + fieldName + '"]', stepEl).forEach(function (b) {
          b.classList.remove('is-selected');
          b.setAttribute('aria-pressed', 'false');
        });

        btn.classList.add('is-selected');
        btn.setAttribute('aria-pressed', 'true');
        state[fieldName] = btn.getAttribute('data-value');

        setNextEnabled(step, true);
        updateEstimateBadge();
      });
    });
  }

  /* ─── Multi-select Checkboxes ────────────────────────────────────── */

  function bindMultiSelect(listId, stateKey) {
    var listEl = el(listId);
    if (!listEl) return;

    qsa('.qb-check', listEl).forEach(function (label) {
      var input   = qs('.qb-check__input', label);
      var isNone  = label.classList.contains('qb-check--none');

      if (!input) return;

      input.addEventListener('change', function () {
        if (isNone && input.checked) {
          // "None" checked — uncheck everything else
          qsa('.qb-check:not(.qb-check--none) .qb-check__input', listEl).forEach(function (cb) {
            cb.checked = false;
            cb.closest('.qb-check').classList.remove('is-checked');
          });
        } else if (!isNone && input.checked) {
          // Regular option checked — uncheck "None"
          var noneInput = qs('.qb-check--none .qb-check__input', listEl);
          if (noneInput) {
            noneInput.checked = false;
            noneInput.closest('.qb-check').classList.remove('is-checked');
          }
        }

        // Sync visual state
        label.classList.toggle('is-checked', input.checked);

        // Rebuild state array
        var selected = [];
        qsa('.qb-check__input:checked', listEl).forEach(function (cb) {
          selected.push(cb.value);
        });
        state[stateKey] = selected;

        updateEstimateBadge();
      });
    });
  }

  /* ─── Render Quote ───────────────────────────────────────────────── */

  function renderQuote() {
    var quote    = calculateQuote();
    var tier     = quote.tier;
    var tierData = quote.tierData;

    /* — Tier badge ———————————————————————————————————————————————— */
    var tierBadge = el('qb-tier-badge');
    if (tierBadge) {
      tierBadge.textContent = tierData.label + ' Tier';
      tierBadge.style.background = tierData.color;
    }

    var quoteSub = el('qb-quote-sub');
    if (quoteSub) {
      quoteSub.textContent = 'Tier signals: ' + tierData.signals;
    }

    /* — Platform cards ———————————————————————————————————————————— */
    var cardsEl = el('qb-platform-cards');
    if (cardsEl) {
      var preferred = (state.platform && state.platform !== 'unsure') ? state.platform : null;
      // "Recommended" logic: Shopify for eCommerce/enterprise, Elementor otherwise
      var recommended = (tier === 'ecommerce' || tier === 'enterprise') && preferred === 'shopify'
        ? 'shopify'
        : (tier === 'ecommerce' ? 'shopify' : 'elementor');

      cardsEl.innerHTML = ['elementor', 'custom', 'shopify'].map(function (p) {
        var prices = quote.platforms[p];
        var pl     = PLATFORM_LABELS[p];
        var isRec  = p === recommended;
        var isSel  = p === preferred;

        var classes = 'qb-platform-card';
        if (isRec) classes += ' is-recommended';
        if (isSel && !isRec) classes += ' is-selected';

        var badge = isRec
          ? '<span class="qb-platform-card__badge">Recommended</span>'
          : (isSel ? '<span class="qb-platform-card__badge" style="background:var(--qb-orange)">Your Choice</span>' : '');

        return '<div class="' + classes + '">' +
          badge +
          '<h4 class="qb-platform-card__name">' + pl.name + '</h4>' +
          '<p class="qb-platform-card__desc">' + pl.desc + '</p>' +
          '<div class="qb-platform-card__range">' +
            '<span class="qb-platform-card__min">' + fmt(prices.min) + '</span>' +
            '<span class="qb-platform-card__sep">&ndash;</span>' +
            '<span class="qb-platform-card__max">' + fmt(prices.max) + '</span>' +
          '</div>' +
        '</div>';
      }).join('');
    }

    /* — Scope list ———————————————————————————————————————————————— */
    var scopeEl = el('qb-scope-list');
    if (scopeEl) {
      scopeEl.innerHTML = tierData.includes.map(function (item) {
        return '<li class="qb-scope-item">' +
          '<span class="qb-scope-item__check" aria-hidden="true">\u2713</span>' +
          item +
        '</li>';
      }).join('');
    }

    /* — Selected add-ons ————————————————————————————————————————— */
    var addonsBlock = el('qb-selected-addons-block');
    var addonsEl    = el('qb-selected-addons');
    var selectedAddons = [];

    if (state.contentNeeds === 'copy_ds')    selectedAddons.push('copy_ds');
    if (state.contentNeeds === 'copy_photo') selectedAddons.push('copy_photo');
    if (state.integrations.indexOf('crm') !== -1) selectedAddons.push('crm');
    ['local_seo', 'ada', 'multilang'].forEach(function (k) {
      if (state.addons.indexOf(k) !== -1) selectedAddons.push(k);
    });
    if (quote.isRush) selectedAddons.push('_rush');

    if (selectedAddons.length === 0) {
      if (addonsBlock) addonsBlock.hidden = true;
    } else {
      if (addonsBlock) addonsBlock.hidden = false;
      if (addonsEl) {
        addonsEl.innerHTML = selectedAddons.map(function (k) {
          if (k === '_rush') {
            return '<div class="qb-addon-item">' +
              '<span class="qb-addon-item__icon">\u26A1</span>' +
              '<span class="qb-addon-item__label">Rush Delivery (under 6 weeks)</span>' +
              '<span class="qb-addon-item__price">+15\u201325% of total</span>' +
            '</div>';
          }
          var a = ADDONS[k];
          return '<div class="qb-addon-item">' +
            '<span class="qb-addon-item__icon">' + a.icon + '</span>' +
            '<span class="qb-addon-item__label">' + a.label + '</span>' +
            '<span class="qb-addon-item__price">+' + fmt(a.min) + '\u2013' + fmt(a.max) + '</span>' +
          '</div>';
        }).join('');
      }
    }

    /* — Payment plans ————————————————————————————————————————————— */
    // Default to user's preferred platform, else elementor
    var initPlatform = (state.platform && state.platform !== 'unsure') ? state.platform : 'elementor';
    renderPaymentPlans(initPlatform, quote);

    // Activate the matching tab
    qsa('.qb-tab[data-platform]').forEach(function (tab) {
      var active = tab.getAttribute('data-platform') === initPlatform;
      tab.classList.toggle('is-active', active);
      tab.setAttribute('aria-selected', active ? 'true' : 'false');
    });

    /* — Payment tab click handlers ————————————————————————————— */
    qsa('.qb-tab[data-platform]').forEach(function (tab) {
      // Clone to remove old listeners
      var fresh = tab.cloneNode(true);
      tab.parentNode.replaceChild(fresh, tab);
      fresh.addEventListener('click', function () {
        qsa('.qb-tab[data-platform]').forEach(function (t) {
          t.classList.remove('is-active');
          t.setAttribute('aria-selected', 'false');
        });
        fresh.classList.add('is-active');
        fresh.setAttribute('aria-selected', 'true');
        renderPaymentPlans(fresh.getAttribute('data-platform'), quote);
      });
    });
  }

  function renderPaymentPlans(platform, quote) {
    var plansEl = el('qb-payment-plans');
    if (!plansEl) return;

    var mid = quote.platforms[platform].midpoint;
    var min = quote.platforms[platform].min;
    var max = quote.platforms[platform].max;

    plansEl.innerHTML = PAYMENT_PLANS.map(function (plan, idx) {
      var total   = Math.round(mid * (1 + plan.fee));
      var monthly = Math.round(total / plan.months);
      var isPopular = idx === 1; // 6-month is highlighted

      var cls = 'qb-plan-card' + (isPopular ? ' qb-plan-card--popular' : '');

      return '<div class="' + cls + '">' +
        '<p class="qb-plan-card__months">' + plan.months + ' Monthly Payments</p>' +
        '<p class="qb-plan-card__fee">' + plan.feeLabel + '</p>' +
        '<div class="qb-plan-card__monthly">' + fmt(monthly) + '</div>' +
        '<p class="qb-plan-card__per">per month</p>' +
        '<hr class="qb-plan-card__divider">' +
        '<p class="qb-plan-card__total">Total: <strong>' + fmt(total) + '</strong></p>' +
      '</div>';
    }).join('');

    // Update the note below
    var note = qs('.qb-payment-note');
    if (note) {
      note.textContent = '* Monthly amounts are based on the ' +
        PLATFORM_LABELS[platform].name + ' midpoint estimate of ' + fmt(mid) +
        ' (range: ' + fmt(min) + '\u2013' + fmt(max) + '). ' +
        'Rush premium included. Final amounts are confirmed at proposal.';
    }
  }

  /* ─── Form Submission ────────────────────────────────────────────── */

  function buildSummaryText() {
    var quote = calculateQuote();
    var tier  = quote.tier;
    var lines = [
      'QUESTIONNAIRE RESULTS',
      '=====================',
      'Tier: ' + TIERS[tier].label,
      '',
      'Answers:',
      '  Business type  : ' + (state.businessType  || 'n/a'),
      '  Primary goal   : ' + (state.primaryGoal   || 'n/a'),
      '  Website size   : ' + (state.websiteSize   || 'n/a'),
      '  Coverage       : ' + (state.coverage      || 'n/a'),
      '  Content needs  : ' + (state.contentNeeds  || 'n/a'),
      '  Integrations   : ' + (state.integrations.join(', ') || 'none'),
      '  Add-ons        : ' + (state.addons.join(', ')        || 'none'),
      '  Platform pref  : ' + (state.platform  || 'n/a'),
      '  Timeline       : ' + (state.timeline  || 'n/a'),
      '',
      'Estimated Ranges:',
      '  WP Elementor   : ' + fmt(quote.platforms.elementor.min) + ' \u2013 ' + fmt(quote.platforms.elementor.max),
      '  WP Custom Build: ' + fmt(quote.platforms.custom.min)    + ' \u2013 ' + fmt(quote.platforms.custom.max),
      '  Shopify        : ' + fmt(quote.platforms.shopify.min)   + ' \u2013 ' + fmt(quote.platforms.shopify.max)
    ];
    return lines.join('\n');
  }

  function bindContactForm() {
    var form      = el('qb-contact-form');
    var successEl = el('qb-form-success');
    var submitBtn = el('qb-submit-btn');
    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.checkValidity()) { form.reportValidity(); return; }

      submitBtn.disabled    = true;
      submitBtn.textContent = 'Sending\u2026';

      var data = new FormData(form);
      data.append('action',  'qb_quote_submit');
      data.append('nonce',   (window.qbData && window.qbData.nonce) || '');
      data.append('summary', buildSummaryText());

      // Include all state fields for the server
      data.append('qb_tier',         determineTier());
      data.append('qb_businessType', state.businessType  || '');
      data.append('qb_primaryGoal',  state.primaryGoal   || '');
      data.append('qb_websiteSize',  state.websiteSize   || '');
      data.append('qb_coverage',     state.coverage      || '');
      data.append('qb_contentNeeds', state.contentNeeds  || '');
      data.append('qb_integrations', state.integrations.join(', '));
      data.append('qb_addons',       state.addons.join(', '));
      data.append('qb_platform',     state.platform      || '');
      data.append('qb_timeline',     state.timeline      || '');

      var ajaxUrl = (window.qbData && window.qbData.ajaxUrl) || '/wp-admin/admin-ajax.php';

      fetch(ajaxUrl, {
        method:      'POST',
        credentials: 'same-origin',
        body:        data
      })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json.success) {
            if (successEl) {
              successEl.hidden = false;
              successEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
            form.hidden = true;
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
    state = {
      businessType: null, primaryGoal: null,  websiteSize: null,
      coverage:     null, contentNeeds: null, integrations: [],
      addons:       [],   platform: null,     timeline: null
    };

    // Clear all selected option buttons
    qsa('.qb-option.is-selected').forEach(function (b) {
      b.classList.remove('is-selected');
      b.removeAttribute('aria-pressed');
    });

    // Clear all checkboxes
    qsa('.qb-check__input:checked').forEach(function (cb) {
      cb.checked = false;
      cb.closest('.qb-check').classList.remove('is-checked');
    });

    // Disable next buttons
    [1,2,3,4,5,8,9].forEach(function (s) { setNextEnabled(s, false); });

    // Hide estimate badge
    var badge = el('qb-estimate-badge');
    if (badge) badge.hidden = true;

    // Reset form
    var form = el('qb-contact-form');
    var succ = el('qb-form-success');
    var btn  = el('qb-submit-btn');
    if (form) { form.reset(); form.hidden = false; }
    if (succ) succ.hidden = true;
    if (btn)  { btn.disabled = false; btn.textContent = 'Get My Full Proposal \u2192'; }
  }

  /* ─── Initialise ─────────────────────────────────────────────────── */

  function init() {
    /* Single-select steps */
    bindSingleSelect(1, 'businessType');
    bindSingleSelect(2, 'primaryGoal');
    bindSingleSelect(3, 'websiteSize');
    bindSingleSelect(4, 'coverage');
    bindSingleSelect(5, 'contentNeeds');
    bindSingleSelect(8, 'platform');
    bindSingleSelect(9, 'timeline');

    /* Multi-select checkboxes */
    bindMultiSelect('qb-integrations-list', 'integrations');
    bindMultiSelect('qb-addons-list',       'addons');

    /* Back buttons */
    qsa('[data-prev]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        goToStep(parseInt(btn.getAttribute('data-prev'), 10));
      });
    });

    /* Next buttons (steps 1–9) */
    for (var s = 1; s <= TOTAL_STEPS; s++) {
      (function (step) {
        var btn = el('qb-next-' + step);
        if (!btn) return;
        btn.addEventListener('click', function () {
          if (step === TOTAL_STEPS) {
            /* Last question — render quote and go to results */
            renderQuote();
            goToStep(10);
          } else {
            goToStep(step + 1);
          }
        });
      })(s);
    }

    /* Restart */
    var restartBtn = el('qb-restart-btn');
    if (restartBtn) {
      restartBtn.addEventListener('click', function () {
        resetState();
        goToStep(1);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }

    /* Contact form */
    bindContactForm();

    /* Initial progress */
    updateProgress(1);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
