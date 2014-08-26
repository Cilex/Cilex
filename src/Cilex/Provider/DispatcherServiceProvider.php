<?php

namespace Cilex\Provider;

use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;

class DispatcherServiceProvider implements \Pimple\ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['dispatcher'] = function () {
            return new EventDispatcher;
        };
    }
}
