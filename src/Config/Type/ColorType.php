<?php

class UTCW_ColorType extends UTCW_Type
{
    function validate($value)
    {
        // TODO: Allow more flexibility in color setting, like rgb/rgba/hsl/hsla and named colors
        return preg_match('/#([a-f0-9]{6}|[a-f0-9]{3})/i', $value) > 0;
    }

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

    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return 'transparent';
    }
}