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
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Registers EventDispatcher and related services with the Pimple Container
 *
 * @api
 */
class DispatcherServiceProvider implements \Pimple\ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $pimple)
    {
        $pimple['dispatcher'] = function () {
            return new EventDispatcher;
        };
    }
}
