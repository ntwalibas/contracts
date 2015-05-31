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

namespace Contracts\Helpers;

use Contracts\Operators;

use Contracts\Predicates\ObjectPredicates;
use Contracts\Computations\ObjectComputations;

class ObjectX
{
    protected $predicates = null;

    public function __construct()
    {
        $this->predicates = 
        new ObjectComputations(new ObjectPredicates(
            new Operators()
        ));
    }

    public function __invoke($symbol)
    {
        $this->predicates->setSymbol($symbol);
        return $this->predicates;
    }
}

function objectx($symbol)
{
    $predicates =     
    new ObjectComputations(new ObjectPredicates(
        new Operators()
    ));

    $predicates->setSymbol($symbol);
    return $predicates;
}
