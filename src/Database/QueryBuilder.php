<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage language
 * @since      2.2
 */

/**
 * Class to handle QTranslate multi language support
 *
 * @since      2.2
 * @package    utcw
 * @subpackage database
 */
class UTCW_QueryBuilder
{

    /**
     * Database reference
     *
     * @var wpdb
     * @since 2.2
     */
    protected $db;

    /**
     * Creates a new instance of the QueryBuilder
     *
     * @param UTCW_Plugin $plugin Main plugin instance
     *
     * @since 2.2
     */
    public function __construct(UTCW_Plugin $plugin)
    {
        $this->db         = $plugin->get('wpdb');
        $this->plugin     = $plugin;
        $this->query      = $this->getBaseQuery();
        $this->parameters = array();
    }

    /**
     * Returns the resulting query
     *
     * @return string
     * @since 2.2
     */
    public function getQuery()
    {
        return join(' ', $this->query);
    }

    /**
     * Returns the parameters for the resulting query
     *
     * @return array
     * @since 2.2
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Adds a parameter to the query
     *
     * @param $parameter
     *
     * @since 2.5
     */
    public function addParameter($parameter)
    {
        $this->parameters[] = $parameter;
    }

    /**
     * Add a statement to the query
     *
     * @param string $statement
     *
     * @since 2.2
     */
    public function addStatement($statement)
    {
        $this->query[] = $statement;
    }

    /**
     * Returns the base query with joins
     *
     * @return array
     * @since 2.2
     */
    public function getBaseQuery()
    {
        $query = array();

        $query[] = 'SELECT t.term_id, t.name, t.slug, COUNT(p.ID) AS `count`, tt.taxonomy';
        $query[] = 'FROM `' . $this->db->terms . '` AS t';
        $query[] = 'JOIN `' . $this->db->term_taxonomy . '` AS tt ON t.term_id = tt.term_id';
        $query[] = 'LEFT JOIN `' . $this->db->term_relationships . '` AS tr ON tt.term_taxonomy_id = tr.term_taxonomy_id';
        $query[] = 'LEFT JOIN `' . $this->db->posts . '` AS p ON tr.object_id = p.ID';

        return $query;
    }

    /**
     * Add author constraint
     *
     * @param array $authors
     *
     * @since 2.2
     */
    public function addAuthorConstraint(array $authors)
    {
        if ($authors) {
            $author_parameters = array();

            foreach ($authors as $author) {
                $author_parameters[] = '%d';
                $this->parameters[]  = $author;
            }

            $this->query[] = 'AND p.post_author IN (' . join(',', $author_parameters) . ')';
        }
    }

    /**
     * Add post term relationship constraint
     *
     * @param array $post_terms
     *
     * @since 2.3
     */
    public function addPostTermConstraint(array $post_terms)
    {
        if ($post_terms) {

            $post_term_parameters = array();

            foreach ($post_terms as $post_term) {
                $post_term_parameters[] = '%d';
                $this->parameters[]     = $post_term;
            }

            $this->query[] = 'AND p.ID IN (SELECT _p.ID FROM `' . $this->db->posts . '` _p';
            $this->query[] = 'JOIN `' . $this->db->term_relationships . '` AS _tr ON _tr.object_id = _p.ID';
            $this->query[] = 'JOIN `' . $this->db->term_taxonomy . '` AS _tt ON _tt.term_taxonomy_id = _tr.term_taxonomy_id';
            $this->query[] = 'WHERE _tt.term_id IN (' . join(',', $post_term_parameters) . '))';
        }
    }

    /**
     * Add post type constraint
     *
     * @param array $post_types
     *
     * @since 2.2
     */
    public function addPostTypeConstraint(array $post_types)
    {
        $post_type_parameters = array();

        foreach ($post_types as $post_type) {
            $post_type_parameters[] = '%s';
            $this->parameters[]     = $post_type;
        }

        $this->query[] = 'AND p.post_type IN (' . join(',', $post_type_parameters) . ')';
    }

