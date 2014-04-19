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
 * Class type configuration option
 *
 * @since 2.3
 */
class UTCW_ClassType extends UTCW_Type
{
    /**
     * Validates if the value is valid for the given set
     *
     * @param mixed $value
     *
     * @return bool
     * @since 2.3
     */
    function validate($value)
    {
        $classMap  = isset($this->options['classMap']) ? $this->options['classMap'] : array();
        $baseClass = $this->options['baseClass'];

        if ($value instanceof $baseClass) {
            return true;
        }

        if (!is_string($value)) {
            return false;
        }

        if (class_exists($value)) {
            $parents = class_parents($value);

            if (in_array($baseClass, $parents)) {
                return true;
            }
        }

        if (array_key_exists($value, $classMap)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     *
     * @return object
     */
    function normalize($value)
    {
        if (is_string($value)) {

            $className = isset($this->options['classMap'][$value]) ? $this->options['classMap'][$value] : $value;

            return call_user_func($this->options['factory'], $className);
        }

        return $value;
    }

    /**
     * Returns the first value of the set if a default value is not given
     *
     * @return mixed
     * @since 2.3
     */
    function getDefaultValue()
    {
        if (isset($this->options['default'])) {
            return $this->normalize($this->options['default']);
        }

        if (isset($this->options['classMap']) && is_array($this->options['classMap']) && $this->options['classMap']) {
            return $this->normalize($this->options['classMap'][0]);
        }

        return '';
    }
}