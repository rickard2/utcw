<?php

require 'dist/ultimate-tag-cloud-widget.php';

class testWPDB extends wpdb
{

    function prepare($query, $arguments)
    {
        $query = str_replace('%s', "'%s'", $query);
        return vsprintf($query, $arguments);
    }
}

class MockFactory
{

    /**
     * @var WP_UnitTestCase
     */
    private $testCase;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $utcw_not_authenticated;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $utcw_authenticated;

    function __construct(WP_UnitTestCase $testcase)
    {
        $this->testCase = $testcase;

        $this->utcw_not_authenticated = $this->getUTCWMock();

        $this->utcw_not_authenticated->expects($this->testCase->any())
            ->method('isAuthenticatedUser')
            ->will($this->testCase->returnValue(false));

        $this->utcw_authenticated = $this->getUTCWMock();

        $this->utcw_authenticated->expects($this->testCase->any())
            ->method('isAuthenticatedUser')
            ->will($this->testCase->returnValue(true));
    }

    function getUTCWNotAuthenticated()
    {
        return $this->utcw_not_authenticated;
    }

    function getUTCWAuthenticated()
    {
        return $this->utcw_authenticated;
    }

    /**
     * @param array $additional_methods
     *
     * @return PHPUnit_Framework_MockObject_MockObject|UTCW_Plugin
     */
    function getUTCWMock(array $additional_methods = array())
    {

        $methods = array_merge(
            array(
                'getAllowedTaxonomies',
                'getAllowedPostTypes',
                'isAuthenticatedUser',
                'getTermLink',
                'checkTermTaxonomy',
            ),
            $additional_methods
        );

        $mock = $this->testCase->getMock(
            'UTCW_Plugin',
            $methods,
            array(),
            '',
            false
        );

        $mock->expects($this->testCase->any())
            ->method('getAllowedTaxonomies')
            ->will($this->testCase->returnValue(array('post_tag', 'category')));

        $mock->expects($this->testCase->any())
            ->method('getAllowedPostTypes')
            ->will($this->testCase->returnValue(array('post', 'page', 'attachment')));

        $mock->expects($this->testCase->any())
            ->method('getTermLink')
            ->will($this->testCase->returnValue('http://example.com/'));

        return $mock;
    }

    function getWPDBMock()
    {
        return $this->testCase->getMock('testWPDB', array('get_results'), array(), '', false);
    }
}

class DataProvider
{

    /**
     * @var MockFactory
     */
    private $mockFactory;

    /**
     * @var WP_UnitTestCase
     */
    private $testCase;

    function __construct(WP_UnitTestCase $testCase)
    {
        $this->mockFactory = new MockFactory($testCase);
        $this->testCase    = $testCase;
    }

    function termsProvider($count = 10)
    {
        $terms = array();
        $count++;

        for ($x = 1; $x < $count; $x++) {
            $term = new stdClass;

            $term->term_id  = $x;
            $term->name     = 'Test term ' . $x;
            $term->slug     = 'term-' . $x;
            $term->count    = $x * 10;
            $term->taxonomy = 'post_tag';

            $terms[] = $term;
        }

        return array(array($terms));
    }

    function get_terms(array $instance, array $query_terms)
    {
        $data = $this->get_data_object($instance, $query_terms);
        return $data->getTerms();
    }

    function get_renderer(array $instance, array $query_terms, $utcw = null)
    {
        if (!$utcw) {
            $utcw = $this->mockFactory->getUTCWNotAuthenticated();
        }

        $utcw->set('renderConfig', $this->get_render_config($instance, $utcw));
        $utcw->set('data', $this->get_data_object($instance, $query_terms));

        return new UTCW_Render($utcw);
    }

    function get_data_config(array $instance, $plugin)
    {
        return new UTCW_DataConfig($instance, $plugin);
    }

    function get_render_config(array $instance, $plugin)
    {
        return new UTCW_RenderConfig($instance, $plugin);
    }

    function get_data_object(array $instance, array $query_terms)
    {
        $plugin = $this->mockFactory->getUTCWMock();

        $db = $this->mockFactory->getWPDBMock();

        $db->expects($this->testCase->any())
            ->method('get_results')
            ->will($this->testCase->returnValue($query_terms));

        $plugin->set('wpdb', $db);
        $plugin->set('dataConfig', $this->get_data_config($instance, $plugin));

        return new UTCW_Data($plugin);
    }
}

define('UTCW_TEST_HTML_REGEX', '/<[a-z]+/i');