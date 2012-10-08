<?php
/*
Plugin Name: Ultimate tag cloud widget
Plugin URI: https://www.0x539.se/wordpress/ultimate-tag-cloud-widget/
Description: This plugin aims to be the most configurable tag cloud widget out there, able to suit all your weird tag cloud needs.
Version: 2.0 alpha
Author: Rickard Andersson
Author URI: https://www.0x539.se
License: GPLv2
*/
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.0
 * @license    GPLv2
 * @package    utcw
 * @subpackage main
 * @since      2.0
 *
 * @todo       Find plugin compatibility, both PHP, WP and jQuery
 * @todo       README
 */
if ( ! defined( 'ABSPATH' ) ) die();

/**
 * Current version number
 *
 * @var string
 * @since 2.0
 */
define( 'UTCW_VERSION', '2.0-alpha' );

/**
 * If development mode is currently enabled
 *
 * @var bool
 * @since 2.0
 */
define( 'UTCW_DEV', false );

/**
 * Regular expression for matching hexadecimal colors
 *
 * @var string
 * @since 2.0
 */
define( 'UTCW_HEX_COLOR_REGEX', '/#([a-f0-9]{6}|[a-f0-9]{3})/i' );

/**
 * printf format for rendering hexadecimal colors
 *
 * @var string
 * @since 2.0
 */
define( 'UTCW_HEX_COLOR_FORMAT', '#%02x%02x%02x' );

require_once 'utcw-config.php';
require_once 'utcw-widget.php';
require_once 'utcw-data.php';
require_once 'utcw-render.php';
require_once 'utcw-term.php';

/**
 * Class for general plugin integration with WordPress
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */
class UTCW_Plugin {

	/**
	 * An array of which taxonomies are available
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_taxonomies = array();

	/**
	 * An array of which post types are available
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_post_types = array();

	/**
	 * Singleton instance
	 *
	 * @var UTCW_Plugin
	 * @since 2.0
	 */
	private static $instance;

