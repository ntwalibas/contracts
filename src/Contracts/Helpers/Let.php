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

use Contracts\Environment;

class Let
{
    protected $symbol = null;

    public function __construct($symbol = null)
    {
        $this->symbol = $symbol;
    }

    public function __invoke($symbol)
    {
        $this->symbol = $symbol;
        return $this;
    }

    public function be($value)
    {
        Environment::getInstance()->attach($this->symbol, $value);
    }
}

function let($symbol)
{
    return new Let($symbol);
}

