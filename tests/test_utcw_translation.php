<?php
//use Rickard\UTCW\Config;
//use Rickard\UTCW\Data;
//use Rickard\UTCW\QTranslateTerm;

if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.2.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Translation extends WP_UnitTestCase
{

    /**
     * @var MockFactory
     */
    private $mockFactory;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
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

    public function test_lets_translation_handler_create_term_when_enabled()
    {
        $plugin  = $this->mockFactory->getUTCWMock(array('getTranslationHandler'));
        $handler = $this->getMockForAbstractClass('TranslationHandler');

        $this->wpdb->expects($this->once())
            ->method('get_results')
            ->will($this->returnValue(array($this->term)));

        $handler->expects($this->once())
            ->method('createTerm')
            ->with($this->get_term(), $plugin);

        $plugin->expects($this->once())
            ->method('getTranslationHandler')
            ->will($this->returnValue($handler));

        $config = new Config(array(), $plugin);

        $data = new Data($config, $plugin, $this->wpdb);

        $data->getTerms();
    }
}