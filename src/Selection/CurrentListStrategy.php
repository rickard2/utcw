<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage selection
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
     * Add constraint to only contain the terms associated with the terms in the current list
     *
     * @param UTCW_QueryBuilder $builder
     *
     * @since 2.6
     */
    public function buildQuery(UTCW_QueryBuilder $builder)
    {
        $terms   = $this->plugin->getCurrentQueryTerms();
        $termIds = array_map(create_function('$term', 'return $term->term_id;'), $terms);

        $parameters = array();

        foreach ($termIds as $termId) {
            $parameters[] = '%d';
            $builder->addParameter($termId);
        }

        $builder->addStatement('AND term_id IN (' . join(',', $parameters) . ')');
    }

    /**
     * Returns an empty array if no terms could be found in the current list
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

        return parent::getData();
    }
}