# Creating your own Selection Strategy

As of version 2.6 you can create your own selection strategy. This is the part of the code where
the terms are fetched and returned for further processing. You can use this to provide the tag
cloud with whatever data you want.

The way to do it is to create your own class which extends the base class `UTCW_SelectionStrategy`:

````
<?php

class MyStrategy extends UTCW_SelectionStrategy {

    protected $plugin;

    public function __construct(UTCW_Plugin $plugin) {
        $this->plugin = $plugin;
    }

    public function getData() {

        // Return an array of objects with the keys:
        // term_id, name, slug, count, taxonomy

        $result = array();

        $foo = new stdClass;

        $foo->term_id = 1;
        $foo->name = 'test';
        $foo->slug = 'test';
        $foo->count = 4;
        $foo->taxonomy = '';

        $result[] = $foo;

        return $result;
    }

    public function cleanupForDebug() {
        // Remove sensitive data before debug output
    }
}
````

You can use `UTCW_QueryBuilder` class to create queries with the regular tag cloud constraints if you want.

To use your new class, use a short code with the name, or the PHP function with the name or an instance:

`[utcw strategy=MyStrategy]`

`<?php do_utcw(array('strategy' => 'MyStrategy')) ?>

`<?php do_utcw(array('strategy' => new MyStrategy()) ?>