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
 * Configuration class for the widget.
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */
class UTCW_Config {

	/**
	 * Title text of the widget.
	 * Default value: Tag cloud
	 *
	 * @var string
	 * @since 2.0
	 */
	public $title;

	/**
	 * How the result should be ordered
	 * Default value: name
	 * Valid values: random, name, slug, id, color, count
	 *
	 * @var string
	 * @since 2.0
	 */
	public $order;

	/**
	 * The smallest possible size
	 * Default: 10px
	 *
	 * @var string
	 * @since 2.0
	 */
	public $size_from;

	/**
	 * The greatest possible size
	 * Default: 30px
	 *
	 * @var string
	 * @since 2.0
	 */
	public $size_to;

	/**
	 * Maximum number of tags to display
	 * Default: 45
	 *
	 * @var int
	 * @since 2.0
	 */
	public $max;

	/**
	 * Which taxonomy to show tags from
	 * Default: [post_tag]
	 *
	 * @var array
	 * @since 2.0
	 */
	public $taxonomy;

	/**
	 * If the order of tags should be shown in reverse order
	 * Default: false
	 *
	 * @var bool
	 * @since 2.0
	 */
	public $reverse;

	/**
	 * Which coloring strategy to use
	 * Default: none
	 * Valid values: none, random, set, span
	 *
	 * @var string
	 * @since 2.0
	 */
	public $color;

	/**
	 * CSS letter-spacing value (in pixels)
	 * Default: normal
	 *
	 * @var string
	 * @since 2.0
	 */
	public $letter_spacing;

	/**
	 * CSS word-spacing value (in pixels)
	 * Default: normal
	 *
	 * @var string
	 * @since 2.0
	 */
	public $word_spacing;

	/**
	 * CSS text-transform value
	 * Default: none
	 * Valid values: lowercase, uppercase, capitalize
	 *
	 * @var string
	 * @since 2.0
	 */
	public $text_transform;

	/**
	 * If sorting should be applied case sensitive
	 * Default: false
	 *
	 * @var bool
	 * @since 2.0
	 */
	public $case_sensitive;

	/**
	 * How many posts a term needs to have to be shown in the cloud
	 * Default: 1
	 *
	 * @var int
	 * @since 2.0
	 */
	public $minimum;

	/**
	 * How the $tags_list should be used
	 * Default: exclude
	 * Valid values: exclude, include
	 *
	 * @var string
	 * @since 2.0
	 */
	public $tags_list_type;

	/**
	 * If the title attribute should be added to links in the cloud
	 * Default: true
	 *
	 * @var bool
	 * @since 2.0
	 */
	public $show_title;

	/**
	 * If links should be styled with underline decoration
	 * Default: default
	 * Valid values: yes, no, default
	 *
	 * @var string
	 * @since 2.0
	 */
	public $link_underline;

	/**
	 * If links should be styled as bold
	 * Default: default
	 * Valid values: yes, no, default
	 *
	 * @var string
	 * @since 2.0
	 */
	public $link_bold;

	/**
	 * If links should be styled as italic
	 * Default: default
	 * Valid values: yes, no, default
	 *
	 * @var string
	 * @since 2.0
	 */
	public $link_italic;

	/**
	 * Background color for links
	 * Default: transparent
	 * Valid values: A hexadecimal color
	 *
	 * @var string
	 * @since 2.0
	 */
	public $link_bg_color;

	/**
	 * Border style for links
	 * Default: none
	 * Valid values: none, dotted, dashed, solid, double, groove, ridge, inset, outset
	 *
	 * @var string
	 * @since 2.0
	 */
	public $link_border_style;

	/**
	 * Border width for links
	 * Default: 0
	 *
	 * @var string
	 * @since 2.0
	 */
	public $link_border_width;

	/**
	 * Border color for links
	 * Default: none
	 * Valid values: A hexadecimal color
	 *
	 * @var string
	 * @since 2.0
	 */
	public $link_border_color;

	/**
	 * If links should be decorated with underline decoration in their hover state
	 * Default: default
	 * Valid values: yes, no, default
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_underline;

	/**
	 * If links should be styled as bold in their hover state
	 * Default: default
	 * Valid values: yes, no, default
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_bold;

	/**
	 * If links should be styled as italic in their hover state
	 * Default: default
	 * Valid values: yes, no, default
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_italic;

	/**
	 * Background color for links in their hover state
	 * Default: transparent
	 * Valid values: A hexadecimal color
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_bg_color;

	/**
	 * Text color for links in their hover state
	 * Default: default
	 * Valid values: A hexadecimal color
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_color;

	/**
	 * Border style for links in their hover state
	 * Default: none
	 * Valid values: none, dotted, dashed, solid, double, groove, ridge, inset, outset
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_border_style;

	/**
	 * Border width for links in their hover state
	 * Default: 0
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_border_width;

	/**
	 * Border color for links in their hover state
	 * Default: none
	 * Valid values: A hexadecimal color
	 *
	 * @var string
	 * @since 2.0
	 */
	public $hover_border_color;

