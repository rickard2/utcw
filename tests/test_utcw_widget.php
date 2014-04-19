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

class test_utcw_widget extends PHPUnit_Framework_TestCase
{

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $utcw;

    function setUp()
    {
        $this->utcw = $this->getMock('UTCW_Plugin', array(), array(), '', false);
    }

    function test_save_config()
    {

        $instance = array(
            'save_config'      => 'on',
            'save_config_name' => '__test',
        );

        $this->utcw->expects($this->once())
            ->method('saveConfiguration')
            ->with('__test');

        $widget = new UTCW_Widget($this->utcw);
        $widget->update($instance, array());
    }

    function test_load_config()
    {

        $instance = array(
            'load_config'      => 'on',
            'load_config_name' => '__test',
        );

        $this->utcw->expects($this->once())
            ->method('loadConfiguration')
            ->with('__test');

        $widget = new UTCW_Widget($this->utcw);
        $widget->update($instance, array());
    }

    function test_form_renders_html()
    {
        $this->expectOutputRegex(UTCW_TEST_HTML_REGEX);

        $widget = new UTCW_Widget();
        $widget->form(array());
    }

    function test_widget_renders_html()
    {
        $this->expectOutputRegex(UTCW_TEST_HTML_REGEX);

        $widget = new UTCW_Widget();
        $widget->widget(array(), array());
    }

    function test_widget_converts_empty_checkbox_values_to_false()
    {
        $widget = new UTCW_Widget();

        $test_render_config = new UTCW_Test_Render_Config();
        $test_data_config   = new UTCW_Test_Data_Config();
        $defaults           = array_merge($test_render_config->defaults, $test_data_config->defaults);
        $booleans           = array();

        foreach ($defaults as $key => $value) {
            if (is_bool($value)) {
                $booleans[] = $key;
            }
        }

        $instance = $widget->update(array(), array());

        foreach ($booleans as $boolean) {
            $this->assertEquals(
                false,
                $instance[$boolean],
                'The boolean configuration option ' . $boolean . ' needs to be converted to false when not present in input'
            );
        }
    }
}