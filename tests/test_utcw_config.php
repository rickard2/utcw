<?php

class UTCW_Test_Config extends WP_UnitTestCase {

	protected $utcw;

	function setUp()
	{
		$this->utcw = UTCW_Plugin::get_instance();
	}

	function test_config_defaults()
	{
		$config   = new UTCW_Config( array(), $this->utcw );
		$options  = $config->get_defaults();
		$instance = $config->get_instance();

		$this->assertEquals( $options, $instance );
	}

	function test_title_ok()
	{
		$this->helper_string_ok( 'title' );
	}

	function test_title_fail()
	{
		$this->helper_string_fail( 'title' );
	}

	function test_order_ok()
	{
		$this->helper_string_ok( 'order', 'count' );
	}

	function test_order_fail()
	{
		$this->helper_string_fail( 'order', 'invalid order' );
	}

	function test_size_ok()
	{
		$instance = array(
			'size_from' => 10,
			'size_to'   => 100,
		);

		$config = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $instance[ 'size_from' ], $config->size_from );
		$this->assertEquals( $instance[ 'size_to' ], $config->size_to );
	}

	function test_size_equal_ok() {
		$instance = array(
			'size_from' => 100,
			'size_to'   => 100,
		);

		$config = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $instance[ 'size_from' ], $config->size_from );
		$this->assertEquals( $instance[ 'size_to' ], $config->size_to );
	}

	function test_size_from_fail()
	{
		$this->helper_int_fail( 'size_from', 100, 'You always need to submit both size_from and size_to' );
	}

	function test_size_to_fail()
	{
		$this->helper_int_fail( 'size_to', 100, 'You always need to submit both size_from and size_to' );
	}

	function test_size_wrong_order_fail()
	{
		$instance = array(
			'size_from' => 100,
			'size_to'   => 10,
		);

		$config = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $instance[ 'size_from' ], $config->size_from, 'Size from should always be lower than size to' );
		$this->assertNotEquals( $instance[ 'size_to' ], $config->size_to, 'Size from should always be lower than size to' );
	}

	function test_max_ok()
	{
		$this->helper_int_ok( 'max' );
	}

	function test_max_fail()
	{
		$this->helper_int_fail( 'max' );
	}

	function test_max_zero_fail()
	{
		$this->helper_int_fail( 'max', 0 );
	}

	function test_reverse_ok()
	{
		$this->helper_bool_ok( 'reverse' );
	}

	function test_reverse_fail()
	{
		$this->helper_bool_fail( 'reverse' );
	}

	function test_taxonomy_ok()
	{
		$this->helper_string_ok( 'taxonomy', 'post_tag' );
	}

	function test_taxonomy_fail()
	{
		$this->helper_string_fail( 'taxonomy', 'invalid taxonomy' );
	}

	function test_color_ok()
	{
		$this->helper_string_ok( 'color', 'random' );
	}

	function test_color_fail()
	{
		$this->helper_string_fail( 'color', 'invalid color' );
	}

	function test_letter_spacing_ok()
	{
		$this->helper_int_ok( 'letter_spacing' );
	}

	function test_letter_spacing_fail()
	{
		$this->helper_int_fail( 'letter_spacing' );
	}

	function test_word_spacing_ok()
	{
		$this->helper_int_ok( 'word_spacing' );
	}

	function test_word_spacing_fail()
	{
		$this->helper_int_fail( 'word_spacing' );
	}

	function test_text_transform_ok()
	{
		$this->helper_string_ok( 'text_transform', 'capitalize' );
	}

	function test_case_fail()
	{
		$this->helper_string_fail( 'text_transform', 'invalid text_transform' );
	}

	function test_case_sensitive_ok()
	{
		$this->helper_bool_ok( 'case_sensitive' );
	}

	function test_case_sensitive_fail()
	{
		$this->helper_bool_fail( 'case_sensitive' );
	}

	function test_minimum_ok()
	{
		$this->helper_int_ok( 'minimum' );
	}

	function test_minimum_fail()
	{
		$this->helper_int_fail( 'minimum' );
	}

	function test_minimum_zero_fail()
	{
		$this->helper_int_fail( 'minimum', 0 );
	}

	function test_tags_list_type_ok()
	{
		$this->helper_string_ok( 'tags_list_type', 'include' );
	}

	function test_tags_list_type_fail()
	{
		$this->helper_string_fail( 'tags_list_type', 'invalid type' );
	}

	function test_show_title_ok()
	{
		$this->helper_bool_ok( 'show_title' );
	}

	function test_show_title_fail()
	{
		$this->helper_bool_fail( 'show_title' );
	}

	function test_link_underline_ok()
	{
		$this->helper_optional_bool_ok( 'link_underline' );
	}

	function test_link_underline_fail()
	{
		$this->helper_optional_bool_fail( 'link_underline' );
	}

	function test_link_bold_ok()
	{
		$this->helper_optional_bool_ok( 'link_bold' );
	}

	function test_link_bold_fail()
	{
		$this->helper_optional_bool_fail( 'link_bold' );
	}

	function test_link_italic_ok()
	{
		$this->helper_optional_bool_ok( 'link_italic' );
	}

	function test_link_italic_fail()
	{
		$this->helper_optional_bool_fail( 'link_italic' );
	}

	function test_link_bg_color_ok()
	{
		$this->helper_color_ok( 'link_bg_color' );
	}

	function test_link_bg_color_fail()
	{
		$this->helper_color_fail( 'link_bg_color' );
	}

	function test_link_border_style_ok()
	{
		$this->helper_string_ok( 'link_border_style', 'dashed' );
	}

	function test_link_border_style_fail()
	{
		$this->helper_string_fail( 'link_border_style', 'invalid border style' );
	}

	function test_link_border_width_ok()
	{
		$this->helper_int_ok( 'link_border_width' );
	}

	function test_link_border_width_fail()
	{
		$this->helper_int_fail( 'link_border_width' );
	}

	function test_link_border_width_zero_ok()
	{
		$this->helper_int_ok( 'link_border_width', 0 );
	}

	function test_link_border_color_ok()
	{
		$this->helper_color_ok( 'link_border_color' );
	}

	function test_link_border_color_fail()
	{
		$this->helper_color_fail( 'link_border_color' );
	}

	function test_hover_underline_ok()
	{
		$this->helper_optional_bool_ok( 'hover_underline' );
	}

	function test_hover_underline_fail()
	{
		$this->helper_optional_bool_fail( 'hover_underline' );
	}

	function test_hover_bold_ok()
	{
		$this->helper_optional_bool_ok( 'hover_bold' );
	}

	function test_hover_bold_fail()
	{
		$this->helper_optional_bool_fail( 'hover_bold' );
	}

	function test_hover_italic_ok()
	{
		$this->helper_optional_bool_ok( 'hover_italic' );
	}

	function test_hover_italic_fail()
	{
		$this->helper_optional_bool_fail( 'hover_italic' );
	}

	function test_hover_bg_color_ok()
	{
		$this->helper_color_ok( 'hover_bg_color' );
	}

	function test_hover_bg_color_fail()
	{
		$this->helper_color_fail( 'hover_bg_color' );
	}

	function test_hover_color_ok()
	{
		$this->helper_color_ok( 'hover_color' );
	}

	function test_hover_color_fail()
	{
		$this->helper_color_fail( 'hover_color' );
	}

	function test_hover_border_style_ok()
	{
		$this->helper_string_ok( 'hover_border_style', 'groove' );
	}

	function test_hover_border_style_fail()
	{
		$this->helper_string_fail( 'hover_border_style', 'invalid border style' );
	}

	function test_hover_border_width_ok()
	{
		$this->helper_int_ok( 'hover_border_width' );
	}

	function test_hover_border_width_fail()
	{
		$this->helper_int_fail( 'hover_border_width' );
	}

	function test_hover_border_width_zero_ok()
	{
		$this->helper_int_ok( 'hover_border_width', 0 );
	}

	function test_hover_border_color_ok()
	{
		$this->helper_color_ok( 'hover_border_color' );
	}

	function test_hover_border_color_fail()
	{
		$this->helper_color_fail( 'hover_border_color' );
	}

	function test_tag_spacing_ok()
	{
		$this->helper_int_ok( 'tag_spacing' );
	}

	function test_tag_spacing_fail()
	{
		$this->helper_int_fail( 'tag_spacing' );
	}

	function test_debug_ok()
	{
		$this->helper_bool_ok( 'debug' );
	}

	function test_debug_fail()
	{
		$this->helper_bool_fail( 'debug' );
	}

	function test_days_old_ok()
	{
		$this->helper_int_ok( 'days_old' );
	}

	function test_days_old_fail()
	{
		$this->helper_int_fail( 'days_old' );
	}

	function test_days_old_zero_ok()
	{
		$this->helper_int_ok( 'days_old', 0 );
	}

	function test_line_height_ok()
	{
		$this->helper_int_ok( 'line_height' );
	}

	function test_line_height_fail()
	{
		$this->helper_int_fail( 'line_height' );
	}

	function test_separator_ok()
	{
		$this->helper_string_ok( 'separator' );
	}

	function test_prefix_ok()
	{
		$this->helper_string_ok( 'prefix' );
	}

	function test_suffix_ok()
	{
		$this->helper_string_ok( 'suffix' );
	}

	function test_prefix_empty_ok()
	{
		$this->helper_string_ok( 'prefix', '' );
	}

	function test_suffix_empty_ok()
	{
		$this->helper_string_ok( 'suffix', '' );
	}

	function test_show_title_text_ok()
	{
		$this->helper_bool_ok( 'show_title_text' );
	}

	function test_show_title_text_fail()
	{
		$this->helper_bool_fail( 'show_title_text' );
	}

	function test_authors_ok()
	{
		$this->helper_int_array_ok( 'authors' );
	}

	function test_authors_fail()
	{
		$this->helper_int_array_fail( 'authors' );
	}

	function test_authors_csv_ok()
	{
		$this->helper_array_ok( 'authors', '1,2,3' );
	}

	function test_authors_empty_ok()
	{
		$this->helper_int_array_ok( 'authors', array() );
	}

	function test_post_type_ok()
	{
		$this->helper_array_ok( 'post_type', array( 'post' ) );
	}

	function test_post_type_fail()
	{
		$this->helper_array_fail( 'post_type', array( 'invalid post type' ) );
	}

	function test_post_type_csv_ok()
	{
		// TODO: this test should include multiple values but without dynamic fetching of post types there's only one valid value
		$this->helper_array_ok( 'post_type', 'post' );
	}

	function test_post_type_empty_not_ok()
	{
		$this->helper_array_fail( 'post_type', array() );
	}

	function test_color_span_from_ok()
	{
		$this->helper_color_ok( 'color_span_from' );
	}

	function test_color_span_from_fail()
	{
		$this->helper_color_fail( 'color_span_to' );
	}

	function test_color_span_to_ok()
	{
		$this->helper_color_ok( 'color_span_to' );
	}

	function test_color_span_to_fail()
	{
		$this->helper_color_fail( 'color_span_to' );
	}

	function test_tags_list_ok()
	{
		$this->helper_int_array_ok( 'tags_list' );
	}

	function test_tags_list_fail()
	{
		$this->helper_int_array_fail( 'tags_list' );
	}

	function test_tags_list_taxonomy() {
		//$this->assertTrue( 'test written', 'Write test that checks that the tags_list constraint checks the type of the terms in tags_list against the selected taxonomy');
	}

	function test_color_set_ok()
	{
		$this->helper_array_ok( 'color_set', array( '#bada55', '#fff', '#000', '#123456', '#fafafa' ), array(
																											'#bada55',
																											'#ffffff',
																											'#000000',
																											'#123456',
																											'#fafafa'
																									   ) );
	}

	function test_color_set_fail()
	{
		$this->helper_array_fail( 'color_set', array( '#badaxx', 'not a color', 123456, '#fbfa' ) );
	}

	function test_color_set_csv_ok()
	{
		$this->helper_array_ok( 'color_set', '#bada55,#fff,#000,#123456,#fafafa', array(
																					   '#bada55', '#ffffff', '#000000',
																					   '#123456', '#fafafa'
																				  ) );
	}

	function test_before_widget()
	{
		$this->helper_string_ok( 'before_widget' );
	}

	function test_after_widget()
	{
		$this->helper_string_ok( 'after_widget' );
	}

	function test_before_title()
	{
		$this->helper_string_ok( 'before_title' );
	}

	function test_after_title()
	{
		$this->helper_string_ok( 'after_title' );
	}

	function test_color_set_expands()
	{
		$instance[ 'color_set' ] = array( '#fff', '#fba' );
		$config                  = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( array( '#ffffff', '#ffbbaa' ), $config->color_set );
	}

	function test_unknown_attribute()
	{
		$attr              = '__unknown';
		$instance[ $attr ] = 'value';
		$config            = new UTCW_Config( $instance, $this->utcw );
		$this->assertFalse( isset( $config->$attr ) );
	}

	private function helper_string_ok( $option, $ok_string = 'test', $message = '' )
	{
		$instance[ $option ] = $ok_string;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_string_fail( $option, $fail_string = '', $message = '' )
	{
		$instance[ $option ] = $fail_string;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_int_ok( $option, $ok_int = 10, $message = '' )
	{
		$instance[ $option ] = $ok_int;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_int_fail( $option, $fail_int = 'fail', $message = '' )
	{
		$instance[ $option ] = $fail_int;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_bool_ok( $option, $ok_bool = true, $message = '' )
	{
		$instance[ $option ] = $ok_bool;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_bool_fail( $option, $fail_bool = 'fail', $message = '' )
	{
		$instance[ $option ] = $fail_bool;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_optional_bool_ok( $option, $ok_opt_bool = 'yes', $message = '' )
	{
		$instance[ $option ] = $ok_opt_bool;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_optional_bool_fail( $option, $fail_opt_bool = 'fail', $message = '' )
	{
		$instance[ $option ] = $fail_opt_bool;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_int_array_ok( $option, $ok_int_array = array( 1, 2, 3 ), $message = '' )
	{
		$instance[ $option ] = $ok_int_array;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_int_array_fail( $option, $fail_int_array = array( 'fail', 'more fail' ), $message = '' )
	{
		$instance[ $option ] = $fail_int_array;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_color_ok( $option, $ok_color = '#bada55', $message = '' )
	{
		$instance[ $option ] = $ok_color;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_color_fail( $option, $fail_color = 'invalid color', $message = '' )
	{
		$instance[ $option ] = $fail_color;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $config->$option, $instance[ $option ], $message );
	}

	private function helper_array_ok( $option, $ok_array = array( 'test' ), $expected = false, $message = '' )
	{
		if ( $expected === false ) {
			$expected = $ok_array;
		}

		$expected = is_array( $expected ) ? $expected : explode( ',', $expected );

		$instance[ $option ] = $ok_array;
		$config              = new UTCW_Config( $instance, $this->utcw );

		$this->assertEquals( $config->$option, $expected, $message );
	}

	private function helper_array_fail( $option, $fail_array = 'not an array', $message = '' )
	{
		$instance[ $option ] = $fail_array;
		$config              = new UTCW_Config( $instance, $this->utcw );
		$this->assertNotEquals( $config->$option, $instance[ $option ], $message );
	}
}