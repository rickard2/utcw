<?php
use Rickard\UTCW\Config;
use Rickard\UTCW\Data;
use Rickard\UTCW\QTranslateTerm;

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_QTranslate extends WP_UnitTestCase
{

    /**
     * @var MockFactory
     */
    private $mockFactory;

    /**
     * @var WPDB
     */
    private $wpdb;

    /**
     * @var stdClass
     */
    private $term;

    function setUp()
    {
        $this->mockFactory = new MockFactory($this);
        $this->wpdb        = $this->mockFactory->getWPDBMock();
        $this->term        = $this->get_term();
    }

    protected function get_term()
    {
        $term           = new stdClass;
        $term->name     = 'Test term 1';
        $term->slug     = 'term-1';
        $term->count    = 10;
        $term->taxonomy = 'post_tag';

        return $term;
    }

    public function test_returns_qtranslate_terms_when_qtranslate_is_enabled()
    {
        $this->wpdb->expects($this->once())
            ->method('get_results')
            ->will($this->returnValue(array($this->term)));

        $plugin = $this->mockFactory->getUTCWMock(array('getQTranslateHandler'));

        $handler = $this->getMock('\Rickard\UTCW\QTranslateHandler', array('isEnabled'), array(array()));

        $handler->expects($this->once())
            ->method('isEnabled')
            ->will($this->returnValue(true));

        $plugin->expects($this->atLeastOnce())
            ->method('getQTranslateHandler')
            ->will($this->returnValue($handler));

        $config = new Config(array(), $plugin);

        $data  = new Data($config, $plugin, $this->wpdb);
        $terms = $data->getTerms();

        $this->assertCount(1, $terms);

        $this->assertEquals('Rickard\UTCW\QTranslateTerm', get_class($terms[0]));
    }

    public function test_will_map_term_name()
    {
        $name = 'Testing termius singularis';

        $plugin = $this->mockFactory->getUTCWMock(array('getQTranslateHandler'));

        $handler = $this->getMock('\Rickard\UTCW\QTranslateHandler', array('getTermName'), array(array()));

        $plugin->expects($this->once())
            ->method('getQTranslateHandler')
            ->will($this->returnValue($handler));

        $handler->expects($this->once())
            ->method('getTermName')
            ->with('Test term 1')
            ->will($this->returnValue($name));

        $term = new QTranslateTerm($this->term, $plugin);

        $this->assertEquals($name, $term->name);
    }
}