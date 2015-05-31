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

abstract class Predicates
{
    protected $predicateEvaluator = null;
    protected $symbolManager = null;

    protected $constraint = null;
    protected $lastOperand = null;

    protected static $predicates = array();

    public function __construct($predicates)
    {
        self::$predicates[] = $predicates;
    }

    public function setPredicateEvaluator($predicateEvaluator)
    {
        $this->predicateEvaluator = $predicateEvaluator;        
    }

    public function getPredicateEvaluator()
    {
        return $this->predicateEvaluator;
    }

    public function setSymbolManager($symbolManager)
    {
        $this->symbolManager = $symbolManager;
    }

    public function getSymbolManager()
    {
        return $this->symbolManager;
    }

    public function setOperand($symbol, $value)
    {
        Environment::getInstance()->attach($symbol, $value);
    }

    public function getOperand($symbol)
    {
        return Environment::getInstance()->resolve($symbol);
    }

    public function setSymbol($symbol)
    {
        $this->symbolManager->setSymbol($symbol);
    }

    public function getSymbol()
    {
        return $this->symbolManager->getSymbol();
    }

    public function evaluate()
    {
        return $this->predicateEvaluator->evaluate($this);
    }

    public function registerPredicate($predicate, $args)
    {
        $this->predicateEvaluator->registerPredicate($predicate, $args);
    }

    public function registerOperator($operator)
    {
        $this->predicateEvaluator->registerOperator($operator);
    }

    public function registerComputable($computable, $args)
    {
        $this->predicateEvaluator->registerComputable($computable, $args);
    }

    public function varx($symbol)
    {
        $this->symbolManager->setSymbol($symbol);
        return $this;   
    }

    public function constx($value)
    {
        $symbol = "__?__";
        $this->symbolManager->setSymbol($symbol);
        Environment::getInstance()->attach($symbol, $value);

        return $this;
    }

    public function setConstraint($constraint)
    {
        $this->constraint = $constraint;
    }

    public function getConstraint()
    {
        return $this->constraint;
    }

    public function setLastOperand($operand)
    {
        $this->lastOperand = $operand;
    }

    public function getLastOperand()
    {
        return $this->lastOperand;
    }

    public function __call($method, $parameters)
    {
        $returnValue = null;
        $length = count(self::$predicates) - 1;

        for ($i = 0, $j = $length; $j >= $i; $j--) {
            if (method_exists(self::$predicates[$j], $method) == true) {
                return call_user_func_array(array(self::$predicates[$j], $method), $parameters);
                break;
            }
        }
        
        throw new \Exception("Method '$method' not found on all registered predicate sets.");        
    }
}
