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
 * Class to select the newest terms from the DB
 *
 * @since      2.5
 * @package    utcw
 * @subpackage selection
 */
class UTCW_CreationTimeStrategy extends UTCW_SelectionStrategy
{
    /**
     * Add sorting by term_id (effectively by creation time) to query
     *
     * @param UTCW_QueryBuilder $builder
     *
     * @since 2.6
     */
    public function buildQuery(UTCW_QueryBuilder $builder)
    {
        $builder->addStatement('ORDER BY term_id DESC');
    }
}