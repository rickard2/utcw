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
 * Factory class to handle creation of a handler
 *
 * @since      2.4
 * @package    utcw
 * @subpackage handler
 */
class UTCW_HandlerFactory
{
    /**
     * An array of available handlers
     *
     * @var UTCW_Handler[]
     *
     * @since 2.4
     */
    protected $handlers;

    /**
     * @param UTCW_Handler[] $handlers
     *
     * @since 2.4
     */
    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * Returns an instance of the first enabled handler found
     *
     * @return UTCW_Handler
     *
     * @since 2.4
     */
    public function getInstance()
    {
        foreach ($this->handlers as $handler) {

            $instance = new $handler();

            /** @var UTCW_Handler $instance */

            if ($instance->isEnabled()) {
                $instance->init();

                return $instance;
            }
        }

        return false;
    }
}