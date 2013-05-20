<?php

class UTCW_MeasurementType extends UTCW_Type
{

    function validate($value)
    {
        return !!preg_match('/^' . UTCW_DECIMAL_REGEX . '(em|px|%)?$/i', $value);
    }

    public function normalize($value)
    {
        if (preg_match('/^' . UTCW_DECIMAL_REGEX . '$/', $value)) {
            return $value . 'px';
        }

        return $value;
    }

    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return 0;
    }
}