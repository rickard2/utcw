<?php
/*
Plugin Name: Ultimate Tag Cloud Widget
Plugin URI: https://www.0x539.se/wordpress/ultimate-tag-cloud-widget/
Description: This plugin aims to be the most configurable tag cloud widget out there.
Version: 2.7.2
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
define('UTCW_VERSION', '2.7.2');

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


function utcw_load()
{
    $prefix = UTCW_DEV ? '/www/utcw2/src/' : 'src/';
    $files  = array(
        'Plugin.php',
        'ShortCode.php',
        'Widget.php',
        'Data.php',
        'Render.php',
        'Term.php',
        'Handler/Handler.php',
        'Handler/HandlerFactory.php',
        'Language/TranslationHandler.php',
        'Language/QTranslateHandler.php',
        'Language/WPMLHandler.php',
        'Selection/SelectionStrategy.php',
        'Selection/PopularityStrategy.php',
        'Selection/RandomStrategy.php',
        'Selection/CreationTimeStrategy.php',
        'Selection/CurrentListStrategy.php',
        'Database/QueryBuilder.php',
        'Config/Config.php',
        'Config/DataConfig.php',
        'Config/RenderConfig.php',
        'Config/Type/Type.php',
        'Config/Type/SetType.php',
        'Config/Type/ClassType.php',
        'Config/Type/ColorType.php',
        'Config/Type/ArrayType.php',
        'Config/Type/IntegerType.php',
        'Config/Type/MeasurementType.php',
        'Config/Type/StringType.php',
        'Config/Type/BooleanType.php',
        'Cache/WPSuperCacheHandler.php',
        'Cache/W3TotalCacheHandler.php',
        'Style/StyleProvider.php',
        'Style/HoverStyleProvider.php',
        'Style/MainStyleProvider.php',
        'Style/LinkStyleProvider.php',
    );

    foreach ($files as $file) {
        require_once $prefix . $file;
    }
}

utcw_load();

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
    $plugin    = UTCW_Plugin::getInstance();
    $shortCode = new UTCW_ShortCode($plugin);

    echo $shortCode->render($args);
}
