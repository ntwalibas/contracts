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
 * Implements String predicates
 */
class StringPredicates extends Predicates
{
    public function __construct($predicates)
    {
        parent::__construct($this);
        $this->setPredicateEvaluator($predicates->getPredicateEvaluator());
        $this->setSymbolManager($predicates->getSymbolManager());
    }

    public function stringx($symbol)
    {
        $this->symbolManager->setSymbol($symbol);
        return $this;   
    }

    /**
     * IsString predicate
     */
    public function isString()
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("i_s", array($boundSymbol));

        return $this;
    }

    public function i_s($symbol)
    {
        $operand = $this->getOperand($symbol);

        if (is_string($operand)) {
            return true;
        }

        return false;
    }
}
