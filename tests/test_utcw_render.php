<?php if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.1
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Render extends WP_UnitTestCase
{

    /**
     * @var DataProvider
     */
    private $dataProvider;

    /**
     * @var MockFactory
     */
    private $mockFactory;

    function setUp()
    {
        $this->dataProvider = new DataProvider($this);
        $this->mockFactory  = new MockFactory($this);
    }

    function getRenderer($input = array(), $query_terms = array(), $utcw = null)
    {
        return $this->dataProvider->get_renderer($input, $query_terms, $utcw);
    }

    function test_title_is_outside_of_wrapper()
    {
        $render = $this->getRenderer(array('title' => 'Hello World'));
        $this->assertRegExp('/Hello World<div class="widget_tag_cloud/', $render->getCloud());
    }

    function test_title_is_inside_widget()
    {
        $render = $this->getRenderer(array('before_widget' => 'BEFORE_WIDGET', 'title' => 'Hello World'));
        $this->assertRegExp('/BEFORE_WIDGETHello World/', $render->getCloud());
    }

    function test_output_contains_wrapper()
    {
        $render = $this->getRenderer();
        $this->assertRegExp('/<div class="widget_tag_cloud utcw-[0-9a-z]+">.*<\/div>$/i', $render->getCloud());
    }

    function test_wrapper_is_inside_widget()
    {
        $this->helper_contains(
            array(
                'before_widget' => 'BEFORE_WIDGET',
                'title'         => 'title'
            ),
            'BEFORE_WIDGETtitle<div class="'
        );
    }

    function test_return_value_and_output_is_equal()
    {
        $render = $this->getRenderer();
        $this->expectOutputString($render->getCloud());
        $render->render();
    }

    function test_output_contains_css()
    {
        $this->helper_contains(array(), '<style type="text/css">');
    }

    function test_output_contains_word_wrap()
    {
        $this->helper_contains(array(), 'word-wrap:break-word');
    }

    function test_text_transform()
    {
        $this->helper_contains(array('text_transform' => 'capitalize'), 'text-transform:capitalize');
    }

    function test_letter_spacing()
    {
        $this->helper_contains(array('letter_spacing' => 10), 'letter-spacing:10px');
    }

    function test_letter_spacing_em()
    {
        $this->helper_contains(array('letter_spacing' => '1em'), 'letter-spacing:1em');
    }

    function test_letter_spacing_percentage()
    {
        $this->helper_contains(array('letter_spacing' => '10%'), 'letter-spacing:10%');
    }

    function test_word_spacing()
    {
        $this->helper_contains(array('word_spacing' => 10), 'word-spacing:10px');
    }

    function test_word_spacing_em()
    {
        $this->helper_contains(array('word_spacing' => '1em'), 'word-spacing:1em');
    }

    function test_word_spacing_percentage()
    {
        $this->helper_contains(array('word_spacing' => '10%'), 'word-spacing:10%');
    }

    function test_link_underline()
    {
        $this->helper_contains(array('link_underline' => 'yes'), 'a{text-decoration:underline');
    }

    function test_link_bold()
    {
        $this->helper_contains(array('link_bold' => 'yes'), 'a{font-weight:bold');
    }

    function test_link_italic()
    {
        $this->helper_contains(array('link_italic' => 'yes'), 'a{font-style:italic');
    }

    function test_link_bg_color()
    {
        $this->helper_contains(array('link_bg_color' => '#bada55'), 'a{background-color:#bada55');
    }

    function test_link_border_style()
    {
        $this->helper_contains(array('link_border_style' => 'groove'), 'a{border-style:groove');
    }

    function test_link_border_width()
    {
        $this->helper_contains(array('link_border_width' => 10), 'a{border-width:10px');
    }

    function test_link_border_width_em()
    {
        $this->helper_contains(array('link_border_width' => '1em'), 'a{border-width:1em');
    }

    function test_link_border_width_percentage()
    {
        $this->helper_contains(array('link_border_width' => '50%'), 'a{border-width:50%');
    }

    function test_link_border_color()
    {
        $this->helper_contains(array('link_border_color' => '#bada55'), 'a{border-color:#bada55');
    }

    function test_hover_underline()
    {
        $this->helper_contains(array('hover_underline' => 'yes'), 'a:hover{text-decoration:underline');
    }

    function test_hover_bold()
    {
        $this->helper_contains(array('hover_bold' => 'yes'), 'a:hover{font-weight:bold');
    }

    function test_hover_italic()
    {
        $this->helper_contains(array('hover_italic' => 'yes'), 'a:hover{font-style:italic');
    }

    function test_hover_bg_color()
    {
        $this->helper_contains(array('hover_bg_color' => '#bada55'), 'a:hover{background-color:#bada55');
    }

    function test_hover_border_style()
    {
        $this->helper_contains(array('hover_border_style' => 'groove'), 'a:hover{border-style:groove');
    }

    function test_hover_border_width()
    {
        $this->helper_contains(array('hover_border_width' => 10), 'a:hover{border-width:10px');
    }

    function test_hover_border_width_em()
    {
        $this->helper_contains(array('hover_border_width' => '1em'), 'a:hover{border-width:1em');
    }

    function test_hover_border_width_percentage()
    {
        $this->helper_contains(array('hover_border_width' => '50%'), 'a:hover{border-width:50%');
    }

    function test_hover_border_color()
    {
        $this->helper_contains(array('hover_border_color' => '#bada55'), 'a:hover{border-color:#bada55');
    }

    function test_hover_color()
    {
        $this->helper_contains(array('hover_color' => '#bada55'), 'a:hover{color:#bada55');
    }

    function test_hover_border_shorthand()
    {
        $this->helper_contains(
            array(
                'hover_border_style' => 'groove',
                'hover_border_width' => 10,
                'hover_border_color' => '#bada55',
            ),
            'a:hover{border:groove 10px #bada55'
        );
    }

    function test_tag_spacing()
    {
        $this->helper_contains(array('tag_spacing' => 10), 'a{margin-right:10px');
    }

    function test_tag_spacing_em()
    {
        $this->helper_contains(array('tag_spacing' => '1em'), 'a{margin-right:1em');
    }

    function test_tag_spacing_percentage()
    {
        $this->helper_contains(array('tag_spacing' => '50%'), 'a{margin-right:50%');
    }

    function test_line_height()
    {
        $this->helper_contains(array('line_height' => 10), 'a{line-height:10px');
    }

    function test_line_height_em()
    {
        $this->helper_contains(array('line_height' => '1em'), 'a{line-height:1em');
    }

    function test_line_height_percentage()
    {
        $this->helper_contains(array('line_height' => '50%'), 'a{line-height:50%');
    }

    function test_before_widget()
    {
        $this->helper_contains(array('before_widget' => '<section>'), '<section>');
    }

    function test_after_widget()
    {
        $this->helper_contains(array('after_widget' => '</section>'), '</section>');
    }

    function test_before_title()
    {
        $this->helper_contains(array('before_title' => '<h1>'), '<h1>');
    }

    function test_after_title()
    {
        $this->helper_contains(array('after_title' => '</h1>'), '</h1>');
    }

    function test_title()
    {
        $this->helper_contains(array('title' => 'Hello World!'), 'Hello World!');
    }

    function test_show_title_text()
    {
        $this->helper_not_contains(
            array(
                'show_title_text' => false,
                'title'           => 'Hello World!',
            ),
            'Hello World!'
        );
    }

    function test_title_wrapped()
    {
        $this->helper_contains(
            array(
                'before_title' => '<h1>',
                'title'        => 'Hello World!',
                'after_title'  => '</h1>'
            ),
            '<h1>Hello World!</h1>'
        );
    }

    function test_no_title_no_wrapper()
    {
        $this->helper_not_contains(
            array(
                'show_title_text' => false,
                'before_title'    => 'Hello World!',
                'after_title'     => 'Hello World!',
            ),
            'Hello World!'
        );
    }

    /**
     * @dataProvider terms
     */
    function test_separator($terms)
    {
        $instance = array('separator' => 'SEPARATOR');

        $expected = count($terms) - 1;

        $this->helper_substr_count($instance, 'SEPARATOR', $terms, $expected);
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_prefix($terms)
    {
        $instance = array('prefix' => 'PREFIX');
        $this->helper_substr_count($instance, 'PREFIX', $terms, count($terms));
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_suffix($terms)
    {
        $instance = array('suffix' => 'SUFFIX');
        $this->helper_substr_count($instance, 'SUFFIX', $terms, count($terms));
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_prefix_separator_suffix_placement($terms)
    {
        $instance = array(
            'prefix' => 'PREFIX',
            'separator' => 'SEPARATOR',
            'suffix' => 'SUFFIX',
        );

        $renderer = $this->getRenderer($instance, $terms);
        $this->assertEquals(
            9,
            preg_match_all('/PREFIX<a[^>]+>Test term [0-9]+<\/a>SUFFIXSEPARATOR/', $renderer->getCloud(), $dummy)
        );
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_show_title_shows_title($terms)
    {
        $instance = array('show_title' => true);
        $renderer = $this->getRenderer($instance, $terms);
        $this->assertRegExp('/title="[0-9]+ topics?"/', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_hide_title_hides_title($terms)
    {
        $instance = array('show_title' => false);
        $renderer = $this->getRenderer($instance, $terms);
        $this->assertNotRegExp('/title="[0-9]+ topics?"/', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_output_links_contains_class($terms)
    {
        $renderer = $this->getRenderer(array(), $terms);
        $this->assertRegexp('/class="tag-link-[0-9]+"/', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_output_contains_color($terms)
    {
        $renderer = $this->getRenderer(array('color' => 'random'), $terms);
        $this->assertRegexp('/;color:#[0-9a-f]{6}"/', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_output_contains_size($terms)
    {
        $renderer = $this->getRenderer(array(), $terms);
        $this->assertRegExp('/style="font-size:[0-9.]+px"/', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_output_contains_size_in_em($terms)
    {
        $renderer = $this->getRenderer(array('size_from' => '1em', 'size_to' => '2em'), $terms);
        $this->assertRegExp('/style="font-size:[0-9.]+em"/', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_output_contains_size_in_percentage($terms)
    {
        $renderer = $this->getRenderer(array('size_from' => '25%', 'size_to' => '200%'), $terms);
        $this->assertRegExp('/style="font-size:[0-9.]+%"/', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_show_links_false_doesnt_render_links($terms)
    {
        $renderer = $this->getRenderer(array('show_links' => false), $terms);
        $this->assertNotContains('<a', $renderer->getCloud());
    }

    function test_debug()
    {
        $this->helper_contains(array('debug' => true), '<!-- Ultimate Tag Cloud Debug information');
    }

    function test_applies_filter_to_widget_title()
    {
        $utcw = $this->mockFactory->getUTCWMock(array('applyFilters'));
        $utcw->expects($this->once())
            ->method('applyFilters')
            ->with('widget_title', 'Tag Cloud')
            ->will($this->returnValue('Tag Cloud'));

        $renderer = $this->getRenderer(array(), array(), $utcw);
        $renderer->getCloud();
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_output_contains_href($terms)
    {
        $renderer = $this->getRenderer(array(), $terms);
        $this->assertRegexp('/href="http:\/\/example.com\/"/', $renderer->getCloud());
    }

    function test_debug_output_omits_wpdb()
    {
        $this->helper_not_contains(array('debug' => true), 'wpdb');
    }

    function terms()
    {
        $dp = new DataProvider($this);
        return $dp->termsProvider();
    }

    function helper_substr_count($config, $needle, $terms, $expected)
    {
        $renderer = $this->getRenderer($config, $terms);
        $this->assertEquals($expected, substr_count($renderer->getCloud(), $needle));
    }

    function helper_contains($config, $needle)
    {
        $render = $this->getRenderer($config);
        $this->assertContains($needle, $render->getCloud());
    }

    function helper_not_contains($config, $needle)
    {
        $render = $this->getRenderer($config);
        $this->assertNotContains($needle, $render->getCloud());
    }
}