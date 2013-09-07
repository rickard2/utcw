# Configuration options #

All the configuration options can be used both in `do_utcw()` and the shortcode.

## Strategy ##
Description: Which strategy to use when fetching terms  
Type: Set  
Name: `strategy`  
Default: `popularity`  
Shortcode example: `[utcw strategy=random]`  
Valid values: `popularity`, `random`  

## Order ##
Description: How the result should be ordered  
Type: Set  
Name: `order`  
Default: `name`  
Shortcode example: `[utcw order=count]`  
Valid values: `name`, `random`, `slug`, `id`, `color`, `count`  

## Tags list type ##
Description: How the [tags list](#tags-list) should be used  
Type: Set  
Name: `tags_list_type`  
Default: `exclude`  
Shortcode example: `[utcw tags_list_type=include]`  
Valid values: `exclude`, `include`  

## Color ##
Description: Which coloring strategy to use  
Type: Set  
Name: `color`  
Default: `none`  
Shortcode example: `[utcw color=span]`  
Valid values: `none`, `random`, `set`, `span`  

## Color span to ##
Description: Which color value to start from in color calculation. This is the color that the smallest tag will get.  
Type: Color  
Name: `color_span_to`  
Default: None  
Shortcode example: `[utcw color_span_to="#bada55"]`  

## Color span from ##
Description: Which color value to end at in color calculation. This is the color that the biggest tag will get.  
Type: Color  
Name: `color_span_from`  
Default: None  
Shortcode example: `[utcw color_span_from="#bada55"]`  

## Color set ##
Description: A set of colors to randomly select from when coloring the tags  
Type: Array  
Name: `color_set`  
Default: None  
Shortcode example: `[utcw color_set="#fff,#000,#bada55"]`  

## Taxonomy ##
Description: Which taxonomy to show tags from  
Type: Array  
Name: `taxonomy`  
Default: `[post_tag]`  
Shortcode example: `[utcw taxonomy="foo,bar,baz"]`  

## Post type ##
Description: An array of post type names to to include posts from in tag size calculation  
Type: Array  
Name: `post_type`  
Default: `[post]`  
Shortcode example: `[utcw post_type="foo,bar,baz"]`  

## Authors ##
Description: Which authors to include posts from. An empty array will include all authors  
Type: Array  
Name: `authors`  
Default: None  
Shortcode example: `[utcw authors="1,2,3"]`  

## Tags list ##
Description: A list of term IDs to be included or excluded. Inclusion or exclusion is determined by [tags list type](#tags-list-type)  
Type: Array  
Name: `tags_list`  
Default: None  
Shortcode example: `[utcw tags_list="1,2,3"]`  

## Post term ##
Description: A list of term IDs which the posts needs to have to be included in tag size calculation  
Type: Array  
Name: `post_term`  
Default: None  
Shortcode example: `[utcw post_term="1,2,3"]`  

## Size from ##
Description: The smallest possible size  
Type: Measurement  
Name: `size_from`  
Default: `10px`  
Shortcode example: `[utcw size_from="10px"]`  

## Size to ##
Description: The greatest possible size  
Type: Measurement  
Name: `size_to`  
Default: `30px`  
Shortcode example: `[utcw size_to="10px"]`  

## Max ##
Description: Maximum number of tags to display  
Type: Integer  
Name: `max`  
Default: `45`  
Shortcode example: `[utcw max=10]`  

## Minimum ##
Description: How many posts a term needs to have to be shown in the cloud  
Type: Integer  
Name: `minimum`  
Default: `1`  
Shortcode example: `[utcw minimum=10]`  

## Days old ##
Description: How many days old a post needs to be to be included in tag size calculation  
Type: Integer  
Name: `days_old`  
Default: `0`  
Shortcode example: `[utcw days_old=10]`  

## Reverse ##
Description: If the order of tags should be shown in reverse order  
Type: Boolean  
Name: `reverse`  
Default: `false`  
Shortcode example: `[utcw reverse=1]`  

## Case sensitive ##
Description: If sorting should be applied case sensitive  
Type: Boolean  
Name: `case_sensitive`  
Default: `false`  
Shortcode example: `[utcw case_sensitive=1]`  

## Text transform ##
Description: CSS text-transform value  
Type: Set  
Name: `text_transform`  
Default: `none`  
Shortcode example: `[utcw text_transform=capitalize]`  
Valid values: `lowercase`, `uppercase`, `capitalize`  

## Link underline ##
Description: If links should be styled with underline decoration  
Type: Set  
Name: `link_underline`  
Default: `default`  
Shortcode example: `[utcw link_underline=no]`  
Valid values: `default`, `yes`, `no`  

## Link bold ##
Description: If links should be styled as bold  
Type: Set  
Name: `link_bold`  
Default: `default`  
Shortcode example: `[utcw link_bold=no]`  
Valid values: `default`, `yes`, `no`  

## Link italic ##
Description: If links should be styled as italic  
Type: Set  
Name: `link_italic`  
Default: `default`  
Shortcode example: `[utcw link_italic=no]`  
Valid values: `default`, `yes`, `no`  

## Hover underline ##
Description: If links should be decorated with underline decoration in their hover state  
Type: Set  
Name: `hover_underline`  
Default: `default`  
Shortcode example: `[utcw hover_underline=no]`  
Valid values: `default`, `yes`, `no`  

## Hover bold ##
Description: If links should be styled as bold in their hover state  
Type: Set  
Name: `hover_bold`  
Default: `default`  
Shortcode example: `[utcw hover_bold=no]`  
Valid values: `default`, `yes`, `no`  

## Hover italic ##
Description: If links should be styled as italic in their hover state  
Type: Set  
Name: `hover_italic`  
Default: `default`  
Shortcode example: `[utcw hover_italic=no]`  
Valid values: `default`, `yes`, `no`  

## Link border style ##
Description: Border style for links  
Type: Set  
Name: `link_border_style`  
Default: `none`  
Shortcode example: `[utcw link_border_style=outset]`  
Valid values: `none`, `dotted`, `dashed`, `solid`, `double`, `groove`, `ridge`, `inset`, `outset`  

## Hover border style ##
Description: Border style for links in their hover state  
Type: Set  
Name: `hover_border_style`  
Default: `none`  
Shortcode example: `[utcw hover_border_style=outset]`  
Valid values: `none`, `dotted`, `dashed`, `solid`, `double`, `groove`, `ridge`, `inset`, `outset`  

## Alignment ##
Description: How the text in the resulting cloud should be aligned  
Type: Set  
Name: `alignment`  
Default: None  
Shortcode example: `[utcw alignment=justify]`  
Valid values: `left`, `right`, `center`, `justify`  

## Display ##
Description: How the resulting cloud should be displayed  
Type: Set  
Name: `display`  
Default: `inline`  
Shortcode example: `[utcw display=list]`  
Valid values: `inline`, `list`  

## Title type ##
Description: What type of information the title text should contain  
Type: Set  
Name: `title_type`  
Default: `counter`  
Shortcode example: `[utcw title_type=custom]`  
Valid values: `counter`, `name`, `custom`  

## Link bg color ##
Description: Background color for links  
Type: Color  
Name: `link_bg_color`  
Default: `transparent`  
Shortcode example: `[utcw link_bg_color="#bada55"]`  

## Hover bg color ##
Description: Background color for links in their hover state  
Type: Color  
Name: `hover_bg_color`  
Default: `transparent`  
Shortcode example: `[utcw hover_bg_color="#bada55"]`  

## Link border color ##
Description: Border color for links  
Type: Color  
Name: `link_border_color`  
Default: `none`  
Shortcode example: `[utcw link_border_color="#bada55"]`  

## Hover color ##
Description: Text color for links in their hover state  
Type: Color  
Name: `hover_color`  
Default: `default`  
Shortcode example: `[utcw hover_color="#bada55"]`  

## Hover border color ##
Description: Border color for links in their hover state  
Type: Color  
Name: `hover_border_color`  
Default: `none`  
Shortcode example: `[utcw hover_border_color="#bada55"]`  

## Letter spacing ##
Description: CSS letter-spacing value (in pixels)  
Type: Measurement  
Name: `letter_spacing`  
Default: `normal`  
Shortcode example: `[utcw letter_spacing="10px"]`  

## Word spacing ##
Description: CSS word-spacing value (in pixels)  
Type: Measurement  
Name: `word_spacing`  
Default: `normal`  
Shortcode example: `[utcw word_spacing="10px"]`  

## Tag spacing ##
Description: CSS margin between tags  
Type: Measurement  
Name: `tag_spacing`  
Default: `auto`  
Shortcode example: `[utcw tag_spacing="10px"]`  

## Line height ##
Description: CSS line-height for the tags  
Type: Measurement  
Name: `line_height`  
Default: `inherit`  
Shortcode example: `[utcw line_height="10px"]`  

## Link border width ##
Description: Border width for links  
Type: Measurement  
Name: `link_border_width`  
Default: `0`  
Shortcode example: `[utcw link_border_width="10px"]`  

## Hover border width ##
Description: Border width for links in their hover state  
Type: Measurement  
Name: `hover_border_width`  
Default: `0`  
Shortcode example: `[utcw hover_border_width="10px"]`  

## Title ##
Description: Title text of the widget  
Type: String  
Name: `title`  
Default: `Tag Cloud`  
Shortcode example: `[utcw title="foo"]`  

## Separator ##
Description: Separator between tags  
Type: String  
Name: `separator`  
Default: ` ` (space character)  
Shortcode example: `[utcw separator="foo"]`  

## Prefix ##
Description: Prefix before each tag  
Type: String  
Name: `prefix`  
Default: None  
Shortcode example: `[utcw prefix="foo"]`  

## Suffix ##
Description: Suffix after each tag  
Type: String  
Name: `suffix`  
Default: None  
Shortcode example: `[utcw suffix="foo"]`  

## Title custom template ##
Description: A C-style printf-template for the title text. Include %d to get the post count and %s to get the term name.  
Type: String  
Name: `title_custom_template`  
Default: None  
Shortcode example: `[utcw title_custom_template="foo"]`  

## Show title ##
Description: If the title attribute should be added to links in the cloud  
Type: Boolean  
Name: `show_title`  
Default: `true`  
Shortcode example: `[utcw show_title=0]`  

## Show links ##
Description: If the tags should be wrapped in links  
Type: Boolean  
Name: `show_links`  
Default: `true`  
Shortcode example: `[utcw show_links=0]`  

## Show title text ##
Description: If the widget title should be shown  
Type: Boolean  
Name: `show_title_text`  
Default: `true`  
Shortcode example: `[utcw show_title_text=0]`  

## Show post count ##
Description: If the number of posts with that term should be displayed with the name  
Type: Boolean  
Name: `show_post_count`  
Default: `false`  
Shortcode example: `[utcw show_post_count=1]`  

## Debug ##
Description: If debug output should be included  
Type: Boolean  
Name: `debug`  
Default: `false`  
Shortcode example: `[utcw debug=1]`  

*Configuration options auto generated at 2013-09-07 21:58:12 for version 2.4*