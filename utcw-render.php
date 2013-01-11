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
 * Class for rendering the cloud
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */
class UTCW_Render {

	/**
	 * Reference to the Data class which contains the data to be rendered
	 *
	 * @var UTCW_Data
	 * @since 2.0
	 */
	private $data;

	/**
	 * Reference to the current configuration
	 *
	 * @var UTCW_Config
	 * @since 2.0
	 */
	private $config;

	/**
	 * Reference to the main plugin instance
	 *
	 * @var UTCW_Plugin
	 * @since 2.0
	 */
	private $plugin;

	/**
	 * Unique ID for this widget configuration
	 *
	 * @var int
	 * @since 2.0
	 */
	private $id;

	/**
	 * CSS styles for this widget instance
	 *
	 * @var string
	 * @since 2.0
	 */
	private $css = '';

	/**
	 * Creates a new instance of the renderer
	 *
	 * @param UTCW_Config $config Configuration
	 * @param UTCW_Data   $data   Term data
	 * @param UTCW_Plugin $plugin Main plugin instance
	 *
	 * @since 2.0
	 */
	public function __construct( UTCW_Config $config, UTCW_Data $data, UTCW_Plugin $plugin ) {
		$this->data   = $data;
		$this->config = $config;
		$this->plugin = $plugin;
		$this->id     = base_convert( crc32( serialize( $config ) ), 10, 27 );

		$this->build_css();
	}

	/**
	 * Renders the cloud as output
	 *
	 * @since 2.0
	 */
	public function render() {
		echo $this->get_cloud();
	}

	/**
	 * Returns the cloud as a string
	 *
	 * @return string
	 * @since 2.0
	 */
	public function get_cloud() {
		$markup = array();

		if ( $this->css ) {
			$markup[ ] = $this->css;
		}

		if ( $this->config->before_widget ) {
			$markup[ ] = $this->config->before_widget;
		}

		if ( $this->config->show_title_text ) {
			if ( $this->config->before_title ) {
				$markup[ ] = $this->config->before_title;
			}

			$markup[ ] = $this->plugin->apply_filters( 'widget_title', $this->config->title );

			if ( $this->config->after_title ) {
				$markup[ ] = $this->config->after_title;
			}
		}

		$markup[ ] = '<div class="widget_tag_cloud utcw-' . $this->id . '">';

		$terms = array();

		foreach ( $this->data->get_terms() as $term ) {
			$color = $term->color ? ';color:' . $term->color : '';
			$title = $this->config->show_title ? sprintf( ' title="' . _n( '%s topic', '%s topics', $term->count ) . '"', $term->count ) : '';

			$terms[ ] = sprintf(
							'%s<a class="tag-link-%s" href="%s" style="font-size:%s%s"%s>%s</a>%s',
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

		if ( $this->config->debug ) {
			$debug_object = clone $this->data;
			$debug_object->cleanup_for_debug();
			$markup[ ] = sprintf( "<!-- Ultimate Tag Cloud Debug information:\n%s -->", print_r( $debug_object, true ) );
		}

		if ( $this->config->after_widget ) {
			$markup[ ] = $this->config->after_widget;
		}

		return join( '', $markup );
	}

	/**
	 * Builds the CSS needed to properly style the cloud
	 *
	 * @since 2.0
	 */
	private function build_css() {
		$main_styles = array( 'word-wrap:break-word' );

		if ( ! $this->has_default_value( 'text_transform' ) ) {
			$main_styles[ ] = sprintf( 'text-transform:%s', $this->config->text_transform );
		}

		if ( ! $this->has_default_value( 'letter_spacing' ) ) {
			$main_styles[ ] = sprintf( 'letter-spacing:%s', $this->config->letter_spacing );
		}

		if ( ! $this->has_default_value( 'word_spacing' ) ) {
			$main_styles[ ] = sprintf( 'word-spacing:%s', $this->config->word_spacing );
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
			$link_styles[ ] = sprintf( 'border:%s %s %s', $this->config->link_border_style, $this->config->link_border_width, $this->config->link_border_color );
		} else {
			if ( ! $this->has_default_value( 'link_border_style' ) ) {
				$link_styles[ ] = sprintf( 'border-style:%s', $this->config->link_border_style );
			}

			if ( ! $this->has_default_value( 'link_border_color' ) ) {
				$link_styles[ ] = sprintf( 'border-color:%s', $this->config->link_border_color );
			}

			if ( ! $this->has_default_value( 'link_border_width' ) ) {
				$link_styles[ ] = sprintf( 'border-width:%s', $this->config->link_border_width );
			}
		}

		if ( ! $this->has_default_value( 'tag_spacing' ) ) {
			$link_styles[ ] = sprintf( 'margin-right:%s', $this->config->tag_spacing );
		}

		if ( ! $this->has_default_value( 'line_height' ) ) {
			$link_styles[ ] = sprintf( 'line-height:%s', $this->config->line_height );
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
			$hover_styles[ ] = sprintf( 'border:%s %s %s', $this->config->hover_border_style, $this->config->hover_border_width, $this->config->hover_border_color );
		} else {
			if ( ! $this->has_default_value( 'hover_border_style' ) ) {
				$hover_styles[ ] = sprintf( 'border-style:%s', $this->config->hover_border_style );
			}

			if ( ! $this->has_default_value( 'hover_border_color' ) ) {
				$hover_styles[ ] = sprintf( 'border-color:%s', $this->config->hover_border_color );
			}

			if ( ! $this->has_default_value( 'hover_border_width' ) ) {
				$hover_styles[ ] = sprintf( 'border-width:%s', $this->config->hover_border_width );
			}
		}

		if ( ! $this->has_default_value( 'hover_color' ) ) {
			$hover_styles[ ] = sprintf( 'color:%s', $this->config->hover_color );
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

	/**
	 * Checks if option still has the default value
	 *
	 * @param string $option
	 *
	 * @return bool
	 * @since 2.0
	 */
	private function has_default_value( $option ) {
		$defaults = $this->config->get_defaults();
		return $this->config->$option === $defaults[ $option ];
	}
}