<?php

require 'utcw.php';

class testWPDB extends wpdb {

	function prepare( $query, $arguments ) {
		$query = str_replace( '%s', "'%s'", $query );
		return vsprintf( $query, $arguments );
	}
}

class MockFactory {

	/**
	 * @var WP_UnitTestCase
	 */
	private $testCase;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject
	 */
	protected $utcw_not_authenticated;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject
	 */
	protected $utcw_authenticated;

	function __construct( WP_UnitTestCase $testcase ) {
		$this->testCase = $testcase;

		$this->utcw_not_authenticated = $this->getUTCWMock();

		$this->utcw_not_authenticated->expects( $this->testCase->any() )
			->method( 'is_authenticated_user' )
			->will( $this->testCase->returnValue( false ) );

		$this->utcw_authenticated = $this->getUTCWMock();

		$this->utcw_authenticated->expects( $this->testCase->any() )
			->method( 'is_authenticated_user' )
			->will( $this->testCase->returnValue( true ) );
	}

	function getUTCWNotAuthenticated() {
		return $this->utcw_not_authenticated;
	}

	function getUTCWAuthenticated() {
		return $this->utcw_authenticated;
	}

	function getUTCWMock() {
		$mock = $this->testCase->getMock(
			'UTCW_Plugin',
			array(
				 'get_allowed_taxonomies',
				 'get_allowed_post_types',
				 'is_authenticated_user',
				 'get_term_link',
				 'check_term_taxonomy',
			),
			array(),
			'',
			false
		);

		$mock->expects( $this->testCase->any() )
			->method( 'get_allowed_taxonomies' )
			->will( $this->testCase->returnValue( array( 'post_tag', 'category' ) ) );

		$mock->expects( $this->testCase->any() )
			->method( 'get_allowed_post_types' )
			->will( $this->testCase->returnValue( array( 'post', 'page' ) ) );

		$mock->expects( $this->testCase->any() )
			->method( 'get_term_link' )
			->will( $this->testCase->returnValue( 'http://example.com/' ) );

		return $mock;
	}

	function getWPDBMock() {
		return $this->testCase->getMock( 'testWPDB', array( 'get_results' ), array(), '', false );
	}
}

class DataProvider {

	/**
	 * @var MockFactory
	 */
	private $mockFactory;

	/**
	 * @var WP_UnitTestCase
	 */
	private $testCase;

	function __construct( WP_UnitTestCase $testCase ) {
		$this->mockFactory = new MockFactory( $testCase );
		$this->testCase    = $testCase;
	}

	function termsProvider( $count = 10 ) {
		$terms = array();
		$count ++;

		for ( $x = 1; $x < $count; $x ++ ) {
			$term = new stdClass;

			$term->term_id = $x;
			$term->name    = 'Test term ' . $x;
			$term->slug    = 'term-' . $x;
			$term->count   = $x * 10;

			$terms[ ] = $term;
		}

		return array( array( $terms ) );
	}

	function get_terms( array $instance, array $query_terms ) {
		$data = $this->get_data_object( $instance, $query_terms );
		return $data->get_terms();
	}

	function get_renderer( array $instance, array $query_terms ) {
		return new UTCW_Render( $this->get_config( $instance ), $this->get_data_object( $instance, $query_terms ) );
	}

	function get_config( array $instance ) {
		return new UTCW_Config( $instance, $this->mockFactory->getUTCWAuthenticated() );
	}

	function get_data_object( array $instance, array $query_terms ) {

		$config = $this->get_config( $instance );
		$db     = $this->mockFactory->getWPDBMock();

		$db->expects( $this->testCase->any() )
			->method( 'get_results' )
			->will( $this->testCase->returnValue( $query_terms ) );

		return new UTCW_Data( $config, $this->mockFactory->getUTCWMock(), $db );
	}
}

define( 'UTCW_TEST_HTML_REGEX', '/<[a-z]+/i' );