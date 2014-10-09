<?php

/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <mike.vanriel@naenius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cilex\Tests\Command;

use Cilex\Command;
use Cilex\Application;

class CommandMock extends \Cilex\Provider\Console\Command {}

/**
 * Command\Command test cases.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Cilex\Command\Command */
    protected $fixture = null;

    /**
     * Sets up the test fixture.
     */
    public function setUp()
    {
        $this->fixture = new CommandMock('demo:test');
    }

    /**
     * Tests the getContainer method.
     */
    public function testContainer()
    {
        $app = new Application('Test');
        $app->command($this->fixture);

        $this->assertSame($app, $this->fixture->getContainer());
    }

    /**
     * Tests whether the getService method correctly retrieves an element from
     * the container.
     */
    public function testGetService()
    {
        $app = new Application('Test');
        $app->command($this->fixture);

        $this->assertInstanceOf('Symfony\Component\Console\Application', $this->fixture->getService('console'));
    }
}
