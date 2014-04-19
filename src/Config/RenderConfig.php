<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage config
 * @since      2.3
 */

/**
 * Class to represent a the configuration options for cloud rendering retrieval
 *
 * @since 2.3
 * @property-read string title                    Title text of the widget
 * @property-read string letter_spacing           CSS letter-spacing value (in pixels)
 * @property-read string word_spacing             CSS word-spacing value (in pixels)
 * @property-read string text_transform           CSS text-transform value
 * @property-read string show_title               If the title attribute should be added to links in the cloud
 * @property-read string show_links               If the tags should be wrapped in links
 * @property-read string link_underline           If links should be styled with underline decoration
 * @property-read string link_bold                If links should be styled as bold
 * @property-read string link_italic              If links should be styled as italic
 * @property-read string link_bg_color            Background color for links
 * @property-read string link_border_style        Border style for links
 * @property-read string link_border_width        Border width for links
 * @property-read string link_border_color        Border color for links
 * @property-read string hover_underline          If links should be decorated with underline decoration in their hover state
 * @property-read string hover_bold               If links should be styled as bold in their hover state
 * @property-read string hover_italic             If links should be styled as italic in their hover state
 * @property-read string hover_bg_color           Background color for links in their hover state
 * @property-read string hover_color              Text color for links in their hover state
 * @property-read string hover_border_style       Border style for links in their hover state
 * @property-read string hover_border_width       Border width for links in their hover state
 * @property-read string hover_border_color       Border color for links in their hover state
 * @property-read string tag_spacing              CSS margin between tags
 * @property-read bool   debug                    If debug output should be included
 * @property-read string line_height              CSS line-height for the tags
 * @property-read string separator                Separator between tags
 * @property-read string prefix                   Prefix before each tag
 * @property-read string suffix                   Suffix after each tag
 * @property-read bool   show_title_text          If the widget title should be shown
 * @property-read string alignment                How the text in the resulting cloud should be aligned
 * @property-read string display                  How the resulting cloud should be displayed
 * @property-read bool   show_post_count          If the number of posts with that term should be displayed with the name
 * @property-read string title_type               What type of information the title text should contain
 * @property-read string title_custom_template    A C-style printf-template for the title text. Include %d to get the post count and %s to get the term name.
 * @property-read bool   prevent_breaking         If wrapping lines in the middle of words should be prevented
 * @property-read bool   avoid_theme_styling      Try to avoid styles applied to the tag cloud from themes
 * @property-read string before_widget            @internal
 * @property-read string after_widget             @internal
 * @property-read string before_title             @internal
 * @property-read string after_title              @internal
 */

class UTCW_RenderConfig extends UTCW_Config
{
    /**
     * Valid values for optional boolean set
     *
     * @var array
     * @since 2.3
     */
    protected $optionalBooleanValues = array('default', 'yes', 'no');

    /**
     * Valid values for border style set
     *
     * @var array
     * @since 2.3
     */
    protected $borderStyleValues = array(
        'none',
        'dotted',
        'dashed',
        'solid',
        'double',
        'groove',
        'ridge',
        'inset',
        'outset'
    );

    /**
     * Valid values for alignment set
     *
     * @var array
     * @since 2.3
     */
    protected $alignmentValues = array(
        'left',
        'right',
        'center',
        'justify',
    );

    /**
     * Valid values for title type
     *
     * @var array
     * @since 2.4
     */
    protected $titleTypeValues = array('counter', 'name', 'custom');

    /**
     * Valid values for display set
     *
     * @var array
     * @since 2.3
     */
    protected $displayValues = array('inline', 'list');

    /**
     * Creates a new instance of the class and adds all the options
     *
     * @param array       $input
     * @param UTCW_Plugin $plugin
     *
     * @since 2.3
     */
    public function __construct(array $input, UTCW_Plugin $plugin)
    {
        $this->addOption(
            'text_transform',
            'set',
            array(
                'values'  => array('lowercase', 'uppercase', 'capitalize'),
                'default' => 'none'
            )
        );

        $this->addOption('link_underline', 'set', array('values' => $this->optionalBooleanValues));
        $this->addOption('link_bold', 'set', array('values' => $this->optionalBooleanValues));
        $this->addOption('link_italic', 'set', array('values' => $this->optionalBooleanValues));
        $this->addOption('hover_underline', 'set', array('values' => $this->optionalBooleanValues));
        $this->addOption('hover_bold', 'set', array('values' => $this->optionalBooleanValues));
        $this->addOption('hover_italic', 'set', array('values' => $this->optionalBooleanValues));

        $this->addOption('link_border_style', 'set', array('values' => $this->borderStyleValues));
        $this->addOption('hover_border_style', 'set', array('values' => $this->borderStyleValues));
        $this->addOption('alignment', 'set', array('values' => $this->alignmentValues, 'default' => ''));
        $this->addOption('display', 'set', array('values' => $this->displayValues));
        $this->addOption('title_type', 'set', array('values' => $this->titleTypeValues));

        $this->addOption('link_bg_color', 'color');
        $this->addOption('hover_bg_color', 'color');
        $this->addOption('link_border_color', 'color', array('default' => 'none'));
        $this->addOption('hover_color', 'color', array('default' => 'default'));
        $this->addOption('hover_border_color', 'color', array('default' => 'none'));

        $this->addOption('letter_spacing', 'measurement', array('default' => 'normal'));
        $this->addOption('word_spacing', 'measurement', array('default' => 'normal'));
        $this->addOption('tag_spacing', 'measurement', array('default' => 'auto'));
        $this->addOption('line_height', 'measurement', array('default' => 'inherit'));
        $this->addOption('link_border_width', 'measurement');
        $this->addOption('hover_border_width', 'measurement');

        $this->addOption('title', 'string', array('default' => 'Tag Cloud'));
        $this->addOption('separator', 'string', array('default' => ' '));
        $this->addOption('prefix', 'string');
        $this->addOption('suffix', 'string');
        $this->addOption('before_widget', 'string');
        $this->addOption('after_widget', 'string');
        $this->addOption('before_title', 'string');
        $this->addOption('after_title', 'string');
        $this->addOption('title_custom_template', 'string');

        $this->addOption('show_title', 'boolean', array('default' => true));
        $this->addOption('show_links', 'boolean', array('default' => true));
        $this->addOption('show_title_text', 'boolean', array('default' => true));
        $this->addOption('show_post_count', 'boolean', array('default' => false));
        $this->addOption('prevent_breaking', 'boolean', array('default' => false));
        $this->addOption('avoid_theme_styling', 'boolean', array('default' => false));
        $this->addOption('debug', 'boolean');

        parent::__construct($input, $plugin);
    }
}