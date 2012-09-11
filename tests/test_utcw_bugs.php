<?php

class UTCW_Test_Bugs extends WP_UnitTestCase {

	/**
	 * @var MockFactory
	 */
	private $mockFactory;

	/**
	 * @var DataProvider
	 */
	private $dataProvider;

	function setUp()
	{
		$this->mockFactory  = new MockFactory( $this );
		$this->dataProvider = new DataProvider( $this );
	}

	function test_calc_step_division_by_zero()
	{
		$term          = new stdClass;
		$term->term_id = 1;
		$term->count   = 1;

		$terms = array( $term, $term );

		$data = $this->dataProvider->get_data_object( array(), $terms );
		$data->get_terms();
	}
}