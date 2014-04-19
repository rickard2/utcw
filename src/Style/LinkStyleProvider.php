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
        $config       = $this->plugin->get('renderConfig');
        $this->styles = array();

        $this->addStyle(
            'link_underline',
            'text-decoration:%s',
            $config->link_underline === 'yes' ? 'underline' : 'none'
        );

        $this->addStyle('link_bold', 'font-weight:%s', $config->link_bold === 'yes' ? 'bold' : 'normal');
        $this->addStyle('link_italic', 'font-style:%s', $config->link_italic === 'yes' ? 'italic' : 'normal');
        $this->addStyle('link_bg_color', 'background-color:%s');

        if (
            !$this->hasDefaultValue('link_border_style') &&
            !$this->hasDefaultValue('link_border_color') &&
            !$this->hasDefaultValue('link_border_width')
        ) {
            $this->styles[] = sprintf(
                'border:%s %s %s',
                $config->link_border_style,
                $config->link_border_width,
                $config->link_border_color
            );
        } else {
            $this->addStyle('link_border_style', 'border-style:%s');
            $this->addStyle('link_border_color', 'border-color:%s');
            $this->addStyle('link_border_width', 'border-width:%s');
        }

        $this->addStyle('tag_spacing', 'margin-right:%s');
        $this->addStyle('line_height', 'line-height:%s');
        $this->addStyle('prevent_breaking', 'white-space:%s', 'nowrap');

        return $this->styles;
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