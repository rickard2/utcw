<?php

class testWPDB extends wpdb {

	function prepare( $query, $arguments )
	{
		$query = str_replace( '%s', "'%s'", $query );
		return vsprintf( $query, $arguments );
	}
}

class UTCW_Test_Data extends WP_UnitTestCase {

	protected $utcw_not_authenticated;
	protected $utcw_authenticated;

	function setUp()
	{

		$this->utcw_not_authenticated = $this->getUTCWMock();

		$this->utcw_not_authenticated->expects( $this->any() )
			->method( 'is_authenticated_user' )
			->will( $this->returnValue( false ) );

		$this->utcw_authenticated = $this->getUTCWMock();

		$this->utcw_authenticated->expects( $this->any() )
			->method( 'is_authenticated_user' )
			->will( $this->returnValue( true ) );
	}

	function getUTCWMock()
	{
		$mock = $this->getMock( 'UTCW_Plugin', array( 'get_allowed_taxonomies', 'get_allowed_post_types', 'is_authenticated_user' ), array(), '', false );

		$mock->expects( $this->any() )
			->method( 'get_allowed_taxonomies' )
			->will( $this->returnValue( array( 'post_tag', 'category' ) ) );

		$mock->expects( $this->any() )
			->method( 'get_allowed_post_types' )
			->will( $this->returnValue( array( 'post', 'page' ) ) );

		return $mock;
	}

	function getWPDBMock()
	{
		return $this->getMock( 'testWPDB', array( 'get_results' ), array(), '', false );
	}

	function test_taxonomy()
	{
		$this->helper_contains( array( 'taxonomy' => 'category' ), "taxonomy = 'category'" );
	}

	function test_author()
	{
		$this->helper_contains( array( 'authors' => array( 1, 2, 3 ) ), 'post_author IN (1,2,3)' );
	}

	function test_single_post_type()
	{
		$this->helper_contains( array( 'post_type' => 'post' ), "post_type IN ('post')" );
	}

	function test_multiple_post_types()
	{
		$this->helper_contains( array( 'post_type' => array( 'post', 'page' ) ), "post_type IN ('post','page')" );
	}

	function test_post_status_not_authenticated()
	{
		$this->helper_contains( array(), "post_status = 'publish'" );
	}

	function test_post_status_authenticated()
	{
		$this->helper_contains( array(), "post_status IN ('publish','private')", 'authenticated' );
	}

	function test_tags_list_include()
	{
		$instance = array(
			'tags_list_type' => 'include',
			'tags_list'      => array( 1, 2, 3 ),
		);
		$this->helper_contains( $instance, 't.term_id IN (1,2,3)' );
	}

	function test_tags_list_exclude()
	{
		$instance = array(
			'tags_list_type' => 'exclude',
			'tags_list'      => array( 1, 2, 3 ),
		);
		$this->helper_contains( $instance, 't.term_id NOT IN (1,2,3)' );
	}

	function helper_contains( $instance, $string, $authenticated = false )
	{
		$utcw = $authenticated ? $this->utcw_authenticated : $this->utcw_not_authenticated;

		$config = new UTCW_Config( $instance, $utcw );
		$db     = $this->getWPDBMock();

		$db->expects( $this->once() )
			->method( 'get_results' )
			->with( $this->stringContains( $string ) );

		$data = new UTCW_Data( $config, $db );
		$data->get_terms();
	}
}
