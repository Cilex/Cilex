#!/usr/bin/env php
<?php
if (!$loader = include __DIR__ . '/../vendor/autoload.php')
{
    die('You must set up the project dependencies.');
}
$app = new \Cilex\Application('Cilex');
$app->command(new \Cilex\Command\GreetCommand());
$app->command(new \Cilex\Command\DemoInfoCommand());
$app->run();
