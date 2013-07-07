<?php

class test_utcw_wp_super_cache_handler extends PHPUnit_Framework_TestCase
{
    public function testHandler()
    {
        $handler = new UTCW_WPSuperCacheHandler();
        $handler->init();
        do_action('utcw_shortcode');

        $this->assertTrue(
            defined('DONOTCACHEPAGE'),
            'WP Super Cache handler should define the constant DONOTCACHEPAGE when the shortcode is run'
        );
    }
}