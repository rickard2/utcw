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
		$this->assertRegExp( '/^<div class="widget_tag_cloud utcw-[0-9a-z]+">.*<\/div>$/i', $render->get_cloud() );
	}

	function test_wrapper_is_inside_widget()
	{
		$this->helper_contains( array( 'before_widget' => 'BEFORE_WIDGET' ), 'BEFORE_WIDGET<div class="' );
	}

	function test_defaults_outputs_no_css()
	{
		$this->helper_not_contains( array(), '<style' );
	}

	function test_return_value_and_output_is_equal()
	{
		$render = $this->getRenderer();
		$this->expectOutputString( $render->get_cloud() );
		$render->render();
	}

	function test_output_contains_css()
	{
		$this->helper_contains( array( 'text_transform' => 'capitalize' ), '<style type="text/css">' );
	}

	function test_text_transform()
	{
		$this->helper_contains( array( 'text_transform' => 'capitalize' ), 'text-transform:capitalize' );
	}

	function test_letter_spacing()
	{
		$this->helper_contains( array( 'letter_spacing' => 10 ), 'letter-spacing:10px' );
	}

	function test_word_spacing()
	{
		$this->helper_contains( array( 'word_spacing' => 10 ), 'word-spacing:10px' );
	}

	function test_link_underline()
	{
		$this->helper_contains( array( 'link_underline' => 'yes' ), 'a{text-decoration:underline' );
	}

	function test_link_bold()
	{
		$this->helper_contains( array( 'link_bold' => 'yes' ), 'a{font-weight:bold' );
	}

	function test_link_italic()
	{
		$this->helper_contains( array( 'link_italic' => 'yes' ), 'a{font-style:italic' );
	}

	function test_link_bg_color()
	{
		$this->helper_contains( array( 'link_bg_color' => '#bada55' ), 'a{background-color:#bada55' );
	}

	function test_link_border_style()
	{
		$this->helper_contains( array( 'link_border_style' => 'groove' ), 'a{border-style:groove' );
	}

	function test_link_border_width()
	{
		$this->helper_contains( array( 'link_border_width' => 10 ), 'a{border-width:10px' );
	}

	function test_link_border_color()
	{
		$this->helper_contains( array( 'link_border_color' => '#bada55' ), 'a{border-color:#bada55' );
	}

	function test_hover_underline()
	{
		$this->helper_contains( array( 'hover_underline' => 'yes' ), 'a:hover{text-decoration:underline' );
	}

	function test_hover_bold()
	{
		$this->helper_contains( array( 'hover_bold' => 'yes' ), 'a:hover{font-weight:bold' );
	}

	function test_hover_italic()
	{
		$this->helper_contains( array( 'hover_italic' => 'yes' ), 'a:hover{font-style:italic' );
	}

	function test_hover_bg_color()
	{
		$this->helper_contains( array( 'hover_bg_color' => '#bada55' ), 'a:hover{background-color:#bada55' );
	}

	function test_hover_border_style()
	{
		$this->helper_contains( array( 'hover_border_style' => 'groove' ), 'a:hover{border-style:groove' );
	}

	function test_hover_border_width()
	{
		$this->helper_contains( array( 'hover_border_width' => 10 ), 'a:hover{border-width:10px' );
	}

	function test_hover_border_color()
	{
		$this->helper_contains( array( 'hover_border_color' => '#bada55' ), 'a:hover{border-color:#bada55' );
	}

	function test_hover_border_shorthand()
	{
		$this->helper_contains(
			array(
				 'hover_border_style' => 'groove',
				 'hover_border_width' => 10,
				 'hover_border_color' => '#bada55',
			),
			'a:hover{border:groove 10px #bada55'
		);
	}

	function test_tag_spacing()
	{
		$this->helper_contains( array( 'tag_spacing' => 10 ), 'a{margin-right:10px' );
	}

	function test_line_height()
	{
		$this->helper_contains( array( 'line_height' => 10 ), 'a{line-height:10px' );
	}

	function test_before_widget()
	{
		$this->helper_contains( array( 'before_widget' => '<section>' ), '<section>' );
	}

	function test_after_widget()
	{
		$this->helper_contains( array( 'after_widget' => '</section>' ), '</section>' );
	}

	function test_before_title()
	{
		$this->helper_contains( array( 'before_title' => '<h1>' ), '<h1>' );
	}

	function test_after_title()
	{
		$this->helper_contains( array( 'after_title' => '</h1>' ), '</h1>' );
	}

	function test_title()
	{
		$this->helper_contains( array( 'title' => 'Hello World!' ), 'Hello World!' );
	}

	function test_show_title_text()
	{
		$this->helper_not_contains(
			array(
				 'show_title_text' => false,
				 'title'           => 'Hello World!',
			),
			'Hello World!'
		);
	}

	function test_title_wrapped()
	{
		$this->helper_contains(
			array(
				 'before_title' => '<h1>',
				 'title'        => 'Hello World!',
				 'after_title'  => '</h1>'
			),
			'<h1>Hello World!</h1>'
		);
	}

	function test_no_title_no_wrapper()
	{
		$this->helper_not_contains(
			array(
				 'show_title_text' => false,
				 'before_title'    => 'Hello World!',
				 'after_title'     => 'Hello World!',
			),
			'Hello World!'
		);
	}

	function helper_contains( $config, $string )
	{
		$render = $this->getRenderer( $config );
		$this->assertContains( $string, $render->get_cloud() );
	}

	function helper_not_contains( $config, $string )
	{
		$render = $this->getRenderer( $config );
		$this->assertNotContains( $string, $render->get_cloud() );
	}
}