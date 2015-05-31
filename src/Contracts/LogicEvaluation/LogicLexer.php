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

use Dissect\Lexer\SimpleLexer;

class LogicLexer extends SimpleLexer
{
    public function __construct()
    {
        $this->regex("BOOL", "/^true|false/");
        $this->token("&&");
        $this->token("||");
        $this->token("->");
        $this->token("<=>");

        $this->regex('WSP', "/^[ \r\n\t]+/");
        $this->skip('WSP');
    }
}
