<?php

abstract class UTCW_Type
{
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function normalize($value)
    {
        return $value;
    }

    abstract function validate($value);

    abstract function getDefaultValue();
}