	/**
	 * CSS margin between tags
	 * Default: auto
	 *
	 * @var string
	 * @since 2.0
	 */
	public $tag_spacing;

	/**
	 * If debug output should be included
	 * Default: false
	 *
	 * @var bool
	 * @since 2.0
	 */
	public $debug;

	/**
	 * How many days old a post needs to be to be included in tag size calculation
	 * Default: 0
	 *
	 * @var int
	 * @since 2.0
	 */
	public $days_old;

	/**
	 * CSS line-height for the tags
	 * Default: inherit
	 *
	 * @var string
	 * @since 2.0
	 */
	public $line_height;

	/**
	 * Separator between tags
	 * Default:  (a space character)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $separator;

	/**
	 * Prefix before each tag
	 * Default: (empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $prefix;

	/**
	 * Suffix after each tag
	 * Default: (empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $suffix;

	/**
	 * If the widget title should be shown
	 * Default: true
	 *
	 * @var bool
	 * @since 2.0
	 */
	public $show_title_text;

	/**
	 * An array of post type names to to include posts from in tag size calculation
	 * Default: [ post ]
	 *
	 * @var array
	 * @since 2.0
	 */
	public $post_type;

	/**
	 * A list of term IDs to be included or excluded. Inclusion or exclusion is determined by $tags_list_type
	 * Default: [] (an empty array)
	 *
	 * @var array
	 * @since 2.0
	 */
	public $tags_list;

	/**
	 * Which color value to start from in color calculation. This is the color that the smallest tag will get.
	 * Default: (an empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $color_span_to;

	/**
	 * Which color value to end at in color calculation. This is the color that the biggest tag will get.
	 * Default: (an empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $color_span_from;

	/**
	 * Which authors to include posts from. An empty array will include all authors
	 * Default: [] (an empty array)
	 *
	 * @var array
	 * @since 2.0
	 */
	public $authors;

	/**
	 * A set of colors to randomly select from when coloring the tags
	 * Default: [] (an empty array)
	 *
	 * @var array
	 * @since 2.0
	 */
	public $color_set;

	/**
	 * If the current user is authenticated. Will be set internally
	 *
	 * @internal
	 * @var bool
	 * @since 2.0
	 */
	public $authenticated;

	/**
	 * Text to display before the widget. The default value for this setting will probably be determined by the theme
	 * Default: (an empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $before_widget;

	/**
	 * Text to display after the widget. The default value for this setting will probably be determined by the theme
	 * Default: (an empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $after_widget;

	/**
	 * Text to display before the widget title. The default value for this setting will probably be determined by the theme
	 * Default: (an empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $before_title;

	/**
	 * Text to display after the widget title. The default value for this setting will probably be determined by the theme
	 * Default: (an empty string)
	 *
	 * @var string
	 * @since 2.0
	 */
	public $after_title;

	/**
	 * Config store with default values
	 *
	 * @static
	 * @var array
	 * @since 2.0
	 */
	static protected $options = array(
		'title'              => 'Tag Cloud',
		'order'              => 'name',
		'size_from'          => '10px',
		'size_to'            => '30px',
		'max'                => 45,
		'taxonomy'           => array( 'post_tag' ),
		'reverse'            => false,
		'color'              => 'none',
		'letter_spacing'     => 'normal',
		'word_spacing'       => 'normal',
		'text_transform'     => 'none',
		'case_sensitive'     => false,
		'minimum'            => 1,
		'tags_list_type'     => 'exclude',
		'show_title'         => true,
		'link_underline'     => 'default',
		'link_bold'          => 'default',
		'link_italic'        => 'default',
		'link_bg_color'      => 'transparent',
		'link_border_style'  => 'none',
		'link_border_width'  => '0',
		'link_border_color'  => 'none',
		'hover_underline'    => 'default',
		'hover_bold'         => 'default',
		'hover_italic'       => 'default',
		'hover_bg_color'     => 'transparent',
		'hover_color'        => 'default',
		'hover_border_style' => 'none',
		'hover_border_width' => '0',
		'hover_border_color' => 'none',
		'tag_spacing'        => 'auto',
		'debug'              => false,
		'days_old'           => 0,
		'line_height'        => 'inherit',
		'separator'          => ' ',
		'prefix'             => '',
		'suffix'             => '',
		'show_title_text'    => true,
		'post_type'          => array( 'post' ),
		'tags_list'          => array(),
		'color_span_to'      => '',
		'color_span_from'    => '',
		'authors'            => array(),
		'color_set'          => array(),
		'before_widget'      => '',
		'after_widget'       => '',
		'before_title'       => '',
		'after_title'        => '',
	);

