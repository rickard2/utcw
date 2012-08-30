<?php if ( ! defined( 'ABSPATH' ) ) die();
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
 * @todo Preview
 * @todo Rendering class
 * @todo Find plugin compatibility, both PHP, WP and jQuery
 * @todo Shortcode
 * @todo Function for plugin / theme authors
 */

define( 'UTCW_VERSION', '2.0-alpha' );
define( 'UTCW_DEV', false );
define( 'UTCW_HEX_COLOR_REGEX', '/#([a-f0-9]{6}|[a-f0-9]{3})/i' );

require 'utcw-config.php';
require 'utcw-widget.php';
require 'utcw-data.php';
require 'utcw-render.php';
require 'utcw-term.php';

class UTCW_Plugin {

	protected $allowed_taxonomies = array();
	protected $allowed_post_types = array();

	private static $instance;

	private function __construct()
	{
		add_action( 'admin_head-widgets.php', array( $this, 'init_admin_assets' ) );
		add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );
		add_action( 'init', array( $this, 'init_assets' ) );
		add_action( 'widgets_init', create_function( '', 'return register_widget("UTCW");' ) );
	}

	/**
	 * @static
	 * @return UTCW_Plugin
	 */
	public static function get_instance()
	{
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	function wp_loaded()
	{
		$this->allowed_taxonomies = get_taxonomies();
		$this->allowed_post_types = get_post_types( array( 'public' => true ) );
	}

	/**
	 * @todo Create dynamic asset version
	 */
	function init_assets()
	{
		wp_register_style( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/utcw-css.php' ), array() );
	}

	public function init_admin_assets()
	{
		wp_enqueue_style( 'utcw-admin', plugins_url( 'ultimate-tag-cloud-widget/css/style.css' ), array(), UTCW_VERSION );

		if ( UTCW_DEV ) {
			wp_enqueue_script( 'utcw-lib-jsuri', plugins_url( 'ultimate-tag-cloud-widget/js/lib/jsuri-1.1.1.min.js' ), UTCW_VERSION, true );
			wp_enqueue_script( 'utcw-lib-tooltip', plugins_url( 'ultimate-tag-cloud-widget/js/lib/tooltip.min.js' ), array( 'jquery' ), UTCW_VERSION, true );
			wp_enqueue_script( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/js/utcw.js' ), array( 'utcw-lib-jsuri', 'utcw-lib-tooltip', 'jquery' ), UTCW_VERSION, true );
		} else {
			wp_enqueue_script( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/js/utcw.min.js' ), array( 'jquery' ), UTCW_VERSION, true );
		}
	}

	public function get_allowed_taxonomies()
	{
		return $this->allowed_taxonomies;
	}

	public function get_allowed_taxonomies_objects()
	{
		return get_taxonomies( array(), 'objects' );
	}

	public function get_terms() {
		$terms = array();

		foreach ( $this->get_allowed_taxonomies() as $taxonomy ) {
			$terms[ $taxonomy ] = get_terms( $taxonomy );
		}

		return $terms;
	}

	public function get_allowed_post_types()
	{
		return $this->allowed_post_types;
	}

	/**
	 * Returns the users on this blog
	 * @return array
	 */
	function get_users()
	{
		global $wp_version;

		if ( (float)$wp_version < 3.1 ) {
			return get_users_of_blog();
		} else {
			return get_users();
		}
	}

	function get_configurations()
	{
		return get_option( 'utcw_saved_configs', array() );
	}

	public function is_authenticated_user()
	{
		return is_user_logged_in();
	}
}

// Instantiates the plugin
UTCW_Plugin::get_instance();
