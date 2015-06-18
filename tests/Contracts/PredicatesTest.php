<?php
/**
 * Contracts libray - a design by contracts library
 *
 * @author      Ntwali Bashige <ntwali.bashige@gmail.com>
 * @copyright   2015 Ntwali Bashige
 * @link        http://www.ntwalibas.me/contracts
 * @license     http://www.ntwalibas.me/contracts/license
 * @version     0.1.0
 *
 * MIT LICENSE
 */

use Contracts\Predicates;

/**
 * The Predicates abstract class is mostly made of getters and setters
 * For the moment, we shall focus on testing its __call method
 * TODO: Other methods do warrant testing - mainly integration tests but we reserve those tests for later
 */
class PredicatesTest extends PHPUnit_Framework_TestCase
{
    protected $mockPredicates;

    public function setUp()
    {
        $this->mockPredicates = new MockPredicates;
    }

    public function testConstructor()
    {
        $this->assertTrue($this->mockPredicates instanceof Predicates, "Failed to assert that the mock predicates successfuly inherit from the Predicates class.");
    }

    public function testCall()
    {
        $secondMockPredicates = new SecondMockPredicates($this->mockPredicates);

        $this->assertTrue($secondMockPredicates->mockMethod(), "Failed to call the mockMethod on a  registered predicates.");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCallException()
    {
        $secondMockPredicates = new SecondMockPredicates($this->mockPredicates);

        $this->assertTrue($secondMockPredicates->badMockMethod(), "Failed to throw an exception given an inexistent method.");
    }
}

class MockPredicates extends Predicates
{
    public function __construct()
    {
        parent::__construct($this);
    }

    public function mockMethod()
    {
        return true;
    }
}

class SecondMockPredicates extends Predicates
{
    public function __construct($predicatesDecorator)
    {
        parent::__construct($this);
    }
}
