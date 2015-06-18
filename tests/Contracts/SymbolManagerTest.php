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

use Contracts\SymbolManager;

class SymbolManagerTest extends PHPUnit_Framework_TestCase
{
    public function testGetSymbol()
    {
        $symbolManager = new SymbolManager;
        $symbolManager->setSymbol('__x__');

        $this->assertEquals($symbolManager->getSymbol(), '__x__', "Failed to assert that the symbol manager returns a symbol equal to the one set.");
    }
}
