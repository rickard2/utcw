<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
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
        $this->styles = array('word-wrap:break-word');

        $this->addStyle('text_transform', 'text-transform:%s');
        $this->addStyle('letter_spacing', 'letter-spacing:%s');
        $this->addStyle('word_spacing', 'word-spacing:%s');
        $this->addStyle('alignment', 'text-align:%s');

        return $this->styles;
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