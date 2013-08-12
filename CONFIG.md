# Configuration options #

All the configuration options can be used both in `do_utcw()` and the shortcode.

## Strategy ##
Description: Which strategy to use when fetching terms  
Type: Set  
Name: `strategy`  
Default: `popularity`  
Valid values: `popularity`, `random`  

## Order ##
Description: How the result should be ordered  
Type: Set  
Name: `order`  
Default: `name`  
Valid values: `name`, `random`, `slug`, `id`, `color`, `count`  

## Tags list type ##
Description: How the [tags list](#tags-list) should be used  
Type: Set  
Name: `tags_list_type`  
Default: `exclude`  
Valid values: `exclude`, `include`  

## Color ##
Description: Which coloring strategy to use  
Type: Set  
Name: `color`  
Default: `none`  
Valid values: `none`, `random`, `set`, `span`  

## Color span to ##
Description: Which color value to start from in color calculation. This is the color that the smallest tag will get.  
Type: Color  
Name: `color_span_to`  
Default: None  

## Color span from ##
Description: Which color value to end at in color calculation. This is the color that the biggest tag will get.  
Type: Color  
Name: `color_span_from`  
Default: None  

## Color set ##
Description: A set of colors to randomly select from when coloring the tags  
Type: Array  
Name: `color_set`  
Default: None  

## Taxonomy ##
Description: Which taxonomy to show tags from  
Type: Array  
Name: `taxonomy`  
Default: `[post_tag]`  

## Post type ##
Description: An array of post type names to to include posts from in tag size calculation  
Type: Array  
Name: `post_type`  
Default: `[post]`  

## Authors ##
Description: Which authors to include posts from. An empty array will include all authors  
Type: Array  
Name: `authors`  
Default: None  

## Tags list ##
Description: A list of term IDs to be included or excluded. Inclusion or exclusion is determined by [tags list type](#tags-list-type)  
Type: Array  
Name: `tags_list`  
Default: None  

## Post term ##
Description: A list of term IDs which the posts needs to have to be included in tag size calculation  
Type: Array  
Name: `post_term`  
Default: None  

## Size from ##
Description: The smallest possible size  
Type: Measurement  
Name: `size_from`  
Default: `10px`  

## Size to ##
Description: The greatest possible size  
Type: Measurement  
Name: `size_to`  
Default: `30px`  

## Max ##
Description: Maximum number of tags to display  
Type: Integer  
Name: `max`  
Default: `45`  

## Minimum ##
Description: How many posts a term needs to have to be shown in the cloud  
Type: Integer  
Name: `minimum`  
Default: `1`  

## Days old ##
Description: How many days old a post needs to be to be included in tag size calculation  
Type: Integer  
Name: `days_old`  
Default: `0`  

## Reverse ##
Description: If the order of tags should be shown in reverse order  
Type: Boolean  
Name: `reverse`  
Default: `false`  

## Case sensitive ##
Description: If sorting should be applied case sensitive  
Type: Boolean  
Name: `case_sensitive`  
Default: `false`  

## Text transform ##
Description: CSS text-transform value  
Type: Set  
Name: `text_transform`  
Default: `none`  
Valid values: `lowercase`, `uppercase`, `capitalize`  

## Link underline ##
Description: If links should be styled with underline decoration  
Type: Set  
Name: `link_underline`  
Default: `default`  
Valid values: `default`, `yes`, `no`  

## Link bold ##
Description: If links should be styled as bold  
Type: Set  
Name: `link_bold`  
Default: `default`  
Valid values: `default`, `yes`, `no`  

## Link italic ##
Description: If links should be styled as italic  
Type: Set  
Name: `link_italic`  
Default: `default`  
Valid values: `default`, `yes`, `no`  

## Hover underline ##
Description: If links should be decorated with underline decoration in their hover state  
Type: Set  
Name: `hover_underline`  
Default: `default`  
Valid values: `default`, `yes`, `no`  

## Hover bold ##
Description: If links should be styled as bold in their hover state  
Type: Set  
Name: `hover_bold`  
Default: `default`  
Valid values: `default`, `yes`, `no`  

## Hover italic ##
Description: If links should be styled as italic in their hover state  
Type: Set  
Name: `hover_italic`  
Default: `default`  
Valid values: `default`, `yes`, `no`  

## Link border style ##
Description: Border style for links  
Type: Set  
Name: `link_border_style`  
Default: `none`  
Valid values: `none`, `dotted`, `dashed`, `solid`, `double`, `groove`, `ridge`, `inset`, `outset`  

## Hover border style ##
Description: Border style for links in their hover state  
Type: Set  
Name: `hover_border_style`  
Default: `none`  
Valid values: `none`, `dotted`, `dashed`, `solid`, `double`, `groove`, `ridge`, `inset`, `outset`  

## Alignment ##
Description: How the text in the resulting cloud should be aligned  
Type: Set  
Name: `alignment`  
Default: None  
Valid values: `left`, `right`, `center`, `justify`  

## Display ##
Description: How the resulting cloud should be displayed  
Type: Set  
Name: `display`  
Default: `inline`  
Valid values: `inline`, `list`  

## Link bg color ##
Description: Background color for links  
Type: Color  
Name: `link_bg_color`  
Default: `transparent`  

## Hover bg color ##
Description: Background color for links in their hover state  
Type: Color  
Name: `hover_bg_color`  
Default: `transparent`  

## Link border color ##
Description: Border color for links  
Type: Color  
Name: `link_border_color`  
Default: `none`  

## Hover color ##
Description: Text color for links in their hover state  
Type: Color  
Name: `hover_color`  
Default: `default`  

## Hover border color ##
Description: Border color for links in their hover state  
Type: Color  
Name: `hover_border_color`  
Default: `none`  

## Letter spacing ##
Description: CSS letter-spacing value (in pixels)  
Type: Measurement  
Name: `letter_spacing`  
Default: `normal`  

## Word spacing ##
Description: CSS word-spacing value (in pixels)  
Type: Measurement  
Name: `word_spacing`  
Default: `normal`  

## Tag spacing ##
Description: CSS margin between tags  
Type: Measurement  
Name: `tag_spacing`  
Default: `auto`  

## Line height ##
Description: CSS line-height for the tags  
Type: Measurement  
Name: `line_height`  
Default: `inherit`  

## Link border width ##
Description: Border width for links  
Type: Measurement  
Name: `link_border_width`  
Default: `0`  

## Hover border width ##
Description: Border width for links in their hover state  
Type: Measurement  
Name: `hover_border_width`  
Default: `0`  

## Title ##
Description: Title text of the widget  
Type: String  
Name: `title`  
Default: `Tag Cloud`  

## Separator ##
Description: Separator between tags  
Type: String  
Name: `separator`  
Default: ` ` (space character)  

## Prefix ##
Description: Prefix before each tag  
Type: String  
Name: `prefix`  
Default: None  

## Suffix ##
Description: Suffix after each tag  
Type: String  
Name: `suffix`  
Default: None  

## Show title ##
Description: If the title attribute should be added to links in the cloud  
Type: Boolean  
Name: `show_title`  
Default: `true`  

## Show links ##
Description: If the tags should be wrapped in links  
Type: Boolean  
Name: `show_links`  
Default: `true`  

## Show title text ##
Description: If the widget title should be shown  
Type: Boolean  
Name: `show_title_text`  
Default: `true`  

## Show post count ##
Description: If the number of posts with that term should be displayed with the name  
Type: Boolean  
Name: `show_post_count`  
Default: `false`  

## Debug ##
Description: If debug output should be included  
Type: Boolean  
Name: `debug`  
Default: `false`  

*Configuration options auto generated at 2013-08-12 21:22:26 for version 2.4*