<?php if ( ! defined( 'ABSPATH' ) ) die();
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.1
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Shortcode extends WP_UnitTestCase {

	/**
	 * @var UTCW_Plugin
	 */
	private $utcw;

	function setUp()
	{
		$this->utcw = UTCW_Plugin::get_instance();
	}

	function test_function_exists()
	{
		$this->assertTrue( method_exists( $this->utcw, 'utcw_shortcode' ) );
	}

	function test_function_returns_html()
	{
		$this->assertRegExp( UTCW_TEST_HTML_REGEX, $this->utcw->utcw_shortcode( array() ) );
	}

	function test_function_no_output()
	{
		$this->expectOutputString( '' );
		$this->utcw->utcw_shortcode( array() );
	}

	function test_function_registered_as_shortcode()
	{
		global $shortcode_tags;
		$this->assertNotNull( $shortcode_tags[ 'utcw' ] );
	}
}