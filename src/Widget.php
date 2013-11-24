<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.5
 * @license    GPLv2
 * @package    utcw
 * @subpackage main
 * @since      2.0
 */

/**
 * Widget class for WordPress integration
 *
 * @since      1.0
 * @package    utcw
 * @subpackage main
 */
class UTCW_Widget extends WP_Widget
{

    /**
     * Reference to the main plugin instance
     *
     * @var UTCW_Plugin
     * @since 2.0
     */
    private $plugin;

    /**
     * Constructor
     *
     * @param UTCW_Plugin $plugin Optional. UTCW_Plugin instance for dependency injection
     *
     * @return UTCW_Widget
     * @since 1.0
     */
    public function __construct(UTCW_Plugin $plugin = null)
    {
        $options = array('description' => __('Highly configurable tag cloud', 'utcw'));
        parent::__construct('utcw', __('Ultimate Tag Cloud', 'utcw'), $options);

        $this->plugin = $plugin ? $plugin : UTCW_Plugin::getInstance();
    }

    /**
     * Load a saved configuration if given by the settings
     *
     * @param array $new_instance
     *
     * @return array
     * @since 2.6
     */
    protected function load($new_instance)
    {
        $load_config = isset($new_instance['load_config']) &&
            isset($new_instance['load_config_name']) &&
            $new_instance['load_config_name'];

        // Overwrite the form values with the saved configuration
        if ($load_config) {
            $loaded_configuration = $this->plugin->loadConfiguration($new_instance['load_config_name']);

            if ($loaded_configuration) {
                return $loaded_configuration;
            }
        }

        return $new_instance;
    }

    /**
     * Save configuration if given by the settings
     *
     * @param array $new_instance
     * @param array $config
     *
     * @since 2.6
     */
    protected function save($new_instance, $config)
    {
        $save_config = isset($new_instance['save_config']) &&
            isset($new_instance['save_config_name']) &&
            $new_instance['save_config_name'];

        if ($save_config) {
            $this->plugin->saveConfiguration($new_instance['save_config_name'], $config);
        }
    }

    /**
     * Remove configurations if given by the settings
     *
     * @param array $new_instance
     *
     * @since 2.6
     */
    protected function remove($new_instance)
    {
        if (isset($new_instance['remove_config']) && is_array($new_instance['remove_config'])) {
            foreach ($new_instance['remove_config'] as $configuration) {
                $this->plugin->removeConfiguration($configuration);
            }
        }
    }

    /**
     * Action handler for the form in the admin panel
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array
     * @since 1.0
     */
    public function update($new_instance, $old_instance)
    {
        $new_instance = $this->load($new_instance);

        // Checkbox inputs which are unchecked, will not be set in $new_instance. Set them manually to false
        $checkbox_settings = array('show_title_text', 'show_links', 'show_title', 'debug', 'reverse', 'case_sensitive');

        foreach ($checkbox_settings as $checkbox_setting) {
            if (!isset($new_instance[$checkbox_setting])) {
                $new_instance[$checkbox_setting] = false;
            }
        }

        $dataConfig   = new UTCW_DataConfig($new_instance, $this->plugin);
        $renderConfig = new UTCW_RenderConfig($new_instance, $this->plugin);

        $config = array_merge($dataConfig->getInstance(), $renderConfig->getInstance());

        $this->save($new_instance, $config);
        $this->remove($new_instance);

        return $config;
    }

    /**
     * Function for handling the widget control in admin panel
     *
     * @param array $instance
     *
     * @return void|string
     * @since 1.0
     */
    public function form($instance)
    {
        $authors = $this->plugin->getUsers();
        $terms   = $this->plugin->getTerms();

        // Create a lookup table with all the terms indexed by their ID
        $terms_by_id = array();

        foreach ($terms as $taxonomyTerms) {
            foreach ($taxonomyTerms as $term) {
                $terms_by_id[$term->term_id] = $term;
            }
        }
        // Create a lookup table with all the authors indexed by their ID
        $authors_by_id = array();

        foreach ($authors as $author) {
            $authors_by_id[$author->ID] = $author;
        }

        $data = array(
            'dataConfig'           => new UTCW_DataConfig($instance, $this->plugin),
            'renderConfig'         => new UTCW_RenderConfig($instance, $this->plugin),
            'configurations'       => $this->plugin->getConfigurations(),
            'available_post_types' => $this->plugin->getAllowedPostTypes(),
            'available_taxonomies' => $this->plugin->getAllowedTaxonomiesObjects(),
            'authors'              => $authors,
            'terms'                => $terms,
            'authors_by_id'        => $authors_by_id,
            'terms_by_id'          => $terms_by_id,
        );

        $this->render('settings', $data);
    }

    /**
     * Render a template
     *
     * @param string $template
     * @param array  $data
     */
    protected function render($template, array $data)
    {
        extract($data);

        require dirname(__FILE__) . '/../pages/' . $template . '.php';
    }

    /**
     * Function for rendering the widget
     *
     * @param array $args
     *
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        global $wpdb;

        $input = array_merge($instance, $args);

        $this->plugin->set('wpdb', $wpdb);
        $this->plugin->set('dataConfig', new UTCW_DataConfig($input, $this->plugin));
        $this->plugin->set('renderConfig', new UTCW_RenderConfig($input, $this->plugin));
        $this->plugin->set('data', new UTCW_Data($this->plugin));

        $render = new UTCW_Render($this->plugin);

        $render->render();
    }
}
