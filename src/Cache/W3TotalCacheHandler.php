<?php

/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage cache
 * @since      2.4
 */
class UTCW_W3TotalCacheHandler extends UTCW_Handler
{

    protected $args;

    /**
     * Returns true if W3 Total Cache is enabled
     *
     * @return bool
     * @since 2.4
     */
    public function isEnabled()
    {
        // todo: check late init
        return class_exists('W3_Plugin');
    }

    /**
     * Initializes the handler
     *
     * @since 2.4
     */
    public function init()
    {
        add_filter('filter_shortcode', array($this, 'filterShortCode'));
        add_action('utcw_shortcode', array($this, 'onShortCode'));
    }

    /**
     * Called when the short code is used
     *
     * @since 2.4
     */
    public function onShortCode($args)
    {
        $this->args = $args;
    }

    /**
     * @param $content
     *
     * @return string
     */
    public function filterShortCode($content)
    {
        $return = array(
            sprintf('<!-- mfunc %s -->', W3TC_DYNAMIC_SECURITY),
            sprintf("echo do_utcw(%s);", $this->argsToArray($this->args)),
            sprintf('<!-- /mfunc %s -->', W3TC_DYNAMIC_SECURITY),
        );

        return join("\r\n", $return);
    }

    /**
     * @param array $args
     *
     * @return string
     */
    protected function argsToArray(array $args)
    {
        $values = array();

        foreach ($args as $key => $value) {
            $values[] = sprintf('"%s" => "%s"', $key, addslashes($value));
        }

        $values[] = '"mfunc" => 1';

        return sprintf('array(%s)', join(',', $values));
    }
}