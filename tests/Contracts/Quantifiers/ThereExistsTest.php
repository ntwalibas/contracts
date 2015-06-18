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

use Contracts\Quantifiers\ThereExists;
use Contracts\Helpers\Number;
use Contracts\Helpers\Let;

function test_thereexists_numberx($symbol)
{
    $numberx = new Number;
    return $numberx($symbol);
}

function test_thereexists_let($symbol)
{
    return new Let($symbol);
}

function thereExists($symbol)
{
    return new ThereExists($symbol);
}

class ThereExistsTest extends PHPUnit_Framework_TestCase
{
    public function testIn()
    {
        $traversable = array(1, 2, 3, 4, 5, 6, 7);
        $thereExists = thereExists('number')->in($traversable);

        $this->assertSame($thereExists->getTraversable(), $traversable, "Failed to assert that the registered traverable is the same as the original.");
        // TODO: Pass an object that implements the Traversal interface for a complete test
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInBadTraversableException()
    {
        $traversable = null;
        $thereExists = thereExists('number')->in($traversable);

        $this->assertSame($thereExists->getTraversable(), $traversable, "Failed to throw an exception when a non-traversable was passed.");
    }

    /**
     * @expectedException Exception
     */
    public function testInEmptyTraversablException()
    {
        $traversable = [];
        $thereExists = thereExists('number')->in($traversable);

        $this->assertSame($thereExists->getTraversable(), $traversable, "Failed to throw an exception when an empty traversable was passed.");
    }

    /**
     * Testing suchThat that is a bit more involved.
     * We shall start by testing its core logic
     */
    public function testSuchThat()
    {
        $traversable = array(1, 2, 3, 4, 5, 6, 7);

        // First we test for good input
        $thereExists = thereExists('number')->in($traversable)->suchThat(
            test_thereexists_numberx('number')->greaterThan(0)
        );
        $this->assertTrue($thereExists->evaluate(), "Failed to assert that all the numbers in the traversable are greater than 0 when that must be the case.");

        // Then we test for bad input
        $thereExists = thereExists('number')->in($traversable)->suchThat(
            test_thereexists_numberx('number')->greaterThan(9)
        );
        $this->assertFalse($thereExists->evaluate(), "Failed to assert that not all the numbers are strictly greater than 1.");
    }
}
