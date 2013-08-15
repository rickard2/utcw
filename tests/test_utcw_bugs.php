<?php
////use Rickard\UTCW\Widget;

if ( ! defined( 'ABSPATH' ) ) die();
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3.1
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Bugs extends WP_UnitTestCase {

	/**
	 * @var MockFactory
	 */
	private $mockFactory;

	/**
	 * @var DataProvider
	 */
	private $dataProvider;

	function setUp() {
		$this->mockFactory  = new MockFactory( $this );
		$this->dataProvider = new DataProvider( $this );
	}

	function test_calc_step_division_by_zero() {
		$term          = new stdClass;
		$term->term_id = 1;
		$term->count   = 1;

		$terms = array( $term, $term );

		$data = $this->dataProvider->get_data_object( array(), $terms );
		$data->getTerms();
	}

	/**
	 * When $args and $instance is merged, make sure that the $args values have precedence,
	 * otherwise $instance might overwrite before_widget, after_widget, etc
	 */
	function test_merge_args_instance_order() {
		$widget = new UTCW_Widget();

		$args     = array( 'before_widget' => 'Hello World' );
		$instance = array( 'before_widget' => 'Goodbye World' );

		$this->expectOutputRegex( '/Hello World/' );

		$widget->widget( $args, $instance );
	}
}