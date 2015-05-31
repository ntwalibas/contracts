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

use Dissect\Parser\LALR1\Parser;

class LogicParser
{
    private $parser;
    private $lexer;

    public function __construct()
    {
        $this->parser = new Parser(new LogicGrammar);
        $this->lexer = new LogicLexer;
    }

    public function parse($expression)
    {
        $stream = $this->lexer->lex($expression);
        return $this->parser->parse($stream);
    }
}
