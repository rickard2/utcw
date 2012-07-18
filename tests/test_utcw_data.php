<?php

class testWPDB extends wpdb {

	function prepare( $query, $arguments )
	{
		$query = str_replace( '%s', "'%s'", $query );
		return vsprintf( $query, $arguments );
	}
}

class UTCW_Test_Data extends WP_UnitTestCase {

	protected $utcw;

	function setUp()
	{
		$this->utcw = $this->getMock( 'UTCW_Plugin', array( 'get_allowed_taxonomies', 'get_allowed_post_types' ), array(), '', false );

		$this->utcw->expects( $this->any() )
			->method( 'get_allowed_taxonomies' )
			->will( $this->returnValue( array( 'post_tag', 'category' ) ) );

		$this->utcw->expects( $this->any() )
			->method( 'get_allowed_post_types' )
			->will( $this->returnValue( array( 'post', 'page' ) ) );
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

	function helper_contains( $instance, $string )
	{
		$config = new UTCW_Config( $instance, $this->utcw );
		$db     = $this->getWPDBMock();

		$db->expects( $this->once() )
			->method( 'get_results' )
			->with( $this->stringContains( $string ) );

		$data = new UTCW_Data( $config, $db );
		$data->get_terms();
	}
}
