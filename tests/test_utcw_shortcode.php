<?php
//use Rickard\UTCW\Plugin;

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3.1
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Shortcode extends WP_UnitTestCase
{

    /**
     * @var UTCW_Plugin
     */
    private $utcw;

    function setUp()
    {
        $this->utcw = UTCW_Plugin::getInstance();
    }

    function test_function_exists()
    {
        $this->assertTrue(method_exists($this->utcw, 'shortcode'));
    }

    function test_function_returns_html()
    {
        $this->assertRegExp(UTCW_TEST_HTML_REGEX, $this->utcw->shortcode(array()));
    }

    function test_function_no_output()
    {
        $this->expectOutputString('');
        $this->utcw->shortcode(array());
    }

    function test_function_registered_as_shortcode()
    {
        global $shortcode_tags;
        $this->assertNotNull($shortcode_tags['utcw']);
    }

    function test_function_loads_configuration()
    {
        $utcw = $this->getMock('UTCW_Plugin', array('loadConfiguration'), array(), '', false);
        $utcw->expects($this->once())->method('loadConfiguration')->will($this->returnValue(array()));
        $utcw->shortcode(array('load_config' => 'test'));
    }
}