	/**
	 * Initializes the WordPress hooks needed
	 *
	 * @todo  Add tests that these hooks are set
	 * @since 2.0
	 */
	private function __construct() {
		add_action( 'admin_head-widgets.php', array( $this, 'init_admin_assets' ) );
		add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );
		add_action( 'widgets_init', create_function( '', 'return register_widget("UTCW");' ) );
		add_shortcode( 'utcw', array( $this, 'utcw_shortcode' ) );
	}

	/**
	 * Returns an instance of the plugin
	 *
	 * @static
	 * @return UTCW_Plugin
	 * @since 2.0
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Action handler for 'wp_loaded' hook
	 * Loads taxonomies and post types
	 *
	 * @since 2.0
	 */
	function wp_loaded() {
		$this->allowed_taxonomies = get_taxonomies();
		$this->allowed_post_types = get_post_types( array( 'public' => true ) );
	}

	/**
	 * Shortcode handler for 'utcw' hook
	 *
	 * @param array $args
	 *
	 * @return string
	 * @since 2.0
	 */
	function utcw_shortcode( array $args ) {
		global $wpdb;

		$config = new UTCW_Config( $args, $this );
		$data   = new UTCW_Data( $config, $this, $wpdb );
		$render = new UTCW_Render( $config, $data );

		return $render->get_cloud();
	}

	/**
	 * Action handler for 'admin_head-widgets.php' hook
	 * Loads assets needed by the administration interface
	 *
	 * @since 2.0
	 */
	public function init_admin_assets() {
		wp_enqueue_style( 'utcw-admin', plugins_url( 'ultimate-tag-cloud-widget/css/style.css' ), array(), UTCW_VERSION );

		// In development mode, add the libraries and main file individually
		if ( UTCW_DEV ) {
			wp_enqueue_script( 'utcw-lib-jsuri', plugins_url( 'ultimate-tag-cloud-widget/js/lib/jsuri-1.1.1.min.js' ), UTCW_VERSION, true );
			wp_enqueue_script( 'utcw-lib-tooltip', plugins_url( 'ultimate-tag-cloud-widget/js/lib/tooltip.min.js' ), array( 'jquery' ), UTCW_VERSION, true );
			wp_enqueue_script( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/js/utcw.js' ), array( 'utcw-lib-jsuri', 'utcw-lib-tooltip', 'jquery' ), UTCW_VERSION, true );
		} else {
			wp_enqueue_script( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/js/utcw.min.js' ), array( 'jquery' ), UTCW_VERSION, true );
		}
	}

	/**
	 * Returns an array with the names of allowed taxonomies
	 *
	 * @return array
	 * @since 2.0
	 */
	public function get_allowed_taxonomies() {
		return $this->allowed_taxonomies;
	}

	/**
	 * Returns allowed taxonomies as objects
	 *
	 * @return array
	 * @since 2.0
	 */
	public function get_allowed_taxonomies_objects() {
		return get_taxonomies( array(), 'objects' );
	}

	/**
	 * Returns an array with taxonomy as key and an array of term objects for each taxonomy. Like:
	 *
	 * @return array
	 * @since 2.0
	 */
	public function get_terms() {
		$terms = array();

		foreach ( $this->get_allowed_taxonomies() as $taxonomy ) {
			$terms[ $taxonomy ] = get_terms( $taxonomy );
		}

		return $terms;
	}

	/**
	 * Returns an array with the names of allowed post types
	 *
	 * @return array
	 * @since 2.0
	 */
	public function get_allowed_post_types() {
		return $this->allowed_post_types;
	}

	/**
	 * Returns the users on this blog
	 *
	 * @return array
	 * @since 2.0
	 */
	function get_users() {
		global $wp_version;

		if ( (float)$wp_version < 3.1 ) {
			return get_users_of_blog();
		} else {
			return get_users();
		}
	}

	/**
	 * Saves the configuration
	 *
	 * @param string $name   Name of configuration
	 * @param array  $config Exported configuration from UTCW_Config
	 *
	 * @return bool
	 * @since 2.0
	 */
	function save_configuration( $name, array $config ) {
		$configs          = $this->get_configurations();
		$configs[ $name ] = $config;

		return update_option( 'utcw_saved_configs', $configs );
	}

	/**
	 * Loads saved configuration
	 *
	 * @param string $name Name of configuration
	 *
	 * @return array|bool Returns an instance array on success and boolean false on failure
	 * @since 2.0
	 */
	function load_configuration( $name ) {
		$configs = $this->get_configurations();

		if ( isset( $configs[ $name ] ) ) {
			return $configs[ $name ];
		}

		return false;
	}

	/**
	 * Get saved configurations
	 *
	 * @return array
	 * @since 2.0
	 */
	function get_configurations() {
		return get_option( 'utcw_saved_configs', array() );
	}

	/**
	 * Returns boolean true if the current page request is for an authenticated user
	 *
	 * @return bool
	 * @since 2.0
	 */
	public function is_authenticated_user() {
		return is_user_logged_in();
	}

	/**
	 * Returns an absolute URI to the archive page for the term
	 *
	 * @param int    $term_id     Term ID
	 * @param string $taxonomy    Taxonomy name
	 *
	 * @return string Returns URI on success and empty string on failure
	 * @since 2.0
	 */
	public function get_term_link( $term_id, $taxonomy ) {
		$link = get_term_link( $term_id, $taxonomy );

		return ! is_wp_error( $link ) ? $link : '';
	}

	/**
	 * Check if the term exist for taxonomy
	 *
	 * @param int    $term_id     Term ID
	 * @param string $taxonomy    Taxonomy name
	 *
	 * @return bool
	 * @since 2.0
	 */
	public function check_term_taxonomy( $term_id, $taxonomy ) {
		return ! ! get_term( $term_id, $taxonomy );
	}
}

// Instantiates the plugin
UTCW_Plugin::get_instance();

/**
 * Function for theme integration
 *
 * @param array $args
 *
 * @since 1.3
 */
function do_utcw( array $args ) {
	$plugin = UTCW_Plugin::get_instance();
	echo $plugin->utcw_shortcode( $args );
}
