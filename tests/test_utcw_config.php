<?php

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.1
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Config extends WP_UnitTestCase
{

    /**
     * @var UTCW_Plugin
     */
    public $utcw;

    /**
     * @var MockFactory
     */
    public $mockFactory;

    public $skipDefaultCheck = array();

    public $configClass = '';

    public $defaults = array();

    function setUp()
    {
        $this->mockFactory = new MockFactory($this);
        $this->utcw        = $this->mockFactory->getUTCWNotAuthenticated();
    }

    function test_unknown_attribute()
    {
        if ($this->configClass) {
            $attr            = '__unknown';
            $instance[$attr] = 'value';
            $config          = new $this->configClass($instance, $this->utcw);
            $this->assertFalse(isset($config->$attr));
        }
    }

    function test_config_defaults()
    {
        if ($this->configClass && $this->defaults) {
            $config   = new $this->configClass(array(), $this->utcw);
            $instance = $config->getInstance();

            foreach ($this->skipDefaultCheck as $key) {
                unset($instance[$key]);
            }

            $this->assertEquals($this->defaults, $instance);
        }
    }

    public function helper_string_ok($option, $ok_string = 'test', $message = '')
    {
        $instance[$option] = $ok_string;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    public function helper_string_fail($option, $fail_string = '', $message = '')
    {
        $instance[$option] = $fail_string;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    public function helper_instance_ok($option, $ok_value, $expected_class, $message = '')
    {
        $instance[$option] = $ok_value;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertInstanceOf($expected_class, $config->$option, $message);
    }

    public function helper_instance_fail($option, $fail_value, $expected_class, $message = '')
    {
        $instance[$option] = $fail_value;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertInstanceOf($expected_class, $config->$option, $message);
    }

    public function helper_int_ok($option, $ok_int = 10, $message = '')
    {
        $instance[$option] = $ok_int;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    public function helper_int_fail($option, $fail_int = 'fail', $message = '')
    {
        $instance[$option] = $fail_int;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    public function helper_bool_ok($option, $ok_bool = true, $message = '')
    {
        $instance[$option] = $ok_bool;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    public function helper_bool_fail($option, $fail_bool = 'fail', $message = '')
    {
        $instance[$option] = $fail_bool;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    public function helper_optional_bool_ok($option, $ok_opt_bool = 'yes', $message = '')
    {
        $instance[$option] = $ok_opt_bool;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    public function helper_optional_bool_fail($option, $fail_opt_bool = 'fail', $message = '')
    {
        $instance[$option] = $fail_opt_bool;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    public function helper_int_array_ok($option, $ok_int_array = array(1, 2, 3), $message = '')
    {
        $instance[$option] = $ok_int_array;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    public function helper_int_array_fail($option, $fail_int_array = array('fail', 'more fail'), $message = '')
    {
        $instance[$option] = $fail_int_array;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    public function helper_color_ok($option, $ok_color = '#bada55', $message = '')
    {
        $instance[$option] = $ok_color;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertEquals($instance[$option], $config->$option, $message);
    }

    public function helper_color_fail($option, $fail_color = 'invalid color', $message = '')
    {
        $instance[$option] = $fail_color;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }

    public function helper_array_ok($option, $ok_array = array('test'), $expected = false, $message = '')
    {
        if ($expected === false) {
            $expected = $ok_array;
        }

        $expected = is_array($expected) ? $expected : explode(',', $expected);

        $instance[$option] = $ok_array;
        $config            = new $this->configClass($instance, $this->utcw);

        $this->assertEquals($expected, $config->$option, $message);
    }

    public function helper_array_fail($option, $fail_array = 'not an array', $message = '')
    {
        $instance[$option] = $fail_array;
        $config            = new $this->configClass($instance, $this->utcw);
        $this->assertNotEquals($instance[$option], $config->$option, $message);
    }
}