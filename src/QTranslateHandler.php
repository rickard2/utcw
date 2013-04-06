<?php

namespace Rickard\UTCW;

/**
 * Class to handle QTranslate multi language support
 *
 * Class QTranslateHandler
 *
 * @package Rickard\UTCW
 */
class QTranslateHandler
{
    /**
     * An array of term names mapped to translated names
     *
     * @var array
     */
    protected $nameMap;

    /**
     * @param array $nameMap An array of term names mapped to translated names
     */
    public function __construct(array $nameMap)
    {
        $this->nameMap = $nameMap;
    }

    /**
     * Returns true if QTranslate support is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return defined('QT_SUPPORTED_WP_VERSION');
    }

    /**
     * Returns the current QTranslate language
     *
     * @return string|bool
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