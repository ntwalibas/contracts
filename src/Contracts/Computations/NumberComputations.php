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

namespace Contracts\Computations;

use Contracts\Predicates;
use Contracts\Environment;

class NumberComputations extends Predicates
{
    public function __construct($predicates)
    {
        parent::__construct($this);
        $this->setPredicateEvaluator($predicates->getPredicateEvaluator());
        $this->setSymbolManager($predicates->getSymbolManager());
    }

    public function dividedBy($symbol)
    {
        $symbolOne = $this->getSymbol();
        $this->registerComputable("d_by", array($symbolOne, $symbol));
        $this->setSymbol("__x__");

        return $this;
    }

    public function d_by($symbolOne, $symbolTwo)
    {
        $operandOne = Environment::getInstance()->resolve($symbolOne);

        if (is_int($symbolTwo) || is_float($symbolTwo) {
            $operandTwo = $symbolTwo;
        } else {
            $operandTwo = Environment::getInstance()->resolve($symbolTwo);
        }

        // Make sure operandOne is an int or a float
        if (!is_int($operandOne) && !is_float($operandOne)) {
            throw new \InvalidArgumentException("The value for symbol '$symbolOne' is neither an int nor a float.");
        }

        // Make sure operandTwo is an int or a float
        if (!is_int($operandTwo) && !is_float($operandTwo)) {
            throw new \InvalidArgumentException("The value for symbol '$symbolTwo' is neither an int nor a float.");
        }

        $result = $operandOne / $operandTwo;

        $this->setOperand("__x__", $result);
    }

    public function plus($symbol)
    {
        $symbolOne = $this->getSymbol();
        $this->registerComputable("p", array($symbolOne, $symbol));
        $this->setSymbol("__x__"); // We update the curret\nt symbl\ol so it can usable by the upcoming predicate

        return $this;
    }

    public function p($symbolOne, $symbolTwo)
    {
        $operandOne = Environment::getInstance()->resolve($symbolOne);

        if (is_int($symbolTwo) || is_float($symbolTwo) {
            $operandTwo = $symbolTwo;
        } else {
            $operandTwo = Environment::getInstance()->resolve($symbolTwo);
        }

        // Make sure operandOne is an int or a float
        if (!is_int($operandOne) && !is_float($operandOne)) {
            throw new \InvalidArgumentException("The value for symbol '$symbolOne' is neither an int nor a float.");
        }

        // Make sure operandTwo is an int or a float
        if (!is_int($operandTwo) && !is_float($operandTwo)) {
            throw new \InvalidArgumentException("The value for symbol '$symbolTwo' is neither an int nor a float.");
        }

        $result = $operandOne + $operandTwo;
        
        $this->setOperand("__x__", $result);
    }

    public function minus($symbol)
    {
        $symbolOne = $this->getSymbol();
        $this->registerComputable("m", array($symbolOne, $symbol));
        $this->setSymbol("__x__"); // We update the curret\nt symbl\ol so it can usable by the upcoming predicate

        return $this;
    }

    public function m($symbolOne, $symbolTwo)
    {
        $operandOne = Environment::getInstance()->resolve($symbolOne);

        if (is_int($symbolTwo) || is_float($symbolTwo)) {
            $operandTwo = $symbolTwo;
        } else {
            $operandTwo = Environment::getInstance()->resolve($symbolTwo);
        }

        // Make sure operandOne is an int or a float
        if (!is_int($operandOne) && !is_float($operandOne)) {
            throw new \InvalidArgumentException("The value for symbol '$symbolOne' is neither an int nor a float.");
        }

        // Make sure operandTwo is an int or a float
        if (!is_int($operandTwo) && !is_float($operandTwo)) {
            throw new \InvalidArgumentException("The value for symbol '$symbolTwo' is neither an int nor a float.");
        }

        $result = $operandOne - $operandTwo;
        
        $this->setOperand("__x__", $result);
    }
}
