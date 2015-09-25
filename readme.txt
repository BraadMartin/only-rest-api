=== Only REST API ===
Contributors: Braad
Donate link: http://braadmartin.com/
Tags: rest, api, json, only
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Redirects all front end, non-REST API requests to a single page.

== Description ==

Got a WordPress install that serves only as the data layer and/or admin UI of your web application? This plugin will effectively turn off all default front end output and optionally display a message of your choice.

The message can be a simple plain text message or you can use the included filters to completely control the HTML output.

All activity in the wp-admin and all non-template front end requests like for images, scripts, etc. will be unaffected by this plugin. Only requests that go through `template_redirect` will be affected.

= Message Output =

Rather than contaminate the data structures you might be using for your application (like posts and pages), this plugin includes a settings page with a simple textarea box where you can save any basic message you want to show, and the message content is stored in the options table.

You can use the `only_rest_api_page_content` filter to include any custom HTML output you want inside the <body> tags, or you can use the `only_rest_api_page_html` filter to completely replace all HTML output of the message page, including the <html> and <head> tags.

There is also an `only_rest_api_page_css` filter that allows you to override the 5 lines of CSS this plugin includes to center the message on the page.

If you want a hook added or have a feature request let me know. Pull requests are welcome [on Github](https://github.com/BraadMartin/only-rest-api "Only REST API on Github").

== Installation ==

= Manual Installation =

1. Upload the entire `/only-rest-api` directory to the `/wp-content/plugins/` directory.
1. Activate Only REST API through the 'Plugins' menu in WordPress.

= Better Installation =

1. Go to Plugins > Add New in your WordPress admin and search for Only REST API.
1. Click Install.

== Frequently Asked Questions ==

= Will this plugin affect assets like images? =

No, this plugin hooks into the `template_redirect` action, which only fires when a front end page of some kind is being served.

== Screenshots ==

1. Customizable message shown on the front end for non-REST API requests

== Changelog ==

= 1.0.0 =
* First Release

== Upgrade Notice ==

= 1.0.0 =
* First Release