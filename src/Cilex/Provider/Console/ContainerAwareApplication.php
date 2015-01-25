<?php

/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <mike.vanriel@naenius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cilex\Provider\Console;

use Pimple\Container;
use Symfony\Component\Console\Application;

/**
 * Cilex Pimple Console Application
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ContainerAwareApplication extends Application
{
    private $pimple;

    /**
     * Constructor
     *
     * @param string $name    The name of the application
     * @param string $version The version of the application
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);
    }

    /**
     * Sets a pimple instance onto this application.
     *
     * @param Container $pimple
     *
     * @return void
     */
    public function setContainer(Container $pimple)
    {
        $this->pimple = $pimple;
    }

    /**
     * Get the Container.
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->pimple;
    }

    /**
     * Returns a service contained in the application pimple or null if none is found with that name.
     *
     * This is a convenience method used to retrieve an element from the Application pimple without having to assign
     * the results of the getContainer() method in every call.
     *
     * @param string $name Name of the service.
     *
     * @see self::getContainer()
     *
     * @api
     *
     * @return mixed|null
     */
    public function getService($name)
    {
        return $this->pimple[$name];
    }
}
