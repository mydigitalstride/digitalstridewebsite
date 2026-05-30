=== DS Quote Questionnaire ===
Contributors: digitalstride
Tags: quote, calculator, pricing, questionnaire, website cost
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPL-2.0-or-later

Interactive multi-step website quote questionnaire with live pricing, PDF export, and email delivery.

== Description ==

Embed the Digital Stride website quote questionnaire anywhere on your site using the shortcode:

  [ds_quote_questionnaire]

Features:
* 9-step guided questionnaire
* Live price estimate badge that updates as the user answers
* Platform comparison (WordPress + Elementor, WordPress Custom Build, Shopify)
* Flexible payment plan calculator (3 / 6 / 12 months)
* Client-side PDF generation via jsPDF
* Automated email delivery to the team and the client

== Installation ==

1. Upload the `ds-quote-questionnaire` folder to `/wp-content/plugins/`.
2. Activate the plugin in **Plugins → Installed Plugins**.
3. Add `[ds_quote_questionnaire]` to any page or post.

== Customisation ==

* **Notification email** — filter `ds_qb_notification_email` to change the team inbox:

  add_filter( 'ds_qb_notification_email', fn() => 'you@example.com' );

* **Logo in PDF** — the plugin reads the ACF `header_logo` option field (if ACF is active).
  To use a different logo, filter `ds_qb_logo_url` (hook coming in v1.1).

== Changelog ==

= 1.0.0 =
* Initial release — extracted from the DigitalStride theme and packaged as a standalone plugin.
