Cilex, a simple Command Line Interface framework
================================================

Cilex is a simple command line application framework to develop simple tools
based on [Symfony2][1] components:

```php
<?php
require_once __DIR__.'/cilex.phar';

$app = new \Cilex\Application('Cilex');
$app->command(new \Cilex\Command\GreetCommand());
$app->run();
```

Cilex works with PHP 5.3.2 or later and is heavily inspired on the [Silex][2]
web micro-framework by Fabien Potencier.

## Installation

 1. `git clone` _this_ repository.
 2. Download composer: `curl -s https://getcomposer.org/installer | php`
 3. Install Cilex' dependencies: `php composer.phar install`
 4. Create the phar: `php ./compile`

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

## FAQ

Q: How do I pass configuration into the application?

A: You can do this by adding the following line, where $configPath is the path to the configuration file you want to use:

```php
$app->register(new \Cilex\Provider\ConfigServiceProvider(), array('config.path' => $configPath));
```

The formats currently supported are: YAML, XML and JSON