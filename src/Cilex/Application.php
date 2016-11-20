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
use Pimple\Container;
use Pimple\ServiceProviderInterface;
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
class Application extends Container
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
     * @param array       $values
     */
    public function __construct($name, $version = null, array $values = array())
    {
        parent::__construct($values);

        $this->register(new DispatcherServiceProvider);
        $this->register(
            new ConsoleServiceProvider,
            array(
                'console.name'    => $name,
                'console.version' => $version,
            )
        );
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
        if ($this->booted) {
            return;
        }

        $this->booted = true;

        foreach ($this->providers as $provider) {
            if ($provider instanceof EventListenerProviderInterface) {
                $provider->subscribe($this, $this['dispatcher']);
            }
        }
    }

    /**
     * Executes this application.
     *
     * @param InputInterface|null  $input
     * @param OutputInterface|null $output
     *
     * @return integer
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->boot();

        return $this['console']->run($input, $output);
    }

    /**
     * Allows you to add a command as Command object or as a command name+callable
     *
     * @param string|Command $nameOrCommand
     * @param callable|null $callable Must be a callable if $nameOrCommand is the command's name
     * @return Command The command instance that you can further configure
     * @api
     */
    public function command($nameOrCommand, $callable = null)
    {
        if ($nameOrCommand instanceof Command) {
            $command = $nameOrCommand;
        } else {
            if (!is_callable($callable)) {
                throw new \InvalidArgumentException('$callable must be a valid callable with the command\'s code');
            }

            $command = new Command($nameOrCommand);
            $command->setCode($callable);
        }

        $this['console']->add($command);

        return $command;
    }
}
