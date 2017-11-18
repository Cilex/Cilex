<?php

/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <mike.vanriel@naenius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cilex\Tests;

use Cilex\Application;
use Cilex\Command\GreetCommand;
use PHPUnit\Framework\TestCase;

/**
 * Application test cases.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class ApplicationTest extends TestCase
{
    const NAME    = 'Test';
    const VERSION = '1.0.1';

    /** @var  Application */
    private $app;

    /**
     * Sets up the test app.
     */
    public function setUp()
    {
        $this->app = new Application(self::NAME, self::VERSION);
    }

    /**
     * Tests whether the constructor instantiates the correct dependencies and
     * correctly sets the name on the Console's Application.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf('Symfony\Component\Console\Application', $this->app['console']);

        $this->assertEquals(self::NAME, $this->app['console']->getName());
        $this->assertEquals(self::VERSION, $this->app['console']->getVersion());
    }

    public function testCustomInputOutput()
    {
        $input = $this->createMock('Symfony\Component\Console\Input\InputInterface');
        $output = $this->createMock('Symfony\Component\Console\Output\OutputInterface');

        $this->app['console'] = $this->createMock('Symfony\Component\Console\Application');
        $this->app['console']->expects($this->once())->method('run')->with($input, $output);


        $this->app->run($input, $output);

    }

    public function testClosureCommand()
    {
        $invoked = false;
        $command = $this->app->command('closure-command', function () use (&$invoked) {
            $invoked = true;
        });

        $this->assertInstanceOf('Symfony\Component\Console\Command\Command', $command);
        $this->assertTrue($this->app['console']->has('closure-command'));

        $command->run(
            $this->createMock('Symfony\Component\Console\Input\InputInterface'),
            $this->createMock('Symfony\Component\Console\Output\OutputInterface')
        );

        $this->assertTrue($invoked);
    }

    /**
     * Tests the command method to see if the command is properly set and the
     * Cilex application is added as container.
     */
    public function testCommand()
    {
        $this->assertFalse($this->app['console']->has('demo:greet'));

        $this->app->command(new GreetCommand());

        $this->assertTrue($this->app['console']->has('demo:greet'));

        $this->assertSame($this->app, $this->app['console']->get('demo:greet')->getContainer());
    }

    /**
     * Returns a test double for the specified class.
     *
     * This method ensures compatibility with PHPUnit 4 and can be removed as soon as PHPUnit 4 is not used anymore.
     *
     * @param string $originalClassName
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMock($originalClassName)
    {
        return $this->getMockBuilder($originalClassName)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->getMock();
    }
}
