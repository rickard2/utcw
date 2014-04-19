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
 * Color type configuration option
 *
 * @since 2.3
 * @todo  Allow more flexibility in color setting, like rgb/rgba/hsl/hsla and named colors
 */
class UTCW_ColorType extends UTCW_Type
{
    /**
     * Validates the input as a color value
     *
     * @param mixed $value
     *
     * @return bool
     * @since 2.3
     */
    function validate($value)
    {
        return preg_match('/#([a-f0-9]{6}|[a-f0-9]{3})/i', $value) > 0;
    }

    /**
     * Normalizes the input as a color value
     *
     * @param mixed $value
     *
     * @return string
     * @since 2.3
     */
    public function normalize($value)
    {
        if (strlen($value) == 4) {
            $red   = substr($value, 1, 1);
            $green = substr($value, 2, 1);
            $blue  = substr($value, 3, 1);

            return sprintf('#%s%s%s%s%s%s', $red, $red, $green, $green, $blue, $blue);
        }

        return $value;
    }

    /**
     * Returns transparent if a default value is not given
     *
     * @return string
     * @since 2.3
     */
    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return 'transparent';
    }
}