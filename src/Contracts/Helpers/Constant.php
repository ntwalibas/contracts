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
use Contracts\Predicates\NumberPredicates;
use Contracts\Computations\NumberComputations;
use Contracts\Predicates\StringPredicates;
use Contracts\Computations\StringComputations;
use Contracts\Predicates\ArrayPredicates;
use Contracts\Computations\ArrayComputations;
use Contracts\Predicates\ObjectPredicates;
use Contracts\Computations\ObjectComputations;
use Contracts\Predicates\ResourcePredicates;
use Contracts\Computations\ResourceComputations;

class Constant
{
    protected $predicates = null;

    public function __construct()
    {
        $this->predicates = 
        new ResourceComputations(new ResourcePredicates(
            new ObjectComputations(new ObjectPredicates(
                new ArrayComputations(new ArrayPredicates(
                    new StringComputations(new StringPredicates(
                        new NumberComputations(new NumberPredicates(
                            new BooleanComputations(new BooleanPredicates(
                                new Operators()
                            ))
                        ))
                    ))
                ))
            ))
        ));
    }

    public function __invoke($constant)
    {
        $this->predicates->setSymbol("__?__");
        $this->predicates->setOperand("__?__", $constant);
        return $this->predicates;
    }
}



function constx($constant)
{
    $predicates = 
    new ResourceComputations(new ResourcePredicates(
        new ObjectComputations(new ObjectPredicates(
            new ArrayComputations(new ArrayPredicates(
                new StringComputations(new StringPredicates(
                    new NumberComputations(new NumberPredicates(
                        new BooleanComputations(new BooleanPredicates(
                            new Operators()
                        ))
                    ))
                ))
            ))
        ))
    ));

    $predicates->setSymbol("__?__");
    $predicates->setOperand("__?__", $constant);
    return $predicates;
}
