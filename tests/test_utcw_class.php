<?php

//use Rickard\UTCW\Widget;
//use Rickard\UTCW\Plugin;

if ( ! defined( 'ABSPATH' ) ) die();
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.4
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Class extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists('UTCW_Widget') );
	}

	function test_class_inherits_wp_widget() {
		$this->assertTrue( new UTCW_Widget() instanceof WP_Widget );
	}

	function test_config_class_exists() {
		$this->assertTrue( class_exists('UTCW_Config') );
	}

	function test_class_plugin() {
		$this->assertTrue( class_exists('UTCW_Plugin') );
	}

	function test_plugin_singleton() {
		$utcw = UTCW_Plugin::getInstance();
		$this->assertTrue( $utcw instanceof UTCW_Plugin );
	}

	function test_class_data() {
		$this->assertTrue( class_exists('UTCW_Data') );
	}

	function test_class_render() {
		$this->assertTrue( class_exists('UTCW_Render') );
	}

	function test_class_term() {
		$this->assertTrue( class_exists('UTCW_Term') );
	}
}