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

class UTCW extends WP_Widget {

	/**
	 * Constructor
	 * @return UTCW
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
	 */
	function update( $new_instance, $old_instance )
	{

		$config = new UTCW_Config( $new_instance );

		return $config->getInstance();
	}
}