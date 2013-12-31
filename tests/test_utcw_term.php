<?php

if ( ! defined( 'ABSPATH' ) ) die();
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.6
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Tag extends WP_UnitTestCase {

	/**
	 * @var MockFactory
	 */
	private $mockFactory;

	function setUp() {
		$this->mockFactory = new MockFactory( $this );
	}

	function test_term_id_ok()
	{
		$this->helper_int_ok( 'term_id' );
	}

	function test_term_id_fail()
	{
		$this->helper_int_fail( 'term_id' );
	}

	function test_count_ok()
	{
		$this->helper_int_ok( 'count' );
	}

	function test_count_fail()
	{
		$this->helper_int_fail( 'count' );
	}

	function test_slug_ok()
	{
		$this->helper_string_ok( 'slug' );
	}

	function test_slug_fail()
	{
		$this->helper_string_fail( 'slug' );
	}

	function test_name_ok()
	{
		$this->helper_string_ok( 'name' );
	}

	function test_name_fail()
	{
		$this->helper_string_fail( 'name' );
	}

	function test_color_ok()
	{
		$this->helper_string_ok( 'color', '#bada55' );
	}

	function test_color_fail()
	{
		$this->helper_string_fail( 'color', 'invalid color' );
	}

	function test_taxonomy_ok()
	{
		$this->helper_string_ok( 'taxonomy' );
	}

	function test_taxonomy_fail()
	{
		$this->helper_string_fail( 'taxonomy' );
	}

	function test_link_ok()
	{
		$input           = new stdClass;
		$input->term_id  = 10;
		$input->taxonomy = 'post_tag';

		/** @var UTCW_Plugin $utcw  */
		$utcw = $this->mockFactory->getUTCWMock();
        
		$tag = new UTCW_Term( $input, $utcw );
		$this->assertEquals( $utcw->getTermLink( $input->term_id, $input->taxonomy ), $tag->link );
	}

	function test_link_fail()
	{
		$input = new stdClass;

		$tag = new UTCW_Term( $input, $this->mockFactory->getUTCWMock() );
		$this->assertNull( $tag->link );
	}

	function helper_string_fail( $option, $fail_string = '' )
	{
		$input          = new stdClass;
		$input->$option = $fail_string;

		$tag = new UTCW_Term( $input, $this->mockFactory->getUTCWMock() );
		$this->assertNull( $tag->$option );
	}

	function helper_string_ok( $option, $ok_string = 'win' )
	{
		$input          = new stdClass;
		$input->$option = $ok_string;

		$tag = new UTCW_Term( $input, $this->mockFactory->getUTCWMock() );
		$this->assertEquals( $tag->$option, $input->$option );
	}

	function helper_int_ok( $option, $ok_int = 10 )
	{
		$input          = new stdClass;
		$input->$option = $ok_int;

		$tag = new UTCW_Term( $input, $this->mockFactory->getUTCWMock() );
		$this->assertEquals( $tag->$option, $input->$option );
	}

	function helper_int_fail( $option, $fail_int = 'fail' )
	{
		$input          = new stdClass;
		$input->$option = $fail_int;

		$tag = new UTCW_Term( $input, $this->mockFactory->getUTCWMock() );
		$this->assertNull( $tag->$option );
	}
}