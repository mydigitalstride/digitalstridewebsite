<?php
/**
 * Template Name: Educational Review Landing Page
 *
 * Multi-step post-education feedback flow:
 *   Step 1 – Program experience questions
 *   Step 2 – NPS score (revealed after Step 1)
 *   Step 3a – Google Review request (NPS 8-10)
 *   Step 3b – Improvement feedback form (NPS 0-7)
 *
 * @package DigitalStride
 */

get_header();
?>

<main class="er-page" id="educational-review-page">

  <!-- ══ HERO ══════════════════════════════════════════════════════ -->
  <section class="er-hero" aria-label="Thank you hero">
    <div class="er-hero__overlay"></div>
    <div class="er-hero__content">
      <p class="er-hero__eyebrow">We appreciate you being here</p>
      <h1 class="er-hero__title">Thank You for Learning With Us</h1>
      <p class="er-hero__sub">Your feedback helps us build better experiences for every student</p>
    </div>
  </section>

  <!-- ══ MAIN CONTENT ══════════════════════════════════════════════ -->
  <section class="er-main" id="er-main-section">
    <div class="er-container">
      <div class="er-layout">

        <!-- ── Left column: Step forms (≈60%) ──────────────────── -->
        <div class="er-layout__main">

          <!-- ══ STEP 1: Program Experience ═══════════════════════ -->
          <div class="er-step" id="step-experience">
            <div class="er-step__card">
              <div class="er-step__badge">Step 1 of 2</div>

              <div class="er-step__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
              </div>

              <h2 class="er-step__heading">Tell Us About Your Experience</h2>
              <p class="er-step__sub">A few quick questions so we can understand what worked and what we can make even better.</p>

              <form id="er-experience-form" class="er-form" novalidate aria-label="Program experience form">

                <!-- Program / Session attended -->
                <div class="er-form__group">
                  <label class="er-form__label" for="exp-program">
                    Which program or session did you attend?
                    <span class="er-form__required" aria-hidden="true">*</span>
                  </label>
                  <input
                    type="text"
                    id="exp-program"
                    name="program_name"
                    class="er-form__input"
                    placeholder="e.g. Digital Marketing Bootcamp, SEO Workshop…"
                    required
                  />
                </div>

                <!-- Overall experience rating -->
                <fieldset class="er-form__fieldset">
                  <legend class="er-form__legend">
                    How would you rate your overall experience?
                    <span class="er-form__required" aria-hidden="true">*</span>
                  </legend>
                  <div class="er-rating-grid" role="radiogroup" aria-label="Overall experience rating">
                    <label class="er-rating-option">
                      <input type="radio" name="overall_rating" value="excellent" required />
                      <span class="er-rating-option__card">
                        <span class="er-rating-option__emoji" aria-hidden="true">&#x1F929;</span>
                        <span class="er-rating-option__label">Excellent</span>
                      </span>
                    </label>
                    <label class="er-rating-option">
                      <input type="radio" name="overall_rating" value="good" />
                      <span class="er-rating-option__card">
                        <span class="er-rating-option__emoji" aria-hidden="true">&#x1F604;</span>
                        <span class="er-rating-option__label">Good</span>
                      </span>
                    </label>
                    <label class="er-rating-option">
                      <input type="radio" name="overall_rating" value="fair" />
                      <span class="er-rating-option__card">
                        <span class="er-rating-option__emoji" aria-hidden="true">&#x1F610;</span>
                        <span class="er-rating-option__label">Fair</span>
                      </span>
                    </label>
                    <label class="er-rating-option">
                      <input type="radio" name="overall_rating" value="needs_improvement" />
                      <span class="er-rating-option__card">
                        <span class="er-rating-option__emoji" aria-hidden="true">&#x1F914;</span>
                        <span class="er-rating-option__label">Could Be Better</span>
                      </span>
                    </label>
                  </div>
                </fieldset>

                <!-- Most valuable aspects (checkboxes) -->
                <fieldset class="er-form__fieldset">
                  <legend class="er-form__legend">What was most valuable to you? <span class="er-form__legend-optional">(Select all that apply)</span></legend>
                  <div class="er-check-grid">
                    <label class="er-check-option">
                      <input type="checkbox" name="valuable[]" value="content_quality" />
                      <span class="er-check-option__box" aria-hidden="true"></span>
                      <span class="er-check-option__label">Content quality &amp; depth</span>
                    </label>
                    <label class="er-check-option">
                      <input type="checkbox" name="valuable[]" value="instructor_knowledge" />
                      <span class="er-check-option__box" aria-hidden="true"></span>
                      <span class="er-check-option__label">Instructor knowledge</span>
                    </label>
                    <label class="er-check-option">
                      <input type="checkbox" name="valuable[]" value="practical_examples" />
                      <span class="er-check-option__box" aria-hidden="true"></span>
                      <span class="er-check-option__label">Practical examples &amp; demos</span>
                    </label>
                    <label class="er-check-option">
                      <input type="checkbox" name="valuable[]" value="actionable_takeaways" />
                      <span class="er-check-option__box" aria-hidden="true"></span>
                      <span class="er-check-option__label">Actionable takeaways</span>
                    </label>
                    <label class="er-check-option">
                      <input type="checkbox" name="valuable[]" value="qa_session" />
                      <span class="er-check-option__box" aria-hidden="true"></span>
                      <span class="er-check-option__label">Q&amp;A session</span>
                    </label>
                    <label class="er-check-option">
                      <input type="checkbox" name="valuable[]" value="networking" />
                      <span class="er-check-option__box" aria-hidden="true"></span>
                      <span class="er-check-option__label">Networking opportunities</span>
                    </label>
                  </div>
                </fieldset>

                <!-- Key takeaway -->
                <div class="er-form__group">
                  <label class="er-form__label" for="exp-takeaway">
                    What's the biggest thing you're walking away with?
                  </label>
                  <textarea
                    id="exp-takeaway"
                    name="key_takeaway"
                    class="er-form__input er-form__textarea"
                    placeholder="Share your biggest insight or what you plan to apply first…"
                    rows="3"
                  ></textarea>
                </div>

                <!-- What to improve -->
                <div class="er-form__group">
                  <label class="er-form__label" for="exp-improve">
                    What could we do to make this even better?
                  </label>
                  <textarea
                    id="exp-improve"
                    name="improvement_suggestions"
                    class="er-form__input er-form__textarea"
                    placeholder="Be as specific as you like — every suggestion helps…"
                    rows="3"
                  ></textarea>
                </div>

                <!-- Attend again -->
                <fieldset class="er-form__fieldset er-form__fieldset--inline">
                  <legend class="er-form__legend">Would you attend another Digital Stride session?</legend>
                  <div class="er-inline-radio">
                    <label class="er-inline-radio__option">
                      <input type="radio" name="attend_again" value="yes" />
                      <span>Absolutely</span>
                    </label>
                    <label class="er-inline-radio__option">
                      <input type="radio" name="attend_again" value="maybe" />
                      <span>Maybe</span>
                    </label>
                    <label class="er-inline-radio__option">
                      <input type="radio" name="attend_again" value="no" />
                      <span>Probably Not</span>
                    </label>
                  </div>
                </fieldset>

                <div class="er-form__footer">
                  <button type="submit" class="er-form__submit" id="exp-submit-btn">
                    Continue to Step 2 <span aria-hidden="true">&rarr;</span>
                  </button>
                </div>

              </form>
            </div>
          </div><!-- /#step-experience -->

          <!-- ══ STEP 2: NPS Score (hidden until Step 1 complete) ══ -->
          <div class="er-step" id="step-nps" hidden>
            <div class="er-step__card er-step__card--nps">
              <div class="er-step__badge">Step 2 of 2</div>

              <div class="er-step__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
              </div>

              <h2 class="er-step__heading">One Last Question</h2>
              <p class="er-step__sub">On a scale of 0&ndash;10, how likely are you to recommend this program to a friend or colleague?</p>

              <div class="er-nps__scale" role="group" aria-label="Recommendation score 0 to 10">
                <?php for ( $i = 0; $i <= 10; $i++ ) : ?>
                  <button
                    type="button"
                    class="er-nps__btn"
                    data-score="<?php echo esc_attr( $i ); ?>"
                    aria-label="Score <?php echo esc_attr( $i ); ?>"
                  ><?php echo esc_html( $i ); ?></button>
                <?php endfor; ?>
              </div>

              <div class="er-nps__labels" aria-hidden="true">
                <span>Not likely at all</span>
                <span>Extremely likely</span>
              </div>

              <div class="er-nps__submit-wrap" id="nps-submit-wrap" hidden>
                <p class="er-nps__selected-msg" id="nps-selected-msg" aria-live="polite"></p>
                <button type="button" class="er-nps__submit-btn" id="nps-submit-btn">
                  Submit My Score <span aria-hidden="true">&rarr;</span>
                </button>
              </div>

            </div>
          </div><!-- /#step-nps -->

          <!-- ══ STEP 3a: HIGH SCORE — Google Review request ═══════ -->
          <div class="er-response er-response--high" id="response-high" hidden>
            <div class="er-response__icon" aria-hidden="true">&#127775;</div>
            <h3>That means the world to us!</h3>
            <p>
              We&rsquo;re so glad the program was valuable for you. If you have 2 minutes, sharing your experience in a Google Review helps other learners discover us and shows them what they can expect.
            </p>
            <a
              href="https://g.page/r/CcMj7xiuJUJ_EBM/review"
              class="er-review-btn"
              target="_blank"
              rel="noopener noreferrer"
              aria-label="Leave a Google Review for Digital Stride"
            >
              <svg class="er-review-btn__logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" aria-hidden="true">
                <path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C35.6 2.4 30.1 0 24 0 14.6 0 6.6 5.4 2.7 13.3l7.8 6C12.3 13 17.7 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.7c-.5 2.8-2.2 5.2-4.7 6.8l7.3 5.7c4.3-4 6.8-9.9 7.2-16.5z"/>
                <path fill="#FBBC05" d="M10.5 28.7A14.4 14.4 0 0 1 9.5 24c0-1.6.3-3.2.7-4.7l-7.8-6A23.8 23.8 0 0 0 0 24c0 3.9.9 7.5 2.5 10.8l8-6.1z"/>
                <path fill="#34A853" d="M24 48c6.1 0 11.2-2 14.9-5.5l-7.3-5.7c-2 1.4-4.6 2.2-7.6 2.2-6.3 0-11.7-4.3-13.6-10l-8 6.1C6.5 42.6 14.6 48 24 48z"/>
              </svg>
              Leave a Google Review
            </a>
            <p class="er-review-btn__note">Opens Google Reviews in a new tab &mdash; only takes 2 minutes!</p>
          </div>

          <!-- ══ STEP 3b: LOW SCORE — Internal feedback form ═══════ -->
          <div class="er-response er-response--low" id="response-low" hidden>
            <div class="er-response__icon" aria-hidden="true">&#128172;</div>
            <h3>Thank you for your honesty</h3>
            <p>
              We&rsquo;re sorry it didn&rsquo;t fully hit the mark. Your candid feedback is exactly what we need to improve. Please share any details below and a member of our team will personally follow up.
            </p>

            <div id="er-feedback-success" class="er-form__success" hidden>
              <span class="er-form__success-icon" aria-hidden="true">&#10003;</span>
              <strong>Feedback received!</strong> Thank you &mdash; someone from our team will be in touch shortly.
            </div>

            <form id="er-feedback-form" class="er-feedback-form" novalidate aria-label="Improvement feedback form">
              <div class="er-feedback-form__row">
                <div class="er-form__group">
                  <label class="er-form__label" for="fb-name">
                    Your Name <span class="er-form__required" aria-hidden="true">*</span>
                  </label>
                  <input type="text" id="fb-name" name="fb_name" class="er-form__input" placeholder="Your Name" required />
                </div>
                <div class="er-form__group">
                  <label class="er-form__label" for="fb-email">
                    Email Address <span class="er-form__required" aria-hidden="true">*</span>
                  </label>
                  <input type="email" id="fb-email" name="fb_email" class="er-form__input" placeholder="you@example.com" required />
                </div>
              </div>
              <div class="er-form__group">
                <label class="er-form__label" for="fb-message">
                  Your Feedback <span class="er-form__required" aria-hidden="true">*</span>
                </label>
                <textarea id="fb-message" name="fb_message" class="er-form__input er-form__textarea" placeholder="Tell us what we could do better&hellip;" rows="4" required></textarea>
              </div>
              <div class="er-feedback-form__footer">
                <button type="submit" class="er-form__submit">
                  Send Feedback <span aria-hidden="true">&rarr;</span>
                </button>
              </div>
            </form>
          </div>

        </div><!-- /.er-layout__main -->

        <!-- ── Right column: Aside (≈40%) ───────────────────────── -->
        <aside class="er-layout__aside">
          <div class="er-aside__card">
            <h2 class="er-aside__heading">Your Voice Shapes Every Session We Run</h2>
            <p>
              At Digital Stride, every educational program is built around one goal: helping you grow. Whether you walked away with one idea or a dozen, your honest feedback tells us what&rsquo;s landing and what we can push further. It shapes the next session, the next curriculum, and the next person who sits where you sat.
            </p>
            <p>
              We genuinely read every response &mdash; this isn&rsquo;t a checkbox exercise. Thank you for taking the time.
            </p>

            <div class="er-aside__stats">
              <div class="er-aside__stat">
                <span class="er-aside__stat-num">500+</span>
                <span class="er-aside__stat-label">Learners Trained</span>
              </div>
              <div class="er-aside__stat">
                <span class="er-aside__stat-num">4.9&#9733;</span>
                <span class="er-aside__stat-label">Average Rating</span>
              </div>
              <div class="er-aside__stat">
                <span class="er-aside__stat-num">30+</span>
                <span class="er-aside__stat-label">Programs Offered</span>
              </div>
            </div>
          </div>

          <!-- Progress indicator (updated by JS) -->
          <div class="er-progress" id="er-progress" aria-label="Your progress">
            <div class="er-progress__step er-progress__step--active" id="prog-step-1">
              <span class="er-progress__dot" aria-hidden="true"></span>
              <span class="er-progress__label">Your Experience</span>
            </div>
            <div class="er-progress__connector" aria-hidden="true"></div>
            <div class="er-progress__step" id="prog-step-2">
              <span class="er-progress__dot" aria-hidden="true"></span>
              <span class="er-progress__label">Your Score</span>
            </div>
            <div class="er-progress__connector" aria-hidden="true"></div>
            <div class="er-progress__step" id="prog-step-3">
              <span class="er-progress__dot" aria-hidden="true"></span>
              <span class="er-progress__label">Share &amp; Finish</span>
            </div>
          </div>
        </aside>

      </div><!-- /.er-layout -->
    </div>
  </section>

