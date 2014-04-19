<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage language
 * @since      2.2
 */

/**
 * Abstract class to handle multi language support
 *
 * @since      2.2
 * @package    utcw
 * @subpackage language
 */
abstract class UTCW_TranslationHandler extends UTCW_Handler
{
    /**
     * Returns a new Term or null depending on if the term should be included with the current language settings.
     * The returned Term will have its name translated into the current language
     *
     * @param stdClass    $input
     * @param UTCW_Plugin $plugin
     *
     * @return null|UTCW_Term
     * @since 2.2
     */
    abstract public function createTerm(stdClass $input, UTCW_Plugin $plugin);
}