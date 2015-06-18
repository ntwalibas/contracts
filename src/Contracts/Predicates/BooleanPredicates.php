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
        $this->registerPredicate("i_b", array($boundSymbol));

        return $this;
    }

    public function i_b($symbol)
    {
        $operand = $this->getOperand($symbol);

        if (is_bool($operand)) {
            return true;
        }

        return false;
    }
}
