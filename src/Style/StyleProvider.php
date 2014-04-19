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
 * Abstract class to define a provider of CSS styles
 *
 * @since      2.6
 * @package    utcw
 * @subpackage style
 */
abstract class UTCW_StyleProvider
{
    /**
     * @var UTCW_Plugin
     * @since 2.6
     */
    protected $plugin;

    /**
     * @var array
     * @since 2.6
     */
    protected $styles = array();

    /**
     * Only save styles when serializing
     *
     * @return array
     *
     * @since 2.6
     */
    public function __sleep()
    {
        return array('styles');
    }

    /**
     * Get a new copy of the plugin instance when waking up
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
     * @since 2.6
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Returns an array of css rules
     *
     * @return array
     * @since 2.6
     */
    abstract public function getStyles();

    /**
     * Returns an array of which selectors these styles should apply to, relative to the tag cloud
     *
     * @return array
     * @since 2.6
     */
    abstract public function getSelectors();

    /**
     * Checks if option still has the default value
     *
     * @param string $option
     *
     * @return bool
     * @since 2.6
     */
    protected function hasDefaultValue($option)
    {
        $defaultConfig = new UTCW_RenderConfig(array(), $this->plugin);
        $defaults      = $defaultConfig->getInstance();
        $config        = $this->plugin->get('renderConfig');

        return $config->$option === $defaults[$option];
    }

    /**
     * Will add the style to the internal array if the option doesn't have is default value
     *
     * @param string $option
     * @param string $template
     * @param string $value
     *
     * @since 2.6
     */
    protected function addStyle($option, $template, $value = '')
    {
        if (!$value) {
            $value = $this->plugin->get('renderConfig')->$option;
        }

        if (!$this->hasDefaultValue($option)) {
            $this->styles[] = sprintf($template, $value);
        }
    }
}