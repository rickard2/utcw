<?php
if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.4
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Ajax extends WP_UnitTestCase
{
    public function test_returns_json_array()
    {
        $plugin = $this->getMock('UTCW_Plugin', array('getTerms'), array(), '', false);

        $terms = array(
            'category' => array(
                1 => array(
                    'term_id' => 123,
                    'name'    => 'foo'
                ),
                3 => array(
                    'term_id' => 345,
                    'name'    => 'bar'
                )
            ),
        );

        $plugin->expects($this->once())
            ->method('getTerms')
            ->will($this->returnValue($terms));

        $terms = $plugin->getTermsJson();

        $terms = json_decode($terms);

        $this->assertNotNull($terms, 'Terms should be JSON decodeable');
        $this->assertNotNull($terms->category, 'Terms should be decoded back to an object of taxonomies');
        $this->assertInternalType('array', $terms->category, 'Terms of a category should be decoded into an array');
    }
}
