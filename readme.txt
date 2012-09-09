=== Ultimate Tag Cloud Widget ===
Contributors: exz
Tags: widget, tags, configurable, tag cloud
Requires at least: ?
Tested up to: ?
Stable tag: ?
Donate link: https://flattr.com/thing/112193/Ultimate-Tag-Cloud-Widget

This plugin aims to be the most configurable tag cloud widget out there, able to suit all your weird tag cloud needs.

== Description ==

TODO: Write new description

== Installation ==

This is the same procedure as with all ordinary plugins.

1. Download the zip file, unzip it 
2. Upload it to your /wp-content/plugins/ folder 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Use the widgets settings page under 'Appearance' to add it to your page

All the configuration options is set individually in every instance. Some default values are set if you're unsure on how to configure it. 

If your theme doesn't use widgets, you can still use it in your theme by calling the function do_utcw(). See "Other Notes" for more information.

== Frequently Asked Questions ==

TODO: Write up proper FAQ

== Screenshots ==

TODO: Add new screenshots

== Changelog ==

= 2.0 =
* TODO: Write changelog

= 1.3.16 =
* Bug fix; fixes problem with saving "Random from preset values" setting

= 1.3.15 =
* Bux fix; removed jquery 1.7.x dependent functions

= 1.3.14 =
* Bug fix; tag cloud showed up empty after update from 1.3.12

= 1.3.13 =
* Added setting to hide the title of the widget
* Custom post type support, replaces page tagging feature
* Internal optimizations and improved code quality

= 1.3.12 =
* Fixed bug which made the default "data" tab disappear when adding the widget to a sidebar
* Added setting for link hover font color
* Added option to save or load configuration

= 1.3.11 =
* Proper namespacing of the CSS classes to prevent interference with other plugins

= 1.3.10 = 

* Fixed shortcode problem where the content would appear at the top of a post/page instead of where the shortcode was placed.
* Fixed shortcode problem where you couldn't possibly enter some values as array types, now accepting a comma separated list for $tags_list, $color_set and $authors
* Updated spelling error in the documentation which caused some confusion

= 1.3.9 = 

* Added shortcode [utcw]

= 1.3.8 = 

* Improved the tabbed settings when using multiple tag clouds
* Improved the tabbed settings so that the same tab is reloaded after saving the settings
* Updated screenshot 
* Bugfix; The help texts now also shows after saving the settings
* Added a setting for separator, prefix and suffix

= 1.3.7 =

* Added more detailed descriptions of all the settings
* Added the tabs for the sections in the widget settings
* Switched from deprecated function get_users_of_blog() to get_users() for WP 3.1+

= 1.3.6 = 

* Added a setting for row spacing
* Added a setting for post age 

= 1.3.5 = 

* Now also showing private posts when signed in. 

= 1.3.4 = 

* Added support for [page tagging](http://wordpress.org/extend/plugins/page-tagger/) (thanks again Andreas Bogavcic)
* Added a setting for including debug information to help troubleshooting 

= 1.3.3 = 

* Added new styling options upon requests from the forum
* Testing out the new HTML5 input type "number" in the settings form

= 1.3.2 = 

* Fixed bug in the SQL query making the plugin also count posts that isn't published
* Added a new option to set the minimum amount of posts a tag should have to be included

= 1.3.1 = 

* Added Swedish translation
* Minor internationalization changes

= 1.3 = 

* As requested, support for calling a function to display the widget was added. Se other notes for information on how to use it.  
* Javascript changes in order to fix problems with the options page in WP 3.1 beta 1

= 1.2 = 

* Removed all the PHP short tags
* Can now sort by name, slug, id or color (!) case sensitive or case insensitive
* Exclude now takes either tag name or id 

= 1.1 = 

* Fixed bug with options page 
* Improved link generation to create correct tag links  

= 1.0 =

* Initial release 

== Upgrade Notice ==

= 2.0 =

* New plugin architecture and a big rewrite of the plugin foundation. Watch out for breaking changes, please see [TODO: add link] for more information.

= 1.3.16 =

* Bug fix; fixes problem with saving "Random from preset values" setting

= 1.3.15 =

* Bug fix; fixes problems with javascript errors on widgets page

= 1.3.14 =

* Bug fix; fixes problem with empty cloud after upgrade

= 1.3.13 =

* New features and internal optimizations and improvements

= 1.3.12 =

* Minor bug fix and added support for saving/loading configurations.

= 1.3.11 =

* Minor CSS fix

= 1.3.10 = 

* Some shortcode bugfixes

= 1.3.9 =

* Added shortcode

= 1.3.8 = 

* Minor bug fixes from previous version
* Added separator, prefix and suffix settings

= 1.3.7 = 

* Removed deprecated function get_users_of_blog() for WP 3.1+

= 1.3.6 = 

* Added two new features; post age and row spacing

= 1.3.5 = 

* Now also showing private posts when signed in. 

= 1.3.4 = 

Support for page tagging and an option for debug information

= 1.3.3 =

* New styling options added

= 1.3.2 =

* Small bug fix in the SQL-query and a new option added

= 1.3.1 =

* Added Swedish translateion

= 1.3 = 

* Support for integrating the widget within your theme added. 
* New javascript fixing problem with options page in WP 3.1 beta 1 

= 1.1 and 1.2 =

* Just bug fixes, should be safe to upgrade. 

= 1.0 =

* Initial release

== Feedback ==

This plugin is under active development and my goal is to try to help everyone who have issues or suggestions for this plugin. If you have issues please post them in the forums, if you have suggestions I've got a new suggestion system up on my blog at http://0x539.se/wordpress/ultimate-tag-cloud-widget/. If you use this plugin and like it, please consider giving me some [flattr love](https://flattr.com/thing/112193/Ultimate-Tag-Cloud-Widget).

My contact information is

* rickard (a) 0x539.se (email, gtalk, msn, you name it)
* [twitter.com/rickard2](http://twitter.com/rickard2)

== Theme integration / Shortcode == 

TODO: Rewrite theme integration page

== Breaking changes in version 2.0 ==

* Tags lists with named tags will not work in version 2.0, only tags lists with IDs.
* The configuration option for text case has been renamed from case to text_transform
* The styles for links aren't marked as !important in the CSS longer, this might change the cloud presentation in some cases
* The shortcode and theme integration function call no longer accepts the widget arguments before_widget, after_widget, before_title and after_title

== Thanks == 

The power of the open source community is being able to help out and submitting patches when bugs are found. I would like to thank the following contributors for submitting patches and helping out with the development: 

* Andreas Bogavcic
* Fabian Reck

With your help this list will hopefully grow in the future ;)
