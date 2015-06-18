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

use Contracts\Helpers\Boolean;
use Contracts\Helpers\Let;

function test_bool_boolx($symbol)
{
    $boolx = new Boolean;
    return $boolx($symbol);
}

function test_bool_let($symbol)
{
    return new Let($symbol);
}

class BooleanPredicatesTest extends PHPUnit_Framework_TestCase
{
    public function testIsBool()
    {
        // We test that given true, isBool returns true
        test_bool_let('__bool__')->be(true);
        $predicate = test_bool_boolx('__bool__')->isBool();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isBool returns true when the bound symbol is true.");

        // We test that given false, isBool returns false
        test_bool_let('__bool__')->be(false);
        $predicate = test_bool_boolx('__bool__')->isBool();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isBool returns true when the bound symbol is false.");

        // We test that given a different data type, isArray returns false
        test_bool_let('__bool__')->be(null);
        $predicate = test_bool_boolx('__bool__')->isBool();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isBool returns false when the bound symbol is not a boolean.");
    }
}
