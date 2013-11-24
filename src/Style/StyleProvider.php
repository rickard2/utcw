<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.6
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
}