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

namespace Contracts\LogicEvaluation;

use Dissect\Parser\Grammar;

class LogicGrammar extends Grammar
{
    public function __construct()
    {
        // Equivalence evaluation
        $this('Equivalent')
            ->is('Equivalent', '<=>', 'Implies')
            ->call(function ($l, $_, $r) {
                if ($l == "false" && $r == "false") {
                    return true;
                } else if ($l == "false" && $r == "true") {
                    return false;
                } else if ($l == "true" && $r == "false") {
                    return false;
                } else if ($l == "true" && $r == "true") {
                    return true;
                } else {
                    throw new \InvalidArgumentException("We got an operand for 'EQUIV' that is neither true or false");
                }
            })
            ->is('Implies');

        // Implies evalution
        $this('Implies')
            ->is('Implies', '->', 'Or')
            ->call(function ($l, $_, $r) {
                if ($l == "false" && $r == "false") {
                    return true;
                } else if ($l == "false" && $r == "true") {
                    return true;
                } else if ($l == "true" && $r == "false") {
                    return false;
                } else if ($l == "true" && $r == "true") {
                    return true;
                } else {
                    throw new \InvalidArgumentException("We got an operand for 'IMPLIES' that is neither true or false");
                }
            })
            ->is('Or');

        // Or evaluation
        $this('Or')
            ->is('Or', '||', 'And')
            ->call(function ($l, $_, $r) {
                
                if ($l == "false" && $r == "false") {
                    return false;
                } else if ($l == "false" && $r == "true") {
                    return true;
                } else if ($l == "true" && $r == "false") {
                    return true;
                } else if ($l == "true" && $r == "true") {
                    return true;
                } else {
                    throw new \InvalidArgumentException("We got an operand for 'OR' that is neither true or false");
                }
            })
            ->is('And');

        // And evaluation
        $this('And')
            ->is('And', '&&', 'Primary')
            ->call(function ($l, $_, $r) {
                if ($l === "false" && $r === "false") {
                    return false;
                } else if ($l === "false" && $r === "true") {
                    return false;
                } else if ($l === "true" && $r === "false") {
                    return false;
                } else if ($l === "true" && $r === "true") {
                    return true;
                } else {
                    throw new \InvalidArgumentException("We got an operand for 'AND' that is neither true or false");
                }
            })
            ->is('Primary');

        // Primary expression evaluation
        $this('Primary')
            ->is('BOOL')
            ->call(function ($bool) {
                return $bool->getValue();
            });
        
        // Start rule
        $this->start('Equivalent');
    }
}
