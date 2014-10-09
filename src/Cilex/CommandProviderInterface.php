<?php
/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <me@mikevanriel.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cilex;

use Pimple\Container;

interface CommandProviderInterface
{
    public function addCommands(Container $container);
} 