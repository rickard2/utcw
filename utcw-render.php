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
		$this->id     = base_convert( crc32( serialize( $config ) ), 10, 27 );

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

		if ( $this->config->before_widget ) {
			$markup[ ] = $this->config->before_widget;
		}

		$markup[ ] = '<div class="widget_tag_cloud utcw-' . $this->id . '">';

		if ( $this->config->show_title_text ) {
			if ( $this->config->before_title ) {
				$markup[ ] = $this->config->before_title;
			}

			$markup[ ] = apply_filters( 'widget_title', $this->config->title );

			if ( $this->config->after_title ) {
				$markup[ ] = $this->config->after_title;
			}
		}

		$terms = array();

		foreach ( $this->data->get_terms() as $term ) {
			$color = $term->color ? ';color:' . $term->color : '';
			$title = $this->config->show_title ? sprintf( ' title="' . _n( '%s topic', '%s topics', $term->count ) . '"', $term->count ) : '';

			$terms[ ] = sprintf(
							'%s<a class="tag-link-%s" href="%s" style="font-size:%spx%s"%s>%s</a>%s',
							$this->config->prefix,
							$term->term_id,
							$term->link,
							$term->size,
							$color,
							$title,
							$term->name,
							$this->config->suffix
			);
		}

		$markup[ ] = join( $this->config->separator, $terms );

		$markup[ ] = '</div>';

		if ( $this->config->after_widget ) {
			$markup[ ] = $this->config->after_widget;
		}

		return join( '', $markup );
	}

	private function build_css()
	{
		$main_styles = array();

		if ( ! $this->has_default_value( 'text_transform' ) ) {
			$main_styles[ ] = sprintf( 'text-transform:%spx', $this->config->text_transform );
		}

		if ( ! $this->has_default_value( 'letter_spacing' ) ) {
			$main_styles[ ] = sprintf( 'letter-spacing:%spx', $this->config->letter_spacing );
		}

		if ( ! $this->has_default_value( 'word_spacing' ) ) {
			$main_styles[ ] = sprintf( 'word-spacing:%spx', $this->config->word_spacing );
		}

		$link_styles = array();

		if ( ! $this->has_default_value( 'link_underline' ) ) {
			$link_styles[ ] = sprintf( 'text-decoration:%s', $this->config->link_underline === 'yes' ? 'underline' : 'none' );
		}

		if ( ! $this->has_default_value( 'link_bold' ) ) {
			$link_styles[ ] = sprintf( 'font-weight:%s', $this->config->link_bold === 'yes' ? 'bold' : 'normal' );
		}

		if ( ! $this->has_default_value( 'link_italic' ) ) {
			$link_styles[ ] = sprintf( 'font-style:%s', $this->config->link_italic === 'yes' ? 'italic' : 'normal' );
		}

		if ( ! $this->has_default_value( 'link_bg_color' ) ) {
			$link_styles[ ] = sprintf( 'background-color:%s', $this->config->link_bg_color );
		}

		if ( ! $this->has_default_value( 'link_border_style' ) && ! $this->has_default_value( 'link_border_color' ) && ! $this->has_default_value( 'link_border_width' ) ) {
			$link_styles[ ] = sprintf( 'border:%s %spx %s', $this->config->link_border_style, $this->config->link_border_width, $this->config->link_border_color );
		} else {
			if ( ! $this->has_default_value( 'link_border_style' ) ) {
				$link_styles[ ] = sprintf( 'border-style:%s', $this->config->link_border_style );
			}

			if ( ! $this->has_default_value( 'link_border_color' ) ) {
				$link_styles[ ] = sprintf( 'border-color:%s', $this->config->link_border_color );
			}

			if ( ! $this->has_default_value( 'link_border_width' ) ) {
				$link_styles[ ] = sprintf( 'border-width:%spx', $this->config->link_border_width );
			}
		}

		if ( ! $this->has_default_value( 'tag_spacing' ) ) {
			$link_styles[ ] = sprintf( 'margin-right:%spx', $this->config->tag_spacing );
		}

		if ( ! $this->has_default_value( 'line_height' ) ) {
			$link_styles[ ] = sprintf( 'line-height:%spx', $this->config->line_height );
		}

		$hover_styles = array();

		if ( ! $this->has_default_value( 'hover_underline' ) ) {
			$hover_styles[ ] = sprintf( 'text-decoration:%s', $this->config->hover_underline === 'yes' ? 'underline' : 'none' );
		}

		if ( ! $this->has_default_value( 'hover_bold' ) ) {
			$hover_styles[ ] = sprintf( 'font-weight:%s', $this->config->hover_bold === 'yes' ? 'bold' : 'normal' );
		}

		if ( ! $this->has_default_value( 'hover_italic' ) ) {
			$hover_styles[ ] = sprintf( 'font-style:%s', $this->config->hover_italic === 'yes' ? 'italic' : 'normal' );
		}

		if ( ! $this->has_default_value( 'hover_bg_color' ) ) {
			$hover_styles[ ] = sprintf( 'background-color:%s', $this->config->hover_bg_color );
		}

		if ( ! $this->has_default_value( 'hover_border_style' ) && ! $this->has_default_value( 'hover_border_color' ) && ! $this->has_default_value( 'hover_border_width' ) ) {
			$hover_styles[ ] = sprintf( 'border:%s %spx %s', $this->config->hover_border_style, $this->config->hover_border_width, $this->config->hover_border_color );
		} else {
			if ( ! $this->has_default_value( 'hover_border_style' ) ) {
				$hover_styles[ ] = sprintf( 'border-style:%s', $this->config->hover_border_style );
			}

			if ( ! $this->has_default_value( 'hover_border_color' ) ) {
				$hover_styles[ ] = sprintf( 'border-color:%s', $this->config->hover_border_color );
			}

			if ( ! $this->has_default_value( 'hover_border_width' ) ) {
				$hover_styles[ ] = sprintf( 'border-width:%spx', $this->config->hover_border_width );
			}
		}

		$styles = array();

		if ( $main_styles ) {
			$styles[ ] = sprintf( '.utcw-%s{%s}', $this->id, join( ';', $main_styles ) );
		}

		if ( $link_styles ) {
			$styles[ ] = sprintf( '.utcw-%s a{%s}', $this->id, join( ';', $link_styles ) );
		}

		if ( $hover_styles ) {
			$styles[ ] = sprintf( '.utcw-%s a:hover{%s}', $this->id, join( ';', $hover_styles ) );
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