<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.5
 * @license    GPLv2
 * @package    utcw
 * @subpackage language
 * @since      2.5
 */

/**
 * Class to select only the terms that are displayed in the current list
 *
 * @since      2.5
 * @package    utcw
 * @subpackage selection
 */
class UTCW_CurrentListStrategy extends UTCW_SelectionStrategy
{
    /**
     * Config class instance
     *
     * @var UTCW_Config
     * @since 2.5
     */
    protected $config;

    /**
     * Plugin class instance
     *
     * @var UTCW_Plugin
     * @since 2.5
     */
    protected $plugin;

    /**
     * WP Database class instance
     *
     * @var wpdb
     * @since 2.5
     */
    protected $db;

    /**
     * A copy of the SQL query for debugging purposes
     *
     * @var string
     * @since 2.5
     */
    protected $query;

    /**
     * Creates a new instance
     *
     * @param UTCW_Plugin $plugin Main plugin instance
     *
     * @since 2.5
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        $this->config = $plugin->get('dataConfig');
        $this->db     = $plugin->get('wpdb');
        $this->plugin = $plugin;
    }

    /**
     * Returns term data based on current configuration
     *
     * @return stdClass[]
     * @since 2.5
     */
    public function getData()
    {
        $terms = $this->plugin->getCurrentQueryTerms();

        if (!$terms) {
            return array();
        }

        $termIds = array_map(create_function('$term', 'return $term->term_id;'), $terms);

        $builder = new UTCW_QueryBuilder($this->plugin, $this->db);

        $builder->addAuthorConstraint($this->config->authors);
        $builder->addPostTypeConstraint($this->config->post_type);
        $builder->addPostStatusConstraint($this->plugin->isAuthenticatedUser());
        $builder->addDaysOldConstraint($this->config->days_old);
        $builder->addTaxonomyConstraint($this->config->taxonomy);
        $builder->addTagsListConstraint(
            $this->config->tags_list_type,
            $this->config->tags_list,
            $this->config->taxonomy
        );
        $builder->addPostTermConstraint($this->config->post_term);
        $builder->addGrouping();
        $builder->addMinimum($this->config->minimum);

        $parameters = array();

        foreach ($termIds as $termId) {
            $parameters[] = '%d';
            $builder->addParameter($termId);
        }

        $builder->addStatement('AND term_id IN (' . join(',', $parameters) . ')');

        $builder->addMaxConstraint($this->config->max);
        $builder->addSort($this->config->order, $this->config->reverse, $this->config->case_sensitive);

        $query      = $builder->getQuery();
        $parameters = $builder->getParameters();
        $query      = $this->db->prepare($query, $parameters);

        $result      = $this->db->get_results($query);
        $this->query = $this->db->last_query;

        return $result;
    }

    /**
     * Clean up the internal members for debug output
     *
     * @return void
     * @since 2.5
     */
    public function cleanupForDebug()
    {
        unset($this->db);
        $this->plugin->remove('wpdb');
    }
}