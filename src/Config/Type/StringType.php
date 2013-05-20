<?php

class UTCW_StringType extends UTCW_Type
{

    function validate($value)
    {
        return is_string($value) && $value;
    }

    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return '';
    }
}