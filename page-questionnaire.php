<?php
/**
 * Template Name: Website Quote Questionnaire
 *
 * Interactive multi-step questionnaire with live pricing, PDF export,
 * and email delivery.
 *
 * @package DigitalStride
 */

get_header();
?>

<main class="qb-page" id="qb-page">

  <!-- ══ HERO ══════════════════════════════════════════════════════════ -->
  <section class="qb-hero">
    <div class="qb-hero__inner">
      <p class="qb-hero__eyebrow">Free &amp; no-obligation</p>
      <h1 class="qb-hero__title">Get Your Custom Website Quote</h1>
      <p class="qb-hero__sub">Answer 9 quick questions and get a real price range — broken down by platform, with flexible payment plans and a downloadable PDF.</p>
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
        <h2 class="qb-step__heading">What type of business do you run?</h2>
        <p class="qb-step__sub">This shapes our starting point for your website's goals and pricing.</p>

        <div class="qb-options qb-options--grid">
          <button type="button" class="qb-option" data-field="businessType" data-value="trades">
            <span class="qb-option__icon" aria-hidden="true">🔧</span>
            <span class="qb-option__label">Home Services / Trades</span>
            <span class="qb-option__hint">Plumbing, HVAC, electrical, cleaning, landscaping</span>
          </button>
          <button type="button" class="qb-option" data-field="businessType" data-value="contractor">
            <span class="qb-option__icon" aria-hidden="true">🏗️</span>
            <span class="qb-option__label">Specialty Contractor</span>
            <span class="qb-option__hint">Construction, roofing, concrete, remodeling</span>
          </button>
          <button type="button" class="qb-option" data-field="businessType" data-value="industrial">
            <span class="qb-option__icon" aria-hidden="true">🏭</span>
            <span class="qb-option__label">Industrial / Commercial</span>
            <span class="qb-option__hint">B2B services, manufacturing, logistics</span>
          </button>
          <button type="button" class="qb-option" data-field="businessType" data-value="ecommerce">
            <span class="qb-option__icon" aria-hidden="true">🛒</span>
            <span class="qb-option__label">eCommerce / Products</span>
            <span class="qb-option__hint">Online store, physical goods, subscriptions</span>
          </button>
          <button type="button" class="qb-option" data-field="businessType" data-value="trade_school">
            <span class="qb-option__icon" aria-hidden="true">🎓</span>
            <span class="qb-option__label">Trade School / Vocational</span>
            <span class="qb-option__hint">Enrollment-based, courses, certification programs</span>
          </button>
          <button type="button" class="qb-option" data-field="businessType" data-value="other">
            <span class="qb-option__icon" aria-hidden="true">💼</span>
            <span class="qb-option__label">Other Service Business</span>
            <span class="qb-option__hint">Professional services, healthcare, real estate</span>
          </button>
        </div>

        <div class="qb-nav qb-nav--end">
          <button type="button" class="qb-btn qb-btn--next" id="qb-next-1" disabled aria-disabled="true">
            Next <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      </div>

      <!-- ── STEP 2: Primary Goal (skipped for eCommerce) ──────────── -->
      <div class="qb-step" id="qb-step-2" data-step="2">
        <h2 class="qb-step__heading">What's the #1 job your new website needs to do?</h2>
        <p class="qb-step__sub">Focus on the single most important outcome for your business.</p>

        <div class="qb-options qb-options--list">
          <button type="button" class="qb-option qb-option--wide" data-field="primaryGoal" data-value="calls_leads">
            <span class="qb-option__icon" aria-hidden="true">📞</span>
            <span class="qb-option__label">Generate phone calls &amp; inbound leads</span>
          </button>
          <button type="button" class="qb-option qb-option--wide" data-field="primaryGoal" data-value="estimates">
            <span class="qb-option__icon" aria-hidden="true">📋</span>
            <span class="qb-option__label">Capture estimate requests &amp; form submissions</span>
          </button>
          <button type="button" class="qb-option qb-option--wide" data-field="primaryGoal" data-value="sell_products">
            <span class="qb-option__icon" aria-hidden="true">🛍️</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Sell products or services directly online</span>
              <span class="qb-option__hint">Starts at <strong>$5,000–$18,000</strong></span>
            </div>
          </button>
          <button type="button" class="qb-option qb-option--wide" data-field="primaryGoal" data-value="enroll_students">
            <span class="qb-option__icon" aria-hidden="true">🎓</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Enroll students or course participants</span>
              <span class="qb-option__hint">Starts at <strong>$12,000–$28,000</strong></span>
            </div>
          </button>
          <button type="button" class="qb-option qb-option--wide" data-field="primaryGoal" data-value="credibility">
            <span class="qb-option__icon" aria-hidden="true">⭐</span>
            <span class="qb-option__label">Build brand credibility &amp; online presence</span>
          </button>
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
        <h2 class="qb-step__heading">Approximately how many products will you sell?</h2>
        <p class="qb-step__sub">This helps us estimate catalog setup, variant management, and product photography scope.</p>

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
              Each product adds approximately <strong>$50–$100</strong> to your estimate for setup, photography coordination, and content.
            </p>
          </div>

          <div class="qb-product-count__tiers">
            <p class="qb-product-count__tier-heading">Common ranges:</p>
            <div class="qb-product-count__tier-list">
              <button type="button" class="qb-count-preset" data-value="10">1–10 products</button>
              <button type="button" class="qb-count-preset" data-value="25">10–50 products</button>
              <button type="button" class="qb-count-preset" data-value="100">50–200 products</button>
              <button type="button" class="qb-count-preset" data-value="300">200+ products</button>
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
        <h2 class="qb-step__heading">How large is your website project?</h2>
        <p class="qb-step__sub">Estimate the number of pages and complexity. We'll scope it together.</p>

        <div class="qb-options qb-options--list">
          <button type="button" class="qb-option qb-option--sized" data-field="websiteSize" data-value="small">
            <span class="qb-option__icon" aria-hidden="true">📄</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Small — 1 to 5 pages</span>
              <span class="qb-option__hint">Home, About, Services, Contact &amp; one more</span>
            </div>
            <span class="qb-option__tier-badge qb-option__tier-badge--starter">No add-on</span>
          </button>
          <button type="button" class="qb-option qb-option--sized" data-field="websiteSize" data-value="medium">
            <span class="qb-option__icon" aria-hidden="true">📑</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Medium — 6 to 15 pages</span>
              <span class="qb-option__hint">Multiple service pages, blog, location pages</span>
            </div>
            <span class="qb-option__tier-badge qb-option__tier-badge--professional">+$1,000–$2,500</span>
          </button>
          <button type="button" class="qb-option qb-option--sized" data-field="websiteSize" data-value="large">
            <span class="qb-option__icon" aria-hidden="true">📚</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Large — 15 to 30 pages</span>
              <span class="qb-option__hint">eCommerce catalog, multi-location, rich content</span>
            </div>
            <span class="qb-option__tier-badge qb-option__tier-badge--ecommerce">+$2,000–$5,000</span>
          </button>
          <button type="button" class="qb-option qb-option--sized" data-field="websiteSize" data-value="complex">
            <span class="qb-option__icon" aria-hidden="true">🏢</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Complex — 30+ pages or custom functionality</span>
              <span class="qb-option__hint">LMS, enrollment systems, custom features, multi-site</span>
            </div>
            <span class="qb-option__tier-badge qb-option__tier-badge--enterprise">+$5,000–$10,000</span>
          </button>
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
        <h2 class="qb-step__heading">What area do you serve?</h2>
        <p class="qb-step__sub">This affects local SEO architecture and location page strategy.</p>

        <div class="qb-options qb-options--grid-2x2">
          <button type="button" class="qb-option" data-field="coverage" data-value="single">
            <span class="qb-option__icon" aria-hidden="true">📍</span>
            <span class="qb-option__label">Single location</span>
            <span class="qb-option__hint">One city or town</span>
          </button>
          <button type="button" class="qb-option" data-field="coverage" data-value="multi_location">
            <span class="qb-option__icon" aria-hidden="true">🗺️</span>
            <span class="qb-option__label">Multi-location</span>
            <span class="qb-option__hint">Multiple cities, regions, or storefronts</span>
          </button>
          <button type="button" class="qb-option" data-field="coverage" data-value="mobile">
            <span class="qb-option__icon" aria-hidden="true">🚐</span>
            <span class="qb-option__label">Mobile / dispatched</span>
            <span class="qb-option__hint">Service area-based, no fixed location</span>
          </button>
          <button type="button" class="qb-option" data-field="coverage" data-value="national">
            <span class="qb-option__icon" aria-hidden="true">🌐</span>
            <span class="qb-option__label">National / Online only</span>
            <span class="qb-option__hint">No geographic restrictions</span>
          </button>
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
        <h2 class="qb-step__heading">Who will handle content and copy?</h2>
        <p class="qb-step__sub">Great copy is the single biggest difference between a website that sits there and one that converts.</p>

        <div class="qb-options qb-options--list">
          <button type="button" class="qb-option qb-option--wide" data-field="contentNeeds" data-value="client_provides">
            <span class="qb-option__icon" aria-hidden="true">✍️</span>
            <div class="qb-option__text">
              <span class="qb-option__label">I'll provide all content</span>
              <span class="qb-option__hint">You supply all text, photos, and video</span>
            </div>
          </button>
          <button type="button" class="qb-option qb-option--wide" data-field="contentNeeds" data-value="copy_ds">
            <span class="qb-option__icon" aria-hidden="true">📝</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Digital Stride writes the copy</span>
              <span class="qb-option__hint">Professional copywriting optimised for conversions&nbsp; <strong>+$1,200–$3,500</strong></span>
            </div>
          </button>
          <button type="button" class="qb-option qb-option--wide" data-field="contentNeeds" data-value="copy_photo">
            <span class="qb-option__icon" aria-hidden="true">📸</span>
            <div class="qb-option__text">
              <span class="qb-option__label">Copy + professional photography / video</span>
              <span class="qb-option__hint">Full written and visual content production&nbsp; <strong>+$2,000–$6,500</strong></span>
            </div>
          </button>
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
        <h2 class="qb-step__heading">What integrations does your website need?</h2>
        <p class="qb-step__sub">Select all that apply — these connect your website to the tools you already use.</p>

        <div class="qb-options qb-options--checklist" id="qb-integrations-list">
          <label class="qb-check">
            <input type="checkbox" name="integrations" value="booking" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">📅</span>
            <div class="qb-check__text">
              <span class="qb-check__label">Online booking / appointment scheduler</span>
              <span class="qb-check__hint">Calendly, Acuity, or a custom booking widget&nbsp; <strong>+$150–$500</strong></span>
            </div>
          </label>
          <label class="qb-check">
            <input type="checkbox" name="integrations" value="crm" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">⚙️</span>
            <div class="qb-check__text">
              <span class="qb-check__label">CRM / dispatch software (Jobber, ServiceTitan)</span>
              <span class="qb-check__hint">Connect leads directly to your field management system&nbsp; <strong>+$1,500–$4,000</strong></span>
            </div>
          </label>
          <label class="qb-check">
            <input type="checkbox" name="integrations" value="lms" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">🎓</span>
            <div class="qb-check__text">
              <span class="qb-check__label">LMS / enrollment system</span>
              <span class="qb-check__hint">Course management, student portals, financial aid pages</span>
            </div>
          </label>
          <label class="qb-check">
            <input type="checkbox" name="integrations" value="email_mktg" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">📧</span>
            <div class="qb-check__text">
              <span class="qb-check__label">Email marketing integration</span>
              <span class="qb-check__hint">Mailchimp, Klaviyo, ActiveCampaign, etc.&nbsp; <strong>+$150–$500</strong></span>
            </div>
          </label>
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
        <h2 class="qb-step__heading">Any additional services?</h2>
        <p class="qb-step__sub">Optional add-ons that enhance reach, accessibility, and visibility.</p>

        <div class="qb-options qb-options--checklist" id="qb-addons-list">
          <label class="qb-check">
            <input type="checkbox" name="addons" value="local_seo" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">📍</span>
            <div class="qb-check__text">
              <span class="qb-check__label">Local SEO setup (GMB, schema, citations)</span>
              <span class="qb-check__hint">Price scales with site size: <strong>$300–$4,500</strong> depending on scope</span>
            </div>
          </label>
          <label class="qb-check">
            <input type="checkbox" name="addons" value="ada" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">♿</span>
            <div class="qb-check__text">
              <span class="qb-check__label">ADA / WCAG accessibility compliance</span>
              <span class="qb-check__hint">Full audit and remediation to meet standards&nbsp; <strong>+$300–$800</strong></span>
            </div>
          </label>
          <label class="qb-check">
            <input type="checkbox" name="addons" value="multilang" class="qb-check__input" />
            <span class="qb-check__box" aria-hidden="true"></span>
            <span class="qb-check__icon" aria-hidden="true">🌐</span>
            <div class="qb-check__text">
              <span class="qb-check__label">Multi-language support</span>
              <span class="qb-check__hint">Reach additional language markets&nbsp; <strong>+$500–$1,500</strong></span>
            </div>
          </label>
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
        <h2 class="qb-step__heading">Do you have a platform preference?</h2>
        <p class="qb-step__sub">Each platform has different strengths. Your quote will show all three options side by side.</p>

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
        <h2 class="qb-step__heading">What's your timeline?</h2>
        <p class="qb-step__sub">Is there a hard deadline driving this project?</p>

        <div class="qb-options qb-options--grid">
          <button type="button" class="qb-option" data-field="timeline" data-value="flexible">
            <span class="qb-option__icon" aria-hidden="true">🗓️</span>
            <span class="qb-option__label">Flexible</span>
            <span class="qb-option__hint">3–5 months, standard pacing</span>
          </button>
          <button type="button" class="qb-option" data-field="timeline" data-value="normal">
            <span class="qb-option__icon" aria-hidden="true">📅</span>
            <span class="qb-option__label">Soon</span>
            <span class="qb-option__hint">2–3 months, moderate urgency</span>
          </button>
          <button type="button" class="qb-option" data-field="timeline" data-value="rush">
            <span class="qb-option__icon" aria-hidden="true">⚡</span>
            <span class="qb-option__label">Rush</span>
            <span class="qb-option__hint">Under 6 weeks</span>
          </button>
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
              <h2 class="qb-contact-step__heading">Ready to lock in your price?</h2>
              <p class="qb-contact-step__body">This estimate is your starting point. Share your details below and we'll follow up with a detailed proposal — or book a free discovery call to talk through your project.</p>
              <ul class="qb-contact-step__perks">
                <li><span aria-hidden="true">✓</span> No sales pressure, no commitment</li>
                <li><span aria-hidden="true">✓</span> Full scope and pricing in writing</li>
                <li><span aria-hidden="true">✓</span> Response within 1 business day</li>
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
                    <label class="qb-form__label" for="qb-business">Business Name</label>
                    <input type="text" id="qb-business" name="business" class="qb-form__input" placeholder="Acme Services LLC" autocomplete="organization" />
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
                  Get My Full Proposal <span aria-hidden="true">&rarr;</span>
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
                <span aria-hidden="true">📧</span> A copy has been emailed to you and our team.
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
            <a href="/contact" class="qb-btn qb-btn--primary">Book a Discovery Call</a>
            <button type="button" class="qb-btn qb-btn--ghost" id="qb-restart-btn">
              <span aria-hidden="true">↺</span> Start Over
            </button>
          </div>

        </div>
      </div><!-- /step-11 -->

    </div><!-- /qb-container -->
  </section>

</main>

<?php get_footer(); ?>
