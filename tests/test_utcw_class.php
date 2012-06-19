<?php

class UTCW_Test_Class extends WP_UnitTestCase {

	function test_class_exists()
	{
		$this->assertTrue( class_exists( 'UTCW' ) );
	}

	function test_class_inherits_wp_widget()
	{
		$this->assertTrue( new UTCW( '', '' ) instanceof WP_Widget );
	}
}