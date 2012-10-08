<?php

class test_utcw_widget extends PHPUnit_Framework_TestCase {

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $utcw;

    function setUp() {
        $this->utcw = $this->getMock('UTCW_Plugin', array(), array(), '', false);
    }

    function test_save_config() {

        $instance = array(
            'save_config' => 'on',
            'save_config_name' => '__test',
        );

        $this->utcw->expects($this->once())
            ->method('save_configuration')
            ->with('__test', UTCW_Config::get_defaults());

        $widget = new UTCW( $this->utcw );
		$widget->update($instance, array());
    }
}