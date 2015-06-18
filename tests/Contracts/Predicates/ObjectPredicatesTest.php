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

use Contracts\Helpers\ObjectX;
use Contracts\Helpers\Let;

function test_object_objectx($symbol)
{
    $objectx = new ObjectX;
    return $objectx($symbol);
}

function test_object_let($symbol)
{
    return new Let($symbol);
}

class ObjectPredicatesTest extends PHPUnit_Framework_TestCase
{
    public function testIsObject()
    {
        // We test that given an object, isObject returns true
        test_object_let('__object__')->be(new StdClass);
        $predicate = test_object_objectx('__object__')->isObject();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isObject returns true when the bound symbol is an object.");

        // We test that given a different data type, isObject returns false
        test_object_let('__object__')->be(null);
        $predicate = test_object_objectx('__object__')->isObject();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isObject returns false when the bound symbol is not an object.");
    }
}
