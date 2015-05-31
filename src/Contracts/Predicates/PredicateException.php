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

class PredicateException extends \Exception
{
    private $predicate;

    public function setPredicate($predicate)
    {
        $this->predicate = $predicate;
    }

    public function getPredicate()
    {
        return $this->predicate;
    }
}
