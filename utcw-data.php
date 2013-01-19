<?php
/**
 * Ultimate Tag Cloud Widget
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.1
 * @license    GPLv2
 * @package    utcw
 * @subpackage main
 * @since      2.0
 */
if ( ! defined( 'ABSPATH' ) ) die();

/**
 * Class for loading data for the cloud
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */
class UTCW_Data {

	/**
	 * Reference to the current configuration
	 *
	 * @var UTCW_Config
	 * @since 2.0
	 */
	protected $config;

	/**
	 * Reference to WPDB object
	 *
	 * @var wpdb
	 * @since 2.0
	 */
	protected $db;

	/**
	 * Reference to main plugin instance
	 *
	 * @var UTCW_Plugin
	 * @since 2.0
	 */
	protected $plugin;

	/**
	 * A copy of the SQL query for debugging purposes
	 *
	 * @var string
	 * @since 2.1
	 */
	protected $query;

	/**
	 * Creates a new instance
	 *
	 * @param UTCW_Config $config   Current configuration
	 * @param UTCW_Plugin $plugin   Main plugin instance
	 * @param wpdb        $db       WordPress DB instance
	 *
	 * @since 2.0
	 */
	function __construct( UTCW_Config $config, UTCW_Plugin $plugin, wpdb $db ) {
		$this->config = $config;
		$this->db     = $db;
		$this->plugin = $plugin;
	}

	/**
	 * Loads terms based on current configuration
	 *
	 * @return UTCW_Term[]
	 * @since 2.0
	 */
	function get_terms() {
		$query = array();

		// Base query with joins
		$query[ ] = 'SELECT t.term_id, t.name, t.slug, COUNT(p.ID) AS `count`, tt.taxonomy';
		$query[ ] = 'FROM `' . $this->db->terms . '` AS t';
		$query[ ] = 'JOIN `' . $this->db->term_taxonomy . '` AS tt ON t.term_id = tt.term_id';
		$query[ ] = 'LEFT JOIN `' . $this->db->term_relationships . '` AS tr ON tt.term_taxonomy_id = tr.term_taxonomy_id';
		$query[ ] = 'LEFT JOIN `' . $this->db->posts . '` AS p ON tr.object_id = p.ID';

		// Add authors constraint if configured
		if ( $this->config->authors ) {
			$author_parameters = array();

			foreach ( $this->config->authors as $author ) {
				$author_parameters[ ] = '%d';
				$parameters[ ]        = $author;
			}

			$query[ ] = 'AND p.post_author IN (' . join( ',', $author_parameters ) . ')';
		}

		// Add post types constraint
		$post_type_parameters = array();

		foreach ( $this->config->post_type as $post_type ) {
			$post_type_parameters[ ] = '%s';
			$parameters[ ]           = $post_type;
		}

		$query[ ] = 'AND p.post_type IN (' . join( ',', $post_type_parameters ) . ')';

		// Add post status statement, authenticated users are allowed to view tags for private posts
		if ( $this->config->authenticated ) {
			$query[ ] = "AND p.post_status IN ('publish','private')";
		} else {
			$query[ ] = "AND p.post_status = 'publish'";
		}

		// Add days old constraint
		if ( $this->config->days_old ) {
			$query[ ]      = 'AND p.post_date > %s';
			$parameters[ ] = date( 'Y-m-d', strtotime( '-' . $this->config->days_old . ' days' ) );
		}

		// Add taxonomy statement
		$taxonomy_parameters = array();

		foreach ( $this->config->taxonomy as $taxonomy ) {
			$taxonomy_parameters[ ] = '%s';
			$parameters[ ]          = $taxonomy;
		}

		$query[ ] = 'WHERE tt.taxonomy IN (' . join( ',', $taxonomy_parameters ) . ')';

		// Add include or exclude statement
		if ( $this->config->tags_list ) {
			$tags_list_parameters = array();

			foreach ( $this->config->tags_list as $tag_id ) {
				if ( $this->plugin->check_term_taxonomy( $tag_id, $this->config->taxonomy ) ) {
					$tags_list_parameters[ ] = '%d';
					$parameters[ ]           = $tag_id;
				}
			}

			if ( $tags_list_parameters ) {
				$tags_list_operator = $this->config->tags_list_type == 'include' ? 'IN' : 'NOT IN';
				$query[ ]           = 'AND t.term_id ' . $tags_list_operator . ' (' . join( ',', $tags_list_parameters ) . ')';
			}
		}

		$query[ ] = 'GROUP BY tr.term_taxonomy_id';

		// Add minimum constraint
		if ( $this->config->minimum ) {
			$query[ ]      = 'HAVING count >= %d';
			$parameters[ ] = $this->config->minimum;
		}

		// Always sort the result by count DESC to always work with the top result
		$query[ ] = 'ORDER BY count DESC';

		// Add limit constraint
		$query[ ]      = 'LIMIT %d';
		$parameters[ ] = $this->config->max;

		// If the result should be ordered in another way, try to create a sub-query to sort the result
		// directly in the database query
		$subquery_required = true;

		// No subquery is needed if the order should be by count desc (it's already sorted that way)
		if ( $this->config->reverse && $this->config->order == 'count' ) {
			$subquery_required = false;
		}

		// No subquery is needed if the order should be by color since the sorting is done in PHP afterwards
		if ( $this->config->order == 'color' ) {
			$subquery_required = false;
		}

		if ( $subquery_required ) {
			array_unshift( $query, 'SELECT * FROM (' );
			$query[ ] = ') AS subQuery';

			$order  = $this->config->reverse ? 'DESC' : 'ASC';
			$binary = $this->config->case_sensitive ? 'BINARY ' : '';

			switch ( $this->config->order ) {
				case 'random':
					$query[ ] = 'ORDER BY RAND() ' . $order;
					break;

				case 'name':
					$query[ ] = 'ORDER BY ' . $binary . 'name ' . $order;
					break;

				case 'slug':
					$query[ ] = 'ORDER BY ' . $binary . 'slug ' . $order;
					break;

				case 'id':
					$query[ ] = 'ORDER BY term_id ' . $order;
					break;

				case 'count':
					$query[ ] = 'ORDER BY count ' . $order;
					break;
			}
		}

		// Build query
		$query = join( "\n", $query );
		$query = $this->db->prepare( $query, $parameters );

		// Fetch terms from DB
		$result      = $this->db->get_results( $query );
		$this->query = $this->db->last_query;
		$terms       = array();

		// Calculate sizes
		$min_count = PHP_INT_MAX;
		$max_count = 0;

		foreach ( $result as $item ) {
			if ( $item->count < $min_count ) {
				$min_count = $item->count;
			}

			if ( $item->count > $max_count ) {
				$max_count = $item->count;
			}

			$terms[ ] = new UTCW_Term( $item, $this->plugin );
		}

		$size_from = floatval( $this->config->size_from );
		$size_to   = floatval( $this->config->size_to );
		$unit      = preg_replace( '/' . UTCW_DECIMAL_REGEX . '/', '', $this->config->size_from );

		$font_step = $this->calc_step( $min_count, $max_count, $size_from, $size_to );

		foreach ( $terms as $term ) {
			$term->size = $this->calc_size( $size_from, $term->count, $min_count, $font_step ) . $unit;
		}

		// Set colors
		switch ( $this->config->color ) {
			case 'random':
				foreach ( $terms as $term ) {
					$term->color = sprintf( UTCW_HEX_COLOR_FORMAT, rand() % 255, rand() % 255, rand() % 255 );
				}
				break;

			case 'set':
				if ( $this->config->color_set ) {
					foreach ( $terms as $term ) {
						$term->color = $this->config->color_set[ array_rand( $this->config->color_set ) ];
					}
				}
				break;

			case 'span':
				if ( $this->config->color_span_from && $this->config->color_span_to ) {
					preg_match_all( '/[0-9a-f]{2}/i', $this->config->color_span_from, $cf_rgb_matches );
					list( $red_from, $green_from, $blue_from ) = array_map( 'hexdec', $cf_rgb_matches[ 0 ] );

					preg_match_all( '/[0-9a-f]{2}/i', $this->config->color_span_to, $ct_rgb_matches );
					list( $red_to, $green_to, $blue_to ) = array_map( 'hexdec', $ct_rgb_matches[ 0 ] );

					$colors             = new stdClass;
					$colors->red_from   = $red_from;
					$colors->red_to     = $red_to;
					$colors->green_from = $green_from;
					$colors->green_to   = $green_to;
					$colors->blue_from  = $blue_from;
					$colors->blue_to    = $blue_to;

					foreach ( $terms as $term ) {
						$term->color = $this->calc_color( $min_count, $max_count, $colors, $term->count );
					}
				}
		}

		// Last order by color if selected, this is the only order which can't be done in the DB
		if ( $this->config->order == 'color' ) {
			// Change the argument order to change the sort order
			$sort_fn_arguments = $this->config->reverse ? '$b,$a' : '$a,$b';

			// There's no difference in sortin case sensitive or case in-sensitive since
			// the colors are always lower case and internally generated

			$sort_fn = create_function( $sort_fn_arguments, 'return strcmp( $a->color, $b->color );' );

			usort( $terms, $sort_fn );
		}

		return $terms;
	}

