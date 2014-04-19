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

class UTCW_Test_Shortcode extends WP_UnitTestCase
{

    /**
     * @var UTCW_Plugin
     */
    private $plugin;

    /**
     * @var UTCW_ShortCode
     */
    private $shortCode;

    function setUp()
    {
        $this->plugin    = UTCW_Plugin::getInstance();
        $this->shortCode = new UTCW_ShortCode($this->plugin);
    }

    function test_class_exists()
    {
        $this->assertTrue(class_exists('UTCW_ShortCode'));
    }

    function test_function_returns_html()
    {
        $this->assertRegExp(UTCW_TEST_HTML_REGEX, $this->shortCode->render(array()));
    }

    function test_function_no_output()
    {
        $this->expectOutputString('');
        $this->shortCode->render(array());
    }

    function test_function_registered_as_shortcode()
    {
        global $shortcode_tags;
        $this->assertNotNull($shortcode_tags['utcw']);
    }

    function test_function_loads_configuration()
    {
        $plugin = $this->getMock('UTCW_Plugin', array('loadConfiguration'), array(), '', false);
        $plugin->expects($this->once())->method('loadConfiguration')->will($this->returnValue(array()));

        $shortCode = new UTCW_ShortCode($plugin);

        $shortCode->render(array('load_config' => 'test'));
    }

    function test_runs_action()
    {
        global $called;

        $called = false;

        add_action(
            'utcw_shortcode',
            create_function('', 'global $called; $called = true;')
        );

        $this->shortCode->render(array());

        $this->assertTrue($called, 'The shortcode handler should run the action utcw_shortcode');
    }

    function test_runs_shortcode_pre_action_when_post_has_shortcode()
    {
        global $post;
        global $called;

        $called = false;

        add_action(
            'utcw_pre_shortcode',
            create_function('', 'global $called; $called = true;')
        );

        if (!$post) {
            $post = new stdClass;
        }

        $post->post_content = 'Hello World';
        $this->shortCode->triggerPreShortCode();
        $this->assertFalse($called, 'Pre short code should not be called when short code is not present');

        $post->post_content = 'test 123 [utcw title="wtf dude"] 123 test';
        $this->shortCode->triggerPreShortCode();
        $this->assertTrue($called, 'Pre short code should be called when short code is present');
    }
}