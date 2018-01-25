#!/usr/bin/env php
<?php

if (!$loader = include __DIR__ . '/../vendor/autoload.php') {
    die('You must set up the project dependencies.');
}

$app = new \Cilex\Application('Cilex');

foreach (glob(__DIR__ .'/../src/Cilex/Command/*.php') as $commandFile) {
    $i = pathinfo($commandFile);
    $className = $i['filename'];
    $className = '\Cilex\Command\\' . $className;
    $app->command(new $className());
}

$app->run();
