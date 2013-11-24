<?php

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.5
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Hooks extends WP_UnitTestCase
{
    public function test_hooks()
    {
        $plugin = $this->getMock(
            'UTCW_Plugin',
            array('initAdminAssets', 'wpLoaded', 'widgetsInit'),
            array(),
            '',
            false
        );

        $plugin->expects($this->once())->method('initAdminAssets');
        $plugin->expects($this->once())->method('wpLoaded');
//        $plugin->expects($this->once())->method('widgetsInit');

        /** @var UTCW_Plugin $plugin */
        $plugin->setHooks();

        do_action('admin_head-widgets.php');
        do_action('wp_loaded');
//        do_action('widgets_init');
    }
}
