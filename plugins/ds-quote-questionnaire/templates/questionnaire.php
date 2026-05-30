<?php
/**
 * Quote questionnaire HTML template.
 * Rendered by the [ds_quote_questionnaire] shortcode.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cfg = $GLOBALS['ds_qb_config'];
?>
<main class="qb-page" id="qb-page">

  <!-- ══ HERO ══════════════════════════════════════════════════════════ -->
  <section class="qb-hero">
    <div class="qb-hero__inner">
      <p class="qb-hero__eyebrow"><?php echo $cfg['hero']['eyebrow']; ?></p>
      <h1 class="qb-hero__title"><?php echo esc_html( $cfg['hero']['title'] ); ?></h1>
      <p class="qb-hero__sub"><?php echo esc_html( $cfg['hero']['subtitle'] ); ?></p>
    </div>
  </section>

  <!-- ══ QUESTIONNAIRE ════════════════════════════════════════════════ -->
  <section class="qb-section">
    <div class="qb-container">

      <!-- Progress bar -->
      <div class="qb-progress" role="progressbar" aria-label="Questionnaire progress" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100">
        <div class="qb-progress__track">
          <div class="qb-progress__bar" id="qb-progress-bar" style="width:11%"></div>
        </div>
        <span class="qb-progress__label" id="qb-progress-label">Step 1 of 9</span>
      </div>

      <!-- Live estimate badge -->
      <div class="qb-estimate-badge" id="qb-estimate-badge" hidden aria-live="polite">
        <span class="qb-estimate-badge__label">Current Estimate</span>
        <span class="qb-estimate-badge__range" id="qb-estimate-range">&hellip;</span>
      </div>

      <!-- ── STEP 1: Business Type ──────────────────────────────────── -->
      <div class="qb-step is-active" id="qb-step-1" data-step="1">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step1']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step1']['sub'] ); ?></p>

        <div class="qb-options qb-options--grid">
          <?php foreach ( $cfg['step1']['options'] as $opt ) : ?>
          <button type="button" class="qb-option" data-field="businessType" data-value="<?php echo esc_attr( $opt['value'] ); ?>">
            <span class="qb-option__icon" aria-hidden="true"><?php echo $opt['icon']; ?></span>
            <span class="qb-option__label"><?php echo esc_html( $opt['label'] ); ?></span>
            <span class="qb-option__hint"><?php echo esc_html( $opt['hint'] ); ?></span>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="qb-nav qb-nav--end">
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-1" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 2: Primary Goal (skipped for eCommerce) ──────────── -->
      <div class="qb-step" id="qb-step-2" data-step="2">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step2']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step2']['sub'] ); ?></p>

        <div class="qb-options qb-options--list">
          <?php foreach ( $cfg['step2']['options'] as $opt ) : ?>
          <button type="button" class="qb-option qb-option--wide" data-field="primaryGoal" data-value="<?php echo esc_attr( $opt['value'] ); ?>">
            <span class="qb-option__icon" aria-hidden="true"><?php echo $opt['icon']; ?></span>
            <?php if ( ! empty( $opt['hint'] ) ) : ?>
            <div class="qb-option__text">
              <span class="qb-option__label"><?php echo $opt['label']; ?></span>
              <span class="qb-option__hint"><?php echo $opt['hint']; ?></span>
            </div>
            <?php else : ?>
            <span class="qb-option__label"><?php echo $opt['label']; ?></span>
            <?php endif; ?>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="2">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-2" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 2b: Product Count (eCommerce only) ───────────────── -->
      <div class="qb-step" id="qb-step-2b" data-step="2">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step2b']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step2b']['sub'] ); ?></p>

        <div class="qb-product-count-wrap">
          <div class="qb-product-count__field">
            <label class="qb-product-count__label" for="qb-product-count">Number of Products / SKUs</label>
            <input
              type="number"
              id="qb-product-count"
              class="qb-product-count__input"
              placeholder="e.g. 50"
              min="1"
              step="1"
              aria-describedby="qb-product-count-hint"
            />
            <p id="qb-product-count-hint" class="qb-product-count__hint">
              <?php echo $cfg['step2b']['hint']; ?>
            </p>
          </div>

          <div class="qb-product-count__tiers">
            <p class="qb-product-count__tier-heading">Common ranges:</p>
            <div class="qb-product-count__tier-list">
              <?php foreach ( $cfg['step2b']['presets'] as $preset ) : ?>
              <button type="button" class="qb-count-preset" data-value="<?php echo esc_attr( $preset['value'] ); ?>"><?php echo esc_html( $preset['label'] ); ?></button>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="2b">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-2b" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 3: Website Size ───────────────────────────────────── -->
      <div class="qb-step" id="qb-step-3" data-step="3">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step3']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step3']['sub'] ); ?></p>

        <div class="qb-options qb-options--list">
          <?php foreach ( $cfg['step3']['options'] as $opt ) : ?>
          <button type="button" class="qb-option qb-option--sized" data-field="websiteSize" data-value="<?php echo esc_attr( $opt['value'] ); ?>">
            <span class="qb-option__icon" aria-hidden="true"><?php echo $opt['icon']; ?></span>
            <div class="qb-option__text">
              <span class="qb-option__label"><?php echo esc_html( $opt['label'] ); ?></span>
              <span class="qb-option__hint"><?php echo $opt['hint']; ?></span>
            </div>
            <span class="qb-option__tier-badge qb-option__tier-badge--<?php echo esc_attr( $opt['badge_style'] ); ?>"><?php echo esc_html( $opt['badge'] ); ?></span>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="3">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-3" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 4: Service Coverage ──────────────────────────────── -->
      <div class="qb-step" id="qb-step-4" data-step="4">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step4']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step4']['sub'] ); ?></p>

        <div class="qb-options qb-options--list">
          <?php foreach ( $cfg['step4']['options'] as $opt ) : ?>
          <button type="button" class="qb-option qb-option--wide" data-field="coverage" data-value="<?php echo esc_attr( $opt['value'] ); ?>">
            <span class="qb-option__icon" aria-hidden="true"><?php echo $opt['icon']; ?></span>
            <span class="qb-option__label"><?php echo esc_html( $opt['label'] ); ?></span>
            <span class="qb-option__hint"><?php echo esc_html( $opt['hint'] ); ?></span>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="4">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-4" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 5: Content Needs ──────────────────────────────────── -->
      <div class="qb-step" id="qb-step-5" data-step="5">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step5']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step5']['sub'] ); ?></p>

        <div class="qb-options qb-options--list">
          <?php foreach ( $cfg['step5']['options'] as $opt ) : ?>
          <button type="button" class="qb-option qb-option--wide" data-field="contentNeeds" data-value="<?php echo esc_attr( $opt['value'] ); ?>">
            <span class="qb-option__icon" aria-hidden="true"><?php echo $opt['icon']; ?></span>
            <div class="qb-option__text">
              <span class="qb-option__label"><?php echo esc_html( $opt['label'] ); ?></span>
              <span class="qb-option__hint"><?php echo $opt['hint']; ?></span>
            </div>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="5">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-5" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 6: Integrations ───────────────────────────────────── -->
      <div class="qb-step" id="qb-step-6" data-step="6">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step6']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step6']['sub'] ); ?></p>

        <div class="qb-options qb-options--checklist" id="qb-integrations-list">
          <?php foreach ( $cfg['step6']['integrations'] as $item ) : ?>
          <label class="qb-check">
            <input type="checkbox" name="integrations" value="<?php echo esc_attr( $item['value'] ); ?>" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true"><?php echo $item['icon']; ?></span>
            <div class="qb-check__text">
              <span class="qb-check__label"><?php echo esc_html( $item['label'] ); ?></span>
              <span class="qb-check__hint"><?php echo $item['hint']; ?></span>
            </div>
          </label>
          <?php endforeach; ?>
          <label class="qb-check qb-check--none">
            <input type="checkbox" name="integrations" value="none" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">🚫</span>
            <div class="qb-check__text">
              <span class="qb-check__label">None / not sure yet</span>
            </div>
          </label>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="6">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-6">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 7: Add-ons ────────────────────────────────────────── -->
      <div class="qb-step" id="qb-step-7" data-step="7">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step7']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step7']['sub'] ); ?></p>

        <div class="qb-options qb-options--checklist" id="qb-addons-list">
          <?php foreach ( $cfg['step7']['addons'] as $item ) : ?>
          <label class="qb-check">
            <input type="checkbox" name="addons" value="<?php echo esc_attr( $item['value'] ); ?>" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true"><?php echo $item['icon']; ?></span>
            <div class="qb-check__text">
              <span class="qb-check__label"><?php echo esc_html( $item['label'] ); ?></span>
              <span class="qb-check__hint"><?php echo $item['hint']; ?></span>
            </div>
          </label>
          <?php endforeach; ?>
          <label class="qb-check qb-check--none">
            <input type="checkbox" name="addons" value="none" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">🚫</span>
            <div class="qb-check__text">
              <span class="qb-check__label">No additional services needed</span>
            </div>
          </label>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="7">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-7">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 8: Platform Preference ───────────────────────────── -->
      <div class="qb-step" id="qb-step-8" data-step="8">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step8']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step8']['sub'] ); ?></p>

        <div class="qb-options qb-options--platform">
          <button type="button" class="qb-option qb-option--platform" data-field="platform" data-value="elementor">
            <span class="qb-option__platform-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="#92003B"/><rect x="8" y="8" width="6" height="16" rx="1" fill="white"/><rect x="17" y="8" width="7" height="3" rx="1" fill="white"/><rect x="17" y="14.5" width="7" height="3" rx="1" fill="white"/><rect x="17" y="21" width="7" height="3" rx="1" fill="white"/></svg>
            </span>
            <div class="qb-option__platform-body">
              <span class="qb-option__label">WordPress + Elementor</span>
              <span class="qb-option__hint">Most popular for service businesses. Flexible, easy to update, cost-effective with a visual page builder.</span>
            </div>
            <span class="qb-option__tag">Most Popular</span>
          </button>
          <button type="button" class="qb-option qb-option--platform" data-field="platform" data-value="custom">
            <span class="qb-option__platform-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="#1d4382"/><path d="M7 11l5 5-5 5" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 21h10" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
            </span>
            <div class="qb-option__platform-body">
              <span class="qb-option__label">WordPress Custom Build</span>
              <span class="qb-option__hint">Fully custom-coded theme — no page builder. Premium performance, pixel-perfect design, fastest load times.</span>
            </div>
            <span class="qb-option__tag qb-option__tag--premium">Premium</span>
          </button>
          <button type="button" class="qb-option qb-option--platform" data-field="platform" data-value="shopify">
            <span class="qb-option__platform-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="#96BF48"/><path d="M20 9.5l-1.5-.2c-.1 0-.2-.1-.3-.1-.2-.5-.7-2-1.8-2-.1 0-.1 0-.2 0-.2-.3-.6-.4-.9-.4-2.2 0-3.3 2.7-3.6 4.1l-2.5.8L8 23.5l9.5 1 6.5-1.3L20 9.5zM16 8.2c-.5.2-.9.8-1.1 1.7l-1.8.6c.3-1.1 1.1-3 2.2-3 .3 0 .5.2.7.3V8.2z" fill="white"/></svg>
            </span>
            <div class="qb-option__platform-body">
              <span class="qb-option__label">Shopify</span>
              <span class="qb-option__hint">Purpose-built for eCommerce. Fastest path to a converting store with built-in inventory, payments, and shipping.</span>
            </div>
            <span class="qb-option__tag qb-option__tag--ecom">Best for eCommerce</span>
          </button>
          <button type="button" class="qb-option qb-option--platform" data-field="platform" data-value="unsure">
            <span class="qb-option__platform-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="#64748b"/><path d="M16 8a4 4 0 0 1 4 4c0 2-1 3-2.5 4S16 18 16 19" stroke="white" stroke-width="2" stroke-linecap="round"/><circle cx="16" cy="23" r="1.5" fill="white"/></svg>
            </span>
            <div class="qb-option__platform-body">
              <span class="qb-option__label">Not sure yet</span>
              <span class="qb-option__hint">We'll help you choose during your free discovery call. Your quote shows all three options.</span>
            </div>
          </button>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="8">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-8" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 9: Timeline ───────────────────────────────────────── -->
      <div class="qb-step" id="qb-step-9" data-step="9">
        <h2 class="qb-step__heading"><?php echo esc_html( $cfg['step9']['heading'] ); ?></h2>
        <p class="qb-step__sub"><?php echo esc_html( $cfg['step9']['sub'] ); ?></p>

        <div class="qb-options qb-options--grid">
          <?php foreach ( $cfg['step9']['options'] as $opt ) : ?>
          <button type="button" class="qb-option" data-field="timeline" data-value="<?php echo esc_attr( $opt['value'] ); ?>">
            <span class="qb-option__icon" aria-hidden="true"><?php echo $opt['icon']; ?></span>
            <span class="qb-option__label"><?php echo esc_html( $opt['label'] ); ?></span>
            <span class="qb-option__hint"><?php echo esc_html( $opt['hint'] ); ?></span>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="qb-nav">
          <button type="button" class="qb-btn qb-btn--back" data-prev="9">
            <span aria-hidden="true">&larr;</span> Back
          </button>
          <button type="button" class="qb-btn qb-btn--next qb-btn--cta" id="qb-next-9" disabled aria-disabled="true">
            Almost there! <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 10: Contact Info (before results) ─────────────────── -->
      <div class="qb-step" id="qb-step-10" data-step="10">
        <div class="qb-contact-step">
          <div class="qb-contact-step__split">

            <!-- Left: pitch -->
            <div class="qb-contact-step__left">
              <h2 class="qb-contact-step__heading"><?php echo esc_html( $cfg['step10']['heading'] ); ?></h2>
              <p class="qb-contact-step__body"><?php echo esc_html( $cfg['step10']['body'] ); ?></p>
              <ul class="qb-contact-step__perks">
                <?php foreach ( $cfg['step10']['perks'] as $perk ) : ?>
                <li><span aria-hidden="true">✓</span> <?php echo esc_html( $perk ); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>

            <!-- Right: form -->
            <div class="qb-contact-step__right">
              <form id="qb-contact-form" class="qb-form" novalidate aria-label="Quote request form">
                <div class="qb-form__row">
                  <div class="qb-form__group">
                    <label class="qb-form__label" for="qb-name">Your Name <span class="qb-form__req" aria-hidden="true">*</span></label>
                    <input type="text" id="qb-name" name="name" class="qb-form__input" placeholder="Jane Smith" autocomplete="name" required />
                  </div>
                  <div class="qb-form__group">
                    <label class="qb-form__label" for="qb-business">Business Name <span class="qb-form__req" aria-hidden="true">*</span></label>
                    <input type="text" id="qb-business" name="business" class="qb-form__input" placeholder="Acme Services LLC" autocomplete="organization" required />
                  </div>
                </div>
                <div class="qb-form__row">
                  <div class="qb-form__group">
                    <label class="qb-form__label" for="qb-email">Email Address <span class="qb-form__req" aria-hidden="true">*</span></label>
                    <input type="email" id="qb-email" name="email" class="qb-form__input" placeholder="you@example.com" autocomplete="email" required />
                  </div>
                  <div class="qb-form__group">
                    <label class="qb-form__label" for="qb-phone">Phone Number</label>
                    <input type="tel" id="qb-phone" name="phone" class="qb-form__input" placeholder="(555) 555-5555" autocomplete="tel" />
                  </div>
                </div>
                <div class="qb-form__group">
                  <label class="qb-form__label" for="qb-notes">Additional notes or questions</label>
                  <textarea id="qb-notes" name="notes" class="qb-form__input qb-form__textarea" rows="3" placeholder="Specific features, integrations, questions, or anything else we should know&hellip;"></textarea>
                </div>
                <button type="submit" class="qb-btn qb-btn--submit" id="qb-submit-btn">
                  <?php echo esc_html( $cfg['step10']['submit_label'] ); ?> <span aria-hidden="true">&rarr;</span>
                </button>
              </form>
            </div>

          </div>
        </div>

        <div class="qb-nav" style="margin-top:20px">
          <button type="button" class="qb-btn qb-btn--back" data-prev="10">
            <span aria-hidden="true">&larr;</span> Back
          </button>
        </div>
      </div>

      <!-- ── STEP 11: Quote Results ──────────────────────────────────── -->
      <div class="qb-step" id="qb-step-11" data-step="11">
        <div class="qb-quote" id="qb-quote-result">

          <!-- Header -->
          <div class="qb-quote__header">
            <div class="qb-quote__tier-badge" id="qb-tier-badge">Professional Tier</div>
            <h2 class="qb-quote__heading">Your Custom Website Estimate</h2>
            <p class="qb-quote__sub" id="qb-quote-sub"></p>

            <div class="qb-quote__header-actions">
              <button type="button" class="qb-btn qb-btn--download" id="qb-pdf-download" hidden>
                <span aria-hidden="true">⬇</span> Download PDF Quote
              </button>
              <p class="qb-quote__sent-note">
                <span aria-hidden="true">📧</span> A copy has been emailed to you.
              </p>
            </div>
          </div>

          <!-- Platform comparison -->
          <div class="qb-quote__block">
            <h3 class="qb-quote__section-title">
              <span class="qb-quote__section-icon" aria-hidden="true">💻</span>
              Investment by Platform
            </h3>
            <div class="qb-platform-cards" id="qb-platform-cards"><!-- JS --></div>
          </div>

          <!-- Scope -->
          <div class="qb-quote__block">
            <h3 class="qb-quote__section-title">
              <span class="qb-quote__section-icon" aria-hidden="true">✅</span>
              What's Included in Your Scope
            </h3>
            <ul class="qb-scope-list" id="qb-scope-list"><!-- JS --></ul>
          </div>

          <!-- Add-ons -->
          <div class="qb-quote__block" id="qb-selected-addons-block">
            <h3 class="qb-quote__section-title">
              <span class="qb-quote__section-icon" aria-hidden="true">➕</span>
              Selected Add-ons
            </h3>
            <div class="qb-addons-grid" id="qb-selected-addons"><!-- JS --></div>
          </div>

          <!-- Payment plans -->
          <div class="qb-quote__block">
            <h3 class="qb-quote__section-title">
              <span class="qb-quote__section-icon" aria-hidden="true">💳</span>
              Flexible Payment Plans
            </h3>
            <div class="qb-payment-selector">
              <span class="qb-payment-selector__label">Viewing payments for:</span>
              <div class="qb-platform-tabs" id="qb-payment-tabs" role="tablist">
                <button type="button" class="qb-tab is-active" data-platform="elementor" role="tab" aria-selected="true">WP Elementor</button>
                <button type="button" class="qb-tab" data-platform="custom" role="tab" aria-selected="false">WP Custom Build</button>
                <button type="button" class="qb-tab" data-platform="shopify" role="tab" aria-selected="false">Shopify</button>
              </div>
            </div>
            <div class="qb-payment-plans" id="qb-payment-plans"><!-- JS --></div>
            <p class="qb-payment-note"></p>
          </div>

          <!-- CTAs -->
          <div class="qb-quote__cta-row">
            <a href="<?php echo esc_url( $cfg['cta']['booking_url'] ); ?>" class="qb-btn qb-btn--primary" target="_blank" rel="noopener"><?php echo esc_html( $cfg['cta']['booking_label'] ); ?></a>
            <button type="button" class="qb-btn qb-btn--ghost" id="qb-restart-btn">
              <span aria-hidden="true">↺</span> Start Over
            </button>
          </div>

        </div>
      </div><!-- /step-11 -->

    </div><!-- /qb-container -->
  </section>

</main>
