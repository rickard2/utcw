<?php
if (!defined('ABSPATH')) {
    die();
}
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7
 * @license    GPLv2
 * @package    utcw
 * @subpackage test
 */

class UTCW_Test_Ajax extends WP_UnitTestCase
{
    public function test_terms()
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

        /** @var UTCW_Plugin $plugin */
        $terms = $plugin->getTermsJson();

        $terms = json_decode($terms);

        $this->assertNotNull($terms, 'Terms should be JSON decodeable');
        $this->assertNotNull($terms->category, 'Terms should be decoded back to an object of taxonomies');
        $this->assertInternalType('array', $terms->category, 'Terms of a category should be decoded into an array');
    }

    public function test_authors()
    {
        $plugin = $this->getMock('UTCW_Plugin', array('getUsers'), array(), '', false);

        $authors = array(
            new WP_User(0),
        );

        $plugin->expects($this->once())->method('getUsers')->will($this->returnValue($authors));


        /** @var UTCW_Plugin $plugin */
        $authors = $plugin->getAuthorsJson();

        $authors = json_decode($authors);

        $this->assertNotNull($authors, 'Authors should be JSON decodeable');
        $this->assertInternalType('array', $authors, 'Authors should be an array');
        $this->assertEquals($authors[0]->ID, 0);
        $this->assertFalse(isset($authors[0]->data), 'JSON should not contain internal data');
        $this->assertFalse(isset($authors[0]->caps), 'JSON should not contain internal data');
        $this->assertFalse(isset($authors[0]->roles), 'JSON should not contain internal data');
    }
}
