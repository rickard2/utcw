<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage selection
 * @since      2.2
 */

/**
 * Abstract class to define selection strategy for finding terms
 *
 * @since      2.2
 * @package    utcw
 * @subpackage selection
 */
class UTCW_SelectionStrategy
{
    /**
     * Plugin class instance
     *
     * @var UTCW_Plugin
     * @since 2.2
     */
    protected $plugin;

    /**
     * A copy of the SQL query for debugging purposes
     *
     * @var string
     * @since 2.2
     */
    protected $query;

    /**
     * Don't serialize any of the members
     *
     * @return array
     *
     * @since 2.6
     */
    public function __sleep()
    {
        return array();
    }

    /**
     * Request a new plugin instance when unserialized
     *
     * @since 2.6
     */
    public function __wakeup()
    {
        $this->plugin = UTCW_Plugin::getInstance();
    }

    /**
     * Creates a new instance
     *
     * @param UTCW_Plugin $plugin Main plugin instance
     *
     * @since 2.2
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Loads terms based on current configuration
     *
     * @return stdClass[]
     * @since 2.2
     */
    public function getData()
    {
        $db    = $this->plugin->get('wpdb');
        $query = $this->getQuery();

        $result      = $db->get_results($query);
        $this->query = $db->last_query;

        return $result;
    }

    /**
     * Returns the SQL query to be used when fetching terms
     *
     * @return string
     * @since 2.6
     */
    protected function getQuery()
    {
        $config = $this->plugin->get('dataConfig');
        $db     = $this->plugin->get('wpdb');

        $builder = new UTCW_QueryBuilder($this->plugin);

        $builder->addAuthorConstraint($config->authors);
        $builder->addPostTypeConstraint($config->post_type);
        $builder->addPostStatusConstraint($this->plugin->isAuthenticatedUser(), $config->post_type);
        $builder->addDaysOldConstraint($config->days_old);
        $builder->addTaxonomyConstraint($config->taxonomy);
        $builder->addTagsListConstraint(
            $config->tags_list_type,
            $config->tags_list,
            $config->taxonomy
        );
        $builder->addPostTermConstraint($config->post_term);
        $builder->addGrouping();
        $builder->addMinimum($config->minimum);

        // Add statements from the strategy
        $this->buildQuery($builder);

        $builder->addMaxConstraint($config->max);
        $builder->addSort($config->order, $config->reverse, $config->case_sensitive);

        $query      = $builder->getQuery();
        $parameters = $builder->getParameters();

        return $db->prepare($query, $parameters);
    }

    /**
     * @param UTCW_QueryBuilder $builder
     *
     * @return void
     * @since 2.6
     * @throws Exception
     */
    protected function buildQuery(UTCW_QueryBuilder $builder)
    {
        throw new Exception('You need to implement buildQuery() to use the default getData method');
    }

    /**
     * Clean up the internal members for debug output
     *
     * @return void
     */
    public function cleanupForDebug()
    {
        $this->plugin->remove('wpdb');
    }
}