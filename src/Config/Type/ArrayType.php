<?php

class UTCW_ArrayType extends UTCW_Type
{

    /**
     * @var UTCW_Type
     */
    protected $type;

    public function __construct(array $options)
    {
        if (!isset($options['type'])) {
            throw new Exception('Array type needs configuration option type');
        }

        $typeClass = sprintf('UTCW_%sType', ucfirst($options['type']));

        if (!class_exists($typeClass)) {
            throw new Exception('Unknown array type type ' . $options['type']);
        }

        $typeOptions = isset($options['typeOptions']) ? $options['typeOptions'] : array();
        $this->type = new $typeClass($typeOptions);

        unset($options['typeOptions']);
        unset($options['type']);

        parent::__construct($options);
    }

    function validate($value)
    {
        if (!is_array($value)) {
            return explode(',', $value);
        }

        // Invalidate empty arrays and let the default value return an empty array if it's allowed
        if (!$value) {
            return false;
        }

        foreach ($value as $item) {
            if (!$this->type->validate($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    public function normalize($value)
    {
        if (!is_array($value)) {
            $value = explode(',', $value);
        }

        $value = array_map(array($this, 'normalizeItem'), $value);

        return $value;
    }

    protected function normalizeItem($value)
    {
        return $this->type->normalize($value);
    }

    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return array();
    }
}