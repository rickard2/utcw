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
 * Array type configuration option
 *
 * @since 2.3
 */
class UTCW_ArrayType extends UTCW_Type
{

    /**
     * Which type of option this array contains
     *
     * @var UTCW_Type
     * @since 2.3
     */
    protected $type;

    /**
     * Creates a new ArrayType instance
     *
     * @param array $options
     *
     * @since 2.3
     * @throws Exception
     */
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
        $this->type  = new $typeClass($typeOptions);

        unset($options['typeOptions']);
        unset($options['type']);

        parent::__construct($options);
    }

    /**
     * Validates each item in the array with the given type
     *
     * @param string|array $value
     *
     * @return bool
     * @since 2.3
     */
    function validate($value)
    {
        if (!is_array($value)) {
            $value = explode(',', $value);
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
     * Normalizes each item in the array with the given type
     *
     * @param string|array $value
     *
     * @return array
     * @since 2.3
     */
    public function normalize($value)
    {
        if (!is_array($value)) {
            $value = explode(',', $value);
        }

        $value = array_map(array($this->type, 'normalize'), $value);

        return $value;
    }

    /**
     * Returns an empty array if a default value is not given
     *
     * @return array
     * @since 2.3
     */
    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->options['default'];
        }

        return array();
    }
}