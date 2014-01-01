<?php if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.6.1
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
        $this->assertRegExp('/Hello World<div class="utcw-/', $render->getCloud());
    }

    function test_title_is_inside_widget()
    {
        $render = $this->getRenderer(array('before_widget' => 'BEFORE_WIDGET', 'title' => 'Hello World'));
        $this->assertRegExp('/BEFORE_WIDGETHello World/', $render->getCloud());
    }

    function test_regular_tag_cloud_class_is_added_to_before_widget()
    {
        $render = $this->getRenderer(
            array('before_widget' => '<div class="widget widget_utcw">', 'title' => 'Hello World')
        );
        $this->assertRegExp('/<div class="widget widget_utcw widget_tag_cloud">Hello World/', $render->getCloud());
    }

    function test_output_contains_wrapper()
    {
        $render = $this->getRenderer();
        $this->assertRegExp('/<div class="utcw-[0-9a-z]+ tagcloud">.*<\/div>$/i', $render->getCloud());
    }

    function test_avoid_theme_styling()
    {
        $render = $this->getRenderer(
            array(
                'avoid_theme_styling' => true,
                'before_widget'       => '<section class="widget widget_utcw">',
                'after_widget'        => '</section>',
            )
        );

        $result = $render->getCloud();

        $this->assertContains('<section class="', $result);

        $this->assertNotContains('widget_tag_cloud', $result);
        $this->assertNotContains('tagcloud', $result);
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
        $this->helper_contains(array(), '<style scoped type="text/css">');
    }

    function test_output_contains_word_wrap()
    {
        $this->helper_contains(array(), 'word-wrap:break-word');
    }

    function test_output_contains_selector()
    {
        $this->helper_contains(array(), '.utcw-');
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

    function test_alignment()
    {
        $this->helper_contains(array('alignment' => 'justify'), 'text-align:justify');
    }

    function test_no_alignment()
    {
        $this->helper_not_contains(array(), 'text-align');
    }

    function test_display_list_wrapper()
    {
        $this->helper_contains(array('display' => 'list'), '<ul');
    }

    /**
     * @dataProvider terms
     */
    function test_display_list_items($terms)
    {
        $instance = array('display' => 'list');

        $expected = count($terms);

        $this->helper_substr_count($instance, '<li>', $terms, $expected);
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
            'prefix'    => 'PREFIX',
            'separator' => 'SEPARATOR',
            'suffix'    => 'SUFFIX',
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

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_show_post_count($terms)
    {
        $renderer = $this->getRenderer(array('show_post_count' => true), $terms);
        $this->assertContains('Test term 1 (10)', $renderer->getCloud());
    }

    /**
     * @param $terms
     *
     * @dataProvider terms
     */
    function test_show_post_count_false_doesnt_show_post_count($terms)
    {
        $renderer = $this->getRenderer(array('show_post_count' => false), $terms);
        $this->assertNotContains('Test term 1 (10)', $renderer->getCloud());
    }

    function test_debug()
    {
        $this->helper_contains(array('debug' => true), '<!-- Ultimate Tag Cloud Debug information');
    }

    /**
     * @dataProvider terms
     */
    function test_title_type_counter($terms)
    {
        $renderer = $this->getRenderer(array('title_type' => 'counter'), $terms);
        $this->assertContains('title="10 topics"', $renderer->getCloud());
    }

    /**
     * @dataProvider terms
     */
    function test_title_type_name($terms)
    {
        $renderer = $this->getRenderer(array('title_type' => 'name'), $terms);
        $this->assertContains('title="Test term 1"', $renderer->getCloud());
    }

    /**
     * @dataProvider terms
     */
    function test_title_type_custom($terms)
    {
        $renderer = $this->getRenderer(
            array('title_type' => 'custom', 'title_custom_template' => 'Hello %s World %d'),
            $terms
        );
        $this->assertContains('title="Hello Test term 1 World 10"', $renderer->getCloud());

        $renderer = $this->getRenderer(
            array('title_type' => 'custom', 'title_custom_template' => 'Hello %d World %s'),
            $terms
        );
        $this->assertContains('title="Hello 10 World Test term 1"', $renderer->getCloud());

        $renderer = $this->getRenderer(
            array('title_type' => 'custom', 'title_custom_template' => 'Hello World %s'),
            $terms
        );
        $this->assertContains('title="Hello World Test term 1"', $renderer->getCloud());

        $renderer = $this->getRenderer(
            array('title_type' => 'custom', 'title_custom_template' => 'Hello World %d'),
            $terms
        );
        $this->assertContains('title="Hello World 10"', $renderer->getCloud());

        $renderer = $this->getRenderer(
            array('title_type' => 'custom', 'title_custom_template' => 'Hello World'),
            $terms
        );
        $this->assertContains('title="Hello World"', $renderer->getCloud());
    }

    function test_prevent_breaking()
    {
        $renderer = $this->getRenderer(array('prevent_breaking' => true));
        $this->assertContains('white-space:nowrap', $renderer->getCloud());
    }

    function test_applies_filters()
    {
        $utcw = $this->mockFactory->getUTCWMock(array('applyFilters'));

        $dp    = new DataProvider($this);
        $terms = $dp->termsProvider(1);
        $term  = $terms[0][0][0];

        $utcw->expects($this->exactly(7))
            ->method('applyFilters')
            ->with(
                $this->logicalOr(
                    $this->equalTo('widget_title'),
                    $this->equalTo('utcw_render_css'),
                    $this->equalTo('utcw_render_terms'),
                    $this->equalTo('utcw_render_term_title_singular'),
                    $this->equalTo('utcw_render_term_title_plural'),
                    $this->equalTo('utcw_render_tag'),
                    $this->equalTo('utcw_render_term_display_name')
                )
            )
            ->will(
                $this->returnCallback(
                    create_function('$filter, $value', 'return $filter === "utcw_render_terms" ? $value : "";')
                )
            );

        $renderer = $this->getRenderer(array(), array($term), $utcw);
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
        global $wpdb;

        $utcw = $this->mockFactory->getUTCWNotAuthenticated();

        $utcw->set('wpdb', $wpdb);
        $utcw->set('renderConfig', new UTCW_RenderConfig(array('debug' => true), $utcw));
        $utcw->set('dataConfig', new UTCW_DataConfig(array(), $utcw));
        $utcw->set('data', new UTCW_Data($utcw));

        $render = new UTCW_Render($utcw);
        $cloud  = $render->getCloud();
        $this->assertNotContains('wpdb', $cloud, $ignoreCase = true);
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