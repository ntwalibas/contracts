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

use Contracts\PredicateEvaluator;
use Contracts\Helpers\Number;
use Contracts\Helpers\Let;

function number($symbol)
{
    $number = new Number;
    return $number($symbol);
}

function let($symbol)
{
    return new Let($symbol);
}

class PredicateEvalutatorTest extends PHPUnit_Framework_TestCase
{
    protected $predicateEvaluator;

    public function setUp()
    {
        $this->predicateEvaluator = new PredicateEvaluator;
    }

    public function testRegisterPredicate()
    {
        $this->predicateEvaluator->registerPredicate('predicate', array('__x__'));

        $this->assertEquals($this->predicateEvaluator->predicatesCount(), 1, "Failed to assert that after registering one predicate, the predicates count increased by one.");
    }

    public function testRegisterOperator()
    {
        $this->predicateEvaluator->registerOperator('operator');

        $this->assertEquals($this->predicateEvaluator->operatorsCount(), 1, "Failed to assert that after registering one operator, the operators count increased by one.");
    }

    public function testRegisterComputable()
    {
        $this->predicateEvaluator->registerComputable('computable', array('__x__', '__y__'));

        $this->assertEquals($this->predicateEvaluator->computablesCount(), 1, "Failed to assert that after registering one computable, the computables count increased by one.");
    }    

    /**
     * Testing evaluate is a bit more involved
     * 1. First, we test that a single predicates succeeds
     * 2. Next to test that operators work as expected
     * 3. Last we test that computations also work as expected
     */
    public function testEvaluate()
    {
        let('x')->be(14);
        $predicate = number('x')->greaterThan(13);

        // Assert that one predicates works as expected
        $this->assertTrue($predicate->evaluate(), "Failed to assert that given one predicate, the evaluation succeeds.");

        // Asert that operator chaining works as expected
        $predicate = number('x')->greaterThan(13)->andx()->lessThan(15);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that operator chaining works as expected when simplify operator chaining.");

        $predicate = number('x')->greaterThan(13)->andx()->number('x')->lessThan(15);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that operator chaining works as expected.");

        // Assert that number computations work as expected
        let('y')->be(2);
        $predicate = number('x')->plus('y')->equalTo(16);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that computations work as expected.");
    }

    /**
     * 1. First we test that given an operator alone, the evaluation must fail
     * 2. Next we test that given a computable only, the evaluation must fail
     * 3. Next we test that given a malformed expression, as in two or more operators chained immediately, the evaluation fails
     */
    /**
     * @expectedException Exception
     */
    public function testEvaluateOperatorOnlyException()
    {
        let('x')->be(14);
        $predicate = number('x')->andx();

        $this->assertTrue($predicate->evaluate(), "Failed to throw an exception when only an operator was given.");
    }

    /**
     * @expectedException Exception
     */
    public function testEvaluateComputableOnlyException()
    {
        let('x')->be(14);
        $predicate = number('x')->plus('x');

        $this->assertTrue($predicate->evaluate(), "Failed to throw an exception when only a computable was given.");
    }

    /**
     * @expectedException Exception
     */
    public function testEvaluateMalformedException()
    {
        let('x')->be(14);
        $predicate = number('x')->greaterThan(12)->andx()->orx()->lessThan(16);

        $this->assertTrue($predicate->evaluate(), "Failed to throw an exception when passed a malformed expression.");
    }
}
