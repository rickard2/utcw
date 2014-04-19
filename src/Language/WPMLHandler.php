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
 * Class to handle WPML multi-language support
 *
 * @since      2.2
 * @package    utcw
 * @subpackage language
 */
class UTCW_WPMLHandler extends UTCW_TranslationHandler
{
    /**
     * Returns true if WPML is installed and active
     *
     * @return bool
     * @since 2.2
     */
    public function isEnabled()
    {
        return defined('ICL_LANGUAGE_CODE');
    }

    /**
     * @since 2.4
     */
    public function init()
    {
        // void
    }

    /**
     * Returns the current WPML language
     *
     * @return bool|string
     * @since 2.2
     */
    public function getLanguage()
    {
        return defined('ICL_LANGUAGE_CODE') ? constant('ICL_LANGUAGE_CODE') : false;
    }

    /**
     * Returns the default language for WPML
     *
     * @return string
     * @since 2.2
     */
    public function getDefaultLanguage()
    {
        /** @var SitePress */
        global $sitepress;
        return $sitepress->get_default_language();
    }

    /**
     * Returns the WPML translated name for the given term name
     *
     * @param string $term
     *
     * @return string
     * @since 2.2
     */
    public function getTermName($term)
    {
        /** @var SitePress */
        global $sitepress;

        $translated = $sitepress->the_category_name_filter($term);

        if (!$translated) {
            return $term;
        }

        return $translated;
    }

    /**
     * Returns true if the given term input is determined to be in the current language
     *
     * @param stdClass $input
     *
     * @return bool
     * @since 2.2
     */
    public function isInCurrentLanguage(stdClass $input)
    {
        $icl_object_id = icl_object_id($input->term_id, $input->taxonomy);

        // For tags, icl_object_id is null for some reason and the language is present in the term name
        if ($icl_object_id === null) {
            $language        = $this->getLanguage();
            $defaultLanguage = $this->getDefaultLanguage();

            if ($language === $defaultLanguage) {
                return strpos($input->name, '@') === false; // Terms in the default language doesn't have a @-notation
            }

            // Translated terms will have @{lang} at the end
            return strpos($input->name, '@' . $language) !== false;
        }

        // If the returned object id is the same, it's in the current language
        return $icl_object_id == $input->term_id;
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
        if ($this->isInCurrentLanguage($input)) {

            $input->name = $this->getTermName($input->name);

            return new UTCW_Term($input, $plugin);
        }

        return null;
    }
}