<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage config-type
 * @since      2.3
 */

/**
 * Boolean type configuration option
 *
 * @since 2.3
 */
class UTCW_BooleanType extends UTCW_Type
{
    /**
     * Validates the input as a boolean
     *
     * @param mixed $value
     *
     * @return bool
     * @since 2.3
     */
    function validate($value)
    {
        return true; // Everything can be parsed as a boolean
    }

    /**
     * Normalizes the value into a boolean
     *
     * @param mixed $value
     *
     * @return bool
     * @since 2.3
     */
    public function normalize($value)
    {
        return !!$value;
    }

    /**
     * Returns false if a default value is not given
     *
     * @return bool
     * @since 2.3
     */
    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return false;
    }
}