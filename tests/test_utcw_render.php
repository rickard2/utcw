<?php

class UTCW_Test_Render extends WP_UnitTestCase {

	/**
	 * @var DataProvider
	 */
	private $dataProvider;

	function setUp()
	{
		$this->dataProvider = new DataProvider( $this );
	}

	function getRenderer( $input = array(), $query_terms = array() )
	{
		return $this->dataProvider->get_renderer( $input, $query_terms );
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

	function test_hover_color() {
		$this->helper_contains( array( 'hover_color' => '#bada55'), 'a:hover{color:#bada55' );
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

	/**
	 * @dataProvider terms
	 */
	function test_separator( $terms )
	{
		$instance = array( 'separator' => 'SEPARATOR' );

		$expected = count( $terms ) - 1;

		$this->helper_substr_count( $instance, 'SEPARATOR', $terms, $expected );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_prefix( $terms )
	{
		$instance = array( 'prefix' => 'PREFIX' );
		$this->helper_substr_count( $instance, 'PREFIX', $terms, count( $terms ) );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_suffix( $terms )
	{
		$instance = array( 'suffix' => 'SUFFIX' );
		$this->helper_substr_count( $instance, 'SUFFIX', $terms, count( $terms ) );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_prefix_separator_suffix_placement( $terms )
	{
		$instance = array(
			'prefix'    => 'PREFIX',
			'separator' => 'SEPARATOR',
			'suffix'    => 'SUFFIX',
		);

		$renderer = $this->getRenderer( $instance, $terms );
		$this->assertEquals( 9, preg_match_all( '/PREFIX<a[^>]+>Test term [0-9]+<\/a>SUFFIXSEPARATOR/', $renderer->get_cloud(), $dummy ) );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_show_title_shows_title( $terms )
	{
		$instance = array( 'show_title' => true );
		$renderer = $this->getRenderer( $instance, $terms );
		$this->assertRegExp( '/title="[0-9]+ topics?"/', $renderer->get_cloud() );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_hide_title_hides_title( $terms )
	{
		$instance = array( 'show_title' => false );
		$renderer = $this->getRenderer( $instance, $terms );
		$this->assertNotRegExp( '/title="[0-9]+ topics?"/', $renderer->get_cloud() );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_output_links_contains_class( $terms )
	{
		$renderer = $this->getRenderer( array(), $terms );
		$this->assertRegexp( '/class="tag-link-[0-9]+"/', $renderer->get_cloud() );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_output_contains_color( $terms )
	{
		$renderer = $this->getRenderer( array( 'color' => 'random' ), $terms );
		$this->assertRegexp( '/;color:#[0-9a-f]{6}"/', $renderer->get_cloud() );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_output_contains_size( $terms )
	{
		$renderer = $this->getRenderer( array(), $terms );
		$this->assertRegExp( '/style="font-size:[0-9.]+px"/', $renderer->get_cloud() );
	}

	/**
	 * @param $terms
	 *
	 * @dataProvider terms
	 */
	function test_output_contains_href( $terms )
	{
		$renderer = $this->getRenderer( array(), $terms );
		$this->assertRegexp( '/href="http:\/\/example.com\/"/', $renderer->get_cloud() );
	}

	function terms()
	{
		$dp = new DataProvider( $this );
		return $dp->termsProvider();
	}

	function helper_substr_count( $config, $needle, $terms, $expected )
	{
		$renderer = $this->getRenderer( $config, $terms );
		$this->assertEquals( $expected, substr_count( $renderer->get_cloud(), $needle ) );
	}

	function helper_contains( $config, $needle )
	{
		$render = $this->getRenderer( $config );
		$this->assertContains( $needle, $render->get_cloud() );
	}

	function helper_not_contains( $config, $needle )
	{
		$render = $this->getRenderer( $config );
		$this->assertNotContains( $needle, $render->get_cloud() );
	}
}