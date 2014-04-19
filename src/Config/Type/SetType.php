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
 * Set type configuration option
 *
 * @since 2.3
 */
class UTCW_SetType extends UTCW_Type
{

    /**
     * Validates if the value is valid for the given set
     *
     * @param mixed $value
     *
     * @return bool
     * @since 2.3
     */
    function validate($value)
    {
        if (!isset($this->options['values'])) {
            return false;
        }

        if (!is_array($this->options['values'])) {
            return false;
        }

        return in_array($value, $this->options['values']);
    }

    /**
     * Returns the first value of the set if a default value is not given
     *
     * @return mixed
     * @since 2.3
     */
    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        if (isset($this->options['values']) && is_array($this->options['values']) && $this->options['values']) {
            return $this->options['values'][0];
        }

        return '';
    }
}