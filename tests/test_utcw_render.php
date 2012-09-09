<?php

class UTCW_Test_Render extends WP_UnitTestCase {

	function getWPDBMock()
	{
		return $this->getMock( 'testWPDB', array( 'get_results' ), array(), '', false );
	}

	function getRenderer( $input = array() )
	{
		$config = new UTCW_Config( $input, UTCW_Plugin::get_instance() );
		$data   = new UTCW_Data( $config, $this->getWPDBMock() );
		return new UTCW_Render( $config, $data );
	}

	function test_output_contains_wrapper()
	{
		$render = $this->getRenderer();
		$this->assertRegExp( '/^<div class="utcw-[0-9]+">.*<\/div>$/i', $render->get_cloud() );
	}

	function test_defaults_outputs_no_css()
	{
		$render = $this->getRenderer();
		$this->assertNotContains( '<style', $render->get_cloud() );
	}

	function test_output_contains_css()
	{
		$render = $this->getRenderer( array( 'text_transform' => 'capitalize' ) );
		$this->assertContains( '<style type="text/css">', $render->get_cloud() );
	}

	function test_text_transform()
	{
		$render = $this->getRenderer( array( 'text_transform' => 'capitalize' ) );
		$this->assertContains( 'text-transform:capitalize', $render->get_cloud() );
	}
}