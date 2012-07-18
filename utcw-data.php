<?php

class UTCW_Data {

	protected $config;
	protected $db;

	function __construct( UTCW_Config $config, wpdb $db )
	{
		$this->config = $config;
		$this->db     = $db;
	}

	/**
	 * @return UTCW_Term[]
	 */
	function get_terms()
	{
		$query = array();

		// Base query with joins
		$query[ ] = 'SELECT t.term_id, t.name, t.slug, COUNT(tr.term_taxonomy_id) AS `count`';
		$query[ ] = 'FROM `' . $this->db->posts . '` AS p';
		$query[ ] = 'JOIN `' . $this->db->term_relationships . '` AS tr ON tr.object_id = p.ID';
		$query[ ] = 'JOIN `' . $this->db->term_taxonomy . '` AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id';
		$query[ ] = 'JOIN `' . $this->db->terms . '` AS t ON t.term_id = tt.term_id';

		// Add taxonomy statement
		$query[ ]      = 'WHERE tt.taxonomy = %s';
		$parameters[ ] = $this->config->taxonomy;

		// Add authors statement if configured
		if ( $this->config->authors ) {
			$author_parameters = array();

			foreach ( $this->config->authors as $author ) {
				$author_parameters[ ] = '%d';
				$parameters[ ]        = $author;
			}

			$query[ ] = 'AND post_author IN (' . join( ',', $author_parameters ) . ')';
		}

		// Add post types statement
		$post_type_parameters = array();

		foreach ( $this->config->post_type as $post_type ) {
			$post_type_parameters[ ] = '%s';
			$parameters[ ]           = $post_type;
		}

		$query[ ] = 'AND post_type IN (' . join( ',', $post_type_parameters ) . ')';

		// Add post status statement, authenticated users are allowed to view tags for private posts
		if ( $this->config->authenticated ) {
			$query[ ] = "AND post_status IN ('publish','private')";
		} else {
			$query[ ] = "AND post_status = 'publish'";
		}

		// Add include or exclude statement
		if ( $this->config->tags_list ) {
			$tags_list_parameters = array();

			foreach ( $this->config->tags_list as $tag_id ) {
				$tags_list_parameters[ ] = '%d';
				$parameters[ ]           = $tag_id;
			}

			$tags_list_operator = $this->config->tags_list_type == 'include' ? 'IN' : 'NOT IN';

			$query[ ] = 'AND t.term_id ' . $tags_list_operator . ' (' . join( ',', $tags_list_parameters ) . ')';
		}

		// Add days old statement
		if ( $this->config->days_old ) {
			$query[ ]      = 'AND post_date > %s';
			$parameters[ ] = date( 'Y-m-d', strtotime( '-' . $this->config->days_old . ' days' ) );
		}

		$query[ ] = 'GROUP BY tr.term_taxonomy_id';

		// Add minimum constraint
		if ( $this->config->minimum > 1 ) {
			$query[ ]      = 'HAVING count >= %d';
			$parameters[ ] = $this->config->minimum;
		}

		// Try to sort the result using SQL if possible
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

		// Add limit constraint
		$query[ ]      = 'LIMIT %d';
		$parameters[ ] = $this->config->max;

		$query = join( "\n", $query );
		$query = $this->db->prepare( $query, $parameters );

		// TODO: Add coloring
		// TODO: Order by color

		$result = $this->db->get_results( $query );
		$terms  = array();

		$min_count = PHP_INT_MAX;
		$max_count = 0;

		foreach ( $result as $item ) {
			if ( $item->count < $min_count ) {
				$min_count = $item->count;
			}

			if ( $item->count > $max_count ) {
				$max_count = $item->count;
			}

			$item->taxonomy = $this->config->taxonomy;
			$terms[ ]       = new UTCW_Term( $item );
		}

		$font_step = $this->calc_step( $min_count, $max_count, $this->config->size_from, $this->config->size_to );

		foreach ( $terms as $term ) {
			$term->size = $this->calc_size( $this->config->size_from, $term->count, $min_count, $font_step );
		}

		return $terms;
	}

	/**
	 * @param int $size_from
	 * @param int $count
	 * @param int $min_count
	 * @param int $font_step
	 *
	 * @return mixed
	 * @since 2.0
	 */
	private function calc_size( $size_from, $count, $min_count, $font_step )
	{
		return $size_from + ( ( $count - $min_count ) * $font_step );
	}

	/**
	 * Used to calculate how step size in spanning values
	 * Thank you wordpress for this
	 *
	 * @param integer $min
	 * @param integer $max
	 * @param integer $from
	 * @param integer $to
	 *
	 * @return integer
	 * @since 1.0
	 */
	private function calc_step( $min, $max, $from, $to )
	{
		$spread = $max - $min;

		if ( $spread <= 0 ) {
			$spread = 1;
		}

		$font_spread = $to - $from;

		if ( $font_spread < 0 ) {
			$font_spread = 1;
		}

		$step = $font_spread / $spread;

		return $step;
	}
}