<?php if ( ! defined( 'ABSPATH' ) ) die();
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.0
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Constants extends WP_UnitTestCase {

	function test_utcw_dev_defined() {
		$this->assertTrue( defined( 'UTCW_DEV' ) );
	}

	function test_utcw_version_defined() {
		$this->assertTrue( defined( 'UTCW_VERSION' ) );
	}

	function test_utcw_hex_color_regex_defined() {
		$this->assertTrue( defined( 'UTCW_HEX_COLOR_REGEX' ) );
	}

	function test_utcw_hex_format_regex_defined() {
		$this->assertTrue( defined( 'UTCW_HEX_COLOR_FORMAT' ) );
	}

	function test_utcw_dev_false() {
		$this->assertFalse( UTCW_DEV, 'Reset UTCW_DEV to false before committing' );
	}
}