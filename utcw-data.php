<?php

class UTCW_Data {

	protected $config;
	protected $db;

	function __construct( UTCW_Config $config, wpdb $db )
	{
		$this->config = $config;
		$this->db     = $db;
	}

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

		// TODO: Add sizes
		// TODO: Add coloring
		// TODO: Order by color

		$result = $this->db->get_results( $query );
		$terms  = array();

		foreach ( $result as $item ) {
			$item->taxonomy = $this->config->taxonomy;
			$terms[ ]       = new UTCW_Term( $item );
		}

		return $terms;
	}
}