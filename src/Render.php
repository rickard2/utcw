<?php

//namespace Rickard\UTCW;

/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage main
 * @since      2.0
 */

/**
 * Class for rendering the cloud
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */
class UTCW_Render
{

    /**
     * Reference to the Data class which contains the data to be rendered
     *
     * @var UTCW_Data
     * @since 2.0
     */
    private $data;

    /**
     * Reference to the current configuration
     *
     * @var UTCW_Config
     * @since 2.0
     */
    private $config;

    /**
     * Reference to the main plugin instance
     *
     * @var UTCW_Plugin
     * @since 2.0
     */
    private $plugin;

    /**
     * Unique ID for this widget configuration
     *
     * @var int
     * @since 2.0
     */
    private $id;

    /**
     * CSS styles for this widget instance
     *
     * @var string
     * @since 2.0
     */
    private $css = '';

    /**
     * Creates a new instance of the renderer
     *
     * @param UTCW_Plugin $plugin Main plugin instance
     *
     * @since 2.0
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        $this->data   = $plugin->get('data');
        $this->config = $plugin->get('renderConfig');
        $this->plugin = $plugin;
        $this->id     = base_convert(crc32(serialize($this->config)), 10, 27);

        $this->buildCSS();
    }

    /**
     * Renders the cloud as output
     *
     * @since 2.0
     */
    public function render()
    {
        echo $this->getCloud();
    }

    /**
     * Returns the cloud as a string
     *
     * @return string
     * @since 2.0
     */
    public function getCloud()
    {
        $markup = array();

        if ($this->css) {
            $markup[] = $this->css;
        }

        if ($this->config->before_widget) {
            $markup[] = str_replace('widget_utcw', 'widget_utcw widget_tag_cloud', $this->config->before_widget);
        }

        if ($this->config->show_title_text) {
            if ($this->config->before_title) {
                $markup[] = $this->config->before_title;
            }

            $markup[] = $this->plugin->applyFilters('widget_title', $this->config->title);

            if ($this->config->after_title) {
                $markup[] = $this->config->after_title;
            }
        }

        $markup[] = '<div class="tagcloud utcw-' . $this->id . '">';

        $terms = array();

        foreach ($this->data->getTerms() as $term) {
            $color = $term->color ? ';color:' . $term->color : '';
            $title = $this->config->show_title ? sprintf(
                ' title="' . _n('%s topic', '%s topics', $term->count) . '"',
                $term->count
            ) : '';
            $tag   = $this->config->show_links ? 'a' : 'span';

            $terms[] = sprintf(
                '%s<%s class="tag-link-%s" href="%s" style="font-size:%s%s"%s>%s</%s>%s',
                $this->config->prefix,
                $tag,
                $term->term_id,
                $term->link,
                $term->size,
                $color,
                $title,
                $term->name,
                $tag,
                $this->config->suffix
            );
        }

        if ($this->config->display === 'list') {
            $markup[] = '<ul>';

            $terms = array_map(create_function('$term', 'return sprintf("<li>%s</li>", $term);'), $terms);
        }

        $markup[] = join($this->config->separator, $terms);

        if ($this->config->display === 'list') {
            $markup[] = '</ul>';
        }

        $markup[] = '</div>';

        if ($this->config->debug) {
            $debug_object = clone $this->data;
            $debug_object->cleanupForDebug();
            $markup[] = sprintf("<!-- Ultimate Tag Cloud Debug information:\n%s -->", print_r($debug_object, true));
        }

        if ($this->config->after_widget) {
            $markup[] = $this->config->after_widget;
        }

        return join('', $markup);
    }

