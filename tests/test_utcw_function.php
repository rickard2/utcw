<?php
//use Rickard\UTCW\Plugin;

if ( ! defined( 'ABSPATH' ) ) die();
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Function extends WP_UnitTestCase {

	function test_function_exists() {
		$this->assertTrue( function_exists('do_utcw') );
	}

	function test_function_outputs_html() {
		$this->expectOutputRegex( UTCW_TEST_HTML_REGEX );
		do_utcw( array() );
	}

	function test_function_and_shortcode_is_equal() {
		$utcw = UTCW_Plugin::getInstance();
		$this->expectOutputString( $utcw->shortcode( array() ) );
		do_utcw( array() );
	}

}