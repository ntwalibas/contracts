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

namespace Contracts\Assertions;

use Contracts\Predicates;
use Contracts\Quantifiers\Quantifier;
use Contracts\Predicates\PredicateException;

class Assert
{
    private static $errors = "";

    public function __construct()
    {
    }

    public static function That($predicates, $assertionDoc)
    {
        if (!is_array($predicates)) {
            $predicates = array(
                "unnamed-assertion" => $predicates
            );
        }

        self::evaluateAssertions($predicates, $assertionDoc);
    }

    private static function evaluateAssertions($predicates, $assertionDoc)
    {
        $i = 1;
        $exception = new AssertionFailedException("Assertion '$assertionDoc' failed:\r\n");

        foreach($predicates as $assertionId => $predicate) {
            // If we have a callable, we assume it's a quantifier
            if ($predicate instanceof Quantifier) {
                try {
                    $result = $predicate->evaluate();
                } catch(PredicateException $predicateException) {
                    $predicate = $predicateException->getPredicate();
                    $operand = $predicate->getLastOperand();
                    $constraint = $predicate->getConstraint();
                    $stringOperand = self::stringify($operand);
                    $stringConstraint = self::stringify($constraint);

                    $exception->appendMessage(
                        sprintf("%d) `%s` threw an exception within a quantifier with message: %s\r\n", $i++, $assertionId, $predicateException->getMessage() .". Operands were: ". $stringOperand ." and constraints were: ". $stringConstraint)
                    );
                    $exception->addOperand($assertionId, $predicate->getLastOperand());
                    $exception->addConstraint($assertionId, $predicate->getConstraint());

                    continue;
                } catch(\Exception $quantifierException) {
                    $exception->appendMessage(
                        sprintf("%d) `%s` threw an exception from a quantifier with message: %s\r\n", $i++, $assertionId, $quantifierException->getMessage())
                    );

                    continue;
                }

                if ($result === false) {
                    $exception->appendMessage(
                        sprintf("%d) `%s` failed: %s\n", $i++, $assertionId, "Quantifier failed.")
                    );
                }
            } else if ($predicate instanceof Predicates) {
                try {
                    $result = $predicate->evaluate();
                } catch(\Exception $predicateException) {
                    $operand = $predicate->getLastOperand();
                    $constraint = $predicate->getConstraint();
                    $stringOperand = self::stringify($operand);
                    $stringConstraint = self::stringify($constraint);

                    $exception->appendMessage(
                        sprintf("%d) `%s` threw an exception with message: %s\r\n", $i++, $assertionId, $predicateException->getMessage() .". Operands were: ". $stringOperand ." and constraints were: ". $stringConstraint)
                    );
                    $exception->addOperand($assertionId, $predicate->getLastOperand());
                    $exception->addConstraint($assertionId, $predicate->getConstraint());

                    continue; // There is not result, we pass into the next predicate
                }

                $operand = $predicate->getLastOperand();
                $constraint = $predicate->getConstraint();
                $stringOperand = self::stringify($operand);
                $stringConstraint = self::stringify($constraint);

                if ($result === false) {
                    $exception->appendMessage(
                        sprintf("%d) `%s` failed: %s\n", $i++, $assertionId, "operands were: \"". $stringOperand ."\" and constraints were: \"". $stringConstraint ."\"")
                    );
                }
            } else {
                throw new \InvalidArgumentException("The first argument passed to Asssert::That must be either a callable from a quantifier or a predicate or an array of predicates/quantifiers.");
            }
        }

        if ($i > 1) {
            throw $exception;
        }     
    }

    private static function stringify($value)
    {
        if (is_null($value)) {
            $stringValue = "[NULL]";
        } else if (is_object($value)) {
            $stringValue = "[OBJECT]";
        } else if (is_array($value)) {
            $stringValue = "[ARRAY]";
        } else if (is_resource($value)) {
            $stringValue = "[RESOURCE]";
        } else if (is_callable($value)) {
            $stringValue = "[CALLABLE]";
        } else if (is_bool($value)) {
            if ($value == true) {
                $stringValue = "[TRUE]";
            } else {
                $stringValue = "[TRUE]";
            }
        } else {
            $stringValue = (string) $value;
        }

        return $stringValue;
    }
}
