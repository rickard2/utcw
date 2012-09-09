<?php

class UTCW_Render {

	/**
	 * @var UTCW_Data
	 */
	private $data;

	/**
	 * @var UTCW_Config
	 */
	private $config;

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $css = '';

	public function __construct( UTCW_Config $config, UTCW_Data $data )
	{
		$this->data   = $data;
		$this->config = $config;
		$this->id     = crc32( serialize( $config ) );

		$this->build_css();
	}

	public function render()
	{
		echo $this->get_cloud();
	}

	public function get_cloud()
	{
		$markup = array();

		if ( $this->css ) {
			$markup[ ] = $this->css;
		}

		$markup[ ] = '<div class="utcw-' . $this->id . '">';

		$markup[ ] = '</div>';

		return join( '', $markup );
	}

	private function build_css()
	{
		$main_styles = array();

		if ( ! $this->has_default_value( 'text_transform' ) ) {
			$main_styles[ ] = 'text-transform:' . $this->config->text_transform;
		}

		if ( ! $this->has_default_value( 'letter_spacing' ) ) {
			$main_styles[ ] = 'letter-spacing:' . $this->config->letter_spacing;
		}

		if ( ! $this->has_default_value( 'word_spacing' ) ) {
			$main_styles[ ] = 'word-spacing:' . $this->config->word_spacing;
		}

		$link_styles = array();

		$hover_styles = array();

		$styles = array();

		if ( $main_styles ) {
			$styles[ ] = sprintf( '.utcw-%s{%s}', $this->id, join( ';', $main_styles ) );
		}

		if ( $link_styles ) {
			$styles[ ] = sprintf( '.utcw-%s a {%s}', $this->id, join( ';', $link_styles ) );
		}

		if ( $hover_styles ) {
			$styles[ ] = sprintf( '.utcw-%s a:hover {%s}', $this->id, join( ';', $hover_styles ) );
		}

		if ( $styles ) {
			$this->css = sprintf( '<style type="text/css">%s</style>', join( '', $styles ) );
		}
	}

	private function has_default_value( $option )
	{
		$defaults = $this->config->get_defaults();
		return $this->config->$option === $defaults[ $option ];
	}
}