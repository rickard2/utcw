<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage cache
 * @since      2.4
 */
class UTCW_WPSuperCacheHandler extends UTCW_Handler
{

    /**
     * Returns true if WP Super Cache is enabled
     *
     * @return bool
     * @since 2.4
     */
    public function isEnabled()
    {
        return function_exists('add_cacheaction');
    }

    /**
     * Initializes the handler
     *
     * @since 2.4
     */
    public function init()
    {
        add_action('utcw_shortcode', array($this, 'onShortCode'));
    }

    /**
     * Called when the shortcode is used
     *
     * @since 2.4
     */
    public function onShortCode()
    {
        if (!defined('DONOTCACHEPAGE')) {
            define('DONOTCACHEPAGE', true);
        }
    }
}