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

chdir('..');

require 'dist/ultimate-tag-cloud-widget.php';

class DocumentationGenerator
{
    protected $configurationObjects;
    protected $version;

    public function __construct($configurationObjects, $version)
    {
        $this->configurationObjects = $configurationObjects;
        $this->version              = $version;
    }

    protected function keyToName($key)
    {
        $name = str_replace('_', ' ', $key);

        return ucfirst($name);
    }

    protected function typeName($type)
    {
        return str_replace(array('UTCW_', 'Type'), array('', ''), $type);
    }

    protected function defaultDescription($defaultValue)
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

    protected function replaceDescription($matches)
    {
        $link = str_replace('_', '-', $matches[1]);
        $text = $matches[2];

        return sprintf('[%s](#%s)', $text, $link);
    }

    protected function parseDescription($description)
    {
        $description = trim($description);
        $description = preg_replace_callback(
            '/{@link \$?([^ ]+) ([^}]+)}/',
            array($this, 'replaceDescription'),
            $description
        );
        return $description;
    }

    protected function getDocumentationForConfig($config)
    {

        $configReflection = new ReflectionObject($config);
        $comment          = $configReflection->getDocComment();
        $descriptions     = array();

        preg_match_all('/^\s?\*\s?@property-read\s+[a-z]+\s+([a-z_]+)\s+(.+)/m', $comment, $matches);

        foreach ($matches[0] as $index => $match) {
            $propertyName                = $matches[1][$index];
            $description                 = $matches[2][$index];
            $descriptions[$propertyName] = $this->parseDescription($description);
        }

        $configOptionsProperty = $configReflection->getProperty('options');
        $configOptionsProperty->setAccessible(true);

        /** @var UTCW_Type[] $options */
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

            $result[] = sprintf('## %s ##', $this->keyToName($optionName));
            $result[] = sprintf('Description: %s  ', $descriptions[$optionName]);
            $result[] = sprintf('Type: %s  ', $this->typeName(get_class($option)));
            $result[] = sprintf('Name: `%s`  ', $optionName);
            $result[] = sprintf('Default: %s  ', $this->defaultDescription($option->getDefaultValue()));
            $result[] = sprintf(
                'Shortcode example: `[utcw %s=%s]` ',
                $optionName,
                $this->generateExample($option, $options)
            );

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

    protected function generateExample(UTCW_Type $option, array $options)
    {
        $type            = $this->typeName(get_class($option));
        $typeReflection  = new ReflectionObject($option);
        $optionsProperty = $typeReflection->getProperty('options');

        $optionsProperty->setAccessible(true);
        $options = $optionsProperty->getValue($option);

        switch ($type) {
            case 'Set':
                $values = $options['values'];
                return $values[count($values) - 1];

            case 'Color':
                return '"#bada55"';

            case 'Array':
                $typeProperty = $typeReflection->getProperty('type');
                $typeProperty->setAccessible(true);
                $itemType     = $typeProperty->getValue($option);
                $itemTypeName = $this->typeName(get_class($itemType));

                switch ($itemTypeName) {
                    case 'Color':
                        return '"#fff,#000,#bada55"';
                    case 'Set':
                        return '"foo,bar,baz"';
                    case 'Integer':
                        return '"1,2,3"';

                    default:
                        die('Unknown item type: ' . $itemTypeName);
                }

                break;

            case 'Integer':
                return 10;

            case 'Measurement':
                return '"10px"';

            case 'Boolean':
                return $option->getDefaultValue() ? 0 : 1;

            case 'String':
                return '"foo"';


            default:
                die('Unknown type: ' . $type);
        }
    }

    public function getDocumentation()
    {
        $documentation = [];

        foreach ($this->configurationObjects as $configurationObject) {
            $documentation = array_merge($documentation, $this->getDocumentationForConfig($configurationObject));
        }

        $result = join("\n", $documentation);

        $result .= "\n";
        $result .= '*Configuration options auto generated at ' . date(
                'Y-m-d H:i:s'
            ) . ' for version ' . $this->version . '*';

        return $result;
    }
}

$objects = [
    new UTCW_DataConfig(array(), UTCW_Plugin::getInstance()),
    new UTCW_RenderConfig(array(), UTCW_Plugin::getInstance()),
];

$generator = new DocumentationGenerator($objects, UTCW_VERSION);

echo $generator->getDocumentation();

