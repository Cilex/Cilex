Cilex, a simple Command Line Interface framework
================================================

Cilex is a simple command line application framework to develop simple tools
based on [Symfony2][1] components:

```php
<?php
require_once __DIR__.'/cilex.phar';

$app = new \Cilex\Application('Cilex');
$app->command(new \Cilex\Command\DemoGreetCommand());
$app->run();
```

Cilex works with PHP 5.3.2 or later and is heavily inspired on the [Silex][2]
web micro-framework by Fabien Potencier.

## Installation

Installing Cilex is as easy as it can get. Download the [`cilex.phar`][3] file
and you're done!

<!--
## More Information

Read the [documentation][4] for more information.
-->

## License

Cilex is licensed under the MIT license.

[1]: http://symfony.com
[2]: http://silex.sensiolabs.org
[3]: http://cilex.github.com/get/cilex.phar
[4]: http://cilex.github.com/documentation
