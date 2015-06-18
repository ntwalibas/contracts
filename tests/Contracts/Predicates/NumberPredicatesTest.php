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

use Contracts\Predicates\ArrayPredicates;

use Contracts\Helpers\Number;
use Contracts\Helpers\Let;

function test_number_numberx($symbol)
{
    $numberx = new Number;
    return $numberx($symbol);
}

function test_number_let($symbol)
{
    return new Let($symbol);
}

class NumberPredicatesTest extends PHPUnit_Framework_TestCase
{
    public function testIsNumber()
    {
        // We test that given an integer, isNumber returns true
        test_number_let('__number__')->be(12);
        $predicate = test_number_numberx('__number__')->isNumber();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isNumber returns true when the bound symbol is an integer.");

        // We test that given an integer, isNumber returns true
        test_number_let('__number__')->be(415.24);
        $predicate = test_number_numberx('__number__')->isNumber();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isNumber returns true when the bound symbol is a float.");

        // We test that given a different data type, isNumber returns false
        test_number_let('__number__')->be(null);
        $predicate = test_number_numberx('__number__')->isNumber();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isNumber returns false when the bound symbol is not an number.");
    }

    public function testIsInt()
    {
        // We test that given an integer, isNumber returns true
        test_number_let('__number__')->be(541);
        $predicate = test_number_numberx('__number__')->isInt();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isInt returns true when the bound symbol is an integer.");

        // We test that given a different data type, isInt returns false
        test_number_let('__number__')->be(845.36);
        $predicate = test_number_numberx('__number__')->isInt();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isInt returns false when the bound symbol is not an integer.");
    }

    public function testIsFloat()
    {
        // We test that given an integer, isNumber returns true
        test_number_let('__number__')->be(845.36);
        $predicate = test_number_numberx('__number__')->isFloat();
        $this->assertTrue($predicate->evaluate(), "Failed to assert that isFloat returns true when the bound symbol is a float.");

        // We test that given a different data type, isFloat returns false
        test_number_let('__number__')->be(541);
        $predicate = test_number_numberx('__number__')->isFloat();
        $this->assertFalse($predicate->evaluate(), "Failed to assert that isFloat returns false when the bound symbol is not a float.");
    }

