<?php
/**
 * @todo Documentation
 */

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
		$config = new UTCW_Config( $new_instance, UTCW_Plugin::get_instance() );

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
		$config = new UTCW_Config( $instance, UTCW_Plugin::get_instance() );

		/** @noinspection PhpUnusedLocalVariableInspection */
		$configurations = get_option( 'utcw_saved_configs' );

		$args = array( 'public' => true );

		/** @noinspection PhpUnusedLocalVariableInspection */
		$available_post_types = get_post_types( $args );
		/** @noinspection PhpUnusedLocalVariableInspection */
		$available_taxonomies = get_taxonomies( array(), 'objects' );

		$terms = array();

		foreach ( $available_taxonomies as $taxonomy ) {
			$terms[ $taxonomy->name ] = get_terms( $taxonomy->name );
		}

		// Content of the widget settings form
		require 'pages/settings.php';
	}

	/**
	 * Function for rendering the widget
	 *
	 * @param array $args
	 *
	 * @param array $instance
	 */
	function widget( array $args, array $instance )
	{
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
}

add_action( 'widgets_init', create_function( '', 'return register_widget("UTCW");' ) );