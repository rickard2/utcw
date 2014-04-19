<?php
/**
 * Ultimate Tag Cloud Widget
 *
 * @author     Rickard Andersson <rickard@0x539.se>
 * @version    2.7.2
 * @license    GPLv2
 * @package    utcw
 * @subpackage config-type
 * @since      2.3
 */

/**
 * Abstract base class to represent a type of configuration option
 *
 * @since 2.3
 */
abstract class UTCW_Type
{
    /**
     * Contains type specific options
     *
     * @var array
     * @since 2.3
     */
    protected $options;

    /**
     * Creates a new type instance
     *
     * @param array $options
     *
     * @since 2.3
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Normalize configuration value
     *
     * @param mixed $value
     *
     * @return mixed
     * @since 2.3
     */
    public function normalize($value)
    {
        return $value;
    }

    /**
     * Returns true if the given value is valid for this type
     *
     * @param mixed $value
     *
     * @return bool
     * @since 2.3
     */
    abstract function validate($value);

    /**
     * Returns the default value to be set when the value is missing or invalid
     *
     * @return mixed
     * @since 2.3
     */
    abstract function getDefaultValue();
}