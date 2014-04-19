<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage config
 * @since      2.3
 */

/**
 * Abstract base class to represent a set of configuration options
 *
 * @since 2.3
 */
abstract class UTCW_Config
{
    /**
     * The validated configuration option values
     *
     * @var array
     * @since 2.3
     */
    protected $data = array();

    /**
     * A set of configuration options
     *
     * @var UTCW_Type[]
     * @since 2.3
     */
    protected $options = array();

    /**
     * Validates the input and instantiates an object with the parsed input
     *
     * @param array       $input
     * @param UTCW_Plugin $plugin
     */
    public function __construct(array $input, UTCW_Plugin $plugin)
    {
        $this->_validate($input);
    }

    /**
     * Add a new configuration option
     *
     * @param string $name
     * @param string $type
     * @param array  $options
     *
     * @throws Exception
     * @since 2.3
     */
    protected function addOption($name, $type, $options = array())
    {
        $typeClass = sprintf('UTCW_%sType', ucfirst($type));

        if (!class_exists($typeClass)) {
            throw new Exception('Unknown type ' . $type);
        }

        $this->options[$name] = new $typeClass($options);
    }

    /**
     * Parses the input array, validates and normalizes all the values
     *
     * @param array $input
     *
     * @since 2.3
     */
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

    /**
     * Magic method to the return the value of a configuration option
     *
     * @param $name
     *
     * @return mixed
     * @throws Exception
     * @since 2.3
     */
    public function __get($name)
    {
        if (!isset($this->data[$name])) {
            throw new Exception('Invalid configuration option ' . $name);
        }

        return $this->data[$name];
    }

    /**
     * Returns the configuration option values
     *
     * @return array
     * @since 2.3
     */
    public function getInstance()
    {
        return $this->data;
    }
}