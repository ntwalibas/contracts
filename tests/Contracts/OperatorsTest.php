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

use Contracts\Operators;

class OperatorsTest extends PHPUnit_Framework_TestCase
{
    private $operators;
    private $predicateEvaluator;

    public function setUp()
    {
        $this->operators = new Operators;
        $this->predicateEvaluator = $this->operators->getPredicateEvaluator();
    }

    public function testAndx()
    {
        $this->operators->andx();

        $this->assertEquals($this->predicateEvaluator->operatorsCount(), 1, "Failed to assert that upon adding the 'andx' operator, it was successfully registered with the predicate evaluator.");
    }

    public function testOrx()
    {
        $this->operators->orx();

        $this->assertEquals($this->predicateEvaluator->operatorsCount(), 1, "Failed to assert that upon adding the 'orx' operator, it was successfully registered with the predicate evaluator.");
    }

    public function testImplies()
    {
        $this->operators->implies();

        $this->assertEquals($this->predicateEvaluator->operatorsCount(), 1, "Failed to assert that upon adding the 'implies' operator, it was successfully registered with the predicate evaluator.");
    }

    public function testIsEquivalentTo()
    {
        $this->operators->isEquivalentTo();

        $this->assertEquals($this->predicateEvaluator->operatorsCount(), 1, "Failed to assert that upon adding 'isEquivalentTo' operator, it was successfully registered with the predicate evaluator.");
    }
}
