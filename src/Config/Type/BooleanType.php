<?php

class UTCW_BooleanType extends UTCW_Type
{
    function validate($value)
    {
        return true; // Everything can be parsed as a boolean
    }

    public function normalize($value)
    {
        return !!$value;
    }

    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return false;
    }
}