    /**
     * Add post status constraint
     *
     * @param bool  $authenticated
     * @param array $post_types
     *
     * @since 2.2
     */
    public function addPostStatusConstraint($authenticated, array $post_types)
    {
        $statuses           = array('publish');
        $containsAttachment = in_array('attachment', $post_types);
        $singlePostType     = count($post_types) === 1;
        $multiPostType      = count($post_types) > 1;

        // Authenticated users are allowed to view tags for private posts
        if ($authenticated) {
            $statuses[] = 'private';
        }

        // If attachment is the only post type its safe to include inherit in the IN clause
        if ($containsAttachment && $singlePostType) {
            $statuses[] = 'inherit';
        }

        $condition = "p.post_status IN ('" . join("','", $statuses) . "')";

        // If attachment is one of the post types in a multi post type cloud
        // check that only attachments are allowed the post status inherit
        if ($containsAttachment && $multiPostType) {
            $this->query[] = "AND (" . $condition . " OR (post_type = 'attachment' AND post_status = 'inherit'))";
        } else {
            $this->query[] = "AND " . $condition;
        }
    }

    /**
     * Add days old constraint
     *
     * @param int $days_old
     *
     * @since 2.2
     */
    public function addDaysOldConstraint($days_old)
    {
        if ($days_old) {
            $this->query[]      = 'AND p.post_date > %s';
            $this->parameters[] = date('Y-m-d', strtotime('-' . $days_old . ' days'));
        }
    }

    /**
     * Add taxonomies constraint
     *
     * @param array $taxonomies
     *
     * @since 2.2
     */
    public function addTaxonomyConstraint(array $taxonomies)
    {
        $taxonomy_parameters = array();

        foreach ($taxonomies as $taxonomy) {
            $taxonomy_parameters[] = '%s';
            $this->parameters[]    = $taxonomy;
        }

        $this->query[] = 'WHERE tt.taxonomy IN (' . join(',', $taxonomy_parameters) . ')';
    }

    /**
     * Add include or exclude constraint
     *
     * @param string $type
     * @param array  $list
     * @param array  $taxonomy
     *
     * @since 2.2
     */
    public function addTagsListConstraint($type, array $list, array $taxonomy)
    {
        $parameters = array();

        foreach ($list as $tag_id) {
            if ($this->plugin->checkTermTaxonomy($tag_id, $taxonomy)) {
                $parameters[]       = '%d';
                $this->parameters[] = $tag_id;
            }
        }

        if (!$parameters) {
            return;
        }

        $operator      = $type == 'include' ? 'IN' : 'NOT IN';
        $this->query[] = 'AND t.term_id ' . $operator . ' (' . join(',', $parameters) . ')';
    }

    /**
     * Add grouping statement
     *
     * @since 2.2
     */
    public function addGrouping()
    {
        $this->query[] = 'GROUP BY tr.term_taxonomy_id';
    }

    /**
     * Add minimum constraint
     *
     * @param int $minimum
     *
     * @since 2.2
     */
    public function addMinimum($minimum)
    {
        if ($minimum) {
            $this->query[]      = 'HAVING count >= %d';
            $this->parameters[] = $minimum;
        }
    }

    /**
     * Add max constraint
     *
     * @param int $max
     *
     * @since 2.2
     */
    public function addMaxConstraint($max)
    {
        $this->query[]      = 'LIMIT %d';
        $this->parameters[] = $max;
    }

    /**
     * Add sorting the result
     *
     * @param string $order
     * @param bool   $reverse
     * @param bool   $case_sensitive
     *
     * @since 2.2
     */
    public function addSort($order, $reverse, $case_sensitive)
    {
        // No subquery is needed if the order should be by count desc (it's already sorted that way)
        // No subquery is needed if the order should be by color since the sorting is done in PHP afterwards
        if ($order == 'color' || $reverse && $order == 'count') {
            return;
        }

        // If the result should be ordered in another way, try to create a sub-query to sort the result
        // directly in the database query
        array_unshift($this->query, 'SELECT * FROM (');
        $this->query[] = ') AS subQuery';

        $way    = $reverse ? 'DESC' : 'ASC';
        $binary = $case_sensitive ? 'BINARY ' : '';

        $orderStatementMap = array(
            'random' => 'ORDER BY RAND() ' . $way,
            'name'   => 'ORDER BY ' . $binary . 'name ' . $way,
            'slug'   => 'ORDER BY ' . $binary . 'slug ' . $way,
            'id'     => 'ORDER BY term_id ' . $way,
            'count'  => 'ORDER BY count ' . $way,
        );

        $this->query[] = $orderStatementMap[$order];
    }
}