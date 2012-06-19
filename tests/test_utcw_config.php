<?php

class UTCW_Test_Config extends WP_UnitTestCase {

	function test_config_defaults() {

		$reflection = new ReflectionClass('UTCW_Config');
		$properties = $reflection->getDefaultProperties();
		$defaults   = $properties['config'];

		$config   = new UTCW_Config(array());
		$instance = $config->get_instance();

		$this->assertEquals( $defaults, $instance );
	}

	function test_config_valid() {

		$my_instance = $config = array(
			'title'              => 'test',
			'order'              => 'random',
			'size_from'          => 1337,
			'size_to'            => 1337,
			'max'                => 1337,
			// 'taxonomy'           => 'post_tag',
			'reverse'            => true,
			'color'              => 'random',
			'letter_spacing'     => 1337,
			'word_spacing'       => 1337,
			'case'               => 'capitalize',
			'case_sensitive'     => true,
			'minimum'            => 1337,
			'tags_list_type'     => 'include',
			'show_title'         => true,
			'link_underline'     => 'yes',
			'link_bold'          => 'yes',
			'link_italic'        => 'yes',
			'link_bg_color'      => '#123456',
			'link_border_style'  => 'dotted',
			'link_border_width'  => 1337,
			'link_border_color'  => '#123456',
			'hover_underline'    => 'yes',
			'hover_bold'         => 'yes',
			'hover_italic'       => 'yes',
			'hover_bg_color'     => '#123456',
			'hover_color'        => '#123456',
			'hover_border_style' => 'groove',
			'bover_border_width' => 1337,
			'hover_border_color' => '#123456',
			'tag_spacing'        => 1337,
			'debug'              => true,
			'days_old'           => 1337,
			'line_height'        => 1337,
			'separator'          => 'test',
			'prefix'             => 'test',
			'suffix'             => 'test',
			'show_title_text'    => true,
		);

		$config = new UTCW_Config( $my_instance );
		$instance = $config->get_instance();

		foreach ( $my_instance as $key => $item ) {
			$this->assertEquals( $item, $instance[ $key ] );
		}

	}

	function test_config_invalid() {

		$my_instance = $config = array(
			'title'              => false,
			'order'              => 'order',
			'size_from'          => 'size_from',
			'size_to'            => 'size_to',
			'max'                => 'max',
			'reverse'            => 'reverse',
			'color'              => 'color',
			'letter_spacing'     => 'letter_spacing',
			'word_spacing'       => 'word_spacing',
			'case'               => 'case',
			'case_sensitive'     => 'case_sensitive',
			'minimum'            => 'minimum',
			'tags_list_type'     => 'tags_list_type',
			'show_title'         => 'show_title',
			'link_underline'     => 'link_underline',
			'link_bold'          => 'link_bold',
			'link_italic'        => 'link_italic',
			'link_bg_color'      => 'link_bg_color',
			'link_border_style'  => 'link_border_style',
			'link_border_width'  => 'link_border_width',
			'link_border_color'  => 'link_border_color',
			'hover_underline'    => 'hover_underline',
			'hover_bold'         => 'hover_bold',
			'hover_italic'       => 'hover_italic',
			'hover_bg_color'     => 'hover_bg_color',
			'hover_color'        => 'hover_color',
			'hover_border_style' => 'hover_border_style',
			'bover_border_width' => 'bover_border_width',
			'hover_border_color' => 'hover_border_color',
			'tag_spacing'        => 'tag_spacing',
			'debug'              => 'debug',
			'days_old'           => 'days_old',
			'line_height'        => 'line_height',
			'separator'          => false,
			//'prefix'             => false,
			//'suffix'             => false,
			'show_title_text'    => 'show_title_text',
		);

		$config = new UTCW_Config( $my_instance );
		$instance = $config->get_instance();

		foreach ( $my_instance as $key => $item ) {
			$this->assertNotEquals( $item, $instance[ $key ] );
		}

	}

}