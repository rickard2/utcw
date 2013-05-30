<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage config
 * @since      2.3
 */

/**
 * Class to represent a the configuration options for cloud rendering retrieval
 *
 * @since 2.3
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

        $this->addOption('show_title', 'boolean', array('default' => true));
        $this->addOption('show_links', 'boolean', array('default' => true));
        $this->addOption('show_title_text', 'boolean', array('default' => true));
        $this->addOption('debug', 'boolean');

        parent::__construct($input, $plugin);
    }
}