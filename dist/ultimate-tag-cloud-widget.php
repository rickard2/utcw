<?php
//use Rickard\UTCW\Plugin;

/*
Plugin Name: Ultimate tag cloud widget
Plugin URI: https://www.0x539.se/wordpress/ultimate-tag-cloud-widget/
Description: This plugin aims to be the most configurable tag cloud widget out there.
Version: 2.3
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
define('UTCW_VERSION', '2.3');

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

$__prefix = UTCW_DEV ? '/www/utcw2/' : '';

require_once $__prefix . 'src/Plugin.php';
require_once $__prefix . 'src/Widget.php';
require_once $__prefix . 'src/Data.php';
require_once $__prefix . 'src/Render.php';
require_once $__prefix . 'src/Term.php';
require_once $__prefix . 'src/Language/TranslationHandler.php';
require_once $__prefix . 'src/Language/QTranslateHandler.php';
require_once $__prefix . 'src/Language/WPMLHandler.php';
require_once $__prefix . 'src/Selection/SelectionStrategy.php';
require_once $__prefix . 'src/Selection/PopularityStrategy.php';
require_once $__prefix . 'src/Selection/RandomStrategy.php';
require_once $__prefix . 'src/Database/QueryBuilder.php';
require_once $__prefix . 'src/Config/Config.php';
require_once $__prefix . 'src/Config/DataConfig.php';
require_once $__prefix . 'src/Config/RenderConfig.php';
require_once $__prefix . 'src/Config/Type/Type.php';
require_once $__prefix . 'src/Config/Type/SetType.php';
require_once $__prefix . 'src/Config/Type/ColorType.php';
require_once $__prefix . 'src/Config/Type/ArrayType.php';
require_once $__prefix . 'src/Config/Type/IntegerType.php';
require_once $__prefix . 'src/Config/Type/MeasurementType.php';
require_once $__prefix . 'src/Config/Type/StringType.php';
require_once $__prefix . 'src/Config/Type/BooleanType.php';

unset($__prefix);

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
