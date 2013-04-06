<?php

namespace Rickard\UTCW;

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
 * Class to handle QTranslate multi language support
 *
 * Class QTranslateHandler
 *
 * @since      2.2
 * @package    utcw
 * @subpackage language
 */
class QTranslateHandler
{
    /**
     * An array of term names mapped to translated names
     *
     * @var array
     * @since 2.2
     */
    protected $nameMap;

    /**
     * @param array $nameMap An array of term names mapped to translated names
     * @since 2.2
     */
    public function __construct(array $nameMap)
    {
        $this->nameMap = $nameMap;
    }

    /**
     * Returns true if QTranslate support is enabled
     *
     * @return bool
     * @since 2.2
     */
    public function isEnabled()
    {
        return defined('QT_SUPPORTED_WP_VERSION');
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
     * Returns the QTranslate translated name for the given term name.
     *
     * Language is optional and will be determined to the current language if omitted.
     *
     * @param string $term
     * @param string $language (optional)
     *
     * @return string
     * @since 2.2
     */
    public function getTermName($term, $language = null)
    {
        if (!$language) {
            $language = $this->getLanguage();
        }

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