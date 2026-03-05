/**
 * Digital Stride — March Madness Bracket Form
 *
 * Multi-step bracket entry form.
 * Prizes: Perfect bracket = $10,000 | 1st Place = $1,500 AEO Audit & Assessment
 *
 * UPDATING TEAMS: Edit the TEAMS object below after Selection Sunday (March 16, 2026).
 * Seeds run 1–16 per region. Matchup pairings: 1v16, 8v9, 5v12, 4v13, 6v11, 3v14, 7v10, 2v15.
 */

(function () {
  'use strict';

  /* ============================================================
     1. BRACKET DATA — UPDATE AFTER SELECTION SUNDAY 2026
     ============================================================ */

  var TEAMS = {
    South: {
      1: 'Duke',            16: 'High Point',
      8: 'Miss. State',      9: 'Vanderbilt',
      5: 'Gonzaga',         12: 'Drake',
      4: 'Michigan State',  13: 'Furman',
      6: 'Baylor',          11: 'NC State',
      3: 'Kentucky',        14: 'Colgate',
      7: 'Creighton',       10: 'New Mexico',
      2: 'Alabama',         15: 'Montana State'
    },
    East: {
      1: 'Auburn',          16: 'Sacred Heart',
      8: 'Dayton',           9: "St. Mary's",
      5: 'Illinois',        12: 'UC San Diego',
      4: 'Texas A&M',       13: 'Vermont',
      6: 'Marquette',       11: 'Nebraska',
      3: 'Wisconsin',       14: 'Wofford',
      7: 'UCLA',            10: 'Colorado State',
      2: 'Tennessee',       15: 'Longwood'
    },
    West: {
      1: 'Kansas',          16: 'Norfolk State',
      8: 'Xavier',           9: 'Oklahoma',
      5: 'Connecticut',     12: 'San Diego State',
      4: 'Missouri',        13: 'Grand Canyon',
      6: 'Indiana',         11: 'Oregon',
      3: 'Houston',         14: 'Morehead State',
      7: 'Rutgers',         10: 'Utah State',
      2: 'Iowa State',      15: 'Robert Morris'
    },
    Midwest: {
      1: 'Florida',         16: 'Texas Southern',
      8: 'Ohio State',       9: 'West Virginia',
      5: 'Arizona',         12: 'Liberty',
      4: 'Purdue',          13: 'Samford',
      6: 'Virginia',        11: 'Pittsburgh',
      3: 'Michigan',        14: 'Chattanooga',
      7: 'Louisville',      10: 'Arkansas',
      2: "St. John's",      15: 'Bethune-Cookman'
    }
  };

  /* Standard R1 pairings: [topSeed, bottomSeed] */
  var R1_PAIRS = [
    [1, 16], [8, 9], [5, 12], [4, 13],
    [6, 11], [3, 14], [7, 10], [2, 15]
  ];

  var REGIONS = ['South', 'East', 'West', 'Midwest'];

  /* ============================================================
     2. BUILD GAME DEFINITIONS
     ============================================================
     Each game: { id, teamA, teamB, seedA, seedB, depA, depB, round, region, label }
       teamA/B  → team name (R1 only; later rounds use dep IDs)
       depA/B   → game IDs whose winner feeds into teamA/B slot
  */

  var GAMES = {}; // keyed by game ID

  // Round 1 — build from TEAMS
  REGIONS.forEach(function (region) {
    R1_PAIRS.forEach(function (pair, idx) {
      var gameNum = idx + 1;
      var id = 'r1_' + region.toLowerCase() + '_g' + gameNum;
      GAMES[id] = {
        id: id,
        round: 1,
        region: region,
        seedA: pair[0],
        seedB: pair[1],
        teamA: TEAMS[region][pair[0]],
        teamB: TEAMS[region][pair[1]],
        label: 'Game ' + gameNum
      };
    });
  });

  // Helper to build later-round games
  function makeGame(id, round, region, depA, depB, gameNum) {
    GAMES[id] = {
      id: id,
      round: round,
      region: region,
      depA: depA,
      depB: depB,
      label: 'Game ' + gameNum
    };
  }

  // Round 2 (Round of 32) — 4 games per region
  // Winners of R1 games 1+2, 3+4, 5+6, 7+8
  REGIONS.forEach(function (region) {
    var r = region.toLowerCase();
    makeGame('r2_' + r + '_g1', 2, region, 'r1_' + r + '_g1', 'r1_' + r + '_g2', 1);
    makeGame('r2_' + r + '_g2', 2, region, 'r1_' + r + '_g3', 'r1_' + r + '_g4', 2);
    makeGame('r2_' + r + '_g3', 2, region, 'r1_' + r + '_g5', 'r1_' + r + '_g6', 3);
    makeGame('r2_' + r + '_g4', 2, region, 'r1_' + r + '_g7', 'r1_' + r + '_g8', 4);
  });

  // Round 3 (Sweet 16) — 2 games per region
  REGIONS.forEach(function (region) {
    var r = region.toLowerCase();
    makeGame('r3_' + r + '_g1', 3, region, 'r2_' + r + '_g1', 'r2_' + r + '_g2', 1);
    makeGame('r3_' + r + '_g2', 3, region, 'r2_' + r + '_g3', 'r2_' + r + '_g4', 2);
  });

  // Round 4 (Elite Eight) — 1 game per region
  REGIONS.forEach(function (region) {
    var r = region.toLowerCase();
    makeGame('r4_' + r + '_g1', 4, region, 'r3_' + r + '_g1', 'r3_' + r + '_g2', 1);
  });

  // Final Four — South vs East, West vs Midwest
  makeGame('ff_g1', 5, 'Final Four', 'r4_south_g1', 'r4_east_g1', 1);
  makeGame('ff_g2', 5, 'Final Four', 'r4_west_g1',  'r4_midwest_g1', 2);

  // Championship
  makeGame('champ_g1', 6, 'Championship', 'ff_g1', 'ff_g2', 1);

  /* ============================================================
     3. STEP DEFINITIONS
     ============================================================
     type: 'info' | 'games' | 'review'
  */

  var STEPS = [
    // Step 0: Personal info
    { type: 'info', title: "Let's Get Started", roundLabel: 'Your Information' },

    // Steps 1–8: Round 1 (2 steps per region, 4 games each)
    { type: 'games', roundLabel: 'Round 1', title: 'South Region',    desc: 'Games 1–4 of 8',  games: ['r1_south_g1','r1_south_g2','r1_south_g3','r1_south_g4'] },
    { type: 'games', roundLabel: 'Round 1', title: 'South Region',    desc: 'Games 5–8 of 8',  games: ['r1_south_g5','r1_south_g6','r1_south_g7','r1_south_g8'] },
    { type: 'games', roundLabel: 'Round 1', title: 'East Region',     desc: 'Games 1–4 of 8',  games: ['r1_east_g1','r1_east_g2','r1_east_g3','r1_east_g4'] },
    { type: 'games', roundLabel: 'Round 1', title: 'East Region',     desc: 'Games 5–8 of 8',  games: ['r1_east_g5','r1_east_g6','r1_east_g7','r1_east_g8'] },
    { type: 'games', roundLabel: 'Round 1', title: 'West Region',     desc: 'Games 1–4 of 8',  games: ['r1_west_g1','r1_west_g2','r1_west_g3','r1_west_g4'] },
    { type: 'games', roundLabel: 'Round 1', title: 'West Region',     desc: 'Games 5–8 of 8',  games: ['r1_west_g5','r1_west_g6','r1_west_g7','r1_west_g8'] },
    { type: 'games', roundLabel: 'Round 1', title: 'Midwest Region',  desc: 'Games 1–4 of 8',  games: ['r1_midwest_g1','r1_midwest_g2','r1_midwest_g3','r1_midwest_g4'] },
    { type: 'games', roundLabel: 'Round 1', title: 'Midwest Region',  desc: 'Games 5–8 of 8',  games: ['r1_midwest_g5','r1_midwest_g6','r1_midwest_g7','r1_midwest_g8'] },

    // Steps 9–12: Round of 32 (4 games per region)
    { type: 'games', roundLabel: 'Round of 32', title: 'South Region',   desc: '4 matchups',  games: ['r2_south_g1','r2_south_g2','r2_south_g3','r2_south_g4'] },
    { type: 'games', roundLabel: 'Round of 32', title: 'East Region',    desc: '4 matchups',  games: ['r2_east_g1','r2_east_g2','r2_east_g3','r2_east_g4'] },
    { type: 'games', roundLabel: 'Round of 32', title: 'West Region',    desc: '4 matchups',  games: ['r2_west_g1','r2_west_g2','r2_west_g3','r2_west_g4'] },
    { type: 'games', roundLabel: 'Round of 32', title: 'Midwest Region', desc: '4 matchups',  games: ['r2_midwest_g1','r2_midwest_g2','r2_midwest_g3','r2_midwest_g4'] },

    // Steps 13–14: Sweet 16 (mix 2 regions per step for 4 total matchups)
    { type: 'games', roundLabel: 'Sweet 16', title: 'South & East Regions',  desc: '4 matchups', games: ['r3_south_g1','r3_south_g2','r3_east_g1','r3_east_g2'] },
    { type: 'games', roundLabel: 'Sweet 16', title: 'West & Midwest Regions', desc: '4 matchups', games: ['r3_west_g1','r3_west_g2','r3_midwest_g1','r3_midwest_g2'] },

    // Step 15: Elite Eight (4 games)
    { type: 'games', roundLabel: 'Elite Eight', title: 'Who advances to the Final Four?', desc: 'One champion per region', games: ['r4_south_g1','r4_east_g1','r4_west_g1','r4_midwest_g1'] },

    // Step 16: Final Four + Championship (3 games)
    { type: 'games', roundLabel: 'Final Four & Championship', title: 'Pick Your Champion', desc: '3 final matchups', games: ['ff_g1','ff_g2','champ_g1'] },

    // Step 17: Review & Submit
    { type: 'review', roundLabel: 'Almost Done!', title: 'Review Your Bracket' }
  ];

  var TOTAL_STEPS = STEPS.length; // 18 (0–17)
  var BRACKET_STEPS = TOTAL_STEPS - 2; // 16 game-pick steps (excluding info and review)

  /* ============================================================
     4. STATE
     ============================================================ */

  var state = {
    step: 0,
    picks: {},    // gameId → team name
    info: { name: '', email: '', phone: '', favoriteTeam: '' }
  };

  /* ============================================================
     5. HELPERS
     ============================================================ */

  /** Resolve which team name occupies a slot, given the picks so far */
  function resolveTeam(gameId, slot) {
    var game = GAMES[gameId];
    if (!game) return null;
    var depKey = slot === 'A' ? 'depA' : 'depB';
    if (!game[depKey]) {
      // R1 — direct team name
      return slot === 'A' ? game.teamA : game.teamB;
    }
    var depId = game[depKey];
    return state.picks[depId] || null; // null = not yet picked
  }

  /** Resolve seed for display. Only meaningful for R1. */
  function resolveSeed(gameId, slot) {
    var game = GAMES[gameId];
    if (!game || game.round !== 1) return null;
    return slot === 'A' ? game.seedA : game.seedB;
  }

  /** Check that all games in the current step have a pick */
  function stepComplete(stepIdx) {
    var step = STEPS[stepIdx];
    if (step.type === 'info') {
      return (
        state.info.name.trim() !== '' &&
        state.info.email.trim() !== '' &&
        isValidEmail(state.info.email) &&
        state.info.favoriteTeam.trim() !== ''
      );
    }
    if (step.type === 'review') return true;
    return step.games.every(function (gId) {
      return !!state.picks[gId];
    });
  }

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  /** Total bracket game steps (not info, not review) */
  function totalGameSteps() {
    return STEPS.filter(function (s) { return s.type === 'games'; }).length;
  }

  function completedGameSteps() {
    return STEPS.filter(function (s, i) {
      return s.type === 'games' && i < state.step;
    }).length;
  }

  /* ============================================================
     6. RENDER
     ============================================================ */

  var container = document.getElementById('mm-bracket-form');
  if (!container) return;

  function render() {
    var step = STEPS[state.step];
    var html = '';

    // Progress bar (skip for info step; for review show 100%)
    html += renderProgress();

    if (step.type === 'info') {
      html += renderInfoStep();
    } else if (step.type === 'games') {
      html += renderGamesStep(step);
    } else if (step.type === 'review') {
      html += renderReviewStep();
    }

    html += renderNav();

    container.innerHTML = html;
    bindEvents();
  }

  /* ── Progress ── */
  function renderProgress() {
    var totalGame = totalGameSteps();
    var doneGame  = completedGameSteps();
    var pct = state.step === 0 ? 0
            : state.step >= TOTAL_STEPS - 1 ? 100
            : Math.round((doneGame / totalGame) * 100);

    return '<div class="mm-progress">' +
      '<div class="mm-progress__label">' +
        '<span>Your Bracket</span>' +
        '<span>' + pct + '% complete</span>' +
      '</div>' +
      '<div class="mm-progress__bar-wrap">' +
        '<div class="mm-progress__bar-fill" style="width:' + pct + '%"></div>' +
      '</div>' +
    '</div>';
  }

  /* ── Step header ── */
  function renderStepHeader(step) {
    return '<div class="mm-step-header">' +
      '<div class="mm-step-header__round">' + escHtml(step.roundLabel) + '</div>' +
      '<h2 class="mm-step-header__title">' + escHtml(step.title) + '</h2>' +
      (step.desc ? '<p class="mm-step-header__desc">' + escHtml(step.desc) + '</p>' : '') +
    '</div>';
  }

  /* ── Info Step ── */
  function renderInfoStep() {
    var step = STEPS[state.step];
    return renderStepHeader(step) +
    '<div class="mm-info-form">' +
      '<div class="mm-field-group">' +

        '<div class="mm-field">' +
          '<label for="mm-name">Full Name</label>' +
          '<input type="text" id="mm-name" name="name" autocomplete="name" ' +
            'placeholder="Jane Smith" value="' + escHtml(state.info.name) + '">' +
        '</div>' +

        '<div class="mm-field">' +
          '<label for="mm-email">Email Address</label>' +
          '<input type="email" id="mm-email" name="email" autocomplete="email" ' +
            'placeholder="jane@example.com" value="' + escHtml(state.info.email) + '">' +
        '</div>' +

        '<div class="mm-field">' +
          '<label for="mm-team">Favorite Team</label>' +
          '<input type="text" id="mm-team" name="favoriteTeam" ' +
            'placeholder="e.g. Duke" value="' + escHtml(state.info.favoriteTeam) + '">' +
        '</div>' +

        '<div class="mm-field">' +
          '<label for="mm-phone">Phone Number <span class="mm-optional">(optional)</span></label>' +
          '<input type="tel" id="mm-phone" name="phone" autocomplete="tel" ' +
            'placeholder="(555) 555-5555" value="' + escHtml(state.info.phone) + '">' +
        '</div>' +

      '</div>' +
    '</div>';
  }

  /* ── Games Step ── */
  function renderGamesStep(step) {
    var html = renderStepHeader(step);
    html += '<div class="mm-matchups">';

    // Track region changes so we can show dividers on mixed-region steps
    var lastRegion = null;

    step.games.forEach(function (gameId) {
      var game = GAMES[gameId];
      if (!game) return;

      // Region divider on multi-region steps
      if (step.games.length > 2 && game.region !== lastRegion) {
        if (lastRegion !== null) {
          html += '<div class="mm-region-divider">' + escHtml(game.region) + ' Region</div>';
        } else if (hasMultipleRegions(step.games)) {
          html += '<div class="mm-region-divider">' + escHtml(game.region) + ' Region</div>';
        }
        lastRegion = game.region;
      }

      html += renderMatchup(game);
    });

    html += '</div>';
    return html;
  }

  function hasMultipleRegions(gameIds) {
    var regions = {};
    gameIds.forEach(function (id) {
      if (GAMES[id]) regions[GAMES[id].region] = true;
    });
    return Object.keys(regions).length > 1;
  }

  function renderMatchup(game) {
    var teamA = resolveTeam(game.id, 'A');
    var teamB = resolveTeam(game.id, 'B');
    var seedA = resolveSeed(game.id, 'A');
    var seedB = resolveSeed(game.id, 'B');
    var pickedA = state.picks[game.id] === teamA;
    var pickedB = state.picks[game.id] === teamB;

    var tbdA = !teamA;
    var tbdB = !teamB;

    var checkSvg = '<svg class="mm-check-icon" viewBox="0 0 20 20" fill="currentColor">' +
      '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>' +
    '</svg>';

    var matchupLabel = game.region && game.round <= 4
      ? game.region + ' ' + roundName(game.round) + ' — ' + game.label
      : (game.region ? game.region + ' — ' + game.label : game.label);

    return '<div class="mm-matchup">' +
      '<div class="mm-matchup__label">' + escHtml(matchupLabel) + '</div>' +
      '<div class="mm-matchup__teams">' +

        // Team A
        '<button class="mm-team-btn' + (pickedA ? ' mm-selected' : '') + (tbdA ? ' mm-team-btn--tbd' : '') + '" ' +
          'data-game="' + escHtml(game.id) + '" data-team="' + escHtml(teamA || 'TBD') + '" ' +
          (tbdA ? 'disabled' : '') + '>' +
          (seedA ? '<span class="mm-team-seed">' + seedA + '</span>' : '') +
          '<span class="mm-team-name">' + escHtml(teamA || 'TBD — pick from previous round') + '</span>' +
          checkSvg +
        '</button>' +

        '<div class="mm-vs">vs</div>' +

        // Team B
        '<button class="mm-team-btn' + (pickedB ? ' mm-selected' : '') + (tbdB ? ' mm-team-btn--tbd' : '') + '" ' +
          'data-game="' + escHtml(game.id) + '" data-team="' + escHtml(teamB || 'TBD') + '" ' +
          (tbdB ? 'disabled' : '') + '>' +
          (seedB ? '<span class="mm-team-seed">' + seedB + '</span>' : '') +
          '<span class="mm-team-name">' + escHtml(teamB || 'TBD — pick from previous round') + '</span>' +
          checkSvg +
        '</button>' +

      '</div>' +
    '</div>';
  }

  function roundName(n) {
    return ['', 'Round 1', 'Round of 32', 'Sweet 16', 'Elite Eight', 'Final Four', 'Championship'][n] || 'Round ' + n;
  }

  /* ── Review Step ── */
  function renderReviewStep() {
    var step = STEPS[state.step];
    var html = renderStepHeader(step);
    html += '<div class="mm-review">';

    // Personal info summary
    html += '<div class="mm-review__section">' +
      '<div class="mm-review__section-title">Your Information</div>' +
      '<div class="mm-review__info-grid">' +
        infoItem('Name', state.info.name) +
        infoItem('Email', state.info.email) +
        infoItem('Favorite Team', state.info.favoriteTeam) +
        (state.info.phone ? infoItem('Phone', state.info.phone) : '') +
      '</div>' +
    '</div>';

    // Picks by round
    var rounds = [
      { label: 'Round 1', min: 1, max: 1 },
      { label: 'Round of 32', min: 2, max: 2 },
      { label: 'Sweet 16', min: 3, max: 3 },
      { label: 'Elite Eight', min: 4, max: 4 },
      { label: 'Final Four', min: 5, max: 5 },
      { label: 'Championship', min: 6, max: 6 }
    ];

    rounds.forEach(function (rnd) {
      var roundGames = Object.values(state.picks)
        ? Object.keys(state.picks).filter(function (gId) {
            var g = GAMES[gId];
            return g && g.round >= rnd.min && g.round <= rnd.max;
          })
        : [];

      if (!roundGames.length) return;

      html += '<div class="mm-review__section">' +
        '<div class="mm-review__section-title">' + escHtml(rnd.label) + '</div>' +
        '<div class="mm-review__picks-grid">';

      roundGames.forEach(function (gId) {
        var g = GAMES[gId];
        var label = g.region ? g.region + ': ' : '';
        html += '<div class="mm-review__pick">' + escHtml(label + state.picks[gId]) + '</div>';
      });

      html += '</div></div>';
    });

    html += '<div id="mm-submit-error" class="mm-submit-error" style="display:none"></div>';
    html += '</div>';
    return html;
  }

  function infoItem(label, value) {
    return '<div class="mm-review__info-item"><strong>' + escHtml(label) + '</strong>' + escHtml(value) + '</div>';
  }

  /* ── Navigation ── */
  function renderNav() {
    var step = STEPS[state.step];
    var isFirst   = state.step === 0;
    var isReview  = step.type === 'review';

    return '<div class="mm-nav" id="mm-nav">' +
      (!isFirst
        ? '<button class="mm-btn mm-btn--back" id="mm-btn-back">&#8592; Back</button>'
        : '<span></span>') +
      '<span class="mm-nav__pick-reminder" id="mm-pick-reminder">Please make all picks to continue.</span>' +
      (isReview
        ? '<button class="mm-btn mm-btn--submit" id="mm-btn-submit">Submit My Bracket</button>'
        : '<button class="mm-btn mm-btn--next" id="mm-btn-next">Next &#8594;</button>') +
    '</div>';
  }

  /* ============================================================
     7. EVENT BINDING
     ============================================================ */

  function bindEvents() {
    // Team pick buttons
    var teamBtns = container.querySelectorAll('.mm-team-btn:not(.mm-team-btn--tbd)');
    teamBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var gameId = btn.getAttribute('data-game');
        var team   = btn.getAttribute('data-team');
        if (!gameId || !team || team === 'TBD') return;

        var prevPick = state.picks[gameId];
        state.picks[gameId] = team;

        // If this pick changes a winner that downstream games depend on,
        // clear those downstream picks to avoid stale data.
        if (prevPick && prevPick !== team) {
          clearDownstreamPicks(gameId);
        }

        // Re-render only the matchups area for instant feedback (no full re-render)
        render();
        // Scroll so the user sees the next matchup naturally
      });
    });

    // Info inputs
    var inputs = container.querySelectorAll('.mm-info-form input');
    inputs.forEach(function (input) {
      input.addEventListener('input', function () {
        state.info[input.name] = input.value;
      });
    });

    // Back
    var btnBack = container.querySelector('#mm-btn-back');
    if (btnBack) {
      btnBack.addEventListener('click', function () {
        if (state.step > 0) {
          state.step--;
          render();
          scrollToForm();
        }
      });
    }

    // Next
    var btnNext = container.querySelector('#mm-btn-next');
    if (btnNext) {
      btnNext.addEventListener('click', function () {
        if (!stepComplete(state.step)) {
          showPickReminder();
          highlightInfoErrors();
          return;
        }
        state.step++;
        render();
        scrollToForm();
      });
    }

    // Submit
    var btnSubmit = container.querySelector('#mm-btn-submit');
    if (btnSubmit) {
      btnSubmit.addEventListener('click', function () {
        submitBracket(btnSubmit);
      });
    }
  }

  function scrollToForm() {
    var el = document.getElementById('march-madness');
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function showPickReminder() {
    var el = container.querySelector('#mm-pick-reminder');
    if (el) {
      el.classList.add('mm-visible');
      setTimeout(function () { el.classList.remove('mm-visible'); }, 3000);
    }
  }

  function highlightInfoErrors() {
    var fields = { name: 'mm-name', email: 'mm-email', favoriteTeam: 'mm-team' };
    Object.keys(fields).forEach(function (key) {
      var el = container.querySelector('#' + fields[key]);
      if (!el) return;
      var valid = el.value.trim() !== '' && (key !== 'email' || isValidEmail(el.value));
      el.classList.toggle('mm-error', !valid);
    });
  }

  /** Clear any downstream picks that depend on changedGameId */
  function clearDownstreamPicks(changedGameId) {
    Object.keys(GAMES).forEach(function (gId) {
      var g = GAMES[gId];
      if (g.depA === changedGameId || g.depB === changedGameId) {
        if (state.picks[gId]) {
          delete state.picks[gId];
          clearDownstreamPicks(gId); // recurse
        }
      }
    });
  }

  /* ============================================================
     8. AJAX SUBMISSION
     ============================================================ */

  function submitBracket(btn) {
    btn.disabled = true;
    btn.innerHTML = '<span class="mm-spinner"></span> Submitting…';

    var errorEl = container.querySelector('#mm-submit-error');
    if (errorEl) errorEl.style.display = 'none';

    // Build payload
    var payload = {
      action:  'mm_submit_bracket',
      nonce:   (typeof mmBracket !== 'undefined' ? mmBracket.nonce : ''),
      name:    state.info.name,
      email:   state.info.email,
      phone:   state.info.phone,
      favoriteTeam: state.info.favoriteTeam,
      picks:   JSON.stringify(state.picks)
    };

    var ajaxUrl = typeof mmBracket !== 'undefined'
      ? mmBracket.ajaxUrl
      : '/wp-admin/admin-ajax.php';

    var body = Object.keys(payload).map(function (k) {
      return encodeURIComponent(k) + '=' + encodeURIComponent(payload[k]);
    }).join('&');

    fetch(ajaxUrl, {
      method:  'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body:    body
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
      if (data && data.success) {
        renderSuccess();
      } else {
        var msg = (data && data.data) ? data.data : 'Something went wrong. Please try again.';
        showSubmitError(msg, btn);
      }
    })
    .catch(function () {
      showSubmitError('Network error. Please check your connection and try again.', btn);
    });
  }

  function showSubmitError(msg, btn) {
    btn.disabled = false;
    btn.innerHTML = 'Submit My Bracket';
    var errorEl = container.querySelector('#mm-submit-error');
    if (errorEl) {
      errorEl.textContent = msg;
      errorEl.style.display = 'block';
    }
  }

  function renderSuccess() {
    container.innerHTML =
      '<div class="mm-success">' +
        '<div class="mm-success__icon">🎉</div>' +
        '<h2 class="mm-success__title">Bracket Submitted!</h2>' +
        '<p class="mm-success__body">' +
          'Thanks, <strong>' + escHtml(state.info.name) + '</strong>! Your bracket is locked in. ' +
          'We\'ll send a confirmation to <strong>' + escHtml(state.info.email) + '</strong>. ' +
          'Good luck — may your bracket be perfect!' +
        '</p>' +
      '</div>';
  }

  /* ============================================================
     9. UTILITIES
     ============================================================ */

  function escHtml(str) {
    if (str == null) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  /* ============================================================
     10. INIT
     ============================================================ */

  render();

})();
