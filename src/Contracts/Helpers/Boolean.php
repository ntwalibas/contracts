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

use Contracts\Predicates\BooleanPredicates;
use Contracts\Computations\BooleanComputations;

class Boolean
{
    protected $predicates = null;

    public function __construct()
    {
        $this->predicates = 
        new BooleanComputations(new BooleanPredicates(
            new Operators()
        ));
    }

    public function __invoke($symbol)
    {
        $this->predicates->setSymbol($symbol);
        return $this->predicates;
    }
}

function boolean($symbol)
{
    $predicates =     
    new BooleanComputations(new BooleanPredicates(
        new Operators()
    ));

    $predicates->setSymbol($symbol);
    return $predicates;
}
