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

use Contracts\Helpers\ResourceX;
use Contracts\Helpers\Let;

function test_resource_resourcex($symbol)
{
    $resourcex = new ResourceX;
    return $resourcex($symbol);
}

function test_resource_let($symbol)
{
    return new Let($symbol);
}

class ResourcePredicatesTest extends PHPUnit_Framework_TestCase
{
    public function testIsResource()
    {
        // We test that given true, isResource returns true
        test_resource_let('__resource__')->be(tmpfile());
        $predicate = test_resource_resourcex('__resource__')->isResource();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isResource returns true when the bound symbol is an resource.");

        // We test that given a different data type, isArray returns false
        test_resource_let('__resource__')->be(null);
        $predicate = test_resource_resourcex('__resource__')->isResource();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isResource returns false when the bound symbol is not an resource.");
    }
}
