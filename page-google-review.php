<?php
/**
 * Template Name: Google Review Landing Page
 *
 * NPS-gated Google review request with referral bonus form.
 * @package DigitalStride
 */

get_header();
?>

<main class="gr-page" id="google-review-page">

  <!-- ══ HERO ══════════════════════════════════════════════════════ -->
  <section class="gr-hero" aria-label="Thank you hero">
    <div class="gr-hero__overlay"></div>
    <div class="gr-hero__content">
      <p class="gr-hero__eyebrow">We appreciate you</p>
      <h1 class="gr-hero__title">Thank You</h1>
      <p class="gr-hero__sub">From the entire Digital Stride team</p>
    </div>
  </section>

  <!-- ══ NPS SATISFACTION ══════════════════════════════════════════ -->
  <section class="gr-nps" id="nps-section">
    <div class="gr-container">
      <div class="gr-nps__layout">

        <!-- ── Left column: NPS card + response panels (≈60%) ──── -->
        <div class="gr-nps__main">

          <div class="gr-nps__card">
            <div class="gr-nps__icon" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
            </div>
            <h2 class="gr-nps__heading">How satisfied are you with the service from Digital Stride?</h2>
            <p class="gr-nps__sub">On a scale of 0 to 10, how likely are you to recommend us to a friend or colleague?</p>

            <div class="gr-nps__scale" role="group" aria-label="Satisfaction score 0 to 10">
              <?php for ( $i = 0; $i <= 10; $i++ ) : ?>
                <button
                  type="button"
                  class="gr-nps__btn"
                  data-score="<?php echo esc_attr( $i ); ?>"
                  aria-label="Score <?php echo esc_attr( $i ); ?>"
                ><?php echo esc_html( $i ); ?></button>
              <?php endfor; ?>
            </div>

            <div class="gr-nps__labels" aria-hidden="true">
              <span>Not likely at all</span>
              <span>Extremely likely</span>
            </div>

            <div class="gr-nps__submit-wrap" id="nps-submit-wrap" hidden>
              <p class="gr-nps__selected-msg" id="nps-selected-msg" aria-live="polite"></p>
              <button type="button" class="gr-nps__submit-btn" id="nps-submit-btn">
                Submit Score <span aria-hidden="true">&rarr;</span>
              </button>
            </div>
          </div>

          <!-- ── LOW SCORE response (0-7) ────────────────────── -->
          <div class="gr-response gr-response--low" id="response-low" hidden>
            <div class="gr-response__icon" aria-hidden="true">&#128172;</div>
            <h3>Thank you for your honesty</h3>
            <p>
              We&rsquo;re sorry to hear your experience hasn&rsquo;t been everything it should be. Please share your feedback below and a member of our team will personally follow up to make things right.
            </p>

            <div id="gr-feedback-success" class="gr-form__success" hidden>
              <span class="gr-form__success-icon" aria-hidden="true">&#10003;</span>
              <strong>Feedback received!</strong> Thank you &mdash; someone from our team will be in touch shortly.
            </div>

            <form id="gr-feedback-form" class="gr-feedback-form" novalidate aria-label="Feedback form">
              <div class="gr-feedback-form__row">
                <div class="gr-form__group">
                  <label class="gr-form__label" for="fb-name">Your Name <span class="gr-form__required" aria-hidden="true">*</span></label>
                  <input type="text" id="fb-name" name="fb_name" class="gr-form__input" placeholder="Your Name" required />
                </div>
                <div class="gr-form__group">
                  <label class="gr-form__label" for="fb-email">Email Address <span class="gr-form__required" aria-hidden="true">*</span></label>
                  <input type="email" id="fb-email" name="fb_email" class="gr-form__input" placeholder="you@example.com" required />
                </div>
              </div>
              <div class="gr-form__group">
                <label class="gr-form__label" for="fb-message">Your Feedback <span class="gr-form__required" aria-hidden="true">*</span></label>
                <textarea id="fb-message" name="fb_message" class="gr-form__input gr-form__textarea" placeholder="Tell us what we could do better&hellip;" rows="4" required></textarea>
              </div>
              <div class="gr-feedback-form__footer">
                <button type="submit" class="gr-form__submit">Send Feedback <span aria-hidden="true">&rarr;</span></button>
              </div>
            </form>
          </div>

          <!-- ── HIGH SCORE response (8-10) ───────────────────── -->
          <div class="gr-response gr-response--high" id="response-high" hidden>
            <div class="gr-response__icon" aria-hidden="true">&#127775;</div>
            <h3>That means so much to us!</h3>
            <p>
              We&rsquo;re thrilled you&rsquo;ve had a great experience with Digital Stride. Would you be willing to share that with the world? A Google Review helps other businesses find us and takes less than 2 minutes.
            </p>
            <a
              href="https://g.page/r/CcMj7xiuJUJ_EBM/review"
              class="gr-review-btn"
              target="_blank"
              rel="noopener noreferrer"
              aria-label="Leave a Google Review for Digital Stride"
            >
              <svg class="gr-review-btn__logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" aria-hidden="true">
                <path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C35.6 2.4 30.1 0 24 0 14.6 0 6.6 5.4 2.7 13.3l7.8 6C12.3 13 17.7 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.7c-.5 2.8-2.2 5.2-4.7 6.8l7.3 5.7c4.3-4 6.8-9.9 7.2-16.5z"/>
                <path fill="#FBBC05" d="M10.5 28.7A14.4 14.4 0 0 1 9.5 24c0-1.6.3-3.2.7-4.7l-7.8-6A23.8 23.8 0 0 0 0 24c0 3.9.9 7.5 2.5 10.8l8-6.1z"/>
                <path fill="#34A853" d="M24 48c6.1 0 11.2-2 14.9-5.5l-7.3-5.7c-2 1.4-4.6 2.2-7.6 2.2-6.3 0-11.7-4.3-13.6-10l-8 6.1C6.5 42.6 14.6 48 24 48z"/>
              </svg>
              Leave a Google Review
            </a>
            <p class="gr-review-btn__note">Opens Google Reviews in a new tab &mdash; only takes 2 minutes!</p>
          </div>

        </div><!-- /.gr-nps__main -->

        <!-- ── Right column: Gratitude intro (≈40%) ────────────── -->
        <aside class="gr-nps__aside">
          <h2 class="gr-intro__heading">Working With You Is the Best Part of What We Do</h2>
          <p>
            At Digital Stride, we genuinely care about the people we work with &mdash; you&rsquo;re not just a client, you&rsquo;re a partner, and your trust means everything to our team. We&rsquo;d love to hear how we&rsquo;re doing, and your feedback helps us improve and helps other great businesses find us. It only takes a moment, and it means the world to us.
          </p>
        </aside>

      </div><!-- /.gr-nps__layout -->
    </div>
  </section>

  <!-- ══ REFERRAL BONUS (shown only for NPS 8-10) ═════════════════ -->
  <section class="gr-referral" id="referral-section" hidden>
    <div class="gr-container">

      <div class="gr-referral__badge">
        <span class="gr-referral__badge-text">Referral Bonus</span>
      </div>

      <div class="gr-referral__inner">

        <div class="gr-referral__text">
          <h2 class="gr-referral__heading">Know Someone Who Could Use Digital Stride?</h2>
          <p>
            Great clients tend to know other great people. If you refer a friend, colleague, or fellow business owner to Digital Stride and they become a customer, we&rsquo;ll send you a <strong>$200 Amazon gift card</strong> as a thank-you.
          </p>
          <ul class="gr-referral__perks">
            <li>
              <span class="gr-referral__perk-icon" aria-hidden="true">&#9989;</span>
              No limits &mdash; refer as many people as you like
            </li>
            <li>
              <span class="gr-referral__perk-icon" aria-hidden="true">&#9989;</span>
              Gift card sent once they become an active customer
            </li>
            <li>
              <span class="gr-referral__perk-icon" aria-hidden="true">&#9989;</span>
              Works for any Digital Stride service
            </li>
          </ul>
        </div>

        <div class="gr-referral__card-wrap">
          <div class="gr-referral__gift-card" aria-hidden="true">
            <div class="gr-referral__gift-amount">$200</div>
            <div class="gr-referral__gift-label">Amazon Gift Card</div>
            <div class="gr-referral__gift-sub">Per successful referral</div>
          </div>
        </div>

      </div>

      <!-- ── Referral form ─────────────────────────────────────── -->
      <div class="gr-form-wrap">
        <h3 class="gr-form__heading">Submit a Referral</h3>
        <p class="gr-form__sub">Fill out the form below for each person you&rsquo;d like to refer. You can submit this form multiple times.</p>

        <div id="gr-form-success" class="gr-form__success" hidden>
          <span class="gr-form__success-icon" aria-hidden="true">&#127881;</span>
          <strong>Referral submitted!</strong> Thank you &mdash; we&rsquo;ll be in touch with your referral soon. Feel free to submit another below.
        </div>

        <form
          id="gr-referral-form"
          class="gr-form"
          novalidate
          aria-label="Referral submission form"
        >
          <!-- Referral 1 -->
          <fieldset class="gr-form__fieldset">
            <legend class="gr-form__legend">Referral 1</legend>

            <div class="gr-form__row gr-form__row--3">
              <div class="gr-form__group">
                <label class="gr-form__label" for="ref-name">
                  Full Name <span class="gr-form__required" aria-hidden="true">*</span>
                </label>
                <input
                  type="text"
                  id="ref-name"
                  name="referral_name"
                  class="gr-form__input"
                  placeholder="Jane Smith"
                  autocomplete="name"
                  required
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="ref-email">
                  Email Address <span class="gr-form__required" aria-hidden="true">*</span>
                </label>
                <input
                  type="email"
                  id="ref-email"
                  name="referral_email"
                  class="gr-form__input"
                  placeholder="jane@example.com"
                  autocomplete="email"
                  required
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="ref-phone">Phone Number</label>
                <input
                  type="tel"
                  id="ref-phone"
                  name="referral_phone"
                  class="gr-form__input"
                  placeholder="(555) 555-5555"
                  autocomplete="tel"
                />
              </div>
            </div>
          </fieldset>

          <!-- Referral 2 (all optional) -->
          <fieldset class="gr-form__fieldset">
            <legend class="gr-form__legend">Referral 2 <span class="gr-form__legend-optional">(Optional)</span></legend>

            <div class="gr-form__row gr-form__row--3">
              <div class="gr-form__group">
                <label class="gr-form__label" for="ref2-name">Full Name</label>
                <input
                  type="text"
                  id="ref2-name"
                  name="referral_2_name"
                  class="gr-form__input"
                  placeholder="Jane Smith"
                  autocomplete="name"
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="ref2-email">Email Address</label>
                <input
                  type="email"
                  id="ref2-email"
                  name="referral_2_email"
                  class="gr-form__input"
                  placeholder="jane@example.com"
                  autocomplete="email"
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="ref2-phone">Phone Number</label>
                <input
                  type="tel"
                  id="ref2-phone"
                  name="referral_2_phone"
                  class="gr-form__input"
                  placeholder="(555) 555-5555"
                  autocomplete="tel"
                />
              </div>
            </div>
          </fieldset>

          <!-- Referral 3 (all optional) -->
          <fieldset class="gr-form__fieldset">
            <legend class="gr-form__legend">Referral 3 <span class="gr-form__legend-optional">(Optional)</span></legend>

            <div class="gr-form__row gr-form__row--3">
              <div class="gr-form__group">
                <label class="gr-form__label" for="ref3-name">Full Name</label>
                <input
                  type="text"
                  id="ref3-name"
                  name="referral_3_name"
                  class="gr-form__input"
                  placeholder="Jane Smith"
                  autocomplete="name"
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="ref3-email">Email Address</label>
                <input
                  type="email"
                  id="ref3-email"
                  name="referral_3_email"
                  class="gr-form__input"
                  placeholder="jane@example.com"
                  autocomplete="email"
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="ref3-phone">Phone Number</label>
                <input
                  type="tel"
                  id="ref3-phone"
                  name="referral_3_phone"
                  class="gr-form__input"
                  placeholder="(555) 555-5555"
                  autocomplete="tel"
                />
              </div>
            </div>
          </fieldset>

          <!-- Who is submitting -->
          <fieldset class="gr-form__fieldset">
            <legend class="gr-form__legend">Your Information</legend>

            <div class="gr-form__row gr-form__row--3">
              <div class="gr-form__group">
                <label class="gr-form__label" for="sub-name">
                  Your Name <span class="gr-form__required" aria-hidden="true">*</span>
                </label>
                <input
                  type="text"
                  id="sub-name"
                  name="submitter_name"
                  class="gr-form__input"
                  placeholder="Your Name"
                  autocomplete="name"
                  required
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="sub-email">
                  Your Email <span class="gr-form__required" aria-hidden="true">*</span>
                </label>
                <input
                  type="email"
                  id="sub-email"
                  name="submitter_email"
                  class="gr-form__input"
                  placeholder="you@example.com"
                  autocomplete="email"
                  required
                />
              </div>

              <div class="gr-form__group">
                <label class="gr-form__label" for="sub-phone">
                  Your Phone <span class="gr-form__required" aria-hidden="true">*</span>
                </label>
                <input
                  type="tel"
                  id="sub-phone"
                  name="submitter_phone"
                  class="gr-form__input"
                  placeholder="(555) 555-5555"
                  autocomplete="tel"
                  required
                />
              </div>
            </div>
          </fieldset>

          <div class="gr-form__footer">
            <p class="gr-form__disclaimer">
              By submitting, you agree that Digital Stride may contact your referral. We never sell your information to third parties.
            </p>
            <button type="submit" class="gr-form__submit">
              Submit Referral
              <span class="gr-form__submit-arrow" aria-hidden="true">&rarr;</span>
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>

