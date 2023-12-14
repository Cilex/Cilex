<?php

use Rector\Config\RectorConfig;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Set\ValueObject\LevelSetList;

require_once __DIR__ . '/vendor/autoload.php';

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->autoloadPaths(['./vendor']);

    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ]);

    $rectorConfig->skip([
        JsonThrowOnErrorRector::class,
        StaticCallOnNonStaticToInstanceCallRector::class
    ]);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_73
    ]);
};

