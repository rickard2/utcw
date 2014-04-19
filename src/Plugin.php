<?php
/**
 * Class for general plugin integration with WordPress
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */

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
class UTCW_Plugin
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
     * An array of dependencies
     *
     * @var array
     * @since 2.3
     */
    protected $container = array();

    /**
     * Singleton instance
     *
     * @var UTCW_Plugin
     * @since 2.0
     */
    private static $instance;

    /**
     * Initializes the WordPress hooks needed
     *
     * @since 2.0
     */
    private function __construct()
    {
        $this->setHooks();
        $this->set('shortCode', new UTCW_ShortCode($this));
    }

    /**
     * Sets WordPress hooks
     *
     * @since 2.3
     */
    public function setHooks()
    {
        add_action('admin_head-widgets.php', array($this, 'initAdminAssets'));
        add_action('wp_loaded', array($this, 'wpLoaded'));
        add_action('widgets_init', array($this, 'widgetsInit'));
        add_action('wp_ajax_utcw_get_terms', array($this, 'outputTermsJson'));
        add_action('wp_ajax_utcw_get_authors', array($this, 'outputAuthorsJson'));
//        add_action('init', array($this, 'setCacheHandler')); Disabled for now
        add_action('init', array($this, 'setTranslationHandler'));
        add_action('init', array($this, 'initLocalisation'));

        // Theme customizer support
        add_action('load-customize.php', array($this, 'initAdminAssets'));
        add_action('admin_footer-widgets.php', array($this, 'printCustomizerScript'));
    }

    /**
     * Temporary function to output the script in the footer of the customize.php page
     *
     * @since 2.7.1
     */
    public function printCustomizerScript()
    {
        $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

        if (strpos($request_uri, 'customize.php') !== false) {
            echo '<script src="' . plugins_url('ultimate-tag-cloud-widget/js/utcw.min.js') . '"></script>';
        }
    }


    /**
     * Initializes localisation
     *
     * @since 2.6
     */
    public function initLocalisation()
    {
        load_plugin_textdomain('utcw', false, '/ultimate-tag-cloud-widget/language/');
    }

    /**
     * Sets the translation handler if any is available
     *
     * @return bool
     * @since 2.4
     */
    public function setTranslationHandler()
    {
        $factory = new UTCW_HandlerFactory(array(
            'UTCW_QTranslateHandler',
            'UTCW_WPMLHandler'
        ));

        $instance = $factory->getInstance();

        if ($instance) {
            $this->set('translationHandler', $instance);
            return true;
        }

        return false;
    }

    /**
     * Sets the cache handler if any is available
     *
     * @return bool
     * @since 2.4
     */
    public function setCacheHandler()
    {
        $factory = new UTCW_HandlerFactory(array(
            'UTCW_WPSuperCacheHandler',
            'UTCW_W3TotalCacheHandler',
        ));

        $instance = $factory->getInstance();

        if ($instance) {
            $this->set('cacheHandler', $instance);
            return true;
        }

        return false;
    }

    /**
     * Set dependency in the container
     *
     * @param string $key
     * @param mixed  $value
     *
     * @since 2.3
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * Get dependency from the container
     *
     * @param string $key
     *
     * @return mixed|null
     * @since 2.3
     */
    public function get($key)
    {
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }

    /**
     * Removes the dependency from the container
     *
     * @param string $key
     *
     * @since 2.3
     */
    public function remove($key)
    {
        unset($this->container[$key]);
    }

    /**
     * Returns an instance of the plugin
     *
     * @static
     * @return UTCW_Plugin
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
     * Outputs all the terms in JSON format
     *
     * @since 2.3
     */
    public function outputTermsJson()
    {
        header('Content-Type: application/json');
        echo $this->getTermsJson();
        die();
    }

    /**
     * Returns terms in JSON format
     *
     * @since 2.3
     */
    public function getTermsJson()
    {
        $terms = $this->getTerms();

        // Convert terms into value array
        foreach ($terms as $taxonomy => $items) {
            $terms[$taxonomy] = array_values($items);
        }

        return json_encode($terms);
    }

    /**
     * Outputs authors in JSON format
     *
     * @since 2.5
     */
    public function outputAuthorsJson()
    {
        header('Content-Type: application/json');
        echo $this->getAuthorsJson();
        die();
    }

    /**
     * Fetch authors and return a AJAX friendly array as a JSON object
     *
     * @return string
     *
     * @since 2.5
     */
    public function getAuthorsJson()
    {
        $authors = array();

        foreach ($this->getUsers() as $author) {
            $authors[] = array(
                'ID'           => $author->ID,
                'display_name' => $author->display_name
            );
        }

        return json_encode($authors);
    }

    /**
     * Action handler for 'widgets_init' hook
     * Registers the widget
     *
     * @since 2.3
     */
    public function widgetsInit()
    {
        register_widget("UTCW_Widget");
    }

    /**
     * Action handler for 'wp_loaded' hook
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
                plugins_url('ultimate-tag-cloud-widget/js/src/utcw.js'),
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
        $configs        = $this->getConfigurations();
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
     * @param int    $term_id  Term ID
     * @param string $taxonomy Taxonomy name
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
     * Returns the term if found
     *
     * @param $term_id
     *
     * @return bool|object
     * @since 2.5
     */
    public function getTerm($term_id)
    {
        foreach ($this->getTerms() as $taxonomy => $terms) {
            foreach ($terms as $term) {
                if ($term->term_id == $term_id) {
                    $term = get_term($term_id, $taxonomy);

                    if ($term && !is_wp_error($term)) {
                        return $term;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Returns the taxonomy
     *
     * @param $taxonomy
     *
     * @return bool|object
     * @since 2.5
     */
    public function getTaxonomy($taxonomy)
    {
        return get_taxonomy($taxonomy);
    }

    /**
     * Check if the term exist for any of the taxonomies
     *
     * @param int   $term_id  Term ID
     * @param array $taxonomy Array of taxonomy names
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


    /**
     * Returns the terms associated with the posts in the current $wp_query
     *
     * @return stdClass[]
     */
    public function getCurrentQueryTerms()
    {
        global $wp_query;

        $terms = array();

        if (!$wp_query) {
            return array();
        }

        foreach ($wp_query->posts as $post) {
            $postTerms = wp_get_post_terms($post->ID);

            foreach ($postTerms as $term) {
                if (!isset($terms[$term->term_id])) {
                    $terms[$term->term_id] = $term;
                }
            }
        }

        return array_values($terms);
    }
}
