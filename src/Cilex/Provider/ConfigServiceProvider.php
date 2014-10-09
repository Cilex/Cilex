<?php
/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <me@mikevanriel.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cilex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Yaml;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['config'] = function () use ($app) {
            if (!file_exists($app['config.path'])) {
                throw new \InvalidArgumentException(
                    $app['config.path'] . ' is not a valid path to the '
                    .'configuration'
                );
            }

            $fullpath = explode('.', $app['config.path']);

            switch (strtolower(end($fullpath))) {
                case 'php':
                    $result = include($app['config.path']);
                    break;
                case 'yml':
                    $parser = new Yaml\Parser();
                    $result = new \ArrayObject(
                        $parser->parse(file_get_contents($app['config.path']))
                    );
                    break;
                case 'xml':
                    $result = simplexml_load_file($app['config.path']);
                    break;
                case 'json':
                    $result = json_decode(file_get_contents($app['config.path']));

                    if (null == $result) {

                        throw new \InvalidArgumentException(
                            'Unable to decode the configuration file: ' . $app['config.path']
                        );
                    }
                    break;
                default:
                    throw new \InvalidArgumentException(
                        'Unable to load configuration; the provided file extension was not recognized. '
                        .'Only yml, xml or json allowed'
                    );
                    break;
            }

            return $result;
        };
    }
}
