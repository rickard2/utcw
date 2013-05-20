<?php

abstract class UTCW_Config
{
    protected $data = array();

    /**
     * @var UTCW_Type[]
     */
    protected $options = array();

    public function __construct(array $input, UTCW_Plugin $plugin)
    {
        $this->_validate($input);
    }

    protected function addOption($name, $type, $options = array())
    {
        $typeClass = sprintf('UTCW_%sType', ucfirst($type));

        if (!class_exists($typeClass)) {
            throw new Exception('Unknown type ' . $type);
        }

        $this->options[$name] = new $typeClass($options);
    }

    protected function _validate(array $input)
    {
        foreach ($this->options as $name => $type) {

            $value = isset($input[$name]) ? $input[$name] : false;

            if (isset($input[$name]) && $type->validate($value)) {
                $this->data[$name] = $type->normalize($value);
            } else {
                $this->data[$name] = $type->getDefaultValue();
            }
        }
    }

    public function __get($name)
    {
        if (!isset($this->data[$name])) {
            throw new Exception('Invalid configuration option ' . $name);
        }

        return $this->data[$name];
    }

    public function getInstance()
    {
        return $this->data;
    }
}