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

use Contracts\Predicates\NumberPredicates;
use Contracts\Computations\NumberComputations;

class Number
{
    protected $predicates = null;

    public function __construct()
    {
        $this->predicates = 
        new NumberComputations(new NumberPredicates(
            new Operators()
        ));
    }

    public function __invoke($symbol)
    {
        $this->predicates->setSymbol($symbol);
        return $this->predicates;
    }
}

function number($symbol)
{
    $predicates =     
    new NumberComputations(new NumberPredicates(
        new Operators()
    ));

    $predicates->setSymbol($symbol);
    return $predicates;
}