	/**
	 * Which ordering strategies are allowed
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_orders = array( 'random', 'name', 'slug', 'id', 'color', 'count' );

	/**
	 * Which taxonomies are allowed. Will be set dynamically at load
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_taxonomies = array();

	/**
	 * Which post types are allowed. Will be set dynamically at load
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_post_types = array();

	/**
	 * Which coloring strategies are allowed
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_colors = array( 'none', 'random', 'set', 'span' );

	/**
	 * Which CSS text-transform values are allowed
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_text_transforms = array( 'lowercase', 'uppercase', 'capitalize' );

	/**
	 * Which tags_list_type values are allowed
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_tags_list_types = array( 'exclude', 'include' );

	/**
	 * Which values are allowed for optional booleans. These are values which can be true, false or fallback to theme default (where applicable)
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_optional_booleans = array( 'yes', 'no', 'default' );

	/**
	 * Which CSS border-style valeus are allowed
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $allowed_border_styles = array(
		'none', 'dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset',
	);

	/**
	 * Loads a configuration instance array and parses the options
	 *
	 * @param array       $input   Array of key => value pairs of settings and values
	 * @param UTCW_Plugin $plugin  Reference to the main plugin instance
	 *
	 * @since 2.0
	 */
	public function __construct( array $input, UTCW_Plugin $plugin ) {
		$this->allowed_post_types = $plugin->get_allowed_post_types();
		$this->allowed_taxonomies = $plugin->get_allowed_taxonomies();
		$this->authenticated      = $plugin->is_authenticated_user();

		foreach ( self::$options as $key => $default ) {
			$this->$key = $default;

			if ( isset( $input[ $key ] ) ) {
				$valid = true;

				switch ( $key ) {
					case 'order':
						$valid = in_array( $input[ $key ], $this->allowed_orders );
						break;

					case 'text_transform':
						$valid = in_array( $input[ $key ], $this->allowed_text_transforms );
						break;

					case 'tags_list_type':
						$valid = in_array( $input[ $key ], $this->allowed_tags_list_types );
						break;

					// Optional booleans, can be yes, no or default
					case 'link_underline':
					case 'link_bold':
					case 'link_italic':
					case 'hover_underline':
					case 'hover_bold':
					case 'hover_italic':
						$valid = in_array( $input[ $key ], $this->allowed_optional_booleans );
						break;

					case 'link_border_style':
					case 'hover_border_style':
						$valid = in_array( $input[ $key ], $this->allowed_border_styles );
						break;

					case 'color':
						$valid = in_array( $input[ $key ], $this->allowed_colors );
						break;

					// TODO: Allow more flexibility in color setting, like rgb/rgba/hsl/hsla and named colors
					case 'link_bg_color':
					case 'link_border_color':
					case 'hover_bg_color':
					case 'hover_color':
					case 'hover_border_color':
					case 'color_span_to':
					case 'color_span_from':
						$valid = preg_match( UTCW_HEX_COLOR_REGEX, $input[ $key ] ) > 0;
						break;

					case 'color_set':
						if ( ! is_array( $input[ $key ] ) ) {
							$input[ $key ] = explode( ',', $input[ $key ] );
						}

						$valid = $input[ $key ] && array_filter( $input[ $key ], create_function( '$item', 'return preg_match( UTCW_HEX_COLOR_REGEX, $item );' ) ) == $input[ $key ];
						break;

					case 'taxonomy':
						if ( ! is_array( $input[ $key ] ) ) {
							$input[ $key ] = explode( ',', $input[ $key ] );
						}

						// Remove invalid taxonomies
						foreach ( $input[ $key ] as $tax_key => $taxonomy ) {
							if ( ! in_array( $taxonomy, $this->allowed_taxonomies ) ) {
								unset( $input[ $key ][ $tax_key ] );
							}
						}

						$valid = ! ! $input[ $key ]; // Setting is valid if any of the taxonomies were valid
						break;

					case 'post_type':
						if ( ! is_array( $input[ $key ] ) ) {
							$input[ $key ] = explode( ',', $input[ $key ] );
						}

						$valid = $input[ $key ] && count( array_intersect( $this->allowed_post_types, $input[ $key ] ) ) == count( $input[ $key ] );
						break;

					case 'authors':
					case 'tags_list':
						if ( ! is_array( $input[ $key ] ) ) {
							$input[ $key ] = explode( ',', $input[ $key ] );
						}

						$valid         = $this->is_array_numeric( $input[ $key ] );
						$input[ $key ] = array_map( 'intval', $input[ $key ] );
						break;

					case 'size_from':
						$input[ 'size_from' ] = $this->parse_measurement( $input[ 'size_from' ] );
						$size_to              = isset( $input[ 'size_to' ] ) ? $input[ 'size_to' ] : self::$options[ 'size_to' ];
						$valid                = $input[ 'size_from' ] !== false && $this->equal_units( $input[ 'size_from' ], $size_to ) && floatval( $input[ 'size_from' ] ) <= floatval( $size_to );
						break;

					case 'size_to':
						$input[ 'size_to' ] = $this->parse_measurement( $input[ 'size_to' ] );
						$size_from          = isset( $input[ 'size_from' ] ) ? $input[ 'size_from' ] : self::$options[ 'size_from' ];
						$valid              = $input[ 'size_to' ] !== false && $this->equal_units( $size_from, $input[ 'size_to' ] ) && floatval( $input[ 'size_to' ] ) >= floatval( $size_from );
						break;

					case 'letter_spacing':
					case 'word_spacing':
					case 'tag_spacing':
					case 'line_height':
					case 'link_border_width':
					case 'hover_border_width':
						$input[ $key ] = $this->parse_measurement( $input[ $key ] );
						$valid         = $input[ $key ] !== false;
						break;
				}

				if ( ! $valid ) {
					continue;
				}

				// Special handling of the color_set config attribute which needs to be expanded to full 6 digit hexadecimal values
				if ( $key == 'color_set' ) {
					foreach ( $input[ $key ] as $cs_key => $color ) {
						if ( strlen( $color ) == 4 ) {
							$red                      = substr( $color, 1, 1 );
							$green                    = substr( $color, 2, 1 );
							$blue                     = substr( $color, 3, 1 );
							$input[ $key ][ $cs_key ] = sprintf( '#%s%s%s%s%s%s', $red, $red, $green, $green, $blue, $blue );
						}
					}
					$this->$key = $input[ $key ];
				} else if ( $key == 'minimum' ) {
					$this->$key = intval( $input[ $key ] );
				} else if ( is_string( self::$options[ $key ] ) && is_string( $input[ $key ] ) && strlen( $input[ $key ] ) > 0 ) {
					$this->$key = $input[ $key ];
				} else if ( is_integer( self::$options[ $key ] ) && $input[ $key ] > 0 ) {
					$this->$key = intval( $input[ $key ] );
				} else if ( is_bool( self::$options[ $key ] ) ) {
					$this->$key = ! ! $input[ $key ];
				} else if ( is_array( self::$options[ $key ] ) ) {
					$this->$key = is_array( $input[ $key ] ) ? $input[ $key ] : explode( ',', $input[ $key ] );
				}
			}
		}
	}

