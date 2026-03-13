<?php
/**
 * Template Name: Referral Landing Page
 *
 * Professional referral promotion page: $5/contact submitted (up to 20),
 * $300 Amazon gift card per referral who becomes a customer.
 *
 * @package DigitalStride
 */

get_header();
?>

<main class="rl-page" id="referral-landing-page">

  <!-- ══ HERO ══════════════════════════════════════════════════════════ -->
  <section class="rl-hero" aria-label="Referral promotion hero">
    <div class="rl-hero__overlay"></div>
    <div class="rl-hero__layout">

      <!-- Left: branding / eyebrow -->
      <div class="rl-hero__left">
        <p class="rl-hero__eyebrow">Exclusive Partner Promotion</p>
        <h1 class="rl-hero__title">Get Rewarded for Every Referral</h1>
        <p class="rl-hero__sub">Share the people in your network&nbsp;&mdash; we&rsquo;ll make it worth your while.</p>
      </div>

      <!-- Center: CTA button -->
      <div class="rl-hero__center">
        <a href="#referral-form-section" class="rl-hero__cta">Submit Referrals Now <span aria-hidden="true">&darr;</span></a>
      </div>

      <!-- Right: offer summary -->
      <div class="rl-hero__right">
        <div class="rl-hero__offer">
          <p class="rl-hero__offer-label">This Promotion</p>
          <div class="rl-hero__offer-row">
            <span class="rl-hero__offer-amount">$5</span>
            <span class="rl-hero__offer-desc">per contact you submit<br><em>(up to 20&nbsp;&mdash;&nbsp;$100 total)</em></span>
          </div>
          <div class="rl-hero__offer-divider"></div>
          <div class="rl-hero__offer-row">
            <span class="rl-hero__offer-amount rl-hero__offer-amount--gold">$300</span>
            <span class="rl-hero__offer-desc">Amazon gift card per<br>referral who becomes<br>a customer</span>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ══ REWARD CARDS ══════════════════════════════════════════════════ -->
  <section class="rl-rewards" aria-label="Promotion rewards">
    <div class="rl-container">

      <div class="rl-rewards__intro">
        <h2 class="rl-rewards__heading">Two Ways to Earn</h2>
        <p class="rl-rewards__sub">You give us great contacts&nbsp;&mdash; we give you great rewards. It&rsquo;s that simple.</p>
      </div>

      <div class="rl-rewards__grid">

        <!-- Reward Card 1: $5 per contact -->
        <div class="rl-reward-card rl-reward-card--silver">
          <div class="rl-reward-card__icon-wrap" aria-hidden="true">
            <i class="fa-solid fa-address-card"></i>
          </div>
          <div class="rl-reward-card__amount">$5</div>
          <div class="rl-reward-card__label">Per Contact Submitted</div>
          <p class="rl-reward-card__desc">
            Submit up to&nbsp;<strong>20 contacts</strong>&nbsp;and earn&nbsp;<strong>$5</strong>&nbsp;for each one&nbsp;&mdash; that&rsquo;s up to&nbsp;<strong>$100</strong>&nbsp;just for sharing names!
          </p>
          <div class="rl-reward-card__max">Up to $100 total</div>
        </div>

        <!-- Reward Card 2: $300 per customer -->
        <div class="rl-reward-card rl-reward-card--gold">
          <div class="rl-reward-card__icon-wrap" aria-hidden="true">
            <i class="fa-solid fa-star"></i>
          </div>
          <div class="rl-reward-card__amount">$300</div>
          <div class="rl-reward-card__label">Per Referral Who Becomes a Customer</div>
          <p class="rl-reward-card__desc">
            When someone you refer signs on as a Digital Stride client, you receive a&nbsp;<strong>$300 Amazon gift card</strong>&nbsp;as our thank&nbsp;you.
          </p>
          <!-- Amazon-style gift card visual -->
          <div class="rl-amazon-card" aria-label="Amazon gift card reward">
            <div class="rl-amazon-card__ribbon">GIFT CARD</div>
            <div class="rl-amazon-card__smile" aria-hidden="true">
              <svg viewBox="0 0 100 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M6 8 Q50 28 94 8" stroke="#fff" stroke-width="4.5" stroke-linecap="round" fill="none"/>
                <circle cx="94" cy="8" r="4" fill="#fff"/>
              </svg>
            </div>
            <div class="rl-amazon-card__amount">$300</div>
            <div class="rl-amazon-card__foot">Amazon Gift Card</div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ══ HOW IT WORKS ══════════════════════════════════════════════════ -->
  <section class="rl-how" aria-label="How the referral program works">
    <div class="rl-container">

      <h2 class="rl-how__heading">How It Works</h2>

      <div class="rl-how__steps">

        <div class="rl-how__step">
          <div class="rl-how__step-num" aria-hidden="true">1</div>
          <div class="rl-how__step-icon" aria-hidden="true">
            <i class="fa-solid fa-user-plus"></i>
          </div>
          <h3 class="rl-how__step-title">Submit Your Contacts</h3>
          <p class="rl-how__step-desc">Fill out the form below with the name, email, and phone for each person you&rsquo;d like to refer. You can submit up to&nbsp;20.</p>
        </div>

        <div class="rl-how__connector" aria-hidden="true"></div>

        <div class="rl-how__step">
          <div class="rl-how__step-num" aria-hidden="true">2</div>
          <div class="rl-how__step-icon" aria-hidden="true">
            <i class="fa-solid fa-envelope-open-text"></i>
          </div>
          <h3 class="rl-how__step-title">We Reach Out</h3>
          <p class="rl-how__step-desc">Our team personally contacts each referral and shares how Digital Stride can help grow their business online.</p>
        </div>

        <div class="rl-how__connector" aria-hidden="true"></div>

        <div class="rl-how__step">
          <div class="rl-how__step-num" aria-hidden="true">3</div>
          <div class="rl-how__step-icon" aria-hidden="true">
            <i class="fa-solid fa-gift"></i>
          </div>
          <h3 class="rl-how__step-title">Collect Your Rewards</h3>
          <p class="rl-how__step-desc">You receive&nbsp;<strong>$5</strong>&nbsp;per contact submitted and a&nbsp;<strong>$300 Amazon gift card</strong>&nbsp;for each one who becomes a customer.</p>
        </div>

      </div>

    </div>
  </section>

  <!-- ══ REFERRAL FORM ══════════════════════════════════════════════════ -->
  <section class="rl-form-section" id="referral-form-section" aria-label="Submit referrals form">
    <div class="rl-container">

      <div class="rl-form-section__header">
        <span class="rl-badge">Limited Time Offer</span>
        <h2 class="rl-form-section__heading">Submit Your Referrals</h2>
        <p class="rl-form-section__sub">Enter your information and the details for each person you&rsquo;d like to refer. Start with as many or as few as you like&nbsp;&mdash; up to&nbsp;20 total.</p>
      </div>

      <!-- Success message -->
      <div id="rl-form-success" class="rl-form__success" hidden>
        <span class="rl-form__success-icon" aria-hidden="true">&#127881;</span>
        <div>
          <strong>Referrals submitted successfully!</strong><br>
          Thank you&nbsp;&mdash; we&rsquo;ll be in touch with your contacts soon. Your $5-per-contact reward will be processed within 5 business days.
        </div>
      </div>

      <form id="rl-referral-form" class="rl-form" novalidate aria-label="Professional referral submission form">

        <!-- ── YOUR INFORMATION ──────────────────────────────────────── -->
        <div class="rl-form__section rl-form__section--submitter">
          <div class="rl-form__section-header">
            <div class="rl-form__section-icon" aria-hidden="true"><i class="fa-solid fa-circle-user"></i></div>
            <div>
              <h3 class="rl-form__section-title">Your Information</h3>
              <p class="rl-form__section-desc">Tell us who you are so we can send your rewards.</p>
            </div>
          </div>

          <div class="rl-form__row rl-form__row--2">
            <div class="rl-form__group">
              <label class="rl-form__label" for="sub-name">
                Your Name <span class="rl-form__required" aria-hidden="true">*</span>
              </label>
              <input
                type="text"
                id="sub-name"
                name="submitter_name"
                class="rl-form__input"
                placeholder="Jane Smith"
                autocomplete="name"
                required
              />
            </div>
            <div class="rl-form__group">
              <label class="rl-form__label" for="sub-email">
                Your Email <span class="rl-form__required" aria-hidden="true">*</span>
              </label>
              <input
                type="email"
                id="sub-email"
                name="submitter_email"
                class="rl-form__input"
                placeholder="you@example.com"
                autocomplete="email"
                required
              />
            </div>
          </div>
        </div>

        <!-- ── REFERRALS ─────────────────────────────────────────────── -->
        <div class="rl-form__section rl-form__section--referrals">
          <div class="rl-form__section-header">
            <div class="rl-form__section-icon" aria-hidden="true"><i class="fa-solid fa-people-group"></i></div>
            <div>
              <h3 class="rl-form__section-title">Your Referrals</h3>
              <p class="rl-form__section-desc">
                Add up to <strong>20 people</strong>. Name and email are required for each referral; phone is optional.
                <span class="rl-counter" id="rl-counter">1 of 20 slots used</span>
              </p>
            </div>
          </div>

          <!-- Column headers (desktop) -->
          <div class="rl-referral-headers" aria-hidden="true">
            <span>#</span>
            <span>Full Name <span class="rl-form__required">*</span></span>
            <span>Email Address <span class="rl-form__required">*</span></span>
            <span>Phone Number</span>
            <span></span>
          </div>

          <!-- Referral rows container -->
          <div id="rl-referral-rows">
            <!-- Row 1 (always shown, pre-rendered) -->
            <div class="rl-referral-row" data-index="1">
              <div class="rl-referral-row__num" aria-hidden="true">1</div>
              <div class="rl-form__group">
                <label class="rl-form__label rl-sr-only" for="ref-1-name">Referral 1 Full Name *</label>
                <input type="text"  id="ref-1-name"  name="referrals[1][name]"  class="rl-form__input" placeholder="Full Name"          autocomplete="off" required />
              </div>
              <div class="rl-form__group">
                <label class="rl-form__label rl-sr-only" for="ref-1-email">Referral 1 Email Address *</label>
                <input type="email" id="ref-1-email" name="referrals[1][email]" class="rl-form__input" placeholder="Email Address"       autocomplete="off" required />
              </div>
              <div class="rl-form__group">
                <label class="rl-form__label rl-sr-only" for="ref-1-phone">Referral 1 Phone Number</label>
                <input type="tel"   id="ref-1-phone" name="referrals[1][phone]" class="rl-form__input" placeholder="Phone (optional)"    autocomplete="off" />
              </div>
              <div class="rl-referral-row__remove-wrap">
                <button type="button" class="rl-remove-row" aria-label="Remove referral 1" hidden>
                  <i class="fa-solid fa-circle-xmark" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Add row button -->
          <div class="rl-add-row-wrap">
            <button type="button" id="rl-add-row" class="rl-add-row-btn">
              <i class="fa-solid fa-plus" aria-hidden="true"></i>
              Add Another Person
            </button>
            <span class="rl-add-row-limit" id="rl-add-row-limit" hidden>
              Maximum of 20 contacts reached.
            </span>
          </div>

        </div>

        <!-- ── SUBMIT ─────────────────────────────────────────────────── -->
        <div class="rl-form__footer">
          <p class="rl-form__disclaimer">
            By submitting, you confirm you have permission to share these contact details and agree that Digital Stride may reach out to your referrals. We never sell or share your information with third parties.
          </p>
          <button type="submit" class="rl-form__submit">
            Submit Referrals
            <span class="rl-form__submit-arrow" aria-hidden="true">&rarr;</span>
          </button>
        </div>

      </form>

    </div>
  </section>

  <!-- ══ FINE PRINT / FAQ ══════════════════════════════════════════════ -->
  <section class="rl-faq" aria-label="Frequently asked questions">
    <div class="rl-container">
      <h2 class="rl-faq__heading">Frequently Asked Questions</h2>
      <div class="rl-faq__grid">

        <div class="rl-faq__item">
          <h3 class="rl-faq__q"><i class="fa-solid fa-circle-question" aria-hidden="true"></i> When do I get paid?</h3>
          <p class="rl-faq__a">The $5 gift card per submitted contact is processed within 5 business days of submission. The $300 Amazon gift card is sent once your referral signs on as an active Digital Stride customer.</p>
        </div>

        <div class="rl-faq__item">
          <h3 class="rl-faq__q"><i class="fa-solid fa-circle-question" aria-hidden="true"></i> Is there a limit on how many I can refer?</h3>
          <p class="rl-faq__a">You may submit up to 20 contacts per form submission. There&rsquo;s no limit to the number of people who can become customers&nbsp;&mdash; each one earns you a $300 Amazon gift card.</p>
        </div>

        <div class="rl-faq__item">
          <h3 class="rl-faq__q"><i class="fa-solid fa-circle-question" aria-hidden="true"></i> What services does Digital Stride offer?</h3>
          <p class="rl-faq__a">Digital Stride provides digital marketing, web design, SEO, social media management, and more. The $300 reward applies when a referral signs on for any Digital Stride service.</p>
        </div>

        <div class="rl-faq__item">
          <h3 class="rl-faq__q"><i class="fa-solid fa-circle-question" aria-hidden="true"></i> Will my referrals know I submitted their info?</h3>
          <p class="rl-faq__a">Yes&nbsp;&mdash; we believe in transparency. When we reach out, we&rsquo;ll let them know a trusted colleague referred them. This typically leads to a much warmer conversation.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ══ BOTTOM CTA ════════════════════════════════════════════════════ -->
  <section class="rl-bottom-cta" aria-label="Submit referrals call to action">
    <div class="rl-container">
      <div class="rl-bottom-cta__inner">
        <div class="rl-bottom-cta__text">
          <h2 class="rl-bottom-cta__heading">Ready to Start Earning?</h2>
          <p class="rl-bottom-cta__sub">Submit your referrals now&nbsp;&mdash; it only takes a few minutes.</p>
        </div>
        <a href="#referral-form-section" class="rl-bottom-cta__btn">
          Submit Your Referrals <span aria-hidden="true">&uarr;</span>
        </a>
      </div>
    </div>
  </section>

