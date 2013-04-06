<?php

namespace Rickard\UTCW;

use stdClass;

class QTranslateTerm extends Term
{
    public function __construct(stdClass $input, Plugin $plugin)
    {

        $input->name = $plugin->getQTranslateTermName($input->name);

        parent::__construct($input, $plugin);
    }
}