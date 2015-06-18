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

use Contracts\Predicates\ArrayPredicates;

use Contracts\Helpers\ArrayX;
use Contracts\Helpers\Let;

function test_array_arrayx($symbol)
{
    $arrayx = new ArrayX();
    return $arrayx($symbol);
}

function test_array_let($symbol)
{
    return new Let($symbol);
}

class ArrayPredicatesTest extends PHPUnit_Framework_TestCase
{
    public function testIsArray()
    {
        // We test that given an array, isArray returns true
        test_array_let('__array__')->be([1, 2]);
        $predicate = test_array_arrayx('__array__')->isArray();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isArray returns true when the bound symbol is an array.");

        // We test that given a different data type, isArray returns false
        test_array_let('__array__')->be(null);
        $predicate = test_array_arrayx('__array__')->isArray();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isArray returns false when the bound symbol is not an array.");
    }
}
