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

use Contracts\Helpers\StringX;
use Contracts\Helpers\Let;

function test_string_stringx($symbol)
{
    $stringx = new StringX;
    return $stringx($symbol);
}

function test_string_let($symbol)
{
    return new Let($symbol);
}

class StringPredicatesTest extends PHPUnit_Framework_TestCase
{
    public function testIsString()
    {
        // We test that given a string, isString returns true
        test_string_let('__string__')->be("String");
        $predicate = test_string_stringx('__string__')->isString();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isString returns true when the bound symbol is an string.");

        // We test that given a different data type, isArray returns false
        test_string_let('__string__')->be(null);
        $predicate = test_string_stringx('__string__')->isString();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isString returns false when the bound symbol is not an string.");
    }
}
