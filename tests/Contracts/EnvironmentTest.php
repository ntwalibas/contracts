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

use Contracts\Environment;

class EnvironmentTest extends PHPUnit_Framework_TestCase
{
    protected $environment = null;

    public function setUp()
    {
        $this->environment = Environment::getInstance();
    }

    /**
     * Test the getInstance method
     *
     * This method must return the same instance of the Environment class
     */
    public function testGetInstance()
    {
        $environmentTwo = Environment::getInstance();

        $this->assertSame($this->environment, $environmentTwo, "Failed to assert that the getInstance method returns the same environment. The environment must be a singleton.");
    }

    /**
     * Test attach
     *
     * Upon attaching a symbol, the environment symbol count must increase by one.
     * If we reattach the same symbol, the environment symbol count must remain the same
     */
    public function testAttach()
    {
        // First we test that a new symbol has been attached
        $this->environment->attach('__x__', 1);
        $this->assertEquals($this->environment->count(), 1, "Failed to assert that the given symbol was successfully attached.");

        // Next we attach a new symbol and make sure that it was also attached
        $this->environment->attach('__y__', 2);
        $this->assertEquals($this->environment->count(), 2, "Failed to assert that more than one symbol can be attached to the environment.");

        // Last we make sure that if we reattach the same symbol, no new symbol is attached by the old one is replaced
        $this->environment->attach('__x__', 3);
        $this->assertEquals($this->environment->count(), 2, "Failed to assert that attaching the same symbol twice does not result in a new symbol created in the environment.");
    }

    /**
     * Test resolve
     *
     * We test for 3 scenarios:
     * - We test that for all types, we get back the same value attached to a symbol,
     * - We test that we can successfully retrieve the value of an object property via method call on the said objct,
     * - We last test that we retrieve an array valu given the key.
     */
    /**
     * @dataProvider valuesProvider
     */    
    public function testResolve($symbol, $value)
    {
        // First, we start we retrieving any value (from different data types) bound to a symbol in the environment
        $this->environment->attach($symbol, $value);
        $this->assertSame($this->environment->resolve($symbol), $value, "Failed to assert that the bound symbol resolves to the given the value from the data provider.");
        
        // Next we test for a given object, we can get call a method to retrieve an attribute of the said object
        $age = 20;
        $userObject = new User($age);
        $this->environment->attach('__user_object__', $userObject);
        $this->assertEquals($this->environment->resolve('__user_object__:getAge'), $age, "Failed to assert that we can call call an object method to retrieve its return value");

        // Next we make sure we can retrieve an array value given the key
        $userArray = array(
            'age' => $age
        );
        $this->environment->attach('__user_array__', $userArray);
        $this->assertEquals($this->environment->resolve('__user_array__:age'), $age, "Failed to assert that given a key from a bound array we can retrieve the value associated to that key.");
    }

    public function valuesProvider()
    {
        return array(
            array('__bool__', true),
            array('__int__', 1),
            array('__float__', 1.56),
            array('__string__', "Hello World"),
            array('__array__', [1, 2, 3]),
            array('__object__', new StdClass),
            array('__null__', null),
            //array('resource', tmpfile()), // This needs a thorough thinking
        );
    }

    /**
     * We test for the different exceptions that the resolve method can throw
     */
    /**
     * @expectedException InvalidArgumentException
     */
    public function testResolveSymbolNotFoundException()
    {
        // An exception is thrown when we try to resolve a symbol not bound
        $this->assertEquals($this->environment->resolve('__?__'), 3, "Failed to throw an exception when a symbol not attached as resolved.");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testResolveMultipleMethodCallsException()
    {
        // Test object
        $user = new User(10);
        $this->environment->attach('__user__', $user);

        // An exception is thrown when we try to call multiple methods on the same object in one row
        $this->assertEquals($this->environment->resolve('__user__:getAge:getName'), null, "Failed to throw an exception when we tried to call multiple methods on th given object.");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testResolveMultipleAccessexception()
    {
        // Test array
        $person = [
            'name' => 'John Doe',
        ];
        $this->environment->attach('__person__', $person);

        // An exception is thrown when we try to access multiple keys on an array        
        $this->assertEquals($this->environment->resolve('__person__:name:age'), null, "Failed to throw an exception when we tried to access multiple keys on an array");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testResolveInexistentMethodException()
    {
        // Test object
        $user = new User(10);
        $this->environment->attach('__user__', $user);

        // An exception is thrown when we try to call a non-existent method on a bound object
        // Note that this method is vulernable to the existence of a __call method on the object but that would be the client decision
        $this->assertEquals($this->environment->resolve('__user__:getName'), null, "Failed to throw an excption when we tried to call a non-existent method on the object.");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testResolveInexistentAccessKeyException()
    {
        // Test array
        $person = [
            'name' => 'John Doe',
        ];
        $this->environment->attach('__person__', $person);

        // An exception is thrown when we try to access a non-existent key on a bound array
        $this->assertEquals($this->environment->resolve('__person__:age'), null,  "Failed to throw an exception when we tried to access a non-existent key on the array.");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testResolveBadAccessorException()
    {
        // Test scalar
        $scalar = "Noun";
        $this->environment->attach('__scalar__', $scalar);

        // An exception is thrown when we try to call a method on a non-object or access on a non-aray
        $this->assertEquals($this->environment->resolve('__scalar__:age'), null, "Failed to throw an exception when we tried a call/access on a non-object or array");
    }

    /**
     * Test the clear method
     *
     * Upon clearing the environment, it must not contain any symbols
     */
    public function testClear()
    {
        $this->environment->attach('__x__', 12);
        $this->environment->clear();

        $this->assertEquals($this->environment->count(), 0, "Failed to assert that upon clearing the environment no symbols remains attached.");
    }

    public function tearDown()
    {
        $this->environment->reset();
    }
}

class User
{
    private $age;

    public function __construct($age)
    {
        $this->age = $age;
    }

    public function getAge()
    {
        return $this->age;
    }
}
