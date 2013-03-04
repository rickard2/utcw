<?php
use Rickard\UTCW\Plugin;

/*
Plugin Name: Ultimate tag cloud widget
Plugin URI: https://www.0x539.se/wordpress/ultimate-tag-cloud-widget/
Description: This plugin aims to be the most configurable tag cloud widget out there, able to suit all your weird tag cloud needs.
Version: 2.1 beta1
Author: Rickard Andersson
Author URI: https://www.0x539.se
License: GPLv2
*/

/**
 * Current version number
 *
 * @var string
 * @since 2.0
 */
define( 'UTCW_VERSION', '2.1' );

/**
 * If development mode is currently enabled
 *
 * @var bool
 * @since 2.0
 */
define( 'UTCW_DEV', false );

/**
 * Regular expression for matching hexadecimal colors
 *
 * @var string
 * @since 2.0
 */
define( 'UTCW_HEX_COLOR_REGEX', '/#([a-f0-9]{6}|[a-f0-9]{3})/i' );

/**
 * Regular expression for matching decimal numbers
 *
 * @var string
 * @since 2.1
 */
define( 'UTCW_DECIMAL_REGEX', '\d+(\.\d+)?' );

/**
 * printf format for rendering hexadecimal colors
 *
 * @var string
 * @since 2.0
 */
define( 'UTCW_HEX_COLOR_FORMAT', '#%02x%02x%02x' );

require_once 'src/Plugin.php';
require_once 'src/Config.php';
require_once 'src/Widget.php';
require_once 'src/Data.php';
require_once 'src/Render.php';
require_once 'src/Term.php';

// Instantiates the plugin
Plugin::getInstance();

/**
 * Function for theme integration
 *
 * @param array $args
 *
 * @since 1.3
 */
function do_utcw( array $args ) {
    $plugin = Plugin::getInstance();
    echo $plugin->shortcode( $args );
}
