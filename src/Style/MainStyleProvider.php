<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.6
 * @license    GPLv2
 * @package    utcw
 * @subpackage style
 * @since      2.6
 */

/**
 * Class for CSS styles for the main element
 *
 * @since      2.6
 * @package    utcw
 * @subpackage style
 */
class UTCW_MainStyleProvider extends UTCW_StyleProvider
{
    /**
     * @return array
     * @since 2.6
     */
    public function getStyles()
    {
        $config = $this->plugin->get('renderConfig');

        $main_styles = array('word-wrap:break-word');

        if (!$this->hasDefaultValue('text_transform')) {
            $main_styles[] = sprintf('text-transform:%s', $config->text_transform);
        }

        if (!$this->hasDefaultValue('letter_spacing')) {
            $main_styles[] = sprintf('letter-spacing:%s', $config->letter_spacing);
        }

        if (!$this->hasDefaultValue('word_spacing')) {
            $main_styles[] = sprintf('word-spacing:%s', $config->word_spacing);
        }

        if (!$this->hasDefaultValue('alignment')) {
            $main_styles[] = sprintf('text-align:%s', $config->alignment);
        }

        return $main_styles;
    }

    /**
     * @return array
     * @since 2.6
     */
    public function getSelectors()
    {
        return array('');
    }
}