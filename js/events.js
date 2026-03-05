(function () {
    'use strict';

    // Bail if no events data or no calendar element on this page
    if (!window.dsEventsData || !document.getElementById('ds-calendar-grid')) return;

    var events = window.dsEventsData;

    // ── State ─────────────────────────────────────────────────────────────────

    var today = new Date();
    today.setHours(0, 0, 0, 0);

    var currentYear, currentMonth;

    // Start calendar on the month of the earliest upcoming event (or today)
    (function initMonth() {
        var upcoming = events
            .filter(function (e) { return !!e.dateISO; })
            .map(function (e) { return new Date(e.dateISO + 'T00:00:00'); })
            .filter(function (d) { return d >= today; })
            .sort(function (a, b) { return a - b; });

        var start = upcoming.length ? upcoming[0] : today;
        currentYear  = start.getFullYear();
        currentMonth = start.getMonth();
    }());

    // ── Helpers ───────────────────────────────────────────────────────────────

    var MONTH_NAMES = [
        'January','February','March','April','May','June',
        'July','August','September','October','November','December'
    ];

    function pad(n) {
        return String(n).padStart(2, '0');
    }

    // Build Ymd key (e.g. '20260315') — month is 0-based JS month
    function ymd(year, month, day) {
        return '' + year + pad(month + 1) + pad(day);
    }

    // Build ISO key (e.g. '2026-03-15') — month is 0-based JS month
    function isoKey(year, month, day) {
        return year + '-' + pad(month + 1) + '-' + pad(day);
    }

    function todayYMD() {
        return '' + today.getFullYear() + pad(today.getMonth() + 1) + pad(today.getDate());
    }

    // Match by either the raw ACF Ymd string OR the ISO string — handles any
    // minor format variation that ACF might return on the server.
    function eventsOnDate(year, month, day) {
        var keyYmd = ymd(year, month, day);
        var keyIso = isoKey(year, month, day);
        return events.filter(function (e) {
            return e.date === keyYmd || e.dateISO === keyIso;
        });
    }

    function escHTML(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(String(str)));
        return div.innerHTML;
    }

    function stripTags(html) {
        var tmp = document.createElement('div');
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || '';
    }

    function slugify(str) {
        return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    }

    // ── Calendar Rendering ────────────────────────────────────────────────────

    function renderCalendar() {
        var grid  = document.getElementById('ds-calendar-grid');
        var label = document.getElementById('ds-cal-month-label');

        label.textContent = MONTH_NAMES[currentMonth] + ' ' + currentYear;

        // Remove all day cells (keep the 7 header divs)
        var children = Array.prototype.slice.call(grid.children);
        children.forEach(function (child) {
            if (!child.classList.contains('ds-cal-day-header')) {
                grid.removeChild(child);
            }
        });

        var firstDayOfWeek  = new Date(currentYear, currentMonth, 1).getDay(); // 0=Sun
        var daysInMonth     = new Date(currentYear, currentMonth + 1, 0).getDate();
        var daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
        var tYMD = todayYMD();

        // Leading cells from previous month
        for (var i = 0; i < firstDayOfWeek; i++) {
            var prevDay = daysInPrevMonth - firstDayOfWeek + 1 + i;
            grid.appendChild(makeOtherMonthCell(prevDay));
        }

        // Current month days
        for (var d = 1; d <= daysInMonth; d++) {
            var dayEvents = eventsOnDate(currentYear, currentMonth, d);
            var isToday   = ymd(currentYear, currentMonth, d) === tYMD;
            grid.appendChild(makeCurrentMonthCell(d, dayEvents, isToday));
        }

        // Trailing cells for next month
        var totalCells = firstDayOfWeek + daysInMonth;
        var trailing   = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
        for (var t = 1; t <= trailing; t++) {
            grid.appendChild(makeOtherMonthCell(t));
        }
    }

    function makeOtherMonthCell(day) {
        var cell = document.createElement('div');
        cell.className = 'ds-cal-day other-month';
        var num = document.createElement('div');
        num.className = 'ds-cal-day-num';
        num.textContent = day;
        cell.appendChild(num);
        return cell;
    }

    function makeCurrentMonthCell(day, dayEvents, isToday) {
        var cell = document.createElement('div');
        cell.className = 'ds-cal-day' + (isToday ? ' today' : '') + (dayEvents.length ? ' has-events' : '');

        var num = document.createElement('div');
        num.className = 'ds-cal-day-num';
        num.textContent = day;
        cell.appendChild(num);

        if (dayEvents.length) {
            var dotsWrap = document.createElement('div');
            dotsWrap.className = 'ds-cal-event-dots';

            dayEvents.forEach(function (evt) {
                var lbl = document.createElement('div');
                lbl.className = 'ds-cal-event-label';
                lbl.textContent = evt.title;
                lbl.addEventListener('click', function (e) {
                    e.stopPropagation();
                    openModal(evt);
                });
                dotsWrap.appendChild(lbl);
            });

            cell.appendChild(dotsWrap);

            // Clicking the whole cell opens the modal when there's exactly one event
            if (dayEvents.length === 1) {
                cell.addEventListener('click', function () {
                    openModal(dayEvents[0]);
                });
            }
        }

        return cell;
    }

    // ── Calendar Navigation ───────────────────────────────────────────────────

    document.getElementById('ds-cal-prev').addEventListener('click', function () {
        currentMonth--;
        if (currentMonth < 0) { currentMonth = 11; currentYear--; }
        renderCalendar();
    });

    document.getElementById('ds-cal-next').addEventListener('click', function () {
        currentMonth++;
        if (currentMonth > 11) { currentMonth = 0; currentYear++; }
        renderCalendar();
    });

    // ── Event Cards (list grid) ───────────────────────────────────────────────

    Array.prototype.forEach.call(document.querySelectorAll('.ds-event-card'), function (card) {
        var id  = parseInt(card.dataset.eventId, 10);
        var evt = events.find(function (e) { return e.id === id; });
        if (!evt) return;

        card.addEventListener('click', function () { openModal(evt); });
        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openModal(evt);
            }
        });
    });

    // ── Modal ─────────────────────────────────────────────────────────────────

    var overlay  = document.getElementById('ds-events-modal-overlay');
    var closeBtn = document.getElementById('ds-modal-close');

    function openModal(evt) {
        // Image banner
        var banner = document.getElementById('ds-modal-image-banner');
        var img    = document.getElementById('ds-modal-image');

        if (evt.photoUrl) {
            banner.classList.remove('no-photo');
            img.src   = evt.photoUrl;
            img.alt   = evt.photoAlt || evt.title;
            img.style.display = '';
        } else {
            banner.classList.add('no-photo');
            img.src   = '';
            img.style.display = 'none';
        }

        // Title
        document.getElementById('ds-modal-title-text').textContent = evt.title;

        // Description (may contain HTML from wysiwyg)
        var descEl = document.getElementById('ds-modal-description');
        descEl.innerHTML = evt.description || '';

        // Meta rows
        var metaEl = document.getElementById('ds-modal-meta');
        metaEl.innerHTML = '';

        if (evt.dateFormatted) {
            var dateText = evt.dateFormatted + (evt.time ? ' \u00b7 ' + evt.time : '');
            metaEl.appendChild(makeMetaRow('fa-regular fa-calendar', dateText));
        }
        if (evt.location) {
            metaEl.appendChild(makeMetaRow('fa-solid fa-location-dot', evt.location));
        }

        // Registration link
        var regWrap = document.getElementById('ds-modal-reg-wrap');
        regWrap.innerHTML = '';
        if (evt.regLink) {
            var a = document.createElement('a');
            a.href      = evt.regLink;
            a.target    = '_blank';
            a.rel       = 'noopener noreferrer';
            a.className = 'ds-modal-reg-link';
            a.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> Register Now';
            regWrap.appendChild(a);
        }

        // Add to Calendar buttons
        var calBtns = document.getElementById('ds-modal-cal-btns');
        calBtns.innerHTML = '';

        if (evt.dateISO) {
            var gBtn = document.createElement('a');
            gBtn.href      = buildGoogleCalURL(evt);
            gBtn.target    = '_blank';
            gBtn.rel       = 'noopener noreferrer';
            gBtn.className = 'ds-modal-cal-btn ds-cal-google';
            gBtn.innerHTML = '<i class="fa-brands fa-google" aria-hidden="true"></i> Add to Google Calendar';
            calBtns.appendChild(gBtn);

            var aBtn = document.createElement('a');
            aBtn.href      = buildICSDataURI(evt);
            aBtn.download  = slugify(evt.title) + '.ics';
            aBtn.className = 'ds-modal-cal-btn ds-cal-apple';
            aBtn.innerHTML = '<i class="fa-brands fa-apple" aria-hidden="true"></i> Add to Apple Calendar';
            calBtns.appendChild(aBtn);
        }

        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        closeBtn.focus();
    }

    function makeMetaRow(iconClass, text) {
        var row  = document.createElement('div');
        row.className = 'ds-modal-meta-row';
        var icon = document.createElement('i');
        icon.className = iconClass + ' ds-meta-icon';
        icon.setAttribute('aria-hidden', 'true');
        var span = document.createElement('span');
        span.textContent = text;
        row.appendChild(icon);
        row.appendChild(span);
        return row;
    }

    function closeModal() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeModal();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });

    // ── Google Calendar URL ───────────────────────────────────────────────────

    function parseTime(timeStr) {
        // Accepts "10:00 AM", "2:30 PM", or range "10:00 AM – 2:00 PM" (uses start)
        var m = timeStr ? timeStr.match(/(\d{1,2}):(\d{2})\s*(AM|PM)/i) : null;
        if (!m) return null;
        var h   = parseInt(m[1], 10);
        var min = parseInt(m[2], 10);
        var ap  = m[3].toUpperCase();
        if (ap === 'PM' && h < 12) h += 12;
        if (ap === 'AM' && h === 12) h = 0;
        return { h: h, min: min };
    }

    function buildGoogleCalURL(evt) {
        var dateStr = evt.dateISO.replace(/-/g, ''); // '20260315'
        var startDT, endDT;
        var t = parseTime(evt.time);

        if (t) {
            startDT = dateStr + 'T' + pad(t.h) + pad(t.min) + '00';
            var endH = t.h + 1;
            endDT   = dateStr + 'T' + pad(endH > 23 ? 23 : endH) + pad(t.min) + '00';
        } else {
            // All-day
            var nextDate = new Date(evt.dateISO + 'T00:00:00');
            nextDate.setDate(nextDate.getDate() + 1);
            var nextStr = nextDate.getFullYear() + pad(nextDate.getMonth() + 1) + pad(nextDate.getDate());
            startDT = dateStr;
            endDT   = nextStr;
        }

        var base = 'https://calendar.google.com/calendar/render?action=TEMPLATE';
        base += '&text='     + encodeURIComponent(evt.title);
        base += '&dates='    + encodeURIComponent(startDT + '/' + endDT);
        base += '&details='  + encodeURIComponent(evt.description ? stripTags(evt.description) : '');
        base += '&location=' + encodeURIComponent(evt.location || '');
        return base;
    }

    // ── Apple Calendar (.ics via data URI — CSP-safe, no blob needed) ─────────

    function buildICSDataURI(evt) {
        var uid     = 'ds-event-' + evt.id + '@mydigitalstride.com';
        var dateStr = evt.dateISO.replace(/-/g, '');
        var now     = new Date().toISOString().replace(/[-:.]/g, '').slice(0, 15) + 'Z';
        var t       = parseTime(evt.time);

        var dtStart, dtEnd;
        if (t) {
            dtStart = 'DTSTART:' + dateStr + 'T' + pad(t.h) + pad(t.min) + '00';
            var endH2 = t.h + 1;
            dtEnd   = 'DTEND:' + dateStr + 'T' + pad(endH2 > 23 ? 23 : endH2) + pad(t.min) + '00';
        } else {
            var nextD = new Date(evt.dateISO + 'T00:00:00');
            nextD.setDate(nextD.getDate() + 1);
            var nextS = nextD.getFullYear() + pad(nextD.getMonth() + 1) + pad(nextD.getDate());
            dtStart = 'DTSTART;VALUE=DATE:' + dateStr;
            dtEnd   = 'DTEND;VALUE=DATE:' + nextS;
        }

        var lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Digital Stride//Events//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:' + uid,
            'DTSTAMP:' + now,
            dtStart,
            dtEnd,
            'SUMMARY:' + evt.title,
        ];

        if (evt.description) {
            lines.push('DESCRIPTION:' + stripTags(evt.description).replace(/\r?\n/g, '\\n'));
        }
        if (evt.location) {
            lines.push('LOCATION:' + evt.location);
        }
        if (evt.regLink) {
            lines.push('URL:' + evt.regLink);
        }

        lines.push('END:VEVENT', 'END:VCALENDAR');

        // Use data URI — works without blob: CSP allowance
        return 'data:text/calendar;charset=utf8,' + encodeURIComponent(lines.join('\r\n'));
    }

    // ── Init ──────────────────────────────────────────────────────────────────

    renderCalendar();

}());
