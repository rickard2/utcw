<?php
//use Rickard\UTCW\Config;
//use Rickard\UTCW\Plugin;

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Config extends WP_UnitTestCase
{

    /**
     * @var UTCW_Plugin
     */
    protected $utcw;

    /**
     * @var MockFactory
     */
    protected $mockFactory;

    function setUp()
    {
        $this->utcw        = UTCW_Plugin::getInstance();
        $this->mockFactory = new MockFactory($this);
    }

    function test_config_defaults()
    {
        $config   = new UTCW_Config(array(), $this->utcw);
        $options  = $config->getDefaults();
        $instance = $config->getInstance();

        $this->assertEquals($options, $instance);
    }

    function test_strategy_ok()
    {
        $this->helper_string_ok('strategy', 'random');
    }

    function test_strategy_fail()
    {
        $this->helper_string_fail('strategy', 'invalid');
    }

    function test_title_ok()
    {
        $this->helper_string_ok('title');
    }

    function test_title_fail()
    {
        $this->helper_string_fail('title');
    }

    function test_order_ok()
    {
        $this->helper_string_ok('order', 'count');
    }

    function test_order_fail()
    {
        $this->helper_string_fail('order', 'invalid order');
    }

    function test_size_integer_ok()
    {
        $instance = array(
            'size_from' => 50,
            'size_to'   => 100,
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('50px', $config->size_from);
        $this->assertEquals('100px', $config->size_to);
    }

    function test_size_float_ok()
    {
        $instance = array(
            'size_from' => 12.5,
            'size_to'   => 25.5,
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->size_from);
        $this->assertEquals('25.5px', $config->size_to);
    }

    function test_size_different_units_not_ok()
    {
        $instance = array(
            'size_from' => '100px',
            'size_to'   => '200em'
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance['size_from'], $config->size_from);
        $this->assertNotEquals($instance['size_to'], $config->size_to);
    }

    function test_size_pixels_ok()
    {
        $instance = array(
            'size_from' => '50px',
            'size_to'   => '100px',
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('50px', $config->size_from);
        $this->assertEquals('100px', $config->size_to);
    }

    function test_size_ems_ok()
    {
        $instance = array(
            'size_from' => '50em',
            'size_to'   => '100em',
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('50em', $config->size_from);
        $this->assertEquals('100em', $config->size_to);
    }

    function test_size_percent_ok()
    {
        $instance = array(
            'size_from' => '50%',
            'size_to'   => '100%',
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('50%', $config->size_from);
        $this->assertEquals('100%', $config->size_to);
    }

    function test_size_equal_ok()
    {
        $instance = array(
            'size_from' => '100px',
            'size_to'   => '100px',
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals($instance['size_from'], $config->size_from);
        $this->assertEquals($instance['size_to'], $config->size_to);
    }

    function test_size_fail()
    {
        $instance = array(
            'size_from' => 'hello',
            'size_to'   => 'world'
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance['size_from'], $config->size_from);
        $this->assertNotEquals($instance['size_to'], $config->size_to);
    }

    function test_size_from_only_ok()
    {
        $this->helper_string_ok('size_from', '15px');
    }

    function test_size_from_only_fail()
    {
        $this->helper_string_fail('size_from', '100px');
    }

    function test_size_to_only_ok()
    {
        $this->helper_string_ok('size_to', '100px');
    }

    function test_size_to_only_fail()
    {
        $this->helper_string_fail('size_to', '5px');
    }

    function test_size_wrong_order_fail()
    {
        $instance = array(
            'size_from' => '100px',
            'size_to'   => '10px',
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals(
            $instance['size_from'],
            $config->size_from,
            'Size from should always be lower than size to'
        );
        $this->assertNotEquals($instance['size_to'], $config->size_to, 'Size from should always be lower than size to');
    }

    function test_max_ok()
    {
        $this->helper_int_ok('max');
    }

    function test_max_fail()
    {
        $this->helper_int_fail('max');
    }

    function test_max_zero_fail()
    {
        $this->helper_int_fail('max', 0);
    }

    function test_reverse_ok()
    {
        $this->helper_bool_ok('reverse');
    }

    function test_reverse_fail()
    {
        $this->helper_bool_fail('reverse');
    }

    function test_taxonomy_ok()
    {
        $this->utcw = $this->mockFactory->getUTCWMock();
        $this->helper_array_ok('taxonomy', array('category'));
    }

    function test_taxonomy_fail()
    {
        $this->utcw = $this->mockFactory->getUTCWMock();
        $this->helper_array_fail('taxonomy');
    }

    function test_taxonomy_invalid()
    {
        $this->utcw = $this->mockFactory->getUTCWMock();
        $this->helper_array_fail('taxonomy', array('invalid_taxonomy'));
    }

    function test_taxonomy_multiple_ok()
    {
        $this->utcw = $this->mockFactory->getUTCWMock();
        $this->helper_array_ok('taxonomy', array('post_tag', 'category'));
    }

    function test_taxonomy_csv_ok()
    {
        $this->utcw = $this->mockFactory->getUTCWMock();
        $this->helper_array_ok('taxonomy', 'post_tag,category', array('post_tag', 'category'));
    }

    function test_color_ok()
    {
        $this->helper_string_ok('color', 'random');
    }

    function test_color_fail()
    {
        $this->helper_string_fail('color', 'invalid color');
    }

    function test_letter_spacing_int_ok()
    {
        $instance = array('letter_spacing' => 10);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('10px', $config->letter_spacing);
    }

    function test_letter_spacing_float_ok()
    {
        $instance = array('letter_spacing' => 12.5);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->letter_spacing);
    }

    function test_letter_spacing_px_ok()
    {
        $this->helper_string_ok('letter_spacing', '10px');
    }

    function test_letter_spacing_em_ok()
    {
        $this->helper_string_ok('letter_spacing', '10em');
    }

    function test_letter_spacing_percent_ok()
    {
        $this->helper_string_ok('letter_spacing', '10%');
    }

    function test_letter_spacing_fail()
    {
        $this->helper_string_fail('letter_spacing', 'fail');
    }

    function test_letter_spacing_empty_default()
    {
        $defaults = UTCW_Config::getDefaults();

        $instance = array('letter_spacing' => '');
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals(
            $defaults['letter_spacing'],
            $config->letter_spacing,
            'Setting letter_spacing to an empty value should return the default value'
        );
    }

    function test_word_spacing_int_ok()
    {
        $instance = array('word_spacing' => 10);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('10px', $config->word_spacing);
    }

    function test_word_spacing_float_ok()
    {
        $instance = array('word_spacing' => 12.5);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->word_spacing);
    }

    function test_word_spacing_px_ok()
    {
        $this->helper_string_ok('word_spacing', '10px');
    }

    function test_word_spacing_em_ok()
    {
        $this->helper_string_ok('word_spacing', '10em');
    }

    function test_word_spacing_percent_ok()
    {
        $this->helper_string_ok('word_spacing', '10%');
    }

    function test_word_spacing_fail()
    {
        $this->helper_string_fail('word_spacing', 'fail');
    }

    function test_word_spacing_empty_default()
    {
        $defaults = UTCW_Config::getDefaults();

        $instance = array('word_spacing' => '');
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals(
            $defaults['word_spacing'],
            $config->word_spacing,
            'Setting word_spacing to an empty value should return the default value'
        );
    }

    function test_text_transform_ok()
    {
        $this->helper_string_ok('text_transform', 'capitalize');
    }

    function test_case_fail()
    {
        $this->helper_string_fail('text_transform', 'invalid text_transform');
    }

    function test_case_sensitive_ok()
    {
        $this->helper_bool_ok('case_sensitive');
    }

    function test_case_sensitive_fail()
    {
        $this->helper_bool_fail('case_sensitive');
    }

    function test_minimum_ok()
    {
        $this->helper_int_ok('minimum');
    }

    function test_minimum_fail()
    {
        $this->helper_int_fail('minimum');
    }

    function test_minimum_zero_ok()
    {
        $this->helper_int_ok('minimum', 0);
    }

    function test_tags_list_type_ok()
    {
        $this->helper_string_ok('tags_list_type', 'include');
    }

    function test_tags_list_type_fail()
    {
        $this->helper_string_fail('tags_list_type', 'invalid type');
    }

    function test_show_title_ok()
    {
        $this->helper_bool_ok('show_title');
    }

    function test_show_title_fail()
    {
        $this->helper_bool_fail('show_title');
    }

    function test_show_links_ok()
    {
        $this->helper_bool_ok('show_links');
    }

    function test_show_links_fail()
    {
        $this->helper_bool_fail('show_links');
    }

    function test_link_underline_ok()
    {
        $this->helper_optional_bool_ok('link_underline');
    }

    function test_link_underline_fail()
    {
        $this->helper_optional_bool_fail('link_underline');
    }

    function test_link_bold_ok()
    {
        $this->helper_optional_bool_ok('link_bold');
    }

    function test_link_bold_fail()
    {
        $this->helper_optional_bool_fail('link_bold');
    }

    function test_link_italic_ok()
    {
        $this->helper_optional_bool_ok('link_italic');
    }

    function test_link_italic_fail()
    {
        $this->helper_optional_bool_fail('link_italic');
    }

    function test_link_bg_color_ok()
    {
        $this->helper_color_ok('link_bg_color');
    }

    function test_link_bg_color_fail()
    {
        $this->helper_color_fail('link_bg_color');
    }

    function test_link_border_style_ok()
    {
        $this->helper_string_ok('link_border_style', 'dashed');
    }

    function test_link_border_style_fail()
    {
        $this->helper_string_fail('link_border_style', 'invalid border style');
    }

    function test_link_border_width_int_ok()
    {
        $instance = array('link_border_width' => 10);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('10px', $config->link_border_width);
    }

    function test_link_border_width_float_ok()
    {
        $instance = array('link_border_width' => 12.5);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->link_border_width);
    }

    function test_link_border_width_px_ok()
    {
        $this->helper_string_ok('link_border_width', '10px');
    }

    function test_link_border_width_em_ok()
    {
        $this->helper_string_ok('link_border_width', '10em');
    }

    function test_link_border_width_percent_ok()
    {
        $this->helper_string_ok('link_border_width', '10%');
    }

    function test_link_border_width_fail()
    {
        $this->helper_string_fail('link_border_width', 'fail');
    }

    function test_link_border_color_ok()
    {
        $this->helper_color_ok('link_border_color');
    }

    function test_link_border_color_fail()
    {
        $this->helper_color_fail('link_border_color');
    }

    function test_hover_underline_ok()
    {
        $this->helper_optional_bool_ok('hover_underline');
    }

    function test_hover_underline_fail()
    {
        $this->helper_optional_bool_fail('hover_underline');
    }

    function test_hover_bold_ok()
    {
        $this->helper_optional_bool_ok('hover_bold');
    }

    function test_hover_bold_fail()
    {
        $this->helper_optional_bool_fail('hover_bold');
    }

    function test_hover_italic_ok()
    {
        $this->helper_optional_bool_ok('hover_italic');
    }

    function test_hover_italic_fail()
    {
        $this->helper_optional_bool_fail('hover_italic');
    }

    function test_hover_bg_color_ok()
    {
        $this->helper_color_ok('hover_bg_color');
    }

    function test_hover_bg_color_fail()
    {
        $this->helper_color_fail('hover_bg_color');
    }

    function test_hover_color_ok()
    {
        $this->helper_color_ok('hover_color');
    }

    function test_hover_color_fail()
    {
        $this->helper_color_fail('hover_color');
    }

    function test_hover_border_style_ok()
    {
        $this->helper_string_ok('hover_border_style', 'groove');
    }

    function test_hover_border_style_fail()
    {
        $this->helper_string_fail('hover_border_style', 'invalid border style');
    }

    function test_hover_border_width_int_ok()
    {
        $instance = array('hover_border_width' => 10);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('10px', $config->hover_border_width);
    }

    function test_hover_border_width_float_ok()
    {
        $instance = array('hover_border_width' => 12.5);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->hover_border_width);
    }

    function test_hover_border_width_px_ok()
    {
        $this->helper_string_ok('hover_border_width', '10px');
    }

    function test_hover_border_width_em_ok()
    {
        $this->helper_string_ok('hover_border_width', '10em');
    }

    function test_hover_border_width_percent_ok()
    {
        $this->helper_string_ok('hover_border_width', '10%');
    }

    function test_hover_border_width_fail()
    {
        $this->helper_string_fail('hover_border_width', 'fail');
    }

    function test_hover_border_color_ok()
    {
        $this->helper_color_ok('hover_border_color');
    }

    function test_hover_border_color_fail()
    {
        $this->helper_color_fail('hover_border_color');
    }

    function test_tag_spacing_int_ok()
    {
        $instance = array('tag_spacing' => 10);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('10px', $config->tag_spacing);
    }

    function test_tag_spacing_float_ok()
    {
        $instance = array('tag_spacing' => 12.5);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->tag_spacing);
    }

    function test_tag_spacing_px_ok()
    {
        $this->helper_string_ok('tag_spacing', '10px');
    }

    function test_tag_spacing_em_ok()
    {
        $this->helper_string_ok('tag_spacing', '10em');
    }

    function test_tag_spacing_percent_ok()
    {
        $this->helper_string_ok('tag_spacing', '10%');
    }

    function test_tag_spacing_fail()
    {
        $this->helper_string_fail('tag_spacing', 'fail');
    }

    function test_tag_spacing_empty_default()
    {
        $defaults = UTCW_Config::getDefaults();

        $instance = array('tag_spacing' => '');
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals(
            $defaults['tag_spacing'],
            $config->tag_spacing,
            'Setting tag_spacing to an empty value should return the default value'
        );
    }

    function test_debug_ok()
    {
        $this->helper_bool_ok('debug');
    }

    function test_debug_fail()
    {
        $this->helper_bool_fail('debug');
    }

    function test_days_old_ok()
    {
        $this->helper_int_ok('days_old');
    }

    function test_days_old_fail()
    {
        $this->helper_int_fail('days_old');
    }

    function test_days_old_zero_ok()
    {
        $this->helper_int_ok('days_old', 0);
    }

    function test_line_height_int_ok()
    {
        $instance = array('line_height' => 10);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('10px', $config->line_height);
    }

    function test_line_height_float_ok()
    {
        $instance = array('line_height' => 12.5);
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->line_height);
    }

    function test_line_height_px_ok()
    {
        $this->helper_string_ok('line_height', '10px');
    }

    function test_line_height_em_ok()
    {
        $this->helper_string_ok('line_height', '10em');
    }

    function test_line_height_percent_ok()
    {
        $this->helper_string_ok('line_height', '10%');
    }

    function test_line_height_fail()
    {
        $this->helper_string_fail('line_height', 'fail');
    }

    function test_line_height_empty_default()
    {
        $defaults = UTCW_Config::getDefaults();

        $instance = array('line_height' => '');
        $config   = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals(
            $defaults['line_height'],
            $config->line_height,
            'Setting line_height to an empty value should return the default value'
        );
    }

    function test_separator_ok()
    {
        $this->helper_string_ok('separator');
    }

    function test_prefix_ok()
    {
        $this->helper_string_ok('prefix');
    }

    function test_suffix_ok()
    {
        $this->helper_string_ok('suffix');
    }

    function test_prefix_empty_ok()
    {
        $this->helper_string_ok('prefix', '');
    }

    function test_suffix_empty_ok()
    {
        $this->helper_string_ok('suffix', '');
    }

    function test_show_title_text_ok()
    {
        $this->helper_bool_ok('show_title_text');
    }

    function test_show_title_text_fail()
    {
        $this->helper_bool_fail('show_title_text');
    }

    function test_authors_ok()
    {
        $this->helper_int_array_ok('authors');
    }

    function test_authors_fail()
    {
        $this->helper_int_array_fail('authors');
    }

    function test_authors_csv_ok()
    {
        $this->helper_array_ok('authors', '1,2,3');
    }

    function test_authors_empty_ok()
    {
        $this->helper_int_array_ok('authors', array());
    }

    function test_authors_converts_string_to_int()
    {
        $instance = array(
            'authors' => array('1', '2', '3'),
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertTrue(is_int($config->authors[0]));
        $this->assertTrue(is_int($config->authors[1]));
        $this->assertTrue(is_int($config->authors[2]));
    }

    function test_post_type_ok()
    {
        $this->helper_array_ok('post_type', array('post'));
    }

    function test_post_type_fail()
    {
        $this->helper_array_fail('post_type', array('invalid post type'));
    }

    function test_post_type_csv_ok()
    {
        // TODO: this test should include multiple values but without dynamic fetching of post types there's only one valid value
        $this->helper_array_ok('post_type', 'post');
    }

    function test_post_type_empty_not_ok()
    {
        $this->helper_array_fail('post_type', array());
    }

    function test_color_span_from_ok()
    {
        $this->helper_color_ok('color_span_from');
    }

    function test_color_span_from_fail()
    {
        $this->helper_color_fail('color_span_to');
    }

    function test_color_span_to_ok()
    {
        $this->helper_color_ok('color_span_to');
    }

    function test_color_span_to_fail()
    {
        $this->helper_color_fail('color_span_to');
    }

    function test_tags_list_ok()
    {
        $this->helper_int_array_ok('tags_list');
    }

    function test_tags_list_fail()
    {
        $this->helper_int_array_fail('tags_list');
    }

    function test_tags_list_converts_string_to_int()
    {
        $instance = array(
            'tags_list' => array('1', '2', '3'),
        );

        $config = new UTCW_Config($instance, $this->utcw);
        $this->assertTrue(is_int($config->tags_list[0]));
        $this->assertTrue(is_int($config->tags_list[1]));
        $this->assertTrue(is_int($config->tags_list[2]));
    }

    function test_color_set_ok()
    {
        $this->helper_array_ok(
            'color_set',
            array('#bada55', '#fff', '#000', '#123456', '#fafafa'),
            array(
                '#bada55',
                '#ffffff',
                '#000000',
                '#123456',
                '#fafafa'
            )
        );
    }

    function test_color_set_fail()
    {
        $this->helper_array_fail('color_set', array('#badaxx', 'not a color', 123456, '#fbfa'));
    }

    function test_color_set_csv_ok()
    {
        $this->helper_array_ok(
            'color_set',
            '#bada55,#fff,#000,#123456,#fafafa',
            array(
                '#bada55',
                '#ffffff',
                '#000000',
                '#123456',
                '#fafafa'
            )
        );
    }

    function test_before_widget()
    {
        $this->helper_string_ok('before_widget');
    }

    function test_after_widget()
    {
        $this->helper_string_ok('after_widget');
    }

    function test_before_title()
    {
        $this->helper_string_ok('before_title');
    }

    function test_after_title()
    {
        $this->helper_string_ok('after_title');
    }

    function test_color_set_expands()
    {
        $instance['color_set'] = array('#fff', '#fba');
        $config                = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals(array('#ffffff', '#ffbbaa'), $config->color_set);
    }

    function test_unknown_attribute()
    {
        $attr            = '__unknown';
        $instance[$attr] = 'value';
        $config          = new UTCW_Config($instance, $this->utcw);
        $this->assertFalse(isset($config->$attr));
    }

    private function helper_string_ok($option, $ok_string = 'test', $message = '')
    {
        $instance[$option] = $ok_string;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    private function helper_string_fail($option, $fail_string = '', $message = '')
    {
        $instance[$option] = $fail_string;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    private function helper_int_ok($option, $ok_int = 10, $message = '')
    {
        $instance[$option] = $ok_int;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    private function helper_int_fail($option, $fail_int = 'fail', $message = '')
    {
        $instance[$option] = $fail_int;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    private function helper_bool_ok($option, $ok_bool = true, $message = '')
    {
        $instance[$option] = $ok_bool;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    private function helper_bool_fail($option, $fail_bool = 'fail', $message = '')
    {
        $instance[$option] = $fail_bool;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    private function helper_optional_bool_ok($option, $ok_opt_bool = 'yes', $message = '')
    {
        $instance[$option] = $ok_opt_bool;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    private function helper_optional_bool_fail($option, $fail_opt_bool = 'fail', $message = '')
    {
        $instance[$option] = $fail_opt_bool;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    private function helper_int_array_ok($option, $ok_int_array = array(1, 2, 3), $message = '')
    {
        $instance[$option] = $ok_int_array;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    private function helper_int_array_fail($option, $fail_int_array = array('fail', 'more fail'), $message = '')
    {
        $instance[$option] = $fail_int_array;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    private function helper_color_ok($option, $ok_color = '#bada55', $message = '')
    {
        $instance[$option] = $ok_color;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    private function helper_color_fail($option, $fail_color = 'invalid color', $message = '')
    {
        $instance[$option] = $fail_color;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    private function helper_array_ok($option, $ok_array = array('test'), $expected = false, $message = '')
    {
        if ($expected === false) {
            $expected = $ok_array;
        }

        $expected = is_array($expected) ? $expected : explode(',', $expected);

        $instance[$option] = $ok_array;
        $config            = new UTCW_Config($instance, $this->utcw);

        $this->assertEquals($config->$option, $expected, $message);
    }

    private function helper_array_fail($option, $fail_array = 'not an array', $message = '')
    {
        $instance[$option] = $fail_array;
        $config            = new UTCW_Config($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }
}