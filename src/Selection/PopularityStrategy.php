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
 * Class to select the most popular terms from the DB
 *
 * @since      2.2
 * @package    utcw
 * @subpackage selection
 */
class UTCW_PopularityStrategy extends UTCW_SelectionStrategy
{
    /**
     * Adds sorting by count to the query
     *
     * @param UTCW_QueryBuilder $builder
     *
     * @since 2.6
     */
    protected function buildQuery(UTCW_QueryBuilder $builder)
    {
        $builder->addStatement('ORDER BY count DESC');
    }
}