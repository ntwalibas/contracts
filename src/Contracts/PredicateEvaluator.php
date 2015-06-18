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

use Contracts\LogicEvaluation\LogicParser;

/**
 * class PredicateEvaluator
 */
class PredicateEvaluator
{
    protected $executionList;
    protected $evaluationList;

    public function __construct()
    {
        $this->executionList = array();
        $this->evaluationList = array();
    }

    public function registerPredicate($predicate, $args)
    {
        $this->executionList[$predicate] = array(
            "type" => "PREDICATE",
            "args" => $args
        );
    }

    public function predicatesCount()
    {
        $predicatesCount = 0;

        foreach ($this->executionList as $value) {
            if ($value['type'] == "PREDICATE") {
                $predicatesCount++;
            }
        }

        return $predicatesCount;
    }

    public function registerOperator($operator)
    {
        $this->executionList[$operator] = array(
            "type" => "OPERATOR"
        );
    }

    public function operatorsCount()
    {
        $operatorsCount = 0;

        foreach ($this->executionList as $value) {
            if ($value['type'] == "OPERATOR") {
                $operatorsCount++;
            }
        }

        return $operatorsCount;
    }

    public function registerComputable($computable, $args)
    {
        $this->executionList[$computable] = array(
            "type" => "COMPUTABLE",
            "args" => $args
        );
    }

    public function computablesCount()
    {
        $computablesCount = 0;

        foreach ($this->executionList as $value) {
            if ($value['type'] == "COMPUTABLE") {
                $computablesCount++;
            }
        }

        return $computablesCount;
    }

    public function evaluate($predicates)
    {
        $this->evaluationList = array(); // This is necessary because since the predicates object is a reference, the array gets filled up with previous results we don't need

        foreach ($this->executionList as $fn => $data) {
            $args = isset($data["args"]) ? $data["args"] : array();
            $value = call_user_func_array(array($predicates, $fn), $args);

            if ($value === true) {
                $value = "true";
            } else if ($value === false) {
                $value = "false";
            }

            // Don't register anything that is not a predicate evaluation result or an operator
            if ($data["type"] != "COMPUTABLE") {
                $this->evaluationList[] = $value;
            }
        }

        // If we have only a single element in the evaluation list, it's either true or false or an operator
        if (count($this->evaluationList) == 1) {
            if ($this->evaluationList[0] == "true") {
                return true;
            } else if ($this->evaluationList[0] == "false") {
                return false;
            } else {
                throw new \Exception("The predicate must not be an operator. Operators are provided for chaining only as a convinience.");
            }
        }

        // We've got more than one element. The expression could be malformed but the parser will handle that
        $logicExpression = implode(" ", $this->evaluationList);
        $parser = new LogicParser;
        $result = $parser->parse($logicExpression);

        return $result;
    }
}
