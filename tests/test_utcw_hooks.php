<?php
////use Rickard\UTCW\Widget;

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.2.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Hooks extends WP_UnitTestCase
{
    public function test_hooks()
    {
        UTCW_Plugin::getInstance();

        do_action('admin_head-widgets.php');
        do_action('wp_loaded');
        do_action('widgets_init');
    }
}
