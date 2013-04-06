<?php

namespace Rickard\UTCW;

use stdClass;

/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage language
 * @since      2.0
 */

/**
 * Class to represent a QTranslate translated term
 *
 * Class QTranslateHandler
 *
 * @since      2.2
 * @package    utcw
 * @subpackage language
 */
class QTranslateTerm extends Term
{
    /**
     * {@inheritdoc}
     *
     * @param stdClass $input
     * @param Plugin   $plugin
     *
     * @since 2.2
     */
    public function __construct(stdClass $input, Plugin $plugin)
    {
        $handler     = $plugin->getQTranslateHandler();
        $input->name = $handler->getTermName($input->name);

        parent::__construct($input, $plugin);
    }
}