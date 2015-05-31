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

use Contracts\Predicates\ArrayPredicates;
use Contracts\Computations\ArrayComputations;

class ArrayX
{
    protected $predicates = null;

    public function __construct()
    {
        $this->predicates = 
        new ArrayComputations(new ArrayPredicates(
            new Operators()
        ));
    }

    public function __invoke($symbol)
    {
        $this->predicates->setSymbol($symbol);
        return $this->predicates;
    }
}

function arrayx($symbol)
{
    $predicates =     
    new ArrayComputations(new ArrayPredicates(
        new Operators()
    ));

    $predicates->setSymbol($symbol);
    return $predicates;
}
