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
 * Class for CSS styles for hovering
 *
 * @since      2.6
 * @package    utcw
 * @subpackage style
 */
class UTCW_HoverStyleProvider extends UTCW_StyleProvider
{

    /**
     * @return array
     * @since 2.6
     */
    public function getStyles()
    {
        $config       = $this->plugin->get('renderConfig');
        $this->styles = array();

        $this->addStyle(
            'hover_underline',
            'text-decoration:%s',
            $config->hover_underline === 'yes' ? 'underline' : 'none'
        );

        $this->addStyle('hover_bold', 'font-weight:%s', $config->hover_bold === 'yes' ? 'bold' : 'normal');
        $this->addStyle('hover_italic', 'font-style:%s', $config->hover_italic === 'yes' ? 'italic' : 'normal');
        $this->addStyle('hover_bg_color', 'background-color:%s');

        if (
            !$this->hasDefaultValue('hover_border_style') &&
            !$this->hasDefaultValue('hover_border_color') &&
            !$this->hasDefaultValue('hover_border_width')
        ) {
            $this->styles[] = sprintf(
                'border:%s %s %s',
                $config->hover_border_style,
                $config->hover_border_width,
                $config->hover_border_color
            );
        } else {
            $this->addStyle('hover_border_style', 'border-style:%s');
            $this->addStyle('hover_border_color', 'border-color:%s');
            $this->addStyle('hover_border_width', 'border-width:%s');
        }

        $this->addStyle('hover_color', 'color:%s');

        return $this->styles;
    }

    /**
     * @return array
     * @since 2.6
     */
    public function getSelectors()
    {
        return array('span:hover', 'a:hover');
    }
}