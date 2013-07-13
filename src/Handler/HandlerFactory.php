<?php

class UTCW_HandlerFactory
{
    protected $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

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