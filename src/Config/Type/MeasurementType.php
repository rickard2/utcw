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
 * Measurement type configuration option
 *
 * @since 2.3
 */
class UTCW_MeasurementType extends UTCW_IntegerType
{

    /**
     * Validates the input value as a measurement
     *
     * @param string|int|float $value
     *
     * @return bool
     * @since 2.3
     */
    public function validate($value)
    {
        return !!preg_match('/^' . UTCW_DECIMAL_REGEX . '(em|px|%)?$/i', $value);
    }

    /**
     * Normalizes the input value as a measurement
     *
     * @param mixed $value
     *
     * @return string
     * @since 2.3
     */
    public function normalize($value)
    {
        if (preg_match('/^' . UTCW_DECIMAL_REGEX . '$/', $value)) {
            return $value . 'px';
        }

        return $value;
    }
}