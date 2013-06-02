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
 *
 * @property-read string  strategy        Which strategy to use when fetching terms
 * @property-read string  order           How the result should be ordered
 * @property-read string  tags_list_type  How the {@link $tags_list tags list} should be used
 * @property-read string  color           Which coloring strategy to use
 * @property-read string  color_span_to   Which color value to start from in color calculation. This is the color that the smallest tag will get.
 * @property-read string  color_span_from Which color value to end at in color calculation. This is the color that the biggest tag will get.
 * @property-read array   color_set       A set of colors to randomly select from when coloring the tags
 * @property-read array   taxonomy        Which taxonomy to show tags from
 * @property-read array   post_type       An array of post type names to to include posts from in tag size calculation
 * @property-read array   authors         Which authors to include posts from. An empty array will include all authors
 * @property-read array   tags_list       A list of term IDs to be included or excluded. Inclusion or exclusion is determined by {@link $tags_list_type tags list type}
 * @property-read array   post_term       A list of term IDs which the posts needs to have to be included in tag size calculation
 * @property-read string  size_from       The smallest possible size
 * @property-read string  size_to         The greatest possible size
 * @property-read integer max             Maximum number of tags to display
 * @property-read integer minimum         How many posts a term needs to have to be shown in the cloud
 * @property-read integer days_old        How many days old a post needs to be to be included in tag size calculation
 * @property-read bool    reverse         If the order of tags should be shown in reverse order
 * @property-read bool    case_sensitive  If sorting should be applied case sensitive
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
        $this->addOption('post_term', 'array', array('type' => 'integer'));

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