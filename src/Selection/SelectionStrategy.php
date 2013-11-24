<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.5
 * @license    GPLv2
 * @package    utcw
 * @subpackage selection
 * @since      2.2
 */

/**
 * Abstract class to define selection strategy for finding terms
 *
 * @since      2.2
 * @package    utcw
 * @subpackage language
 */
abstract class UTCW_SelectionStrategy
{
    /**
     * Plugin class instance
     *
     * @var UTCW_Plugin
     * @since 2.2
     */
    protected $plugin;

    /**
     * Creates a new instance
     *
     * @param UTCW_Plugin $plugin Main plugin instance
     *
     * @since 2.2
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Loads terms based on current configuration
     *
     * @return stdClass[]
     * @since 2.2
     */
    abstract public function getData();

    /**
     * Clean up the internal members for debug output
     *
     * @return void
     */
    public function cleanupForDebug()
    {
        $this->plugin->remove('wpdb');
    }
}