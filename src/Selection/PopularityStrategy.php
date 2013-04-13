<?php

namespace Rickard\UTCW\Selection;

/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage language
 * @since      2.2
 */

use Rickard\UTCW\Config;
use Rickard\UTCW\Database\QueryBuilder;
use Rickard\UTCW\Plugin;
use \stdClass;
use wpdb;

/**
 * Class to select the most popular terms from the DB
 *
 * @since      2.2
 * @package    utcw
 * @subpackage selection
 */
class PopularityStrategy extends SelectionStrategy
{
    /**
     * @var Config
     * @since 2.2
     */
    protected $config;

    /**
     * @var Plugin
     * @since 2.2
     */
    protected $plugin;

    /**
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
     * @param Config $config   Current configuration
     * @param Plugin $plugin   Main plugin instance
     * @param wpdb   $db       WordPress DB instance
     *
     * @since 2.2
     */
    public function __construct(Config $config, Plugin $plugin, wpdb $db)
    {
        $this->config = $config;
        $this->plugin = $plugin;
        $this->db     = $db;
    }

    /**
     * Returns term data based on current configuration
     *
     * @return stdClass[]
     * @since 2.2
     */
    public function getData()
    {
        $builder = new QueryBuilder($this->plugin, $this->db);

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
     * @return void
     * @since 2.2
     */
    public function cleanupForDebug()
    {
        unset($this->db);
    }
}