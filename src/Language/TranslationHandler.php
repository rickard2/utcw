<?php

//namespace Rickard\UTCW\Language;

/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage language
 * @since      2.2
 */

//use Rickard\UTCW\Plugin;
//use Rickard\UTCW\Term;
//use stdClass;

/**
 * Abstract class to handle multi language support
 *
 * @since      2.2
 * @package    utcw
 * @subpackage language
 */
abstract class UTCW_TranslationHandler
{
    /**
     * Returns true if this multi-language plugin is enabled
     *
     * @return bool
     * @since 2.2
     */
    abstract public function isEnabled();

    /**
     * Returns a new Term or null depending on if the term should be included with the current language settings.
     * The returned Term will have its name translated into the current language
     *
     * @param stdClass $input
     * @param UTCW_Plugin   $plugin
     *
     * @return null|UTCW_Term
     * @since 2.2
     */
    abstract public function createTerm(stdClass $input, UTCW_Plugin $plugin);
}