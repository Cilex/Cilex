<?php

/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <mike.vanriel@naenius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cilex\Provider;

use Pimple\Container;
use Cilex\Provider\Console\ContainerAwareApplication;

/**
 * Cilex Console Service Provider
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ConsoleServiceProvider implements \Pimple\ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['console'] = function($pimple) {
            $console = new ContainerAwareApplication($pimple['console.name'], $pimple['console.version']);
            $console->setDispatcher($pimple['dispatcher']);
            $console->setContainer($pimple);

            return $console;
        };
    }
}
