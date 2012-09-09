<?php
/**
 * @todo Documentation
 */

/**
 * @since 1.0
 */
class UTCW extends WP_Widget {

	/**
	 * @var UTCW_Plugin
	 */
	private $plugin;

	/**
	 * Constructor
	 * @return UTCW
	 * @since 1.0
	 */
	function __construct()
	{
		$options = array( 'description' => __( 'Highly configurable tag cloud', 'utcw' ) );
		parent::WP_Widget( false, __( 'Ultimate Tag Cloud', 'utcw' ), $options );

		$this->plugin = UTCW_Plugin::get_instance();
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
		$config = new UTCW_Config( $new_instance, $this->plugin );
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
		$config = new UTCW_Config( $instance, $this->plugin );
		/** @noinspection PhpUnusedLocalVariableInspection */
		$configurations = $this->plugin->get_configurations();
		/** @noinspection PhpUnusedLocalVariableInspection */
		$available_post_types = $this->plugin->get_allowed_post_types();
		/** @noinspection PhpUnusedLocalVariableInspection */
		$available_taxonomies = $this->plugin->get_allowed_taxonomies_objects();
		/** @noinspection PhpUnusedLocalVariableInspection */
		$users = $this->plugin->get_users();
		/** @noinspection PhpUnusedLocalVariableInspection */
		$terms = $this->plugin->get_terms();

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
		global $wpdb;

		$input = array_merge( $args, $instance );

		$config = new UTCW_Config( $input, $this->plugin );
		$data   = new UTCW_Data( $config, $wpdb );
		$render = new UTCW_Render( $config, $data );

		$render->render();
	}
}