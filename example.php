<?php
require_once __DIR__ . '/cilex.phar';

$app = new \Cilex\Application('Cilex');
$app->command(new \Cilex\Command\GreetCommand());
$app->run();