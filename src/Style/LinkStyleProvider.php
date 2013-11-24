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
 * Class for CSS styles for links
 *
 * @since      2.6
 * @package    utcw
 * @subpackage style
 */
class UTCW_LinkStyleProvider extends UTCW_StyleProvider
{
    /**
     * @return array
     * @since 2.6
     */
    public function getStyles()
    {
        $config = $this->plugin->get('renderConfig');

        $link_styles = array();

        if (!$this->hasDefaultValue('link_underline')) {
            $link_styles[] = sprintf(
                'text-decoration:%s',
                $config->link_underline === 'yes' ? 'underline' : 'none'
            );
        }

        if (!$this->hasDefaultValue('link_bold')) {
            $link_styles[] = sprintf('font-weight:%s', $config->link_bold === 'yes' ? 'bold' : 'normal');
        }

        if (!$this->hasDefaultValue('link_italic')) {
            $link_styles[] = sprintf('font-style:%s', $config->link_italic === 'yes' ? 'italic' : 'normal');
        }

        if (!$this->hasDefaultValue('link_bg_color')) {
            $link_styles[] = sprintf('background-color:%s', $config->link_bg_color);
        }

        if (
            !$this->hasDefaultValue('link_border_style') &&
            !$this->hasDefaultValue('link_border_color') &&
            !$this->hasDefaultValue('link_border_width')
        ) {
            $link_styles[] = sprintf(
                'border:%s %s %s',
                $config->link_border_style,
                $config->link_border_width,
                $config->link_border_color
            );
        } else {
            if (!$this->hasDefaultValue('link_border_style')) {
                $link_styles[] = sprintf('border-style:%s', $config->link_border_style);
            }

            if (!$this->hasDefaultValue('link_border_color')) {
                $link_styles[] = sprintf('border-color:%s', $config->link_border_color);
            }

            if (!$this->hasDefaultValue('link_border_width')) {
                $link_styles[] = sprintf('border-width:%s', $config->link_border_width);
            }
        }

        if (!$this->hasDefaultValue('tag_spacing')) {
            $link_styles[] = sprintf('margin-right:%s', $config->tag_spacing);
        }

        if (!$this->hasDefaultValue('line_height')) {
            $link_styles[] = sprintf('line-height:%s', $config->line_height);
        }

        if (!$this->hasDefaultValue('prevent_breaking')) {
            $link_styles[] = 'white-space:nowrap';
        }

        return $link_styles;
    }

    /**
     * @return array
     * @since 2.6
     */
    public function getSelectors()
    {
        return array('span', 'a');
    }
}