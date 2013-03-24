<?php

namespace Rickard\UTCW;

use WP_Widget;

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
 * Widget class for WordPress integration
 *
 * @since      1.0
 * @package    utcw
 * @subpackage main
 */
class Widget extends WP_Widget
{

    /**
     * Reference to the main plugin instance
     *
     * @var Plugin
     * @since 2.0
     */
    private $plugin;

    /**
     * Constructor
     *
     * @param Plugin $plugin  Optional. Plugin instance for dependency injection
     *
     * @return Widget
     * @since 1.0
     */
    public function __construct(Plugin $plugin = null)
    {
        $options = array('description' => __('Highly configurable tag cloud', 'utcw'));
        parent::__construct('utcw', __('Ultimate Tag Cloud', 'utcw'), $options);

        $this->plugin = $plugin ? $plugin : Plugin::getInstance();
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
    public function update(array $new_instance, array $old_instance)
    {
        $load_config = isset($new_instance['load_config']) &&
            isset($new_instance['load_config_name']) &&
            $new_instance['load_config_name'];

        $save_config = isset($new_instance['save_config']) &&
            isset($new_instance['save_config_name']) &&
            $new_instance['save_config_name'];

        // Overwrite the form values with the saved configuration
        if ($load_config) {
            $loaded_configuration = $this->plugin->loadConfiguration($new_instance['load_config_name']);

            if ($loaded_configuration) {
                $new_instance = $loaded_configuration;
            }
        }

        // Checkbox inputs which are unchecked, will not be set in $new_instance. Set them manually to false
        $checkbox_settings = array('show_title_text', 'show_title', 'debug', 'reverse', 'case_sensitive');

        foreach ($checkbox_settings as $checkbox_setting) {
            if (!isset($new_instance[$checkbox_setting])) {
                $new_instance[$checkbox_setting] = false;
            }
        }

        $config = new Config($new_instance, $this->plugin);

        if ($save_config) {
            $this->plugin->saveConfiguration($new_instance['save_config_name'], $config->getInstance());
        }

        if (isset($new_instance['remove_config']) && is_array($new_instance['remove_config'])) {
            foreach ($new_instance['remove_config'] as $configuration) {
                $this->plugin->removeConfiguration($configuration);
            }
        }

        return $config->getInstance();
    }

    /**
     * Function for handling the widget control in admin panel
     *
     * @param array $instance
     *
     * @return void|string
     * @since 1.0
     */
    public function form(array $instance)
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $config = new Config($instance, $this->plugin);
        /** @noinspection PhpUnusedLocalVariableInspection */
        $configurations = $this->plugin->getConfigurations();
        /** @noinspection PhpUnusedLocalVariableInspection */
        $available_post_types = $this->plugin->getAllowedPostTypes();
        /** @noinspection PhpUnusedLocalVariableInspection */
        $available_taxonomies = $this->plugin->getAllowedTaxonomiesObjects();
        /** @noinspection PhpUnusedLocalVariableInspection */
        $users = $this->plugin->getUsers();
        /** @noinspection PhpUnusedLocalVariableInspection */
        $terms = $this->plugin->getTerms();

        // Content of the widget settings form
        require dirname(__FILE__) . '/../pages/settings.php';
    }

    /**
     * Function for rendering the widget
     *
     * @param array $args
     *
     * @param array $instance
     */
    public function widget(array $args, array $instance)
    {
        global $wpdb;

        $input = array_merge($instance, $args);

        $config = new Config($input, $this->plugin);
        $data   = new Data($config, $this->plugin, $wpdb);
        $render = new Render($config, $data, $this->plugin);

        $render->render();
    }
}
