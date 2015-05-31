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

class AssertionFailedException extends \Exception
{
    private $errors = array();

    public function __construct($message = "", $code = 0, $previous = null)
    {
        $this->message = $message;
        $this->errors = array();
    }

    public function appendMessage($message)
    {
        $this->message .= $message;
    }

    public function addConstraint($assertionId, $constraints)
    {
        $this->errors[$assertionId]["constraints"] = $constraints;
    }

    public function getConstraints($assertionId)
    {
        if (array_key_exists($assertionId, $this->errors)) {
            return $this->errors[$assertionId]["constraints"];
        }

        throw new \InvalidArgumentExcption("There is no assertion name <$assertionId>");
    }

    public function addOperand($assertionId, $operand)
    {
        $this->errors[$assertionId]["operands"] = $operand;
    }

    public function getOperands($assertionId = null)
    {
        if (array_key_exists($assertionId, $this->errors)) {
            return $this->errors[$assertionId]["operands"];
        }

        throw new \InvalidArgumentExcption("There is no assertion name <$assertionId>");
    }

    public function addException($assertionId, $exception)
    {
        $this->errors[$assertionId]["exception"] = $exception;
    }

    public function getExceptions($assertionId)
    {
        if (array_key_exists($assertionId, $this->errors)) {
            return $this->errors[$assertionId]["exception"];
        }

        throw new \InvalidArgumentExcption("There is no assertion name <$assertionId>");
    }
}
