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

namespace Contracts;

/**
 * class Operators
 */
class Operators extends Predicates
{
    public function __construct()
    {
        parent::__construct($this);
        parent::setPredicateEvaluator(new PredicateEvaluator);
        parent::setSymbolManager(new SymbolManager);
    }

    public function andx()
    {
        $this->registerOperator("and_x");

        return $this;
    }

    public function and_x()
    {
        return "&&";
    }

    public function orx()
    {
        $this->registerOperator("or_x");

        return $this;
    }

    public function or_x()
    {
        return "||";
    }

    public function implies()
    {
        $this->registerOperator("implies_x");

        return $this;
    }

    public function implies_x()
    {
        return "->";
    }

    public function isEquivalentTo()
    {
        $this->registerOperator("equiv_x");

        return $this;
    }

    public function equiv_x()
    {        
        return "<=>";
    }
}