</main>

<script>
(function () {
  'use strict';

  var MAX_ROWS   = 20;
  var rowCount   = 1;
  var container  = document.getElementById('rl-referral-rows');
  var addBtn     = document.getElementById('rl-add-row');
  var limitMsg   = document.getElementById('rl-add-row-limit');
  var counter    = document.getElementById('rl-counter');
  var form       = document.getElementById('rl-referral-form');
  var successMsg = document.getElementById('rl-form-success');

  /* ── Update counter text ─────────────────────────────────── */
  function updateCounter() {
    if (!counter) return;
    counter.textContent = rowCount + ' of ' + MAX_ROWS + ' slot' + (rowCount === 1 ? '' : 's') + ' used';
  }

  /* ── Update remove-button visibility ────────────────────── */
  function updateRemoveBtns() {
    var rows = container.querySelectorAll('.rl-referral-row');
    rows.forEach(function (row, i) {
      var btn = row.querySelector('.rl-remove-row');
      if (btn) btn.hidden = (rows.length === 1);
    });
  }

  /* ── Build a new referral row ────────────────────────────── */
  function buildRow(idx) {
    var div = document.createElement('div');
    div.className   = 'rl-referral-row rl-referral-row--new';
    div.dataset.index = idx;

    div.innerHTML =
      '<div class="rl-referral-row__num" aria-hidden="true">' + idx + '</div>' +
      '<div class="rl-form__group">' +
        '<label class="rl-form__label rl-sr-only" for="ref-' + idx + '-name">Referral ' + idx + ' Full Name *</label>' +
        '<input type="text"  id="ref-' + idx + '-name"  name="referrals[' + idx + '][name]"  class="rl-form__input" placeholder="Full Name"       autocomplete="off" required />' +
      '</div>' +
      '<div class="rl-form__group">' +
        '<label class="rl-form__label rl-sr-only" for="ref-' + idx + '-email">Referral ' + idx + ' Email Address *</label>' +
        '<input type="email" id="ref-' + idx + '-email" name="referrals[' + idx + '][email]" class="rl-form__input" placeholder="Email Address"    autocomplete="off" required />' +
      '</div>' +
      '<div class="rl-form__group">' +
        '<label class="rl-form__label rl-sr-only" for="ref-' + idx + '-phone">Referral ' + idx + ' Phone Number</label>' +
        '<input type="tel"   id="ref-' + idx + '-phone" name="referrals[' + idx + '][phone]" class="rl-form__input" placeholder="Phone (optional)" autocomplete="off" />' +
      '</div>' +
      '<div class="rl-referral-row__remove-wrap">' +
        '<button type="button" class="rl-remove-row" aria-label="Remove referral ' + idx + '">' +
          '<i class="fa-solid fa-circle-xmark" aria-hidden="true"></i>' +
        '</button>' +
      '</div>';

    return div;
  }

  /* ── Renumber rows after removal ─────────────────────────── */
  function renumberRows() {
    var rows = container.querySelectorAll('.rl-referral-row');
    rows.forEach(function (row, i) {
      var num = i + 1;
      row.dataset.index = num;
      var numEl = row.querySelector('.rl-referral-row__num');
      if (numEl) numEl.textContent = num;

      /* Update field names + ids */
      ['name','email','phone'].forEach(function (field) {
        var input = row.querySelector('input[name*="[' + field + ']"]');
        var label = row.querySelector('label[for*="-' + field + '"]');
        if (input) {
          input.name = 'referrals[' + num + '][' + field + ']';
          input.id   = 'ref-' + num + '-' + field;
        }
        if (label) label.setAttribute('for', 'ref-' + num + '-' + field);
      });

      var removeBtn = row.querySelector('.rl-remove-row');
      if (removeBtn) removeBtn.setAttribute('aria-label', 'Remove referral ' + num);
    });
    rowCount = rows.length;
    updateCounter();
    updateRemoveBtns();
    addBtn.hidden    = (rowCount >= MAX_ROWS);
    limitMsg.hidden  = (rowCount < MAX_ROWS);
  }

  /* ── Add row ─────────────────────────────────────────────── */
  if (addBtn) {
    addBtn.addEventListener('click', function () {
      if (rowCount >= MAX_ROWS) return;
      rowCount++;
      var newRow = buildRow(rowCount);
      container.appendChild(newRow);

      /* Animate in */
      requestAnimationFrame(function () {
        newRow.classList.add('rl-referral-row--visible');
      });

      /* Focus first input */
      var first = newRow.querySelector('input');
      if (first) setTimeout(function () { first.focus(); }, 50);

      updateCounter();
      updateRemoveBtns();

      if (rowCount >= MAX_ROWS) {
        addBtn.hidden   = true;
        limitMsg.hidden = false;
      }
    });
  }

  /* ── Remove row (delegated) ──────────────────────────────── */
  if (container) {
    container.addEventListener('click', function (e) {
      var btn = e.target.closest('.rl-remove-row');
      if (!btn) return;

      var row = btn.closest('.rl-referral-row');
      if (!row) return;

      /* Animate out */
      row.classList.add('rl-referral-row--removing');
      setTimeout(function () {
        if (row.parentNode) row.parentNode.removeChild(row);
        renumberRows();
        addBtn.hidden   = false;
        limitMsg.hidden = true;
      }, 280);
    });
  }

  /* ── Form submission ─────────────────────────────────────── */
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.checkValidity()) { form.reportValidity(); return; }

      var submitBtn = form.querySelector('.rl-form__submit');
      submitBtn.disabled    = true;
      submitBtn.textContent = 'Submitting\u2026';

      var data = new FormData(form);
      data.append('action', 'rl_referral_submit');
      data.append('nonce',  rlData.nonce);

      fetch(rlData.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: data })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json.success) {
            successMsg.hidden = false;
            form.hidden       = true;
            successMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          } else {
            alert(json.data || 'Something went wrong. Please try again.');
            submitBtn.disabled    = false;
            submitBtn.textContent = 'Submit Referrals \u2192';
          }
        })
        .catch(function () {
          alert('Network error. Please check your connection and try again.');
          submitBtn.disabled    = false;
          submitBtn.textContent = 'Submit Referrals \u2192';
        });
    });
  }

  /* ── Init ────────────────────────────────────────────────── */
  updateCounter();
  updateRemoveBtns();

})();
</script>

<?php get_footer(); ?>
