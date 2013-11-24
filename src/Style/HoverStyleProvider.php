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
        $hover_styles = array();

        if (!$this->hasDefaultValue('hover_underline')) {
            $hover_styles[] = sprintf(
                'text-decoration:%s',
                $config->hover_underline === 'yes' ? 'underline' : 'none'
            );
        }

        if (!$this->hasDefaultValue('hover_bold')) {
            $hover_styles[] = sprintf('font-weight:%s', $config->hover_bold === 'yes' ? 'bold' : 'normal');
        }

        if (!$this->hasDefaultValue('hover_italic')) {
            $hover_styles[] = sprintf('font-style:%s', $config->hover_italic === 'yes' ? 'italic' : 'normal');
        }

        if (!$this->hasDefaultValue('hover_bg_color')) {
            $hover_styles[] = sprintf('background-color:%s', $config->hover_bg_color);
        }


        if (!$this->hasDefaultValue('hover_border_style') && !$this->hasDefaultValue(
                'hover_border_color'
            ) && !$this->hasDefaultValue('hover_border_width')
        ) {
            $hover_styles[] = sprintf(
                'border:%s %s %s',
                $config->hover_border_style,
                $config->hover_border_width,
                $config->hover_border_color
            );
        } else {
            if (!$this->hasDefaultValue('hover_border_style')) {
                $hover_styles[] = sprintf('border-style:%s', $config->hover_border_style);
            }

            if (!$this->hasDefaultValue('hover_border_color')) {
                $hover_styles[] = sprintf('border-color:%s', $config->hover_border_color);
            }

            if (!$this->hasDefaultValue('hover_border_width')) {
                $hover_styles[] = sprintf('border-width:%s', $config->hover_border_width);
            }
        }

        if (!$this->hasDefaultValue('hover_color')) {
            $hover_styles[] = sprintf('color:%s', $config->hover_color);
        }

        return $hover_styles;
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