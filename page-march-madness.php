<?php
/**
 * Template Name: March Madness Bracket
 *
 * Standalone page template for the Digital Stride March Madness bracket contest.
 * Prizes: Perfect bracket = $10,000 | 1st Place = $1,500 AEO Audit & Assessment
 */

get_header();
?>

<main class="mm-page" id="march-madness">

  <!-- Hero Banner -->
  <section class="mm-hero">
    <div class="mm-hero__inner">
      <div class="mm-hero__badge">2026 March Madness Contest</div>
      <h1 class="mm-hero__title">Fill Out Your Bracket</h1>
      <p class="mm-hero__sub">Pick your winners and compete for incredible prizes!</p>
      <div class="mm-hero__prizes">
        <div class="mm-prize mm-prize--gold">
          <span class="mm-prize__icon">🏆</span>
          <span class="mm-prize__amount">$10,000</span>
          <span class="mm-prize__label">Perfect Bracket</span>
        </div>
        <div class="mm-prize mm-prize--silver">
          <span class="mm-prize__icon">🥇</span>
          <span class="mm-prize__amount">$1,500</span>
          <span class="mm-prize__label">1st Place &mdash; AEO Audit &amp; Assessment</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Bracket Form Container -->
  <section class="mm-form-section">
    <div class="mm-container">
      <div id="mm-bracket-form" class="mm-bracket-form">
        <!-- Injected by march-madness.js -->
        <noscript>
          <p class="mm-noscript">Please enable JavaScript to fill out the bracket form.</p>
        </noscript>
      </div>
    </div>
  </section>

  <!-- Rules / Fine Print -->
  <section class="mm-rules">
    <div class="mm-container">
      <h2 class="mm-rules__title">Contest Rules</h2>
      <ul class="mm-rules__list">
        <li>One entry per person. Duplicate entries will be disqualified.</li>
        <li>Bracket picks must be submitted before the first game tips off.</li>
        <li>The $10,000 prize is awarded only for a perfect bracket (all 63 picks correct).</li>
        <li>The $1,500 AEO Audit &amp; Assessment is awarded to the participant with the most correct picks. Tiebreaker: closest championship game score prediction (coming soon).</li>
        <li>Prizes are non-transferable and have no cash equivalent unless stated.</li>
        <li>Digital Stride reserves the right to modify or cancel the contest at any time.</li>
        <li>By entering, you agree to receive occasional emails from Digital Stride. You may unsubscribe at any time.</li>
        <li>Teams shown are projected and subject to change after Selection Sunday (March 16, 2026).</li>
      </ul>
    </div>
  </section>

</main>

<?php get_footer(); ?>
