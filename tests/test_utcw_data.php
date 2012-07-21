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
		$mock = $this->getMock( 'UTCW_Plugin', array(
													'get_allowed_taxonomies', 'get_allowed_post_types',
													'is_authenticated_user'
											   ), array(), '', false );

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
		$this->helper_query_contains( array( 'taxonomy' => 'category' ), "taxonomy = 'category'" );
	}

	function test_author()
	{
		$this->helper_query_contains( array( 'authors' => array( 1, 2, 3 ) ), 'post_author IN (1,2,3)' );
	}

	function test_single_post_type()
	{
		$this->helper_query_contains( array( 'post_type' => 'post' ), "post_type IN ('post')" );
	}

	function test_multiple_post_types()
	{
		$this->helper_query_contains( array( 'post_type' => array( 'post', 'page' ) ), "post_type IN ('post','page')" );
	}

	function test_post_status_not_authenticated()
	{
		$this->helper_query_contains( array(), "post_status = 'publish'" );
	}

	function test_post_status_authenticated()
	{
		$this->helper_query_contains( array(), "post_status IN ('publish','private')", 'authenticated' );
	}

	function test_tags_list_include()
	{
		$instance = array(
			'tags_list_type' => 'include',
			'tags_list'      => array( 1, 2, 3 ),
		);
		$this->helper_query_contains( $instance, 't.term_id IN (1,2,3)' );
	}

	function test_tags_list_exclude()
	{
		$instance = array(
			'tags_list_type' => 'exclude',
			'tags_list'      => array( 1, 2, 3 ),
		);
		$this->helper_query_contains( $instance, 't.term_id NOT IN (1,2,3)' );
	}

	function test_days_old()
	{
		$this->helper_query_contains( array( 'days_old' => 1 ), "post_date > '" . date( 'Y-m-d', strtotime( 'yesterday' ) ) . "'" );
	}

	function test_minimum()
	{
		$this->helper_query_contains( array( 'minimum' => 5 ), 'HAVING count >= 5' );
	}

	function test_order_name()
	{
		$this->helper_query_contains( array( 'order' => 'name', 'reverse' => false ), 'ORDER BY name ASC' );
	}

	function test_order_name_reverse()
	{
		$this->helper_query_contains( array( 'order' => 'name', 'reverse' => true ), 'ORDER BY name DESC' );
	}

	function test_order_name_case_sensitive()
	{
		$this->helper_query_contains( array(
										   'order'        => 'name', 'case_sensitive' => true
									  ), 'ORDER BY BINARY name ASC' );
	}

	function test_order_slug()
	{
		$this->helper_query_contains( array( 'order' => 'slug', 'reverse' => false ), 'ORDER BY slug ASC' );
	}

	function test_order_slug_reverse()
	{
		$this->helper_query_contains( array( 'order' => 'slug', 'reverse' => true ), 'ORDER BY slug DESC' );
	}

	function test_order_slug_case_sensitive()
	{
		$this->helper_query_contains( array(
										   'order'        => 'slug', 'case_sensitive' => true
									  ), 'ORDER BY BINARY slug ASC' );
	}

	function test_order_id()
	{
		$this->helper_query_contains( array( 'order' => 'id', 'reverse' => false ), 'ORDER BY term_id ASC' );
	}

	function test_order_id_reverse()
	{
		$this->helper_query_contains( array( 'order' => 'id', 'reverse' => true ), 'ORDER BY term_id DESC' );
	}

	function test_order_count()
	{
		$this->helper_query_contains( array( 'order' => 'count', 'reverse' => false ), 'ORDER BY count ASC' );
	}

	function test_order_count_reverse()
	{
		$this->helper_query_contains( array( 'order' => 'count', 'reverse' => true ), 'ORDER BY count DESC' );
	}

	/**
	 * @param array $query_terms
	 *
	 * @dataProvider terms
	 */
	function test_size( $query_terms )
	{
		$instance = array(
			'size_from' => 1,
			'size_to'   => 10,
		);

		$terms = $this->helper_get_terms( $instance, $query_terms );

		foreach ( $terms as $term ) {
			$this->assertLessThanOrEqual( 10, $term->size );
			$this->assertGreaterThanOrEqual( 1, $term->size );
		}
	}

	/**
	 * @param array $query_terms
	 *
	 * @dataProvider terms
	 */
	function test_color_random( $query_terms )
	{
		$terms = $this->helper_get_terms( array( 'color' => 'random' ), $query_terms );

		foreach ( $terms as $term ) {
			$this->assertNotEmpty( $term->color );
		}
	}

	/**
	 * @param array $query_terms
	 *
	 * @dataProvider terms
	 */
	function test_color_set( $query_terms )
	{
		$color_set = array( '#fafafa', '#bada55', '#123456' );

		$instance = array(
			'color'     => 'set',
			'color_set' => $color_set,
		);

		$terms = $this->helper_get_terms( $instance, $query_terms );

		foreach ( $terms as $term ) {
			$this->assertContains( $term->color, $color_set );
		}
	}

	/**
	 * @param array $query_terms
	 *
	 * @dataProvider terms
	 */
	function test_color_span_smallest_first( $query_terms )
	{
		$instance = array(
			'color'           => 'span',
			'color_span_from' => '#222222',
			'color_span_to'   => '#333333',
		);

		$colors = new stdClass;

		$colors->red_from = $colors->green_from = $colors->blue_from = 0x22;
		$colors->red_to   = $colors->green_to = $colors->blue_to = 0x33;

		$this->helper_test_color_span( $instance, $colors, $query_terms );
	}

	/**
	 * @param array $query_terms
	 *
	 * @dataProvider terms
	 */
	function test_color_span_biggest_first( $query_terms )
	{
		$instance = array(
			'color'           => 'span',
			'color_span_from' => '#333333',
			'color_span_to'   => '#222222',
		);

		$colors = new stdClass;

		$colors->red_from = $colors->green_from = $colors->blue_from = 0x22;
		$colors->red_to   = $colors->green_to = $colors->blue_to = 0x33;

		$this->helper_test_color_span( $instance, $colors, $query_terms );
	}

	/**
	 * @param array $query_terms
	 *
	 * @dataProvider terms
	 */
	function test_color_span_letters( $query_terms )
	{
		$instance = array(
			'color'           => 'span',
			'color_span_from' => '#bbbbbb',
			'color_span_to'   => '#dddddd',
		);

		$colors = new stdClass;

		$colors->red_from = $colors->green_from = $colors->blue_from = 0xbb;
		$colors->red_to   = $colors->green_to = $colors->blue_to = 0xdd;

		$this->helper_test_color_span( $instance, $colors, $query_terms );
	}

	/**
	 * @param array $query_terms
	 *
	 * @dataProvider terms
	 */
	function test_color_span( $query_terms )
	{
		$instance = array(
			'color'           => 'span',
			'color_span_from' => '#D010EB',
			'color_span_to'   => '#999999',
		);

		$colors = new stdClass;

		$colors->red_from   = 0x99;
		$colors->green_from = 0x10;
		$colors->blue_from  = 0x99;

		$colors->red_to   = 0xd0;
		$colors->green_to = 0x99;
		$colors->blue_to  = 0xeb;

		$this->helper_test_color_span( $instance, $colors, $query_terms );
	}

	function helper_test_color_span( $instance, $colors, $query_terms )
	{

		$terms = $this->helper_get_terms( $instance, $query_terms );

		foreach ( $terms as $term ) {

			$matches = preg_match_all( "/[0-9a-f]{2}/i", $term->color, $rgb_matches );

			$this->assertEquals( 3, $matches, 'Term color should always be in six digit hexadecimal value colors' );

			list( $red, $green, $blue ) = array_map( 'hexdec', $rgb_matches[ 0 ] );

			$this->assertLessThanOrEqual( $colors->red_to, $red );
			$this->assertGreaterThanOrEqual( $colors->red_from, $red );

			$this->assertLessThanOrEqual( $colors->green_to, $green );
			$this->assertGreaterThanOrEqual( $colors->green_from, $green );

			$this->assertLessThanOrEqual( $colors->blue_to, $blue );
			$this->assertGreaterThanOrEqual( $colors->blue_from, $blue );
		}
	}

	function helper_get_terms( $instance, $query_terms )
	{
		$config = new UTCW_Config( $instance, $this->utcw_authenticated );
		$db     = $this->getWPDBMock();

		$db->expects( $this->once() )
			->method( 'get_results' )
			->will( $this->returnValue( $query_terms ) );

		$data = new UTCW_Data( $config, $db );
		return $data->get_terms();
	}

	function helper_query_contains( $instance, $string, $authenticated = false )
	{
		$utcw = $authenticated ? $this->utcw_authenticated : $this->utcw_not_authenticated;

		$config = new UTCW_Config( $instance, $utcw );
		$db     = $this->getWPDBMock();

		$db->expects( $this->once() )
			->method( 'get_results' )
			->will( $this->returnValue( array() ) )
			->with( $this->stringContains( $string ) );

		$data = new UTCW_Data( $config, $db );
		$data->get_terms();
	}

	function terms()
	{
		$terms = array();

		for ( $x = 0; $x < 10; $x ++ ) {
			$term = new stdClass;

			$term->term_id = $x;
			$term->name    = 'Test term ' . $x;
			$term->slug    = 'term-' . $x;
			$term->count   = $x * 10;

			$terms[ ] = $term;
		}

		return array( array( $terms ) );
	}
}
