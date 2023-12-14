Cilex, a simple Command Line Interface framework
================================================
This project is a fork of the existing Cilex project, and aims to add support for PHP 7 & later Symfony versions.

Cilex is a simple command line application framework to develop simple tools
based on [Symfony2][1] components:

```php
<?php
if (!$loader = include __DIR__.'/vendor/autoload.php') {
    die('You must set up the project dependencies.');
}

$app = new \Cilex\Application('Cilex');
$app->command(new \Cilex\Command\GreetCommand());
$app->command('foo', function ($input, $output) {
    $output->writeln('Example output');
});
$app->run();
```

Cilex works with PHP 7.3 or later and is heavily inspired by the [Silex][2]
web micro-framework by Fabien Potencier.

## Installation

 1. `git clone` _this_ repository.
 2. Download composer: `curl -s https://getcomposer.org/installer | php`
 3. Install Cilex' dependencies: `php composer.phar install`

<!--
## More Information

Read the [documentation][4] for more information.
-->

## Usage

 - Create your new commands in `src/Cilex/Command/`
 - Add your new commands to `bin/run.php`
 - Run the commands as:
```sh
./bin/run.php demo:greet world
./bin/run.php demo:greet world -y
./bin/run.php demo:greet world --yell
./bin/run.php demo:info
```

## Creating a PHAR

 - Download and install [box][5]:
```sh
curl -LSs https://box-project.github.io/box2/installer.php | php
chmod +x box.phar
mv box.phar /usr/local/bin/box
```
 - Update the project phar config in box.json
 - Create the package:
```sh
box build
```
 - Run the commands:
```sh
./cilex.phar demo:greet world
./cilex.phar demo:greet world -y
./cilex.phar demo:greet world --yell
./cilex.phar demo:info
```
 - enjoy a lot.

## License

Cilex is licensed under the MIT license.

[1]: http://symfony.com
[2]: http://silex.sensiolabs.org
[3]: http://cilex.github.com/get/cilex.phar
[4]: http://cilex.github.com/documentation
[5]: https://box-project.github.io/box2/

## FAQ

Q: How do I pass configuration into the application?

A: You can do this by adding the following line, where $configPath is the path to the configuration file you want to use:

```php
$app->register(new \Cilex\Provider\ConfigServiceProvider(), array('config.path' => $configPath));
```

The formats currently supported are: YAML, XML and JSON
