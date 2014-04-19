<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
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
     * @var UTCW_RenderConfig
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
            $markup[] = $this->plugin->applyFilters('utcw_render_css', $this->css);
        }

        if ($this->config->before_widget) {

            // If theme styling should be avoided, keep the utcw specific classes
            if ($this->config->avoid_theme_styling) {
                $markup[] = $this->config->before_widget;
            } // If theme styling should be enforced, swap classes to the regular tag cloud classes
            else {
                $markup[] = str_replace('widget_utcw', 'widget_utcw widget_tag_cloud', $this->config->before_widget);
            }
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

        $classes = array('utcw-' . $this->id);

        if (!$this->config->avoid_theme_styling) {
            $classes[] = 'tagcloud';
        }

        $markup[] = '<div class="' . join(' ', $classes) . '">';

        $termObjects = $this->plugin->applyFilters('utcw_render_terms', $this->data->getTerms());

        $terms = array();

        foreach ($termObjects as $term) {
            $color = $term->color ? ';color:' . $term->color : '';

            $title = '';

            if ($this->config->show_title) {
                $title = $this->getTitle($term);
            }

            $tag = $this->config->show_links ? 'a' : 'span';
            $tag = $this->plugin->applyFilters('utcw_render_tag', $tag);

            $displayName = $this->config->show_post_count ? sprintf('%s (%d)', $term->name, $term->count) : $term->name;
            $displayName = $this->plugin->applyFilters('utcw_render_term_display_name', $displayName, $term->name);

            $terms[] = sprintf(
                '%s<%s class="tag-link-%s utcw-tag utcw-tag-%s" href="%s" style="font-size:%s%s"%s>%s</%s>%s',
                $this->config->prefix,
                $tag,
                $term->term_id,
                $term->slug,
                $term->link,
                $term->size,
                $color,
                $title,
                $displayName,
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

        return do_shortcode(join('', $markup));
    }

    /**
     * Builds the CSS needed to properly style the cloud
     *
     * @since 2.0
     */
    private function buildCSS()
    {
        /** @var UTCW_StyleProvider[] $providers */
        $providers = array(
            new UTCW_MainStyleProvider($this->plugin),
            new UTCW_LinkStyleProvider($this->plugin),
            new UTCW_HoverStyleProvider($this->plugin),
        );

        $css = array();

        foreach ($providers as $provider) {

            $selectors = $provider->getSelectors();
            $styles    = $provider->getStyles();

            if ($styles) {

                // Add base class to each selector
                foreach ($selectors as $key => $selector) {
                    $selectors[$key] = sprintf('.utcw-%s %s', $this->id, $selector);
                }

                // Construct CSS with comma separated selectors and the styles
                $css[] = sprintf('%s{%s}', join(',', $selectors), join(';', $styles));
            }

        }

        if ($css) {
            $this->css = sprintf('<style scoped type="text/css">%s</style>', join('', $css));
        }
    }

    /**
     * Returns the title attribute for the given term
     *
     * @param UTCW_Term $term
     *
     * @return string
     * @since 2.4
     */
    private function getTitle(UTCW_Term $term)
    {
        $title = '';

        switch ($this->config->title_type) {
            case 'counter':
                $term_title_singular = $this->plugin->applyFilters('utcw_render_term_title_singular', '%d topic');
                $term_title_plural   = $this->plugin->applyFilters('utcw_render_term_title_plural', '%d topics');

                $title = _n($term_title_singular, $term_title_plural, $term->count, 'utcw');

                if (strpos($title, '%d') !== false) {
                    $title = sprintf(' title="' . $title . '"', $term->count);
                }
                break;

            case 'name':
                $title = sprintf(' title="%s"', $term->name);
                break;

            case 'custom':
                $template       = $this->config->title_custom_template;
                $stringPosition = strpos($template, '%s');
                $numberPosition = strpos($template, '%d');
                $containsString = $stringPosition !== false;
                $containsNumber = $numberPosition !== false;
                $stringFirst    = $stringPosition < $numberPosition;

                if ($containsString && $containsNumber && $stringFirst) {
                    $title = sprintf(' title="' . $template . '"', $term->name, $term->count);
                } elseif ($containsString && $containsNumber) {
                    $title = sprintf(' title="' . $template . '"', $term->count, $term->name);
                } elseif ($containsString) {
                    $title = sprintf(' title="' . $template . '"', $term->name);
                } elseif ($containsNumber) {
                    $title = sprintf(' title="' . $template . '"', $term->count);
                } else {
                    $title = sprintf(' title="%s"', $template);
                }
                break;
        }

        return $title;
    }
}
