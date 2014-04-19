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
 * Class to handle QTranslate multi language support
 *
 * @since      2.2
 * @package    utcw
 * @subpackage language
 */
class UTCW_QTranslateHandler extends UTCW_TranslationHandler
{
    /**
     * An array of term names mapped to translated names
     *
     * @var array
     * @since 2.2
     */
    protected $nameMap;

    /**
     * Returns true if QTranslate is installed and active
     *
     * @return bool
     * @since 2.2
     */
    public function isEnabled()
    {
        return defined('QT_SUPPORTED_WP_VERSION');
    }


    /**
     * Initializes the QTranslate Handler
     *
     * @since 2.4
     */
    public function init()
    {
        $names = get_option('qtranslate_term_name');
        $names = $names ? $names : array();

        $this->nameMap = $names;
    }

    /**
     * Returns the current QTranslate language
     *
     * @return string|bool
     * @since 2.2
     */
    public function getLanguage()
    {
        return function_exists('qtrans_getLanguage') ? qtrans_getLanguage() : false;
    }

    /**
     * {@inheritdoc}
     *
     * @param stdClass    $input
     * @param UTCW_Plugin $plugin
     *
     * @return null|UTCW_Term
     * @since 2.2
     */
    public function createTerm(stdClass $input, UTCW_Plugin $plugin)
    {
        $input->name = $this->getTermName($input->name);

        return new UTCW_Term($input, $plugin);
    }

    /**
     * Returns the QTranslate translated name for the given term name.
     *
     * @param string $term
     *
     * @return string
     * @since 2.2
     */
    public function getTermName($term)
    {
        $language = $this->getLanguage();

        if (!$language) {
            return $term;
        }

        $language = strtolower($language);

        if (!isset($this->nameMap[$term][$language])) {
            return $term;
        }

        return $this->nameMap[$term][$language];
    }
}