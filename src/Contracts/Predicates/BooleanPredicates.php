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

namespace Contracts\Predicates;

use Contracts\Predicates;
use Contracts\Environment;
use Contracts\PredicateEvaluator;

/**
 * Implements Boolean predicates
 */
class BooleanPredicates extends Predicates
{
    public function __construct($predicates)
    {
        parent::__construct($this);
        $this->setPredicateEvaluator($predicates->getPredicateEvaluator());
        $this->setSymbolManager($predicates->getSymbolManager());
    }

    public function boolx($symbol)
    {
        $this->symbolManager->setSymbol($symbol);
        return $this;   
    }

    /**
     * IsBool predicate
     */
    public function isBool()
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("i_bool", array($boundSymbol));

        return $this;
    }

    public function i_bool($symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;

        if (is_bool($operand)) {
            return true;
        }

        return false;
    }

    /**
     * IsTrue predicate
     */
    public function isTrue()
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("i_true", array($boundSymbol));

        return $this;
    }

    public function i_true($symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;

        if ($operand === true) {
            return true;
        }

        return false;
    }

    /**
     * IsFalse predicate
     */
    public function isFalse()
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("i_false", array($boundSymbol));

        return $this;
    }

    public function i_false($symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;

        if ($operand === false) {
            return true;
        }

        return false;
    }
}
