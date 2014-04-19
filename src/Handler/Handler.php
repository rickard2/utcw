<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage handler
 * @since      2.4
 */

/**
 * Base class to represent a handler
 *
 * @since      2.4
 * @package    utcw
 * @subpackage handler
 */
abstract class UTCW_Handler
{
    /**
     * Returns true if the handler is enabled
     *
     * @return bool
     *
     * @since 2.4
     */
    abstract public function isEnabled();

    /**
     * Perform initialization tasks for this handler
     *
     * @return mixed
     *
     * @since 2.4
     */
    abstract public function init();
}