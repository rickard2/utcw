<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.3
 * @license    GPLv2
 * @package    utcw
 * @subpackage config-type
 * @since      2.3
 */

/**
 * Integer type configuration option
 *
 * @since 2.3
 */
class UTCW_IntegerType extends UTCW_Type
{

    /**
     * Validates the input value as a integer
     *
     * @param mixed $value
     *
     * @return bool
     * @since 2.3
     */
    function validate($value)
    {
        if (!is_numeric($value)) {
            return false;
        }

        if (isset($this->options['min']) && $value < $this->options['min']) {
            return false;
        }

        if (isset($this->options['max']) && $value > $this->options['max']) {
            return false;
        }

        return true;
    }

    /**
     * Normalizes the input value into an integer
     *
     * @param mixed $value
     *
     * @return int
     * @since 2.3
     */
    public function normalize($value)
    {
        return intval($value);
    }

    /**
     * Returns zero if a default value is not given
     *
     * @return int
     * @since 2.3
     */
    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return 0;
    }
}