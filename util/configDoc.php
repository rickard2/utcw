<?php

function add_action()
{
}

function add_shortcode()
{
}

class WP_Widget
{
}

function keyToName($key)
{

    $name = str_replace('_', ' ', $key);

    return ucfirst($name);
}

function typeName($type)
{
    return str_replace(array('UTCW_', 'Type'), array('', ''), $type);
}

function defaultDescription($defaultValue)
{
    if (is_bool($defaultValue)) {
        return $defaultValue ? '`true`' : '`false`';
    }

    if ($defaultValue === array() || $defaultValue === '') {
        return 'None';
    }

    if (is_array($defaultValue)) {
        return sprintf('`[%s]`', join(', ', $defaultValue));
    }

    if ($defaultValue === ' ') {
        return '` ` (space character)';
    }

    if (is_string($defaultValue) || is_integer($defaultValue)) {
        return sprintf('`%s`', $defaultValue);
    }

    throw new Exception('Unknown default value type: ' . $defaultValue);
}

chdir('..');

require 'dist/ultimate-tag-cloud-widget.php';

function getDocumentation($config)
{

    $configReflection = new ReflectionObject($config);
    $comment          = $configReflection->getDocComment();
    $descriptions     = array();

    preg_match_all('/^\s?\*\s?@property-read\s+[a-z]+\s+([a-z_]+)\s+(.+)/m', $comment, $matches);

    foreach ($matches[0] as $index => $match) {
        $propertyName                = $matches[1][$index];
        $description                 = $matches[2][$index];
        $descriptions[$propertyName] = trim($description);
    }

    $configOptionsProperty = $configReflection->getProperty('options');
    $configOptionsProperty->setAccessible(true);

    $options = $configOptionsProperty->getValue($config);

    $result = array();

    foreach ($options as $optionName => $option) {

        if (!isset($descriptions[$optionName])) {
            throw new Exception('Option ' . $optionName . ' is missing its description');
        }

        $description = $descriptions[$optionName];

        // Don't add internal properties
        if ($description === '@internal') {
            continue;
        }

        $result[] = sprintf('## %s ##', keyToName($optionName));
        $result[] = sprintf('Description: %s  ', $descriptions[$optionName]);
        $result[] = sprintf('Type: %s  ', typeName(get_class($option)));
        $result[] = sprintf('Name: `%s`  ', $optionName);
        $result[] = sprintf('Default: %s  ', defaultDescription($option->getDefaultValue()));

        if ($option instanceof UTCW_SetType) {
            $setReflection      = new ReflectionObject($option);
            $setOptionsProperty = $setReflection->getProperty('options');
            $setOptionsProperty->setAccessible(true);

            $setOptions = $setOptionsProperty->getValue($option);

            $result[] = sprintf('Valid values: `%s`  ', join('`, `', $setOptions['values']));
        }

        $result[] = '';
    }

    return $result;
}

$dataConfig   = new UTCW_DataConfig(array(), UTCW_Plugin::getInstance());
$renderConfig = new UTCW_RenderConfig(array(), UTCW_Plugin::getInstance());

$documentation = array_merge(getDocumentation($dataConfig), getDocumentation($renderConfig));

echo join("\n", $documentation);

echo "\n";
echo '*Configuration options auto generated at ' . date('Y-m-d H:i:s') . ' for version ' . UTCW_VERSION . '*';