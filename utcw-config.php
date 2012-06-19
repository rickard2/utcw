<?php

/**
 * Configuration class for the widget.
 */
class UTCW_Config {

	/**
	 * Config store with default values
	 * @var array
	 */
	protected $config = array(
		'title'              => 'Tag Cloud',
		'order'              => 'name',
		'size_from'          => 10,
		'size_to'            => 30,
		'max'                => 45,
		'taxonomy'           => 'post_tag',
		'reverse'            => false,
		'color'              => 'none',
		'letter_spacing'     => 'normal',
		'word_spacing'       => 'normal',
		'case'               => 'off',
		'case_sensitive'     => false,
		'minimum'            => 1,
		'tags_list_type'     => 'exclude',
		'show_title'         => true,
		'link_underline'     => 'default',
		'link_bold'          => 'default',
		'link_italic'        => 'default',
		'link_bg_color'      => 'transparent',
		'link_border_style'  => 'none',
		'link_border_width'  => 0,
		'link_border_color'  => 'none',
		'hover_underline'    => 'default',
		'hover_bold'         => 'default',
		'hover_italic'       => 'default',
		'hover_bg_color'     => 'transparent',
		'hover_color'        => 'default',
		'hover_border_style' => 'none',
		'bover_border_width' => 0,
		'hover_border_color' => 'none',
		'tag_spacing'        => 'auto',
		'debug'              => false,
		'days_old'           => 0,
		'line_height'        => 'inherit',
		'separator'          => ' ',
		'prefix'             => '',
		'suffix'             => '',
		'show_title_text'    => true,
	);

	/**
	 * @var array
	 */
	protected $allowed_orders = array( 'random', 'name', 'slug', 'id', 'color', 'count' );

	/**
	 * @var array
	 */
	protected $allowed_taxonomies = array(); // Will be set dynamically at load

	/**
	 * @var array
	 */
	protected $allowed_colors = array( 'none', 'random', 'set', 'span' );

	/**
	 * @var array
	 */
	protected $allowed_cases = array( 'lowercase', 'uppercase', 'capitalize', 'off' );

	/**
	 * @var array
	 */
	protected $allowed_tags_list_types = array( 'exclude', 'include' );

	/**
	 * @var array
	 */
	protected $allowed_booleans = array( 'yes', 'no', 'default' );

	/**
	 * @var array
	 */
	protected $allowed_border_styles = array(
		'none', 'dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset',
	);

	/**
	 * Loads a configuration and parses the options
	 *
	 * @param array $input
	 */
	function __construct( array $input )
	{

		foreach ( $this->config as $key => $item ) {
			if ( isset( $input[ $key ] ) ) {
				$valid = true;

				switch ( $key ) {
					case 'order':
						$valid = in_array( $input[ $key ], $this->allowed_orders );
						break;

					case 'case':
						$valid = in_array( $input[ $key ], $this->allowed_cases );
						break;

					case 'tags_list_type':
						$valid = in_array( $input[ $key ], $this->allowed_tags_list_types );
						break;

					case 'link_underline':
					case 'link_bold':
					case 'link_italic':
					case 'hover_underline':
					case 'hover_bold':
					case 'hover_italic':
						$valid = in_array( $input[ $key ], $this->allowed_booleans );
						break;

					case 'link_border_style':
					case 'hover_border_style':
						$valid = in_array( $input[ $key ], $this->allowed_border_styles );
						break;

					case 'color':
						$valid = in_array( $input[ $key ], $this->allowed_colors );
						break;

					case 'link_bg_color':
					case 'link_border_color':
					case 'hover_bg_color':
					case 'hover_color':
					case 'hover_border_color':
						$valid = preg_match( '/#([a-f0-9]{6}|[a-f0-9]{3})/i', $input[ $key ] ) > 0;
						break;

					case 'letter_spacing':
					case 'word_spacing':
 					case 'tag_spacing':
 					case 'line_height':
						$this->config[ $key ] = intval( $input[ $key ] );
						break;
				}

				if ( ! $valid ) {
					continue;
				}

				if ( is_string( $this->config[ $key ] ) && strlen( $input[ $key ] ) > 0 ) {
					$this->config[ $key ] = $input[ $key ];
				}

				if ( is_integer( $this->config[ $key ] ) && $input[ $key ] >= 0 ) {
					$this->config[ $key ] = intval( $input[ $key ] );
				}

				if ( is_bool( $this->config[ $key ] ) ) {
					$this->config[ $key ] = !! $input[ $key ];
				}
			}
		}
	}

	/**
	 * Returns the WP_Widget instance
	 * @return array
	 */
	function get_instance()
	{
		return $this->config;
	}
}