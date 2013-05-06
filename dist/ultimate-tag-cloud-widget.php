<?php
//use Rickard\UTCW\Plugin;

/*
Plugin Name: Ultimate tag cloud widget
Plugin URI: https://www.0x539.se/wordpress/ultimate-tag-cloud-widget/
Description: This plugin aims to be the most configurable tag cloud widget out there.
Version: 2.2.3
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
define('UTCW_VERSION', '2.2.3');

/**
 * If development mode is currently enabled
 *
 * @var bool
 * @since 2.0
 */
define('UTCW_DEV', false);

/**
 * Regular expression for matching hexadecimal colors
 *
 * @var string
 * @since 2.0
 */
define('UTCW_HEX_COLOR_REGEX', '/#([a-f0-9]{6}|[a-f0-9]{3})/i');

/**
 * Regular expression for matching decimal numbers
 *
 * @var string
 * @since 2.1
 */
define('UTCW_DECIMAL_REGEX', '\d+(\.\d+)?');

/**
 * printf format for rendering hexadecimal colors
 *
 * @var string
 * @since 2.0
 */
define('UTCW_HEX_COLOR_FORMAT', '#%02x%02x%02x');

if (UTCW_DEV) {
    require_once '/www/utcw2/src/Plugin.php';
    require_once '/www/utcw2/src/Config.php';
    require_once '/www/utcw2/src/Widget.php';
    require_once '/www/utcw2/src/Data.php';
    require_once '/www/utcw2/src/Render.php';
    require_once '/www/utcw2/src/Term.php';
    require_once '/www/utcw2/src/Language/TranslationHandler.php';
    require_once '/www/utcw2/src/Language/QTranslateHandler.php';
    require_once '/www/utcw2/src/Language/WPMLHandler.php';
    require_once '/www/utcw2/src/Selection/SelectionStrategy.php';
    require_once '/www/utcw2/src/Selection/PopularityStrategy.php';
    require_once '/www/utcw2/src/Selection/RandomStrategy.php';
    require_once '/www/utcw2/src/Database/QueryBuilder.php';
} else {
    require_once 'src/Plugin.php';
    require_once 'src/Config.php';
    require_once 'src/Widget.php';
    require_once 'src/Data.php';
    require_once 'src/Render.php';
    require_once 'src/Term.php';
    require_once 'src/Language/TranslationHandler.php';
    require_once 'src/Language/QTranslateHandler.php';
    require_once 'src/Language/WPMLHandler.php';
    require_once 'src/Selection/SelectionStrategy.php';
    require_once 'src/Selection/PopularityStrategy.php';
    require_once 'src/Selection/RandomStrategy.php';
    require_once 'src/Database/QueryBuilder.php';
}

// Instantiates the plugin
UTCW_Plugin::getInstance();

/**
 * Function for theme integration
 *
 * @param array $args
 *
 * @since 1.3
 */
function do_utcw(array $args)
{
    $plugin = UTCW_Plugin::getInstance();
    echo $plugin->shortcode($args);
}
