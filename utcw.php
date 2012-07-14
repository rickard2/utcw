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

define( 'UTCW_VERSION', '2.0-alpha' );
define( 'UTCW_DEV', false );

require 'utcw-config.php';
require 'utcw-widget.php';

class UTCW_Plugin {

	protected $allowed_taxonomies = array();
	protected $allowed_post_types = array();

	private static $instance;

	private function __construct()
	{
		add_action( 'admin_head-widgets.php', array( $this, 'init_admin_assets' ) );
		add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );
	}

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

	public function init_admin_assets()
	{
		wp_enqueue_style( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/css/style.css' ), array(), UTCW_VERSION );

		if ( UTCW_DEV ) {
			wp_enqueue_script( 'utcw-lib-tooltip', plugins_url( 'ultimate-tag-cloud-widget/js/lib/tooltip.min.js' ), array( 'jquery' ), UTCW_VERSION, true );
			wp_enqueue_script( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/js/utcw.js' ), array( 'utcw-lib-tooltip', 'jquery' ), UTCW_VERSION, true );
		} else {
			wp_enqueue_script( 'utcw', plugins_url( 'ultimate-tag-cloud-widget/js/utcw.min.js' ), array( 'jquery' ), UTCW_VERSION, true );
		}
	}

	public function get_allowed_taxonomies()
	{
		return $this->allowed_taxonomies;
	}

	public function get_allowed_post_types()
	{
		return $this->allowed_post_types;
	}
}

// Instantiates the plugin
UTCW_Plugin::get_instance();
