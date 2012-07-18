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
		$query[ ] = 'LEFT JOIN `' . $this->db->term_relationships . '` AS tr ON tr.object_id = p.ID';
		$query[ ] = 'LEFT JOIN `' . $this->db->term_taxonomy . '` AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id';
		$query[ ] = 'LEFT JOIN `' . $this->db->terms . '` AS t ON t.term_id = tt.term_id';

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
			$query[ ] = "AND post_date > '" . date( 'Y-m-d', strtotime( '-' . $this->config->days_old . ' days' ) ) . "'";
		}

		$query = join( "\n", $query );
		$query = $this->db->prepare( $query, $parameters );

		$result = $this->db->get_results( $query );

		return $result;
	}
}