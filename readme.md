# Only REST API #
**Contributors:** Braad  
**Donate link:** http://braadmartin.com/  
**Tags:** rest, api, json, only  
**Requires at least:** 4.0  
**Tested up to:** 4.3  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Redirects all front end, non-REST API requests to a single page.

## Description ##

Got a WordPress install that serves only as the data layer and/or admin UI of your web application? This plugin will effectively turn off all default front end output, redirect all front end urls to the main site url, and optionally display a message of your choice.

The message can be a simple plain text message or you can use the included filters to completely control the HTML output.

All activity in the wp-admin and all requests for assets like images, scripts, files, etc. will be unaffected by this plugin. Only requests that go through the `template_redirect` action will be affected.

### Message Output ###

Rather than contaminate the data structures you might be using for your application (like posts and pages) this plugin includes a settings page with a simple textarea box where you can save any basic message you want to show. The message content is stored in the options table, and the textarea supports all the same HTML that you can use in post content.

You can use the `only_rest_api_page_content` filter to include any custom HTML output you want inside the `<body>` tags, or you can use the `only_rest_api_page_html` filter to completely replace all HTML output of the message page, including the `<html>` and `<head>` tags.

There is also an `only_rest_api_page_css` filter that allows you to override the 5 lines of CSS this plugin includes to center the message on the page.

If you want a hook added or have a feature request let me know. Pull requests are welcome [on Github](https://github.com/BraadMartin/only-rest-api "Only REST API on Github").

### Filter Examples ###

Use custom HTML inside the `<body>` tags:

	add_filter( 'only_rest_api_page_content', 'xxx_page_content' );
	function xxx_page_content( $content ) {

		$content = '<div class="custom-output">Sorry, I Only Speak REST. Please try again at a proper endpoint.</div>';

		return $content;
	}

Add custom CSS to the default output:

	add_filter( 'only_rest_api_page_css', 'xxx_page_css' );
	function xxx_page_css( $css ) {

		$css .= '.page-content { color: red; font-size: 72px; }';

		return $css;
	}

Replace the entire HTML output for the page:

	add_filter( 'only_rest_api_page_html', 'xxx_page_html' );
	function xxx_page_html( $html ) {

		ob_start();

		?>
		<!doctype html>
		<html lang="">
			<head>
				<meta charset="utf-8">
				<meta http-equiv="x-ua-compatible" content="ie=edge">
				<title>Call me back over the REST API yo!</title>
				<meta name="description" content="">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" type="text/css" href="your-awesome-stylesheet.css">
				<script type="text/javascript">
					// Do neat stuff...
				</script>
			</head>
			<body>
				<div class="page-content">
					Ain't nobody got time for non-REST API requests. Please try again at a proper endpoint. :)
				</div>
			</body>
		</html>
		<?php

		$html = ob_get_clean();

		return $html;
	}

## Installation ##

### Manual Installation ###

1. Upload the entire `/only-rest-api` directory to the `/wp-content/plugins/` directory.
1. Activate Only REST API through the 'Plugins' menu in WordPress.

### Better Installation ###

1. Go to Plugins > Add New in your WordPress admin and search for Only REST API.
1. Click Install.

## Frequently Asked Questions ##

### Will this plugin affect assets like images, stylesheets, files, etc? ###

No, this plugin hooks into the `template_redirect` action, which only fires when a front end page of some kind is being served.

### Does the plugin work with both v1 and v2 of the WP REST API? ###

Yes! This plugin supports both versions of the WP REST API and will support the final version that gets merged into core.

## Screenshots ##

### 1. Customizable message shown on the front end for non-REST API requests ###
![Customizable message shown on the front end for non-REST API requests](http://ps.w.org/only-rest-api/assets/screenshot-1.png)


## Changelog ##

### 1.0.0 ###
* First Release

## Upgrade Notice ##

### 1.0.0 ###
* First Release