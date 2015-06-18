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

use Contracts\LogicEvaluation\LogicParser;

class LogicParserTest extends PHPUnit_Framework_TestCase
{
    protected $parser;

    public function setUp()
    {
        $this->parser = new LogicParser;
    }

    /**
     * First we test for expected values
     * 1. Given true or false, it must return true or false
     * 2. We then proced to test all the logic operators
     * 3. Then we test for operator precedence and associativuty
     */
    public function testParse()
    {
        // Tests for atomic boolean values
        $this->assertTrue($this->parser->parse("true"), "Failed to assert that when true is parsed, the parser returns true.");
        $this->assertFalse($this->parser->parse("false"), "Failed to assert that when false is parsed, the parser returns false.");

        // Tests for logical operators
        // 1. AND tests
        $this->assertTrue($this->parser->parse("true && true"), "Failed to assert that 'true and true' is true.");
        $this->assertFalse($this->parser->parse("true && false"), "Failed to assert that 'true and false' is false.");
        $this->assertFalse($this->parser->parse("false && true"), "Failed to assert that 'false and true' is false.");
        $this->assertFalse($this->parser->parse("false && false"), "Failed to assert that 'false and false' is false.");

        // 2. OR tests
        $this->assertTrue($this->parser->parse("true || true"), "Failed to assert that 'true or true' is true.");
        $this->assertTrue($this->parser->parse("true || false"), "Failed to assert that 'true or false' is true.");
        $this->assertTrue($this->parser->parse("false || true"), "Failed to assert that 'false or true' is true.");
        $this->assertFalse($this->parser->parse("false || false"), "Failed to assert that 'false or false' is false.");

        // 3. IMPLIES tests
        $this->assertTrue($this->parser->parse("true -> true"), "Failed to assert that 'true implies true' is true.");
        $this->assertFalse($this->parser->parse("true -> false"), "Failed to assert that 'true implies false' is false.");
        $this->assertTrue($this->parser->parse("false -> true"), "Failed to assert that 'false implies true' is true.");
        $this->assertTrue($this->parser->parse("false -> false"), "Failed to assert that 'false implies false' is true.");

        // 4. EQUIVALENCE tests
        $this->assertTrue($this->parser->parse("true <=> true"), "Failed to assert that 'true is_equivalent_to true' is true.");
        $this->assertFalse($this->parser->parse("true <=> false"), "Failed to assert that 'true is_equivalent_to false' is false.");
        $this->assertFalse($this->parser->parse("false <=> true"), "Failed to assert that 'false is_equivalent_to true' is false.");
        $this->assertTrue($this->parser->parse("false <=> false"), "Failed to assert that 'false is_equivalent_to false' is true.");

        // TODO: Associativity and precedence tests
    }
}
