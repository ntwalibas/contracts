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
 * Implements integer and flaot predicates
 */
class NumberPredicates extends Predicates
{
    public function __construct($predicates)
    {
        parent::__construct($this);
        $this->setPredicateEvaluator($predicates->getPredicateEvaluator());
        $this->setSymbolManager($predicates->getSymbolManager());
    }

    public function number($symbol)
    {
        $this->symbolManager->setSymbol($symbol);
        return $this;   
    }

    /**
     * IsNumber predicate
     */
    public function isNumber()
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("i_n", array($boundSymbol));

        return $this;
    }

    public function i_n($symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;

        if (is_int($operand) || is_float($operand)) {
            return true;
        }

        return false;
    }

    /**
     * IsInt predicate
     */
    public function isInt()
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("i_i", array($boundSymbol));

        return $this;
    }

    public function i_i($symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;

        if (is_int($operand)) {
            return true;
        }

        return false;
    }

    /**
     * IsFloat predicate
     */
    public function isFloat()
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("i_f", array($boundSymbol));

        return $this;
    }

    public function i_f($symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;

        if (is_float($operand)) {
            return true;
        }

        return false;
    }

    /**
     * Greater than predicate
     */
    public function greaterThan($constraint)
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("g_t", array($constraint, $boundSymbol));

        return $this;
    }

    public function g_t($constraint, $symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;
        $this->constraint = $constraint;

        // Make sure the constraint is an integer or a floating point number
        if (!is_int($constraint) && !is_float($constraint)) {
            throw new \InvalidArgumentException("The greaterThan operator expects the constraint to be an integer or float.");
        }

        if (!is_int($operand) && !is_float($operand)) {
            throw new \InvalidArgumentException("The greaterThan operator expects the operand to be an integer or float.");
        }

        // Run the predicate
        if ($operand > $constraint) {
            return true;
        }

        return false;
    }

    /**
     * Greater 0r equal predicate
     */
    public function greaterOrEqualTo($constraint)
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("g_o_t", array($constraint, $boundSymbol));

        return $this;
    }

    public function g_o_t($constraint, $symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;
        $this->constraint = $constraint;

        // Make sure the constraint is an integer or a floating point number
        if (!is_int($constraint) && !is_float($constraint)) {
            throw new \InvalidArgumentException("The greaterOrEqualTo operator expects the constraint to be an integer or float.");
        }

        if (!is_int($operand) && !is_float($operand)) {
            throw new \InvalidArgumentException("The greaterOrEqualTo operator expects the operand to be an integer or float.");
        }

        // Run the predicate
        if ($operand >= $constraint) {
            return true;
        }

        return false;
    }

    /**
     * Less than predicate
     */
    public function lessThan($constraint)
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("l_t", array($constraint, $boundSymbol));

        return $this;
    }

    public function l_t($constraint, $symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;
        $this->constraint = $constraint;

        // Make sure the constraint is an integer or a floating point number
        if (!is_int($constraint) && !is_float($constraint)) {
            throw new \InvalidArgumentException("The lesserThan operator expects the constraint to be an integer or float.");
        }

        if (!is_int($operand) && !is_float($operand)) {
            throw new \InvalidArgumentException("The lesserThan operator expects the operand to be an integer or float.");
        }

        // Run the predicate
        if ($operand < $constraint) {
            return true;
        }

        return false;
    }

    /**
     * Less or equal to predicate
     */
    public function lessOrEqualTo($constraint)
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("l_o_t", array($constraint, $boundSymbol));

        return $this;
    }

    public function l_o_t($constraint, $symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;
        $this->constraint = $constraint;

        // Make sure the constraint is an integer or a floating point number
        if (!is_int($constraint) && !is_float($constraint)) {
            throw new \InvalidArgumentException("The lessOrEqualTo operator expects the constraint to be an integer or float.");
        }

        if (!is_int($operand) && !is_float($operand)) {
            throw new \InvalidArgumentException("The lessOrEqualTo operator expects the operand to be an integer or float.");
        }

        // Run the predicate
        if ($operand <= $constraint) {
            return true;
        }

        return false;
    }

    /**
     * Equals predicate
     */
    public function equalTo($constraint)
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("eq_t", array($constraint, $boundSymbol));

        return $this;
    }

    public function eq_t($constraint, $symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;
        $this->constraint = $constraint;

        // Make sure the constraint is an integer or a floating point number
        if (!is_int($constraint) && !is_float($constraint)) {
            throw new \InvalidArgumentException("The equalTo operator expects the constraint to be an integer or float.");
        }

        if (!is_int($operand) && !is_float($operand)) {
            throw new \InvalidArgumentException("The equalTo operator expects the operand to be an integer or float.");
        }

        // Run the predicate
        if ($operand == $constraint) {
            return true;
        }

        return false;
    }

    /**
     * notEqualTo predicate
     */
    public function notEqualTo($constraint)
    {
        $boundSymbol = $this->getSymbol();
        $this->registerPredicate("n_eq_t", array($constraint, $boundSymbol));

        return $this;
    }

    public function n_eq_t($constraint, $symbol)
    {
        $operand = $this->getOperand($symbol);
        $this->lastOperand = $operand;
        $this->constraint = $constraint;
        
        // Make sure the constraint is an integer or a floating point number
        if (!is_int($constraint) && !is_float($constraint)) {
            throw new \InvalidArgumentException("The notEqualTo operator expects the constraint to be an integer or float.");
        }

        if (!is_int($operand) && !is_float($operand)) {
            throw new \InvalidArgumentException("The notEqualTo operator expects the operand to be an integer or float.");
        }

        // Run the predicate
        if ($operand != $constraint) {
            return true;
        }

        return false;
    }
}
