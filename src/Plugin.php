<?php

namespace Rickard\UTCW;

    /**
     * Ultimate Tag Cloud Widget
     *
     * @author     Rickard Andersson <rickard@0x539.se>
     * @version    2.1
     * @license    GPLv2
     * @package    utcw
     * @subpackage main
     * @since      2.0
     */

/**
 * Class for general plugin integration with WordPress
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */
class Plugin
{

    /**
     * An array of which taxonomies are available
     *
     * @var array
     * @since 2.0
     */
    protected $allowed_taxonomies = array();

    /**
     * An array of which post types are available
     *
     * @var array
     * @since 2.0
     */
    protected $allowed_post_types = array();

    /**
     * Singleton instance
     *
     * @var Plugin
     * @since 2.0
     */
    private static $instance;

    /**
     * Initializes the WordPress hooks needed
     *
     * @todo  Add tests that these hooks are set
     * @since 2.0
     */
    private function __construct()
    {
        add_action('admin_head-widgets.php', array($this, 'initAdminAssets'));
        add_action('wpLoaded', array($this, 'wpLoaded'));
        add_action('widgets_init', create_function('', 'return register_widget("UTCW");'));
        add_shortcode('utcw', array($this, 'shortcode'));
    }

    /**
     * Returns an instance of the plugin
     *
     * @static
     * @return Plugin
     * @since 2.0
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Action handler for 'wpLoaded' hook
     * Loads taxonomies and post types
     *
     * @since 2.0
     */
    public function wpLoaded()
    {
        $this->allowed_taxonomies = get_taxonomies();
        $this->allowed_post_types = get_post_types(array('public' => true));
    }

    /**
     * Shortcode handler for 'utcw' hook
     *
     * @param array $args
     *
     * @return string
     * @since 2.0
     */
    public function shortcode(array $args)
    {
        global $wpdb;

        $config = new Config($args, $this);
        $data   = new Data($config, $this, $wpdb);
        $render = new Render($config, $data, $this);

        return $render->getCloud();
    }

    /**
     * Action handler for 'admin_head-widgets.php' hook
     * Loads assets needed by the administration interface
     *
     * @since 2.0
     */
    public function initAdminAssets()
    {
        wp_enqueue_style('utcw-admin', plugins_url('ultimate-tag-cloud-widget/css/style.css'), array(), UTCW_VERSION);

        // In development mode, add the libraries and main file individually
        if (UTCW_DEV) {
            wp_enqueue_script(
                'utcw-lib-jsuri',
                plugins_url('ultimate-tag-cloud-widget/js/lib/jsuri-1.1.1.min.js'),
                array(),
                UTCW_VERSION,
                true
            );
            wp_enqueue_script(
                'utcw-lib-tooltip',
                plugins_url('ultimate-tag-cloud-widget/js/lib/tooltip.min.js'),
                array('jquery'),
                UTCW_VERSION,
                true
            );
            wp_enqueue_script(
                'utcw',
                plugins_url('ultimate-tag-cloud-widget/js/utcw.js'),
                array('utcw-lib-jsuri', 'utcw-lib-tooltip', 'jquery'),
                UTCW_VERSION,
                true
            );
        } else {
            wp_enqueue_script(
                'utcw',
                plugins_url('ultimate-tag-cloud-widget/js/utcw.min.js'),
                array('jquery'),
                UTCW_VERSION,
                true
            );
        }
    }

    /**
     * Returns an array with the names of allowed taxonomies
     *
     * @return array
     * @since 2.0
     */
    public function getAllowedTaxonomies()
    {
        return $this->allowed_taxonomies;
    }

    /**
     * Returns allowed taxonomies as objects
     *
     * @return array
     * @since 2.0
     */
    public function getAllowedTaxonomiesObjects()
    {
        return get_taxonomies(array(), 'objects');
    }

    /**
     * Returns an array with taxonomy as key and an array of term objects for each taxonomy. Like:
     *
     * @return array
     * @since 2.0
     */
    public function getTerms()
    {
        $terms = array();

        foreach ($this->getAllowedTaxonomies() as $taxonomy) {
            $terms[$taxonomy] = get_terms($taxonomy);
        }

        return $terms;
    }

    /**
     * Returns an array with the names of allowed post types
     *
     * @return array
     * @since 2.0
     */
    public function getAllowedPostTypes()
    {
        return $this->allowed_post_types;
    }

    /**
     * Returns the users on this blog
     *
     * @return array
     * @since 2.0
     */
    public function getUsers()
    {
        global $wp_version;

        if ((float)$wp_version < 3.1) {
            return get_users_of_blog();
        } else {
            return get_users();
        }
    }

    /**
     * Removes a previously saved configuration
     *
     * @param string $name
     *
     * @return bool
     * @since 2.1
     */
    public function removeConfiguration($name)
    {
        $configs = $this->getConfigurations();

        if (isset($configs[$name])) {
            unset($configs[$name]);
            return $this->setConfigurations($configs);
        }

        return false;
    }

    /**
     * Saves the configuration
     *
     * @param string $name   Name of configuration
     * @param array  $config Exported configuration from Config
     *
     * @return bool
     * @since 2.0
     */
    public function saveConfiguration($name, array $config)
    {
        $configs = $this->getConfigurations();
        $configs[$name] = $config;

        return $this->setConfigurations($configs);
    }

    /**
     * Loads saved configuration
     *
     * @param string $name Name of configuration
     *
     * @return array|bool Returns an instance array on success and boolean false on failure
     * @since 2.0
     */
    public function loadConfiguration($name)
    {
        $configs = $this->getConfigurations();

        if (isset($configs[$name])) {
            return $configs[$name];
        }

        return false;
    }

    /**
     * Get saved configurations
     *
     * @return array
     * @since 2.0
     */
    public function getConfigurations()
    {
        return get_option('utcw_saved_configs', array());
    }

    /**
     * Set saved configurations
     *
     * @param array $configs
     *
     * @return bool
     * @since 2.1
     */
    protected function setConfigurations($configs)
    {
        return update_option('utcw_saved_configs', $configs);
    }

    /**
     * Returns boolean true if the current page request is for an authenticated user
     *
     * @return bool
     * @since 2.0
     */
    public function isAuthenticatedUser()
    {
        return is_user_logged_in();
    }

    /**
     * Returns an absolute URI to the archive page for the term
     *
     * @param int    $term_id     Term ID
     * @param string $taxonomy    Taxonomy name
     *
     * @return string Returns URI on success and empty string on failure
     * @since 2.0
     */
    public function getTermLink($term_id, $taxonomy)
    {
        $link = get_term_link($term_id, $taxonomy);

        return !is_wp_error($link) ? $link : '';
    }

    /**
     * Check if the term exist for any of the taxonomies
     *
     * @param int    $term_id     Term ID
     * @param array  $taxonomy    Array of taxonomy names
     *
     * @return bool
     * @since 2.0
     */
    public function checkTermTaxonomy($term_id, array $taxonomy)
    {

        foreach ($taxonomy as $tax) {
            if (get_term($term_id, $tax)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Apply filters
     *
     * @param string $tag
     * @param mixed  $value
     *
     * @return mixed|void
     * @since 2.0
     */
    public function applyFilters($tag, $value)
    {
        return apply_filters($tag, $value);
    }
}
