<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.4
 * @license    GPLv2
 * @package    utcw
 * @subpackage cache
 * @since      2.4
 */
abstract class UTCW_CacheHandler
{
    /**
     * Returns true if the caching plugin is enabled
     *
     * @return bool
     */
    abstract public function isEnabled();

    /**
     * Initializes the handler
     *
     * @return void
     */
    abstract public function init();
}