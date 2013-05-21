<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage config
 * @since      2.3
 */

/**
 * Class to represent a the configuration options for data retrieval
 *
 * @since 2.3
 */
class UTCW_DataConfig extends UTCW_Config
{
    /**
     * Creates a new instance of the class and adds all the options
     *
     * @param array       $input
     * @param UTCW_Plugin $plugin
     *
     * @since 2.3
     */
    public function __construct(array $input, UTCW_Plugin $plugin)
    {
        $this->addOption('strategy', 'set', array('values' => array('popularity', 'random')));
        $this->addOption('order', 'set', array('values' => array('name', 'random', 'slug', 'id', 'color', 'count')));
        $this->addOption('tags_list_type', 'set', array('values' => array('exclude', 'include')));
        $this->addOption('color', 'set', array('values' => array('none', 'random', 'set', 'span')));
        $this->addOption('color_span_to', 'color', array('default' => ''));
        $this->addOption('color_span_from', 'color', array('default' => ''));
        $this->addOption('color_set', 'array', array('type' => 'color'));
        $this->addOption(
            'taxonomy',
            'array',
            array(
                'type'        => 'set',
                'typeOptions' => array('values' => $plugin->getAllowedTaxonomies()),
                'default'     => array('post_tag')
            )
        );
        $this->addOption(
            'post_type',
            'array',
            array(
                'type'        => 'set',
                'typeOptions' => array('values' => $plugin->getAllowedPostTypes()),
                'default'     => array('post')
            )
        );

        $this->addOption('authors', 'array', array('type' => 'integer'));
        $this->addOption('tags_list', 'array', array('type' => 'integer'));

        $this->addOption('size_from', 'measurement', array('default' => '10px'));
        $this->addOption('size_to', 'measurement', array('default' => '30px'));

        $this->addOption('max', 'integer', array('default' => 45, 'min' => 1));
        $this->addOption('minimum', 'integer', array('default' => 1));
        $this->addOption('days_old', 'integer');

        $this->addOption('reverse', 'boolean');
        $this->addOption('case_sensitive', 'boolean');

        parent::__construct($input, $plugin);

        $this->checkSizes();
    }

    /**
     * Checks if size_from and size_to have correct values, and reverts to defaults if they don't
     *
     * @since 2.3
     */
    protected function checkSizes()
    {
        $size_from = $this->__get('size_from');
        $size_to   = $this->__get('size_to');

        $unit1 = preg_replace('/' . UTCW_DECIMAL_REGEX . '/', '', $size_from);
        $unit2 = preg_replace('/' . UTCW_DECIMAL_REGEX . '/', '', $size_to);

        $unitsEqual = $unit1 === $unit2 || ($unit1 === 'px' && $unit2 === '') || ($unit1 === '' && $unit2 === 'px');
        $rangeOk    = floatval($size_from) <= floatval($size_to);

        $valid = $unitsEqual && $rangeOk;

        if (!$valid) {
            $this->data['size_from'] = $this->options['size_from']->getDefaultValue();
            $this->data['size_to']   = $this->options['size_to']->getDefaultValue();
        }
    }
}