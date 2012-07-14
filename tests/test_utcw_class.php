<?php

class UTCW_Test_Class extends WP_UnitTestCase {

	function test_class_exists()
	{
		$this->assertTrue( class_exists( 'UTCW' ) );
	}

	function test_class_inherits_wp_widget()
	{
		$this->assertTrue( new UTCW( '', '' ) instanceof WP_Widget );
	}

	function test_config_class_exists() {
		$this->assertTrue( class_exists( 'UTCW_Config') );
	}

	function test_class_plugin() {
		$this->assertTrue( class_exists( 'UTCW_Plugin') );
	}

	function test_plugin_singleton() {
		$utcw = UTCW_Plugin::get_instance();
		$this->assertTrue( $utcw instanceof UTCW_Plugin );
	}
}