	/**
	 * Checks if every item in the array is numeric
	 *
	 * @param array $array
	 *
	 * @return bool
	 * @since 2.0
	 */
	private function is_array_numeric( array $array ) {
		foreach ( $array as $item ) {
			if ( ! is_numeric( $item ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Parses the input value as measurement
	 *
	 * @param mixed $input
	 *
	 * @return bool|string   False on failure
	 * @since 2.1
	 */
	private function parse_measurement( $input ) {
		if ( ! preg_match( '/^' . UTCW_DECIMAL_REGEX . '(em|px|%)?$/i', $input ) ) {
			return false;
		}

		// Convert integer values to pixel values
		if ( preg_match( '/^' . UTCW_DECIMAL_REGEX . '$/', $input ) ) {
			return $input . 'px';
		}

		return $input;
	}

	/**
	 * Checks if the two measurements have the same unit
	 *
	 * @param string $measurement1
	 * @param string $measurement2
	 *
	 * @return bool
	 * @since 2.1
	 */
	private function equal_units( $measurement1, $measurement2 ) {
		$unit1 = preg_replace( '/' . UTCW_DECIMAL_REGEX . '/', '', $measurement1 );
		$unit2 = preg_replace( '/' . UTCW_DECIMAL_REGEX . '/', '', $measurement2 );

		return $unit1 === $unit2 || ( $unit1 === 'px' && $unit2 === '' ) || ( $unit1 === '' && $unit2 === 'px' );
	}

	/**
	 * Returns an array of current configuration
	 *
	 * @return array
	 * @since  2.0
	 */
	public function get_instance() {
		$instance = array();

		foreach ( array_keys( self::$options ) as $key ) {
			$instance[ $key ] = $this->$key;
		}

		return $instance;
	}

	/**
	 * Returns the default values for all the configuration options
	 *
	 * @static
	 * @return array
	 * @since 2.0
	 */
	public static function get_defaults() {
		return self::$options;
	}
}