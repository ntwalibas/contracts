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

namespace Contracts\Quantifiers;

use Contracts\Predicates;
use Contracts\Environment;
use Contracts\Predicates\PredicateException;

class ForAll implements Quantifier
{
    public $symbol;
    public $environment;
    public $traversable;
    private $traversableCount = 0;

    private $forAll;

    public function __construct($symbol = null)
    {
        $this->symbol = $symbol;
        $this->environment = Environment::getInstance();
        $this->traversable = null;
        $this->forAll = null;
    }

    public function __invoke($symbol)
    {
        $this->symbol = $symbol;
    }

    public function in($traversable)
    {
        // Ensure we have an traversable
        if (!is_array($traversable) && !($traversable instanceof \Traversable) ) {
            throw new \InvalidArgumentException("The argument passed to 'in' must be an traversable.");
        }

        // Make sure the traversable is not empty
        if (is_array($traversable)) {
            $this->traversableCount = count($traversable);
        } elseif ($traversable instanceof \Traversable) {
            $this->traversableCount = iterator_count($traversable);
        }
        if ($this->traversableCount == 0) {
            throw new \Exception("The traversable provided cannot be empty.");
        }

        $this->traversable = $traversable;

        return $this;
    }

    public function getTraversable()
    {
        return $this->traversable;
    }

    public function itHoldsThat($predicates)
    {
        $that = $this;

        $forAll = function() use ($that, $predicates) {
            // Make sure we have a symbol to work on
            if (is_null($that->symbol)) {
                throw new \Exception("No symbol has been provided. Please provide one using the constructor.");
            }

            // Make sure the traversable is not empty
            if ($this->traversableCount == 0) {
                throw new \Exception("The traversable provided cannot be empty. Please provide one using the 'in' method");
            }

            foreach ($that->traversable as $value) {
                $that->environment->attach($that->symbol, $value);

                // if we have a predicate set
                if ($predicates instanceof Predicates || $predicates instanceof Quantifier) {
                    try {
                        $constraint = $predicates->evaluate($predicates);
                    } catch(\Exception $exception) {
                        $predicateException = new PredicateException($exception->getMessage());
                        $predicateException->setPredicate($predicates);

                        throw $predicateException;
                    }
                } else {
                    throw new \InvalidArgumentException("The value passed to 'itHoldsThat' must either be a predicate set or a quantifier.");
                }

                if ($constraint == false) {
                    $result = false;
                    break;
                } else {
                    $result = true;
                }
            }

            // If we got a predicate, then after evaluation, we need to clearn after ourselves so that the environment does not get corrupted values
            if ($predicates instanceof Predicates) {
                $this->environment->clear();
            }

            return $result;
        };

        $this->forAll = $forAll;
        return $this;
    }

    public function evaluate()
    {
        if (!is_null($this->forAll) && is_callable($this->forAll)) {
            $forAll = $this->forAll;

            return $forAll();
        }

        throw new \Exception("You must have a complete forAll quantifier prepared before evaluating it. This means you should have something of the like: forAll(...)->in(...)->itHoldsThat(...).");
    }
}