</main>

<script>
(function () {
  'use strict';

  /* ── NPS score selection ──────────────────────────────────── */
  var npsButtons      = document.querySelectorAll('.gr-nps__btn');
  var responseLow     = document.getElementById('response-low');
  var responseHigh    = document.getElementById('response-high');
  var referralSection = document.getElementById('referral-section');
  var npsSubmitWrap   = document.getElementById('nps-submit-wrap');
  var npsSubmitBtn    = document.getElementById('nps-submit-btn');
  var npsSelectedMsg  = document.getElementById('nps-selected-msg');
  var selectedScore   = null;

  npsButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      selectedScore = parseInt(btn.getAttribute('data-score'), 10);

      /* Update active state */
      npsButtons.forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');

      /* Show the submit button and a confirmation message */
      npsSelectedMsg.textContent = 'You selected ' + selectedScore + ' out of 10.';
      npsSubmitWrap.hidden = false;
    });
  });

  if (npsSubmitBtn) {
    npsSubmitBtn.addEventListener('click', function () {
      if (selectedScore === null) { return; }

      /* 8-10 = promoter (show review + referral); 0-7 = detractor/passive (show feedback form) */
      if (selectedScore >= 8) {
        responseLow.hidden  = true;
        responseHigh.hidden = false;
        if (referralSection) referralSection.hidden = false;
      } else {
        responseHigh.hidden = true;
        responseLow.hidden  = false;
        if (referralSection) referralSection.hidden = true;
      }

      /* Disable score buttons so score can't be changed after submit */
      npsButtons.forEach(function (b) { b.disabled = true; });
      npsSubmitBtn.disabled = true;

      /* Smooth-scroll to response */
      var target = selectedScore >= 8 ? responseHigh : responseLow;
      setTimeout(function () {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 120);
    });
  }

  /* ── Feedback form (low score) ────────────────────────────── */
  var feedbackForm    = document.getElementById('gr-feedback-form');
  var feedbackSuccess = document.getElementById('gr-feedback-success');

  if (feedbackForm) {
    feedbackForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!feedbackForm.checkValidity()) { feedbackForm.reportValidity(); return; }

      var submitBtn = feedbackForm.querySelector('.gr-form__submit');
      submitBtn.disabled    = true;
      submitBtn.textContent = 'Sending\u2026';

      var data = new FormData(feedbackForm);
      data.append('action', 'gr_feedback_submit');
      data.append('nonce',  grData.feedbackNonce);

      fetch(grData.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: data })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json.success) {
            feedbackSuccess.hidden = false;
            feedbackForm.hidden    = true;
            feedbackSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          } else {
            alert(json.data || 'Something went wrong. Please try again.');
            submitBtn.disabled    = false;
            submitBtn.textContent = 'Send Feedback \u2192';
          }
        })
        .catch(function () {
          alert('Network error. Please check your connection and try again.');
          submitBtn.disabled    = false;
          submitBtn.textContent = 'Send Feedback \u2192';
        });
    });
  }

  /* ── Referral form ────────────────────────────────────────── */
  var form       = document.getElementById('gr-referral-form');
  var successMsg = document.getElementById('gr-form-success');

  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      if (!form.checkValidity()) { form.reportValidity(); return; }

      var submitBtn = form.querySelector('.gr-form__submit');
      submitBtn.disabled    = true;
      submitBtn.textContent = 'Submitting\u2026';

      var data = new FormData(form);
      data.append('action', 'gr_referral_submit');
      data.append('nonce',  grData.nonce);

      fetch(grData.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: data })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json.success) {
            successMsg.hidden = false;
            successMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            ['#ref-name','#ref-email','#ref-phone',
             '#ref2-name','#ref2-email','#ref2-phone',
             '#ref3-name','#ref3-email','#ref3-phone'].forEach(function (id) {
              var el = form.querySelector(id);
              if (el) el.value = '';
            });
          } else {
            alert(json.data || 'Something went wrong. Please try again.');
          }
        })
        .catch(function () {
          alert('Network error. Please check your connection and try again.');
        })
        .finally(function () {
          submitBtn.disabled    = false;
          submitBtn.textContent = 'Submit Referral \u2192';
        });
    });
  }
})();
</script>

<?php get_footer(); ?>
