<?php
/**
 * Only REST API
 *
 * @package             Only_REST_API
 * @author              Braad Martin <wordpress@braadmartin.com>
 * @license             GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:         Only REST API
 * Plugin URI:          https://wordpress.org/plugins/only-rest-api/
 * Description:         Redirects all front end, non-REST API requests to a single page.
 * Version:             1.0.0
 * Author:              Braad Martin
 * Author URI:          http://braadmartin.com
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         only-rest-api
 * Domain Path:         /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

define( 'ONLY_REST_API_VERSION', '1.0.0' );

/**
 * Our main plugin class.
 *
 * @since  1.0.0
 */
class Only_REST_API {

	/**
	 * Plugin version.
	 *
	 * @var  string
	 */
	protected $version;

	/**
	 * Plugin slug.
	 *
	 * @var  string
	 */
	protected $slug;

	/**
	 * Plugin display name.
	 *
	 * @var  string
	 */
	protected $display_name;

	/**
	 * Plugin option name.
	 *
	 * @var  string
	 */
	protected $option_name;

	/**
	 * Plugin options.
	 *
	 * @var  array
	 */
	protected $options;

	/**
	 * Define our class properties and set up our hooks.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {

		$this->version      = ONLY_REST_API_VERSION;
		$this->slug         = 'only-rest-api';
		$this->display_name = __( 'Only REST API', 'only-rest-api' );
		$this->option_name  = $this->slug . '-options';

		$this->initialize();
	}

	/**
	 * Set up our hooks.
	 *
	 * @since  1.0.0
	 */
	public function initialize() {

		// Primary redirect action.
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );

		// Add our settings page to the admin menu.
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		// Register our settings.
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Add an action link to the settings page.
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
	}

	/**
	 * If we're displaying a front end page, redirect to the site URL and use our output.
	 *
	 * @since  1.0.0
	 */
	public function template_redirect() {

		if ( ! is_front_page() ) {

			wp_redirect( home_url() );
			exit;

		} else {

			$this->output_page();
			exit;
		}
	}

	/**
	 * Add our settings page to the admin menu.
	 *
	 * @since  1.0.0
	 */
	public function admin_menu() {

		add_options_page(
			$this->display_name . ' Settings',
			$this->display_name,
			'manage_options',
			$this->slug,
			array( $this, 'options_page' )
		);
	}

	/**
	 * Output our options page.
	 *
	 * @since  1.0.0
	 */
	public function options_page() {
		?>
		<div class="wrap only-rest-api-settings-page">
			<h1><?php echo $this->display_name; ?></h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( $this->option_name );
					do_settings_sections( $this->slug );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register our settings.
	 *
	 * @since  1.0.0
	 */
	public function register_settings() {

		register_setting(
			$this->option_name,                 // Option group.
			$this->option_name,                 // Option name.
			array( $this, 'validate_settings' ) // Validate.
		);

		add_settings_section(
			$this->slug . '-general',           // Section ID.
			__( 'Options', 'only-rest-api' ),   // Title.
			array( $this, 'settings_section' ), // Callback.
			$this->slug                         // Settings Page.
		);

		// Message to show on the front end.
		add_settings_field(
			'message',                                   // Option ID.
			__( 'Front end message:', 'only-rest-api' ), // Title.
			array( $this, 'message_field' ),             // Callback.
			$this->slug,                                 // Settings Page.
			$this->slug . '-general'                     // Section ID.
		);
	}

	/**
	 * Output the settings section.
	 *
	 * @since  1.0.0
	 */
	public function settings_section() {
		return;
	}

	/**
	 * Output our message field.
	 *
	 * @since  1.0.0
	 */
	public function message_field() {

		$options = get_option( $this->option_name );

		// Use default message if no custom message has been saved.
		if ( ! isset( $options['message'] ) ) {
			$options['message'] = __( 'Sorry, this website only answers requests to the REST API. Please try again at a proper endpoint.', 'only-rest-api' );
		}

		$message = $options['message'];

		printf(
			'<textarea id="%s-message-field" name="%s" class="widefat" rows="8" cols="60">%s</textarea>',
			$this->slug,
			$this->option_name . '[message]',
			esc_textarea( $message )
		);

		printf(
			'<p>' . __( 'This textarea supports the same HTML as post content. Custom HTML can also be used with the %s and %s filters.', 'only-rest-api' ) . '</p>',
			'<code>only_rest_api_page_content</code>',
			'<code>only_rest_api_page_html</code>'
		);
	}

	/**
	 * Validate our settings before saving.
	 *
	 * @since  1.0.0
	 *
	 * @param   array  $input  The raw settings.
	 * @return  array          The clean settings.
	 */
	public function validate_settings( $input ) {

		$new_input = array();

		$new_input['message'] = ( isset( $input['message'] ) ) ? wp_kses_post( $input['message'] ) : '';

		return $new_input;
	}

	/**
	 * Output our front end page.
	 *
	 * @since  1.0.0
	 */
	public function output_page() {

		$options = get_option( $this->option_name );

		// Use default message if no custom message has been saved.
		if ( ! isset( $options['message'] ) ) {
			$options['message'] = __( 'Sorry, this website only answers requests to the REST API. Please try again at a proper endpoint.', 'only-rest-api' );
		}

		// Set up some default css.
		$css = '
		.page-content {
			margin: 200px auto 0;
			width: 420px;
			max-width: 94%;
			font-size: 20px;
			text-align: center;
		}';

		// Allow others to use custom CSS.
		$css = apply_filters( 'only_rest_api_page_css', $css, $options );

		$content = sprintf(
			'<style type="text/css">%s</style><div class="page-content">%s</div>',
			$css,
			$options['message']
		);

		// Allow others to use custom output.
		$content = apply_filters( 'only_rest_api_page_content', $content, $options );

		// Set up our default page HTML.
		ob_start();

		?>
<!doctype html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php echo $content; ?>
	</body>
</html>
		<?php

		$page_html = ob_get_clean();

		// Allow others to use custom html for the entire page.
		$page_html = apply_filters( 'only_rest_api_page_html', $page_html, $options, $content, $css );

		echo $page_html;
	}

	/**
	 * Add an action link to the settings page.
	 *
	 * @since  1.0.0
	 *
	 * @param   array  $link  The plugin action links.
	 * @return  array         The action links with ours added.
	 */
	public function action_links( $links ) {

		$link = sprintf(
			'<a href="%s">%s</a>',
			get_admin_url( null, 'options-general.php?page=only-rest-api' ),
			__( 'Settings', 'only-rest-api' )
		);

		$links[] = $link;

		return $links;
	}
}

/**
 * Start the party.
 */
new Only_REST_API();