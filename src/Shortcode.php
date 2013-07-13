<?php

class UTCW_ShortCode
{

    /**
     * @var UTCW_Plugin
     */
    protected $plugin;

    public function __construct(UTCW_Plugin $plugin)
    {
        $this->plugin = $plugin;

        add_shortcode('utcw', array($this, 'render'));
    }


    /**
     * Short code handler for 'utcw' hook
     *
     * @param array $args
     *
     * @return string
     * @since 2.0
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

        do_action('utcw_shortcode');

        return $render->getCloud();
    }
}