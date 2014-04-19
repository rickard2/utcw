<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage main
 * @since      2.4
 */

/**
 * Class to handle short code
 *
 * @since      2.4
 * @package    utcw
 * @subpackage main
 */
class UTCW_ShortCode
{
    /**
     * @var UTCW_Plugin
     * @since 2.4
     */
    protected $plugin;

    /**
     * Never serialize private members
     *
     * @return array
     *
     * @since 2.6
     */
    public function __sleep()
    {
        return array();
    }

    /**
     * Fetch a new copy of the plugin when waking up
     *
     * @since 2.6
     */
    public function __wakeup()
    {
        $this->plugin = UTCW_Plugin::getInstance();
    }

    /**
     * @param UTCW_Plugin $plugin
     *
     * @since 2.4
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        $this->plugin = $plugin;

        add_shortcode('utcw', array($this, 'render'));
    }

    /**
     * @since 2.4
     */
    public function triggerPreShortCode()
    {
        global $post;

        if ($post && isset($post->post_content) && $this->hasShortCode($post->post_content)) {
            do_action('utcw_pre_shortcode');
        }
    }

    /**
     * Check if the content contains the shortcode. Will use WP 3.6+ has_shortcode if available, otherwise
     * fall back to string matching.
     *
     * @param $content
     *
     * @return bool
     * @since 2.4
     */
    protected function hasShortCode($content)
    {
        if (function_exists('has_shortcode')) {
            return has_shortcode($content, 'utcw');
        }

        return strpos($content, '[utcw') !== false;
    }


    /**
     * Short code handler for 'utcw' hook
     *
     * @param array $args
     *
     * @return string
     * @since 2.4
     */
    public function render(array $args)
    {
        global $wpdb;

        if (isset($args['load_config'])) {
            $loaded = $this->plugin->loadConfiguration($args['load_config']);

            if (is_array($loaded)) {
                $args = $loaded;
            }
        }

        $this->plugin->set('wpdb', $wpdb);
        $this->plugin->set('dataConfig', new UTCW_DataConfig($args, $this->plugin));
        $this->plugin->set('renderConfig', new UTCW_RenderConfig($args, $this->plugin));
        $this->plugin->set('data', new UTCW_Data($this->plugin));

        $render = new UTCW_Render($this->plugin);

        do_action('utcw_shortcode', $args);

        return apply_filters('filter_shortcode', $render->getCloud());
    }
}
