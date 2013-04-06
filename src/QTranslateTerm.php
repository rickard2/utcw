<?php

namespace Rickard\UTCW;

use stdClass;

class QTranslateTerm extends Term
{
    public function __construct(stdClass $input, Plugin $plugin)
    {
        $handler     = $plugin->getQTranslateHandler();
        $input->name = $handler->getTermName($input->name);

        parent::__construct($input, $plugin);
    }
}