<?php

class UTCW_IntegerType extends UTCW_Type
{

    function validate($value)
    {
        if (!is_numeric($value)) {
            return false;
        }

        if (isset($this->options['min']) && $value < $this->options['min']) {
            return false;
        }

        if (isset($this->options['max']) && $value > $this->options['max']) {
            return false;
        }

        return true;
    }

    public function normalize($value)
    {
        return intval($value);
    }

    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return 0;
    }
}