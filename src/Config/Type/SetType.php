<?php

class UTCW_SetType extends UTCW_Type
{
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