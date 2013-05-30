<?php

//namespace Rickard\UTCW\Selection;

/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage language
 * @since      2.2
 */

//use Rickard\UTCW\Config;
//use Rickard\UTCW\Database\QueryBuilder;
//use Rickard\UTCW\Plugin;
//use \stdClass;
//use wpdb;

/**
 * Class to select the most popular terms from the DB
 *
 * @since      2.2
 * @package    utcw
 * @subpackage selection
 */
class UTCW_PopularityStrategy extends UTCW_SelectionStrategy
{
    /**
     * Config class instance
     *
     * @var UTCW_Config
     * @since 2.2
     */
    protected $config;

    /**
     * Plugin class instance
     *
     * @var UTCW_Plugin
     * @since 2.2
     */
    protected $plugin;

    /**
     * WP Database class instance
     *
     * @var wpdb
     * @since 2.2
     */
    protected $db;

    /**
     * A copy of the SQL query for debugging purposes
     *
     * @var string
     * @since 2.2
     */
    protected $query;

    /**
     * Creates a new instance
     *
     * @param UTCW_Plugin $plugin Main plugin instance
     *
     * @since 2.2
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
     * @since 2.2
     */
    public function getData()
    {
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
        $builder->addStatement('ORDER BY count DESC');
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
     * @since 2.2
     */
    public function cleanupForDebug()
    {
        unset($this->db);
        $this->plugin->remove('wpdb');
    }
}