</main>

<script>
(function () {
  'use strict';

  /* ── DOM refs ─────────────────────────────────────────────── */
  var stepExperience = document.getElementById('step-experience');
  var stepNps        = document.getElementById('step-nps');
  var responseLow    = document.getElementById('response-low');
  var responseHigh   = document.getElementById('response-high');

  var expForm        = document.getElementById('er-experience-form');
  var expSubmitBtn   = document.getElementById('exp-submit-btn');

  var npsButtons     = document.querySelectorAll('.er-nps__btn');
  var npsSubmitWrap  = document.getElementById('nps-submit-wrap');
  var npsSubmitBtn   = document.getElementById('nps-submit-btn');
  var npsSelectedMsg = document.getElementById('nps-selected-msg');

  var progStep1      = document.getElementById('prog-step-1');
  var progStep2      = document.getElementById('prog-step-2');
  var progStep3      = document.getElementById('prog-step-3');

  var feedbackForm    = document.getElementById('er-feedback-form');
  var feedbackSuccess = document.getElementById('er-feedback-success');

  var selectedScore  = null;

  /* ── Helpers ──────────────────────────────────────────────── */
  function setProgress(step) {
    [progStep1, progStep2, progStep3].forEach(function (el) {
      el.classList.remove('er-progress__step--active', 'er-progress__step--done');
    });
    if (step === 1) {
      progStep1.classList.add('er-progress__step--active');
    } else if (step === 2) {
      progStep1.classList.add('er-progress__step--done');
      progStep2.classList.add('er-progress__step--active');
    } else if (step === 3) {
      progStep1.classList.add('er-progress__step--done');
      progStep2.classList.add('er-progress__step--done');
      progStep3.classList.add('er-progress__step--active');
    }
  }

  function scrollTo(el) {
    setTimeout(function () {
      el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
  }

  /* ── Step 1: Experience form submission ───────────────────── */
  if (expForm) {
    expForm.addEventListener('submit', function (e) {
      e.preventDefault();

      /* Validate radio for overall_rating explicitly (browsers don't always report fieldset) */
      var ratingChecked = expForm.querySelector('input[name="overall_rating"]:checked');
      if (!ratingChecked) {
        var firstRatingInput = expForm.querySelector('input[name="overall_rating"]');
        if (firstRatingInput) {
          firstRatingInput.setCustomValidity('Please select a rating.');
          firstRatingInput.reportValidity();
          firstRatingInput.setCustomValidity('');
        }
        return;
      }

      if (!expForm.checkValidity()) {
        expForm.reportValidity();
        return;
      }

      /* Animate the step card out, then show NPS step */
      var card = stepExperience.querySelector('.er-step__card');
      if (card) { card.style.opacity = '0'; card.style.transform = 'translateY(-12px)'; }

      setTimeout(function () {
        stepExperience.hidden = true;
        stepNps.hidden = false;
        setProgress(2);
        scrollTo(stepNps);
      }, 300);
    });
  }

  /* ── Step 2: NPS score selection ─────────────────────────── */
  npsButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      selectedScore = parseInt(btn.getAttribute('data-score'), 10);
      npsButtons.forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      npsSelectedMsg.textContent = 'You selected ' + selectedScore + ' out of 10.';
      npsSubmitWrap.hidden = false;
    });
  });

  if (npsSubmitBtn) {
    npsSubmitBtn.addEventListener('click', function () {
      if (selectedScore === null) { return; }

      npsButtons.forEach(function (b) { b.disabled = true; });
      npsSubmitBtn.disabled = true;

      stepNps.hidden = true;
      setProgress(3);

      if (selectedScore >= 8) {
        responseHigh.hidden = false;
        scrollTo(responseHigh);
      } else {
        responseLow.hidden = false;
        scrollTo(responseLow);
      }
    });
  }

  /* ── Step 3b: Improvement feedback form ──────────────────── */
  if (feedbackForm) {
    feedbackForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!feedbackForm.checkValidity()) { feedbackForm.reportValidity(); return; }

      var submitBtn = feedbackForm.querySelector('.er-form__submit');
      submitBtn.disabled    = true;
      submitBtn.textContent = 'Sending…';

      var data = new FormData(feedbackForm);
      data.append('action', 'er_feedback_submit');
      data.append('nonce',  erData.feedbackNonce);

      fetch(erData.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: data })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json.success) {
            feedbackSuccess.hidden = false;
            feedbackForm.hidden    = true;
            feedbackSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          } else {
            alert(json.data || 'Something went wrong. Please try again.');
            submitBtn.disabled    = false;
            submitBtn.textContent = 'Send Feedback →';
          }
        })
        .catch(function () {
          alert('Network error. Please check your connection and try again.');
          submitBtn.disabled    = false;
          submitBtn.textContent = 'Send Feedback →';
        });
    });
  }

  /* ── Rating card visual feedback ─────────────────────────── */
  document.querySelectorAll('.er-rating-option input[type="radio"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
      document.querySelectorAll('.er-rating-option').forEach(function (opt) {
        opt.classList.remove('is-selected');
      });
      radio.closest('.er-rating-option').classList.add('is-selected');
    });
  });

})();
</script>

<?php get_footer(); ?>
