<?php

class UTCW_Term {

	public $term_id;
	public $count;
	public $slug;
	public $name;
	public $link;
	public $color;
	public $taxonomy;
	public $size;

	function __construct( stdClass $input, UTCW_Plugin $utcw )
	{

		if ( isset( $input->term_id ) && filter_var( $input->term_id, FILTER_VALIDATE_INT ) ) {
			$this->term_id = intval( $input->term_id );
		}

		if ( isset( $input->count ) && filter_var( $input->count, FILTER_VALIDATE_INT ) ) {
			$this->count = intval( $input->count );
		}

		if ( isset( $input->slug ) && strlen( $input->slug ) > 0 && preg_match( '/^[0-9a-z\-]+/i', $input->slug ) ) {
			$this->slug = $input->slug;
		}

		if ( isset( $input->name ) && strlen( $input->name ) > 0 ) {
			$this->name = $input->name;
		}

		if ( isset( $input->color ) && strlen( $input->color ) > 0 && preg_match( UTCW_HEX_COLOR_REGEX, $input->color ) ) {
			$this->color = $input->color;
		}

		if ( isset( $input->taxonomy ) && strlen( $input->taxonomy ) > 0 ) {
			$this->taxonomy = $input->taxonomy;
		}

		if ( $this->term_id && $this->taxonomy ) {
			$this->link = $utcw->get_term_link( $this->term_id, $this->taxonomy );
		}
	}
}