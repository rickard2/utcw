<?php

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class TestStrategy extends UTCW_SelectionStrategy
{

    /**
     * Creates a new instance
     *
     * @param UTCW_Plugin $plugin Main plugin instance
     *
     * @since 2.0
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        // TODO: Implement __construct() method.
    }

    /**
     * Loads terms based on current configuration
     *
     * @return stdClass[]
     * @since 2.0
     */
    public function getData()
    {
        // TODO: Implement getData() method.
    }

    /**
     * Clean up the internal members for debug output
     *
     * @return void
     */
    public function cleanupForDebug()
    {
        // TODO: Implement cleanupForDebug() method.
    }
}

class NotAStrategy
{

}

class UTCW_Test_Data_Config extends UTCW_Test_Config
{

    public $configClass = 'UTCW_DataConfig';

    public $skipDefaultCheck = array('strategy');

    public $defaults = array(
        'order'               => 'name',
        'size_from'           => '10px',
        'size_to'             => '30px',
        'taxonomy'            => array('post_tag'),
        'color'               => 'none',
        'tags_list_type'      => 'exclude',
        'post_type'           => array('post'),
        'tags_list'           => array(),
        'color_span_to'       => '',
        'color_span_from'     => '',
        'authors'             => array(),
        'color_set'           => array(),
//        'strategy'            => 'popularity',
        'max'                 => 45,
        'reverse'             => false,
        'case_sensitive'      => false,
        'minimum'             => 1,
        'days_old'            => 0,
        'post_term'           => array(),
        'post_term_query_var' => false,
    );

    function test_strategy_ok()
    {
        $this->helper_instance_ok('strategy', 'random', 'UTCW_RandomStrategy');
    }

    function test_strategy_fail()
    {
        $this->helper_instance_ok('strategy', 'invalid', 'UTCW_PopularityStrategy');
    }

    function test_strategy_class_name()
    {
        $this->helper_instance_ok('strategy', 'TestStrategy', 'TestStrategy');
    }

    function test_strategy_class_instance()
    {
        $this->helper_instance_ok('strategy', new TestStrategy($this->utcw), 'TestStrategy');
    }

    function test_strategy_class_name_invalid()
    {
        $this->helper_instance_ok('strategy', 'NotAStrategy', 'UTCW_PopularityStrategy');
    }

    function test_strategy_class_instance_invalid()
    {
        $this->helper_string_fail('strategy', new NotAStrategy(), 'UTCW_PopularityStrategy');
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

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertEquals('50px', $config->size_from);
        $this->assertEquals('100px', $config->size_to);
    }

    function test_size_float_ok()
    {
        $instance = array(
            'size_from' => 12.5,
            'size_to'   => 25.5,
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertEquals('12.5px', $config->size_from);
        $this->assertEquals('25.5px', $config->size_to);
    }

    function test_size_different_units_not_ok()
    {
        $instance = array(
            'size_from' => '100px',
            'size_to'   => '200em'
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertNotEquals($instance['size_from'], $config->size_from);
        $this->assertNotEquals($instance['size_to'], $config->size_to);
    }

    function test_size_pixels_ok()
    {
        $instance = array(
            'size_from' => '50px',
            'size_to'   => '100px',
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertEquals('50px', $config->size_from);
        $this->assertEquals('100px', $config->size_to);
    }

    function test_size_ems_ok()
    {
        $instance = array(
            'size_from' => '50em',
            'size_to'   => '100em',
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertEquals('50em', $config->size_from);
        $this->assertEquals('100em', $config->size_to);
    }

    function test_size_percent_ok()
    {
        $instance = array(
            'size_from' => '50%',
            'size_to'   => '100%',
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertEquals('50%', $config->size_from);
        $this->assertEquals('100%', $config->size_to);
    }

    function test_size_equal_ok()
    {
        $instance = array(
            'size_from' => '100px',
            'size_to'   => '100px',
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertEquals($instance['size_from'], $config->size_from);
        $this->assertEquals($instance['size_to'], $config->size_to);
    }

    function test_size_fail()
    {
        $instance = array(
            'size_from' => 'hello',
            'size_to'   => 'world'
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
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

        $config = new UTCW_DataConfig($instance, $this->utcw);
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

    function test_taxonomy_empty_not_ok()
    {
        $this->helper_array_fail('taxonomy', array());
    }

    function test_color_ok()
    {
        $this->helper_string_ok('color', 'random');
    }

    function test_color_fail()
    {
        $this->helper_string_fail('color', 'invalid color');
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

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertTrue(is_int($config->authors[0]));
        $this->assertTrue(is_int($config->authors[1]));
        $this->assertTrue(is_int($config->authors[2]));
    }

    function test_post_term_ok()
    {
        $this->helper_int_array_ok('post_term');
    }

    function test_post_term_fail()
    {
        $this->helper_int_array_fail('post_term');
    }

    function test_post_term_csv_ok()
    {
        $this->helper_array_ok('post_term', '1,2,3');
    }

    function test_post_term_empty_ok()
    {
        $this->helper_int_array_ok('post_term', array());
    }

    function test_post_term_converts_string_to_int()
    {
        $instance = array(
            'post_term' => array('1', '2', '3'),
        );

        $config = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertTrue(is_int($config->post_term[0]));
        $this->assertTrue(is_int($config->post_term[1]));
        $this->assertTrue(is_int($config->post_term[2]));
    }

    function test_post_type_ok()
    {
        $this->helper_array_ok('post_type', array('attachment'));
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

        $config = new UTCW_DataConfig($instance, $this->utcw);
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

    function test_color_set_expands()
    {
        $instance['color_set'] = array('#fff', '#fba');
        $config                = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertEquals(array('#ffffff', '#ffbbaa'), $config->color_set);
    }

    function test_unknown_attribute()
    {
        $attr            = '__unknown';
        $instance[$attr] = 'value';
        $config          = new UTCW_DataConfig($instance, $this->utcw);
        $this->assertFalse(isset($config->$attr));
    }
}