    public function testGreaterThan()
    {
        // We test that given 845, greaterThan agrees that it is greater than 12
        test_number_let('__number__')->be(845);
        $predicate = test_number_numberx('__number__')->greaterThan(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that greaterThan returns true when the operand is greater than the constraint.");

        // We test that given 45, greaterThan agrees that it is less than 85
        test_number_let('__number__')->be(45);
        $predicate = test_number_numberx('__number__')->greaterThan(85);
        $this->assertFalse($predicate->evaluate(), "Failed to assert that greaterThan returns false when the constraint is greater than the operand.");
    }

    /**
     * greaterThan throws an exception if the operand is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testGreaterThanOperandException()
    {
        test_number_let('__number__')->be('845');
        $predicate = test_number_numberx('__number__')->greaterThan(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that greaterThan throws an exception when the operand is not a number.");
    }

    /**
     * greaterThan throws an exception if the constraint is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testGreaterThanConstraintException()
    {
        test_number_let('__number__')->be(456);
        $predicate = test_number_numberx('__number__')->greaterThan('12');
        $this->assertTrue($predicate->evaluate(), "Failed to assert that greaterThan throws an exception when the constraint is not a number.");
    }

    public function testGreaterOrEqualTo()
    {
        // We test that given 845, greaterOrEqualTo agrees that it is greater than 12
        test_number_let('__number__')->be(845);
        $predicate = test_number_numberx('__number__')->greaterOrEqualTo(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that greaterOrEqualTo returns true when the operand is greater than the constraint.");

        // We test that given 67, greaterOrEqualTo agrees that it is equal to 67
        test_number_let('__number__')->be(67);
        $predicate = test_number_numberx('__number__')->greaterOrEqualTo(67);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that greaterOrEqualTo returns true when the operand is equal to the constraint.");

        // We test that given 45, greaterOrEqualTo agrees that it is less than 85
        test_number_let('__number__')->be(45);
        $predicate = test_number_numberx('__number__')->greaterThan(85);
        $this->assertFalse($predicate->evaluate(), "Failed to assert that greaterOrEqualTo returns false when the constraint is greater than the operand.");
    }

    /**
     * greaterOrEqualTo throws an exception if the operand is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testGreaterOrEqualToOperandException()
    {
        test_number_let('__number__')->be('845');
        $predicate = test_number_numberx('__number__')->greaterOrEqualTo(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that greaterOrEqualTo throws an exception when the operand is not a number.");
    }

    /**
     * greaterOrEqualTo throws an exception if the constraint is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testGreaterOrEqualToConstraintException()
    {
        test_number_let('__number__')->be(456);
        $predicate = test_number_numberx('__number__')->greaterOrEqualTo('12');
        $this->assertTrue($predicate->evaluate(), "Failed to assert that greaterOrEqualTo throws an exception when the constraint is not a number.");
    }

    public function testLessThan()
    {
        // We test that given 74, lessThan agrees that it is less than 120
        test_number_let('__number__')->be(74);
        $predicate = test_number_numberx('__number__')->lessThan(120);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that lessThan returns true when the operand is less than the constraint.");

        // We test that given 94, lessThan agrees that it is less than 402
        test_number_let('__number__')->be(402);
        $predicate = test_number_numberx('__number__')->lessThan(94);
        $this->assertFalse($predicate->evaluate(), "Failed to assert that lessThan returns false when the constraint is less than the operand.");
    }

    /**
     * lessThan throws an exception if the operand is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testLessThanOperandException()
    {
        test_number_let('__number__')->be('845');
        $predicate = test_number_numberx('__number__')->lessThan(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that lessThan throws an exception when the operand is not a number.");
    }

    /**
     * lessThan throws an exception if the constraint is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testLessThanConstraintException()
    {
        test_number_let('__number__')->be(456);
        $predicate = test_number_numberx('__number__')->lessThan('12');
        $this->assertTrue($predicate->evaluate(), "Failed to assert that lessThan throws an exception when the constraint is not a number.");
    }


    public function testLessOrEqualTo()
    {
        // We test that given 5, lessOrEqualTo agrees that it is less than 12
        test_number_let('__number__')->be(5);
        $predicate = test_number_numberx('__number__')->lessOrEqualTo(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that lessOrEqualTo returns true when the operand is greater than the constraint.");

        // We test that given 7, lessOrEqualTo agrees that it is equal to 7
        test_number_let('__number__')->be(7);
        $predicate = test_number_numberx('__number__')->lessOrEqualTo(7);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that lessOrEqualTo returns true when the operand is equal to the constraint.");

        // We test that given 95, lessOrEqualTo agrees that it is less than 85
        test_number_let('__number__')->be(95);
        $predicate = test_number_numberx('__number__')->lessThan(85);
        $this->assertFalse($predicate->evaluate(), "Failed to assert that lessOrEqualTo returns false when the constraint is greater than the operand.");
    }

    /**
     * lessOrEqualTo throws an exception if the operand is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testLessOrEqualToOperandException()
    {
        test_number_let('__number__')->be('845');
        $predicate = test_number_numberx('__number__')->lessOrEqualTo(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that lessOrEqualTo throws an exception when the operand is not a number.");
    }

    /**
     * lessOrEqualTo throws an exception if the constraint is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testLessOrEqualToConstraintException()
    {
        test_number_let('__number__')->be(456);
        $predicate = test_number_numberx('__number__')->lessOrEqualTo('12');
        $this->assertTrue($predicate->evaluate(), "Failed to assert that lessOrEqualTo throws an exception when the constraint is not a number.");
    }


    public function testEqualTo()
    {
        // We test that given 7, equalTo agrees that it is equal to 7
        test_number_let('__number__')->be(7);
        $predicate = test_number_numberx('__number__')->equalTo(7);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that equalTo returns true when the operand is equal to the constraint.");

        // We test that given 9, equalTo agrees that it is not equal to 10
        test_number_let('__number__')->be(9);
        $predicate = test_number_numberx('__number__')->equalTo(10);
        $this->assertFalse($predicate->evaluate(), "Failed to assert that equalTo returns false when the constraint is different from the operand.");
    }

    /**
     * equalTo throws an exception if the operand is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testEqualToOperandException()
    {
        test_number_let('__number__')->be('845');
        $predicate = test_number_numberx('__number__')->equalTo(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that equalTo throws an exception when the operand is not a number.");
    }

    /**
     * equalTo throws an exception if the constraint is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testEqualToConstraintException()
    {
        test_number_let('__number__')->be(456);
        $predicate = test_number_numberx('__number__')->equalTo('12');
        $this->assertTrue($predicate->evaluate(), "Failed to assert that equalTo throws an exception when the constraint is not a number.");
    }


    public function testNotEqualTo()
    {
        // We test that given 7, NotEqualTo agrees that it is not equal to 8
        test_number_let('__number__')->be(7);
        $predicate = test_number_numberx('__number__')->notEqualTo(8);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that notEqualTo returns true when the operand is not equal to the constraint.");

        // We test that given 10, equalTo agrees that it is not equal to 10
        test_number_let('__number__')->be(10);
        $predicate = test_number_numberx('__number__')->notEqualTo(10);
        $this->assertFalse($predicate->evaluate(), "Failed to assert that notEqualTo returns false when the constraint is equal to the operand.");
    }

    /**
     * equalTo throws an exception if the operand is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotEqualToOperandException()
    {
        test_number_let('__number__')->be('845');
        $predicate = test_number_numberx('__number__')->equalTo(12);
        $this->assertTrue($predicate->evaluate(), "Failed to assert that notEqualTo throws an exception when the operand is not a number.");
    }

    /**
     * equalTo throws an exception if the constraint is not a number
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotEqualToConstraintException()
    {
        test_number_let('__number__')->be(456);
        $predicate = test_number_numberx('__number__')->equalTo('12');
        $this->assertTrue($predicate->evaluate(), "Failed to assert that notEqualTo throws an exception when the constraint is not a number.");
    }
}
