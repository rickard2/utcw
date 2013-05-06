<?php

//use Rickard\UTCW\Widget;
//use Rickard\UTCW\Plugin;

if ( ! defined( 'ABSPATH' ) ) die();
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Class extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'Widget' ) );
	}

	function test_class_inherits_wp_widget() {
		$this->assertTrue( new Widget() instanceof WP_Widget );
	}

	function test_config_class_exists() {
		$this->assertTrue( class_exists( 'Config' ) );
	}

	function test_class_plugin() {
		$this->assertTrue( class_exists( 'Plugin' ) );
	}

	function test_plugin_singleton() {
		$utcw = Plugin::getInstance();
		$this->assertTrue( $utcw instanceof Plugin );
	}

	function test_class_data() {
		$this->assertTrue( class_exists( 'Data' ) );
	}

	function test_class_render() {
		$this->assertTrue( class_exists( 'Render' ) );
	}

	function test_class_term() {
		$this->assertTrue( class_exists( 'Term' ) );
	}
}