	/**
	 * Calculate term color
	 *
	 * @param int      $min_count Min count of all the terms
	 * @param int      $max_count Max count of all the terms
	 * @param stdClass $colors    Object with red/green/blue_from/to properties
	 * @param int      $count     Count of current term
	 *
	 * @return string
	 * @since 2.0
	 */
	private function calc_color( $min_count, $max_count, stdClass $colors, $count ) {
		$red_step   = $this->calc_step( $min_count, $max_count, $colors->red_from, $colors->red_to );
		$green_step = $this->calc_step( $min_count, $max_count, $colors->green_from, $colors->green_to );
		$blue_step  = $this->calc_step( $min_count, $max_count, $colors->blue_from, $colors->blue_to );

		$red   = $this->calc_size( $colors->red_from, $count, $min_count, $red_step );
		$green = $this->calc_size( $colors->green_from, $count, $min_count, $green_step );
		$blue  = $this->calc_size( $colors->blue_from, $count, $min_count, $blue_step );

		$color = sprintf( UTCW_HEX_COLOR_FORMAT, $red, $green, $blue );

		return $color;
	}

	/**
	 * Calculate term size
	 *
	 * @param int $size_from Configured min size
	 * @param int $count     Current count
	 * @param int $min_count Configured max count
	 * @param int $font_step Calculated step
	 *
	 * @return int
	 * @since 2.0
	 */
	private function calc_size( $size_from, $count, $min_count, $font_step ) {
		return $size_from + ( ( $count - $min_count ) * $font_step );
	}

	/**
	 * Calculate step size
	 *
	 * @param int $min  Minimum count
	 * @param int $max  Maximum count
	 * @param int $from Minimum size
	 * @param int $to   Maximum size
	 *
	 * @return int
	 * @since 2.0
	 */
	private function calc_step( $min, $max, $from, $to ) {
		if ( $min === $max ) {
			return 0;
		}

		$spread      = $max - $min;
		$font_spread = $to - $from;
		$step        = $font_spread / $spread;

		return $step;
	}

	/**
	 * Cleans up sensitive data before being used in debug output
	 */
	public function cleanup_for_debug() {
		unset( $this->db );
	}
}