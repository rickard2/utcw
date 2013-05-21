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

class UTCW_Test_Render_Config extends UTCW_Test_Config
{
    public $configClass = 'UTCW_RenderConfig';

    public $defaults = array(
        'text_transform'     => 'none',
        'link_underline'     => 'default',
        'link_bold'          => 'default',
        'link_italic'        => 'default',
        'hover_underline'    => 'default',
        'hover_bold'         => 'default',
        'hover_italic'       => 'default',
        'link_border_style'  => 'none',
        'hover_border_style' => 'none',
        'link_bg_color'      => 'transparent',
        'link_border_color'  => 'none',
        'hover_bg_color'     => 'transparent',
        'hover_color'        => 'default',
        'hover_border_color' => 'none',
        'letter_spacing'     => 'normal',
        'word_spacing'       => 'normal',
        'tag_spacing'        => 'auto',
        'line_height'        => 'inherit',
        'link_border_width'  => 0,
        'hover_border_width' => 0,
        'title'              => 'Tag Cloud',
        'show_title'         => true,
        'show_links'         => true,
        'debug'              => false,
        'separator'          => ' ',
        'prefix'             => '',
        'suffix'             => '',
        'show_title_text'    => true,
        'before_widget'      => '',
        'after_widget'       => '',
        'before_title'       => '',
        'after_title'        => '',
        'alignment'          => '',
        'display'            => 'inline',
    );

    function test_text_transform_ok()
    {
        $this->helper_string_ok('text_transform', 'capitalize');
    }

    function test_case_fail()
    {
        $this->helper_string_fail('text_transform', 'invalid text_transform');
    }

    function test_alignment_ok()
    {
        $this->helper_string_ok('alignment', 'justify');
    }

    function test_alignment_fail()
    {
        $this->helper_string_fail('alignment', 'invalid alignment');
    }

    function test_display_ok()
    {
        $this->helper_string_ok('display', 'list');
    }

    function test_display_fail()
    {
        $this->helper_string_fail('display', 'invalid display');
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

    function test_link_border_style_ok()
    {
        $this->helper_string_ok('link_border_style', 'dashed');
    }

    function test_link_border_style_fail()
    {
        $this->helper_string_fail('link_border_style', 'invalid border style');
    }

    function test_hover_border_style_ok()
    {
        $this->helper_string_ok('hover_border_style', 'groove');
    }

    function test_hover_border_style_fail()
    {
        $this->helper_string_fail('hover_border_style', 'invalid border style');
    }

    function test_link_bg_color_ok()
    {
        $this->helper_color_ok('link_bg_color');
    }

    function test_link_bg_color_fail()
    {
        $this->helper_color_fail('link_bg_color');
    }

    function test_link_border_color_ok()
    {
        $this->helper_color_ok('link_border_color');
    }

    function test_link_border_color_fail()
    {
        $this->helper_color_fail('link_border_color');
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

    function test_hover_border_color_ok()
    {
        $this->helper_color_ok('hover_border_color');
    }

    function test_hover_border_color_fail()
    {
        $this->helper_color_fail('hover_border_color');
    }

    function test_letter_spacing_int_ok()
    {
        $instance = array('letter_spacing' => 10);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals('10px', $config->letter_spacing);
    }

    function test_letter_spacing_float_ok()
    {
        $instance = array('letter_spacing' => 12.5);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
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
        $instance = array('letter_spacing' => '');
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals(
            $this->defaults['letter_spacing'],
            $config->letter_spacing,
            'Setting letter_spacing to an empty value should return the default value'
        );
    }

    function test_word_spacing_int_ok()
    {
        $instance = array('word_spacing' => 10);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals('10px', $config->word_spacing);
    }

    function test_word_spacing_float_ok()
    {
        $instance = array('word_spacing' => 12.5);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
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
        $instance = array('word_spacing' => '');
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals(
            $this->defaults['word_spacing'],
            $config->word_spacing,
            'Setting word_spacing to an empty value should return the default value'
        );
    }

    function test_tag_spacing_int_ok()
    {
        $instance = array('tag_spacing' => 10);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals('10px', $config->tag_spacing);
    }

    function test_tag_spacing_float_ok()
    {
        $instance = array('tag_spacing' => 12.5);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
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
        $instance = array('tag_spacing' => '');
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals(
            $this->defaults['tag_spacing'],
            $config->tag_spacing,
            'Setting tag_spacing to an empty value should return the default value'
        );
    }

    function test_line_height_int_ok()
    {
        $instance = array('line_height' => 10);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals('10px', $config->line_height);
    }

    function test_line_height_float_ok()
    {
        $instance = array('line_height' => 12.5);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
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
        $instance = array('line_height' => '');
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals(
            $this->defaults['line_height'],
            $config->line_height,
            'Setting line_height to an empty value should return the default value'
        );
    }

    function test_link_border_width_int_ok()
    {
        $instance = array('link_border_width' => 10);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals('10px', $config->link_border_width);
    }

    function test_link_border_width_float_ok()
    {
        $instance = array('link_border_width' => 12.5);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
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

    function test_hover_border_width_int_ok()
    {
        $instance = array('hover_border_width' => 10);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
        $this->assertEquals('10px', $config->hover_border_width);
    }

    function test_hover_border_width_float_ok()
    {
        $instance = array('hover_border_width' => 12.5);
        $config   = new UTCW_RenderConfig($instance, $this->utcw);
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

    function test_title_ok()
    {
        $this->helper_string_ok('title');
    }

    function test_title_fail()
    {
        $this->helper_string_fail('title');
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

    function test_debug_ok()
    {
        $this->helper_bool_ok('debug');
    }

    function test_debug_fail()
    {
        $this->helper_bool_fail('debug');
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
}