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
 * Class to select a random set of terms from the DB
 *
 * @since      2.2
 * @package    utcw
 * @subpackage selection
 */
class UTCW_RandomStrategy extends UTCW_SelectionStrategy
{
    /**
     * Add random sorting to query
     *
     * @param UTCW_QueryBuilder $builder
     *
     * @since 2.6
     */
    public function buildQuery(UTCW_QueryBuilder $builder)
    {
        $builder->addStatement('ORDER BY RAND()');
    }
}