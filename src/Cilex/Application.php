<?php

/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <mike.vanriel@naenius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cilex;

use Cilex\Provider\ConsoleServiceProvider;
use Cilex\Provider\DispatcherServiceProvider;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The Cilex framework class.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 *
 * @api
 */
class Application extends \Pimple\Container
{
    /**
     * @var ServiceProviderInterface[]
     */
    private $providers = array();

    /**
     * @var boolean
     */
    private $booted = false;

    /**
     * Registers the autoloader and necessary components.
     *
     * @param string      $name    Name for this application.
     * @param string|null $version Version number for this application.
     */
    public function __construct($name, $version = null, array $values = array())
    {
        parent::__construct($values);

        $this->register(new DispatcherServiceProvider);
        $this->register(new ConsoleServiceProvider, array(
            'console.name' => $name,
            'console.version' => $version,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function register(ServiceProviderInterface $provider, array $values = array())
    {
        parent::register($provider, $values);

        $this->providers[] = $provider;
    }

    /**
     * Boots the Application by calling boot on every provider added and then subscribe
     * in order to add listeners.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->booted) {
            $this->booted = true;

            foreach ($this->providers as $provider) {
                if ($provider instanceof BootableProviderInterface) {
                    $provider->boot($this);
                }

                if ($provider instanceof EventListenerProviderInterface) {
                    $provider->subscribe($this, $this['dispatcher']);
                }
            }
        }
    }

    /**
     * Executes this application.
     *
     * @param bool $interactive runs in an interactive shell if true.
     * @param InputInterface|null $input
     * @param OutputInterface|null $output
     * @return integer
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->boot();

        return $this['console']->run($input, $output);
    }

    /**
     * Adds a command object.
     *
     * If a command with the same name already exists, it will be overridden.
     *
     * @param Command $command A Command object
     * @api
     * @return void
     */
    public function add(Command $command)
    {
        $this['console']->add($command);
    }

    /**
     * @param string $name
     * @param callable $callable
     * @return Command
     */
    public function command($name, $callable)
    {
        $command = new Command($name);
        $command->setCode($callable);

        $this->add($command);

        return $command;
    }
}
