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
 * String type configuration option
 *
 * @since 2.3
 */
class UTCW_StringType extends UTCW_Type
{

    /**
     * Validates the input value as a string
     *
     * @param mixed $value
     *
     *
     * @return bool
     * @since 2.3
     */
    function validate($value)
    {
        return is_string($value) && $value;
    }

    /**
     * Returns an empty string if a default value is not given
     *
     * @return string
     * @since 2.3
     */
    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return '';
    }
}