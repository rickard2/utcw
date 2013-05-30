<?php

//namespace Rickard\UTCW;

//use stdClass;

/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage main
 * @since      2.0
 */

/**
 * Class to represent a term
 *
 * @since      2.0
 * @package    utcw
 * @subpackage main
 */
class UTCW_Term
{

    /**
     * Term ID
     *
     * @var int
     * @since 2.0
     */
    public $term_id;

    /**
     * Number of posts
     *
     * @var int
     * @since 2.0
     */
    public $count;

    /**
     * Term slug
     *
     * @var string
     * @since 2.0
     */
    public $slug;

    /**
     * Term name
     *
     * @var string
     * @since 2.0
     */
    public $name;

    /**
     * Term link
     *
     * @var string
     * @since 2.0
     */
    public $link;

    /**
     * Term color
     *
     * @var string
     * @since 2.0
     */
    public $color;

    /**
     * Term taxonomy
     *
     * @var string
     * @since 2.0
     */
    public $taxonomy;

    /**
     * Term size
     *
     * @var float
     * @since 2.0
     */
    public $size;

    /**
     * Creates a new term
     *
     * @param stdClass    $input   Object with properties term_id, count, slug, name, color and taxonomy
     * @param UTCW_Plugin      $plugin  Reference to the plugin instance
     *
     * @since 2.0
     */
    public function __construct(stdClass $input, UTCW_Plugin $plugin)
    {

        if (isset($input->term_id) && filter_var($input->term_id, FILTER_VALIDATE_INT)) {
            $this->term_id = intval($input->term_id);
        }

        if (isset($input->count) && filter_var($input->count, FILTER_VALIDATE_INT)) {
            $this->count = intval($input->count);
        }

        if (isset($input->slug) && strlen($input->slug) > 0 && preg_match('/^[0-9a-z\-]+/i', $input->slug)) {
            $this->slug = $input->slug;
        }

        if (isset($input->name) && strlen($input->name) > 0) {
            $this->name = $input->name;
        }

        if (isset($input->color) && strlen($input->color) > 0 && preg_match(UTCW_HEX_COLOR_REGEX, $input->color)) {
            $this->color = $input->color;
        }

        if (isset($input->taxonomy) && strlen($input->taxonomy) > 0) {
            $this->taxonomy = $input->taxonomy;
        }

        if ($this->term_id && $this->taxonomy) {
            $this->link = $plugin->getTermLink($this->term_id, $this->taxonomy);
        }
    }
}
