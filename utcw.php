<?php if ( ! defined( 'ABSPATH' ) ) die();
/*
Plugin Name: Ultimate tag cloud widget
Plugin URI: http://www.0x539.se/wordpress/ultimate-tag-cloud-widget/
Description: This plugin aims to be the most configurable tag cloud widget out there, able to suit all your weird tag cloud needs.
Version: 2.0 alpha
Author: Rickard Andersson
Author URI: http://www.0x539.se
License: GPLv2
*/

require 'utcw-config.php';

/**
 * @since 1.0
 */
class UTCW extends WP_Widget {

	/**
	 * Constructor
	 * @return UTCW
	 * @since 1.0
	 */
	function __construct()
	{
		$options = array( 'description' => __( 'Highly configurable tag cloud', 'utcw' ) );
		parent::WP_Widget( false, __( 'Ultimate Tag Cloud', 'utcw' ), $options );
	}

	/**
	 * Action handler for the form in the admin panel
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 * @since 1.0
	 */
	function update( array $new_instance, array $old_instance )
	{

		$config = new UTCW_Config( $new_instance );

		return $config->get_instance();
	}

	/**
	 * Function for handling the widget control in admin panel
	 *
	 * @param array $instance
	 *
	 * @return void|string
	 * @since 1.0
	 */
	function form( array $instance )
	{

		/** @noinspection PhpUnusedLocalVariableInspection */
		$config = new UTCW_Config( $instance );

		/** @noinspection PhpUnusedLocalVariableInspection */
		$configurations = get_option( 'utcw_saved_configs' );

		$args = array( 'public' => true );

		/** @noinspection PhpUnusedLocalVariableInspection */
		$available_post_types = get_post_types( $args );
		/** @noinspection PhpUnusedLocalVariableInspection */
		$available_taxonomies = get_taxonomies();

		// Content of the widget settings form
		require 'pages/settings.php';
	}

	/**
	 * FUnction for rendering the widget
	 *
	 * @param array $args
	 *
	 * @param array $instance
	 */
	function widget( array $args, array $instance )
	{
	}
}