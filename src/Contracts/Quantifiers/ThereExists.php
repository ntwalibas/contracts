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

class ThereExists implements Quantifier
{
    public $symbol;
    public $environment;
    public $traversable;
    private $traversableCount = 0;

    private $thereExists;

    public function __construct($symbol = null)
    {
        $this->symbol = $symbol;
        $this->environment = Environment::getInstance();
        $this->traversable = null;
        $this->thereExists = null;
    }

    public function __invoke($symbol)
    {
        $this->symbol = $symbol;
    }

    public function getTraversable()
    {
        return $this->traversable;
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

    public function suchThat($predicates)
    {
        $that = $this;

        $thereExists = function() use ($that, $predicates) {
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
                    throw new \InvalidArgumentException("The value passed to 'suchThat' must either be a predicate set or a quantifier.");
                }

                if ($constraint == true) {
                    $result = true;
                    break;
                } else {
                    $result = false;
                }
            }

            // If we got a predicate, then after evaluation, we need to clearn after ourselves so that the environment does not get corrupted values
            if ($predicates instanceof Predicates) {
                $this->environment->clear();
            }

            return $result;
        };

        $this->thereExists = $thereExists;
        return $this;
    }

    public function evaluate()
    {
        if (!is_null($this->thereExists) && is_callable($this->thereExists)) {
            $thereExists = $this->thereExists;

            return $thereExists();
        }

        throw new \Exception("You must have a complete thereExists quantifier prepared before evaluating it. This means you should have something of the like: thereExists(...)->in(...)->suchThat(...).");
    }
}
