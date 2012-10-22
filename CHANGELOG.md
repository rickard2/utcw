# Version history for the 1.x branch #

For changelog for the 2.x branch, please see readme.txt

## 1.3.16 ##
* Bug fix; fixes problem with saving "Random from preset values" setting

## 1.3.15 ##
* Bux fix; removed jquery 1.7.x dependent functions

## 1.3.14 ##
* Bug fix; tag cloud showed up empty after update from 1.3.12

## 1.3.13 ##
* Added setting to hide the title of the widget
* Custom post type support, replaces page tagging feature
* Internal optimizations and improved code quality

## 1.3.12 ##
* Fixed bug which made the default "data" tab disappear when adding the widget to a sidebar
* Added setting for link hover font color
* Added option to save or load configuration

## 1.3.11 ##
* Proper namespacing of the CSS classes to prevent interference with other plugins

## 1.3.10 ##

* Fixed shortcode problem where the content would appear at the top of a post/page instead of where the shortcode was placed.
* Fixed shortcode problem where you couldn't possibly enter some values as array types, now accepting a comma separated list for $tags_list, $color_set and $authors
* Updated spelling error in the documentation which caused some confusion

## 1.3.9 ##

* Added shortcode [utcw]

## 1.3.8 ##

* Improved the tabbed settings when using multiple tag clouds
* Improved the tabbed settings so that the same tab is reloaded after saving the settings
* Updated screenshot
* Bugfix; The help texts now also shows after saving the settings
* Added a setting for separator, prefix and suffix

## 1.3.7 ##

* Added more detailed descriptions of all the settings
* Added the tabs for the sections in the widget settings
* Switched from deprecated function get_users_of_blog() to get_users() for WP 3.1+

## 1.3.6 ##

* Added a setting for row spacing
* Added a setting for post age

## 1.3.5 ##

* Now also showing private posts when signed in.

## 1.3.4 ##

* Added support for [page tagging](http://wordpress.org/extend/plugins/page-tagger/) (thanks again Andreas Bogavcic)
* Added a setting for including debug information to help troubleshooting

## 1.3.3 ##

* Added new styling options upon requests from the forum
* Testing out the new HTML5 input type "number" in the settings form

## 1.3.2 ##

* Fixed bug in the SQL query making the plugin also count posts that isn't published
* Added a new option to set the minimum amount of posts a tag should have to be included

## 1.3.1 ##

* Added Swedish translation
* Minor internationalization changes

## 1.3 ##

* As requested, support for calling a function to display the widget was added. Se other notes for information on how to use it.
* Javascript changes in order to fix problems with the options page in WP 3.1 beta 1

## 1.2 ##

* Removed all the PHP short tags
* Can now sort by name, slug, id or color (!) case sensitive or case insensitive
* Exclude now takes either tag name or id

## 1.1 ##

* Fixed bug with options page
* Improved link generation to create correct tag links

## 1.0 ##

* Initial release