    /**
     * Builds the CSS needed to properly style the cloud
     *
     * @since 2.0
     */
    private function buildCSS()
    {
        $main_styles = array('word-wrap:break-word');

        if (!$this->hasDefaultValue('text_transform')) {
            $main_styles[] = sprintf('text-transform:%s', $this->config->text_transform);
        }

        if (!$this->hasDefaultValue('letter_spacing')) {
            $main_styles[] = sprintf('letter-spacing:%s', $this->config->letter_spacing);
        }

        if (!$this->hasDefaultValue('word_spacing')) {
            $main_styles[] = sprintf('word-spacing:%s', $this->config->word_spacing);
        }

        if (!$this->hasDefaultValue('alignment')) {
            $main_styles[] = sprintf('text-align:%s', $this->config->alignment);
        }

        $link_styles = array();

        if (!$this->hasDefaultValue('link_underline')) {
            $link_styles[] = sprintf(
                'text-decoration:%s',
                $this->config->link_underline === 'yes' ? 'underline' : 'none'
            );
        }

        if (!$this->hasDefaultValue('link_bold')) {
            $link_styles[] = sprintf('font-weight:%s', $this->config->link_bold === 'yes' ? 'bold' : 'normal');
        }

        if (!$this->hasDefaultValue('link_italic')) {
            $link_styles[] = sprintf('font-style:%s', $this->config->link_italic === 'yes' ? 'italic' : 'normal');
        }

        if (!$this->hasDefaultValue('link_bg_color')) {
            $link_styles[] = sprintf('background-color:%s', $this->config->link_bg_color);
        }

        if (
            !$this->hasDefaultValue('link_border_style') &&
            !$this->hasDefaultValue('link_border_color') &&
            !$this->hasDefaultValue('link_border_width')
        ) {
            $link_styles[] = sprintf(
                'border:%s %s %s',
                $this->config->link_border_style,
                $this->config->link_border_width,
                $this->config->link_border_color
            );
        } else {
            if (!$this->hasDefaultValue('link_border_style')) {
                $link_styles[] = sprintf('border-style:%s', $this->config->link_border_style);
            }

            if (!$this->hasDefaultValue('link_border_color')) {
                $link_styles[] = sprintf('border-color:%s', $this->config->link_border_color);
            }

            if (!$this->hasDefaultValue('link_border_width')) {
                $link_styles[] = sprintf('border-width:%s', $this->config->link_border_width);
            }
        }

        if (!$this->hasDefaultValue('tag_spacing')) {
            $link_styles[] = sprintf('margin-right:%s', $this->config->tag_spacing);
        }

        if (!$this->hasDefaultValue('line_height')) {
            $link_styles[] = sprintf('line-height:%s', $this->config->line_height);
        }

        $hover_styles = array();

        if (!$this->hasDefaultValue('hover_underline')) {
            $hover_styles[] = sprintf(
                'text-decoration:%s',
                $this->config->hover_underline === 'yes' ? 'underline' : 'none'
            );
        }

        if (!$this->hasDefaultValue('hover_bold')) {
            $hover_styles[] = sprintf('font-weight:%s', $this->config->hover_bold === 'yes' ? 'bold' : 'normal');
        }

        if (!$this->hasDefaultValue('hover_italic')) {
            $hover_styles[] = sprintf('font-style:%s', $this->config->hover_italic === 'yes' ? 'italic' : 'normal');
        }

        if (!$this->hasDefaultValue('hover_bg_color')) {
            $hover_styles[] = sprintf('background-color:%s', $this->config->hover_bg_color);
        }


        if (!$this->hasDefaultValue('hover_border_style') && !$this->hasDefaultValue(
                'hover_border_color'
            ) && !$this->hasDefaultValue('hover_border_width')
        ) {
            $hover_styles[] = sprintf(
                'border:%s %s %s',
                $this->config->hover_border_style,
                $this->config->hover_border_width,
                $this->config->hover_border_color
            );
        } else {
            if (!$this->hasDefaultValue('hover_border_style')) {
                $hover_styles[] = sprintf('border-style:%s', $this->config->hover_border_style);
            }

            if (!$this->hasDefaultValue('hover_border_color')) {
                $hover_styles[] = sprintf('border-color:%s', $this->config->hover_border_color);
            }

            if (!$this->hasDefaultValue('hover_border_width')) {
                $hover_styles[] = sprintf('border-width:%s', $this->config->hover_border_width);
            }
        }

        if (!$this->hasDefaultValue('hover_color')) {
            $hover_styles[] = sprintf('color:%s', $this->config->hover_color);
        }

        $styles = array();

        if ($main_styles) {
            $styles[] = sprintf('.utcw-%s{%s}', $this->id, join(';', $main_styles));
        }

        if ($link_styles) {
            $styles[] = sprintf('.utcw-%s span,.utcw-%s a{%s}', $this->id, $this->id, join(';', $link_styles));
        }

        if ($hover_styles) {
            $styles[] = sprintf(
                '.utcw-%s span:hover,.utcw-%s a:hover{%s}',
                $this->id,
                $this->id,
                join(';', $hover_styles)
            );
        }

        if ($styles) {
            $this->css = sprintf('<style type="text/css">%s</style>', join('', $styles));
        }
    }

    /**
     * Checks if option still has the default value
     *
     * @param string $option
     *
     * @return bool
     * @since 2.0
     */
    private function hasDefaultValue($option)
    {
        $defaultConfig = new UTCW_RenderConfig(array(), $this->plugin);
        $defaults      = $defaultConfig->getInstance();

        return $this->config->$option === $defaults[$option];
    }
}
