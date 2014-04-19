<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
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
     * @param UTCW_Plugin $plugin  Reference to the plugin instance
     *
     * @since 2.0
     */
    public function __construct(stdClass $input, UTCW_Plugin $plugin)
    {
        $this->setInteger($input, 'term_id');
        $this->setInteger($input, 'count');
        $this->setSlug($input, 'slug');
        $this->setString($input, 'name');
        $this->setString($input, 'taxonomy');
        $this->setColor($input, 'color');

        if ($this->term_id && $this->taxonomy) {
            $this->link = $plugin->getTermLink($this->term_id, $this->taxonomy);
        }
    }

    /**
     * Validate and set an integer value
     *
     * @param stdClass $input
     * @param string   $key
     */
    protected function setInteger($input, $key)
    {
        if (isset($input->$key) && filter_var($input->$key, FILTER_VALIDATE_INT)) {
            $this->$key = intval($input->$key);
        }
    }

    /**
     * Validate and set a slug value
     *
     * @param stdClass $input
     * @param string   $key
     */
    protected function setSlug($input, $key)
    {
        if (isset($input->$key) && strlen($input->$key) > 0 && preg_match('/^[0-9a-z\-]+/i', $input->$key)) {
            $this->$key = $input->$key;
        }
    }

    /**
     * Validate and set a string value
     *
     * @param stdClass $input
     * @param string   $key
     */
    protected function setString($input, $key)
    {
        if (isset($input->$key) && strlen($input->$key) > 0) {
            $this->$key = $input->$key;
        }
    }

    /**
     * Validate and set a color value
     *
     * @param stdClass $input
     * @param string   $key
     */
    protected function setColor($input, $key)
    {
        if (isset($input->$key) && strlen($input->$key) > 0 && preg_match(UTCW_HEX_COLOR_REGEX, $input->$key)) {
            $this->$key = $input->$key;
        }
    }
}
