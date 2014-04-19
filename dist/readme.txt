=== Ultimate Tag Cloud Widget ===
Contributors: exz
Tags: widget, tags, configurable, tag cloud
Requires at least: 3.0
Tested up to: 3.9
Stable tag: 2.7.2
Donate link: https://0x539.se/donations/
License: GPLv2 or later

This plugin aims to be the most configurable tag cloud widget out there, able to suit all your weird tag cloud needs.

== Description ==

This is the highly configurable tag cloud widget, the main features for this plugin is:

- All, single author or multiple authors per cloud
- Select which taxonomies or post types to show tags for
- Rules for which posts to include when fetching tags
- Inclusion/exclusion functions
- A bunch of ordering, coloring and styling options
- Multiple strategies for selecting terms with the option to [create your own](https://github.com/rickard2/utcw/blob/master/STRATEGY.md). Built in strategies for most popular, random, recently added, from current list of posts
- Short code and API for developers

The development of this plugin has stopped. I will make sure that the basic features still work with upcoming WordPress versions, but no new features or changes will be made.

The [code is available on github](https://github.com/rickard2/utcw) and if you're in need of new features, you're welcome to submit a pull request for it.

Quick links:

- Short code information: http://wordpress.org/plugins/ultimate-tag-cloud-widget/other_notes/#Theme-integration-/-Shortcode
- Short code configuration options: https://github.com/rickard2/utcw/blob/master/CONFIG.md
- Playground which shows some configuration options: https://0x539.se/wordpress/tag-cloud-playground/
- Custom selection strategy documentation: https://github.com/rickard2/utcw/blob/master/STRATEGY.md

== Installation ==

This is the same procedure as with all ordinary plugins.

1. Download the zip file, unzip it 
2. Upload it to your /wp-content/plugins/ folder 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Use the widgets settings page under 'Appearance' to add it to your page

All the configuration options is set individually in every instance. Some default values are set if you're unsure on how to configure it. 

If your theme doesn't use widgets, you can still use it in your theme by calling the function `do_utcw()` or by using the shortcode `[do_utcw]`. See [Other Notes](http://wordpress.org/extend/plugins/ultimate-tag-cloud-widget/other_notes/#Theme-integration-/-Shortcode) for more information.

== Frequently Asked Questions ==

If you have questions, please post them in the forums.

== Screenshots ==

1. This shows my widget with the default settings on the default wordpress theme.
2. This is a more colorful example with random colors and all tags in uppercase. I'd like to actually see someone use it like this.
3. Maybe a more realistic usage of the widget with spanning colors and capitalized tags.
4. The settings page of the widget

== Changelog ==

= 2.7.2 =

* [#69](https://github.com/rickard2/utcw/issues/69): Fix issues selection strategies

= 2.7.1 =

* [#66](https://github.com/rickard2/utcw/issues/66): Fix issues with theme customizer in 3.9

= 2.7 =

* [#60](https://github.com/rickard2/utcw/issues/60): Add css classes to target individual terms
* [#61](https://github.com/rickard2/utcw/issues/61): Adds missing translation
* [#62](https://github.com/rickard2/utcw/issues/62): Fix formatting issue in settings page
* [#63](https://github.com/rickard2/utcw/issues/63): Support shortcodes in prefix and suffix
* [#65](https://github.com/rickard2/utcw/issues/65): Fix issue with WPML displaying no (or too few) terms

= 2.6.1 =

* [BUGFIX](http://wordpress.org/support/topic/bug-53): Fixed issue with widget markup when using avoid theme styling option

= 2.6 =

* [#46](https://github.com/rickard2/utcw/issues/46): Bring back styling behavior of <= v2.2 with a [configuration option](https://github.com/rickard2/utcw/blob/master/CONFIG.md#avoid-theme-styling)
* [#48](https://github.com/rickard2/utcw/issues/48): Support for custom selection strategies to enable clouds with custom data sources. [Detailed documentation for defining your own strategy](https://github.com/rickard2/utcw/blob/master/STRATEGY.md).
* [#50](https://github.com/rickard2/utcw/issues/50): Added translation files
* [#51](https://github.com/rickard2/utcw/issues/51): Try to prevent line breaks in terms with multiple words
* [#54](https://github.com/rickard2/utcw/issues/54): Support for attachment as custom post type

= 2.5 =

* [#14](https://github.com/rickard2/utcw/issues/14): Updated UI for selecting authors
* [#22](https://github.com/rickard2/utcw/issues/22): Option to fetch terms based on the current list of posts and term creation time
* [#35](https://github.com/rickard2/utcw/issues/35): Updated UI for selecting post terms
* [#41](https://github.com/rickard2/utcw/issues/41): New option to add filtering to tag cloud links
* [#42](https://github.com/rickard2/utcw/issues/42): Added scope attribute to style tag

= 2.4 =

* Fixed issue with WPML and custom taxonomies
* [#32](https://github.com/rickard2/utcw/issues/32): Added filters to enable developers to hook into the plugin
* [#33](https://github.com/rickard2/utcw/issues/33): Updated JS code to support newer versions of jQuery
* [#36](https://github.com/rickard2/utcw/issues/36): [#38](https://github.com/rickard2/utcw/issues/38): Added options for changing the value of the title attribute
* [#37](https://github.com/rickard2/utcw/issues/37): Fixed UI issue with the show title option always being checked
* [#39](https://github.com/rickard2/utcw/issues/39): Added option to add post count to the term name

= 2.3.1 =
* Security fix for sensitive data exposed when using the debug option

= 2.3 =

* [#27](https://github.com/rickard2/utcw/issues/27): Added filtering feature to generate a cloud of posts which have a common term/terms
* [#28](https://github.com/rickard2/utcw/issues/28): Added more styling options (center, right align, justify, display as list)
* [#29](https://github.com/rickard2/utcw/issues/29): Changed CSS classes to match the WordPress tag cloud
* [#25](https://github.com/rickard2/utcw/issues/25): [#26](https://github.com/rickard2/utcw/issues/26), [#31](https://github.com/rickard2/utcw/issues/31): Internal / code quality

= 2.2.3 =

* Fixed naming collision issue with other plugins

= 2.2.2 =

* Fixed widget initialization issue

= 2.2.1 =

* Fixed issue with older PHP versions which doesn't support namespaces

= 2.2 =

* [#19](https://github.com/rickard2/utcw/issues/19): Support for disabling links in tag cloud output
* [#20](https://github.com/rickard2/utcw/issues/20): Support for loading a saved configuration from short code
* [#23](https://github.com/rickard2/utcw/issues/23): Multi language support with qTranslate and WPML
* [#24](https://github.com/rickard2/utcw/issues/24): Support for selecting a random set of tags

= 2.1 =

* [#4](https://github.com/rickard2/utcw/issues/4): Support for multiple taxonomies per widget
* [#5](https://github.com/rickard2/utcw/issues/5): Improved UI for selecting authors
* [#9](https://github.com/rickard2/utcw/issues/9): Support for setting minimum post count to zero
* [#10](https://github.com/rickard2/utcw/issues/10): Support for removing configurations
* [#12](https://github.com/rickard2/utcw/issues/12): Support for other measurements than pixels
* [#15](https://github.com/rickard2/utcw/issues/15): Fixed problem with authors setting not working correctly

= 2.0.1 =

* Small bug fix in the widget options panel

= 2.0 =

* New plugin structure
* Minor changes to the administration interface

The changelog history for the 1.x branch is available on [GitHub](https://github.com/rickard2/utcw/blob/master/CHANGELOG.md)

The upgrade notice history for the 1.x branch is available on [GitHub](https://github.com/rickard2/utcw/blob/master/UPGRADE.md)

== Upgrade Notice ==

= 2.7.2 =

* Fix issues selection strategies

= 2.7.1 =

* Fix issues with theme customizer in 3.9

= 2.7 =

* New features and bugs fixed, see plugin page at wordpress.org for full details.

= 2.6.1 =

* Markup issues fixed

= 2.6 =

* New features, see plugin page at wordpress.org for full details.

= 2.5 =

* New features, see plugin page at wordpress.org for full details.

= 2.4 =

* Issues with WPML and custom taxonomies resolved. New features, see plugin page at wordpress.org for full details.

= 2.3.1 =

* Security fix for sensitive data exposed when using the debug option

= 2.3 =

* New features, see plugin page at wordpress.org for full details. Watch out for the changes in class names: https://github.com/rickard2/utcw/issues/29

= 2.2.3 =

* Fixed naming collision issue with other plugins

= 2.2.2 =

* Fixed widget initialization issue

= 2.2.1 =

* Fixes compatibility issue with PHP 5.2

= 2.2 =

* New features, see the plugin page at wordpress.org for full details

= 2.1 =

* New features, see the plugin page at wordpress.org for full details

= 2.0.1 =

* Small bug fix in the widget options panel

= 2.0 =

* New plugin architecture and a big rewrite of the plugin foundation. Watch out for breaking changes, please see http://exz.nu/utcwbreaking for more information.

== Feedback ==

This plugin is under active development and my goal is to try to help everyone who have issues or suggestions for this plugin. If you find bugs or have feature requests please use [GitHub issues](https://github.com/rickard2/utcw/issues), if you need support please use the [WordPress forums](http://wordpress.org/support/plugin/ultimate-tag-cloud-widget).

My contact information is

* rickard (a) 0x539.se (email, hangouts, you name it)
* [twitter.com/rickard2](http://twitter.com/rickard2)

If you use this plugin and like it, please consider [leaving a donation](https://0x539.se/donations/).

== Theme integration / Shortcode == 

You can integrate the widget within your own theme even if you're not using standard WordPress widgets. Just install and load the plugin as described and use the function

`<?php do_utcw($args); ?>`

...with `$args` being a array of `key => value` pairs for the options you would like to set. For example if you'd like to change the title of the widget:

`<?php
$args = array( "title" => "Most awesome title ever" );

do_utcw( $args );`

To use multiple configuration options just separate them with a comma:

`<?php
$args = array( "title" => "Most awesome title ever", "max" => 10 );

do_utcw( $args );`

If you're not able to change your theme you can also use the shortcode `[utcw]` anywhere in your posts or pages. You can pass any of the settings along with the shortcode in the format of `key="value"`, for instance if you'd like to change the widget title:

`[utcw title="Most awesome title ever"]`

The plugin also uses a couple of filters for you to be able to alter the output. These are documented in the [filters documentation at GitHub](https://github.com/rickard2/utcw/blob/master/FILTERS.md).

As of version 2.6 you can create custom selection strategies, more information can be found in the [strategy documentation at GitHub](https://github.com/rickard2/utcw/blob/master/STRATEGY.md)

== Configuration ==

All the configuration options can be found in the [configuration documentation at GitHub](https://github.com/rickard2/utcw/blob/master/CONFIG.md).

== Breaking changes in version 2.0 ==

* Tags lists with named tags will not work in version 2.0, only tags lists with IDs.
* The configuration option for text case has been renamed from case to text_transform
* The styles for links aren't marked as `!important` in the CSS longer, this might change the cloud presentation in some cases
* The shortcode and theme integration function call no longer accepts the widget arguments `before_widget`, `after_widget`, `before_title` and `after_title`

== Thanks == 

The power of the open source community is being able to help out and submitting patches when bugs are found. I would like to thank the following contributors for submitting patches and helping out with the development: 

* Andreas Bogavcic
* Fabian Reck

With your help this list will hopefully grow in the future ;)
