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
     * A copy of the SQL query for debugging purposes
     *
     * @var string
     * @since 2.5
     */
    protected $query;

    /**
     * Returns term data based on current configuration
     *
     * @return stdClass[]
     * @since 2.5
     */
    public function getData()
    {
        $config = $this->plugin->get('dataConfig');
        $db     = $this->plugin->get('wpdb');

        $terms = $this->plugin->getCurrentQueryTerms();

        if (!$terms) {
            return array();
        }

        $termIds = array_map(create_function('$term', 'return $term->term_id;'), $terms);

        $builder = new UTCW_QueryBuilder($this->plugin);

        $builder->addAuthorConstraint($config->authors);
        $builder->addPostTypeConstraint($config->post_type);
        $builder->addPostStatusConstraint($this->plugin->isAuthenticatedUser());
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

        $parameters = array();

        foreach ($termIds as $termId) {
            $parameters[] = '%d';
            $builder->addParameter($termId);
        }

        $builder->addStatement('AND term_id IN (' . join(',', $parameters) . ')');

        $builder->addMaxConstraint($config->max);
        $builder->addSort($config->order, $config->reverse, $config->case_sensitive);

        $query      = $builder->getQuery();
        $parameters = $builder->getParameters();
        $query      = $db->prepare($query, $parameters);

        $result      = $db->get_results($query);
        $this->query = $db->last_query;

        return $result;
    }
}