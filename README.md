# Contracts - an assertion library

**STATUS:** Full test coverage, more predicates are the next goal and a better documentation.

> This library is *somewhat* production ready. Please don't use it yet for sensitive data validation like in the money related domain.

Contracts is a library to help you write quite intersting assertions. Initially, I was looking at making design by contract possible in PHP but due to the nature of task, I ended up settling with assertions but kept the name.

It is quite powerful because it implements [first-order predicate calculus](http://en.wikipedia.com/wiki/First-order_logic) in an intuitive way, a feature I have failed to find in many assertion and validation librairies. Heck, you can even implement your own predicates.  
It is still in its early stages (many native predicates are not implemented) but it is meant to grow!



## Install

The library is available on [packagist](https://packagist.org/) and installable via [composer](http://getcomposer.org).

```JSON
{
    "require": {
        "ntwalibas/contracts": "0.1.1"
    }
}
```

## Concepts

You generally write propositions that will be evaluated when you want to use them. Each proposition is made of predicates that can joined by logical operators such as `AND`, `OR`, `IMPLIES` and `EQUIVALENT`. The `NOT` logical operator is not implement and is rather replaced by negated predicates.

## Usage

Usage is fairly simple: pass your predicates or quantifiers to the `AssertThat` funtion or `Assert::That` static method and it will throw an `AssertionFailedException` exception if there was any failure.  
So let's understand first the idea of predicates, quantifiers and computations.

### Predicates
A predicate is simply a function that returns `true` or `false`. In our case, the said functions will actually be methods on specific objects.

In predicate calculus, a predicate will have variables that take different values for evaluation. The same goes for us here, with a few syntactical differences. An example shall illustrate.  

Assume we want to evaluate whether a given number is greater than 18. So how do we do that?

```PHP
<?php
use Contracts\Helpers\Constant;
use function Contracts\Helpers\constx; // As of PHP 5.6+

// PHP 5.5-
// You could as well initialize this object in your class where it will be used
function constx($value)
{
    $constant = new Constant;
    return $constant($value);
}

$age = 17;
$predicate = constx($age)->greaterThan(18);
var_dump($predicate->evaluate());

```

Notice the first convention: `$age` is **not** a constant by the way we understand it in PHP. But we consider it a constant here because once its value has been set, it won't change after the predicate has recieved.  
The next thing you might ask is why is it `const**x**` instead of `const`? That's because `const` is a PHP keyword. Infact, whenever you are about to use any method or function provided by the library and it is a PHP keyword or on the list of reserved words, it will be followed by an `x`.

Now back to the library `constants`. A natural question here might be: what does the library consider a variable? Again an example.  
Assume we have an array that maps users' name to their age and we want to know whether they're adult or minors. Using "variables" we can loop over the said array and check using the predicate.

```PHP
<?php
use Contracts\Helpers\Variable;
use function Contracts\Helpers\varx; // As of PHP 5.6+

// PHP 5.5-
function varx($symbol)
{
    $variable = new Variable;
    return $variable($symbol);
}

$userAges = array(
    "John" => 11, 
    "Marie" => 21, 
    "Paul" => 13, 
    "Dupont" => 42, 
    "Dixit" => 15, 
    "Avinash" => 56, 
    "Bora" => 27
);

$predicate = varx("age")->greaterThan(18);

foreach ($userAges as $name => $age) {
    $predicate->setOperand("age", $age);
    if ($predicate->evaluate() === true) {
        print "$name is a legal adult <br>";
    } else {
        print "$name is a minor <br>";
    }
}

```
And this is the concept of variables: a variable is simply a symbol that can take on different values within an execution context. The execution context here is the `foreach` loop. Here, the age will keep changing as the loop executes. Use the `setOperand(string $symbol, mixed $value)` to update the value of the variable represented by the given symbol.  
***Note:*** we'll later see a better way to check if all the users here as adults using quantifiers.

####   More on variables
I. A helper is provided if you want to declare a new variable instead of using a constant (for some reason).
```PHP
<?php
use Contracts\Helpers\Let;
use function Contracts\Helpers\let; // PHP 5.6+

// PHP 5.5-
function let($symbol)
{
    return new Let($symbol)
}

let("age")->be(18);
// Now you can use "age" bellow in predicates and it will have the value of 18

```
II. Objects and array allow for an extra feature: assume you have tied a particular symbol to an object or an array. You can access methods (without arguments - such as getters) on objects or array elements referenced by a key (must be a string.)

** Object example:**
```PHP
<?php
class User
{
    protected $age = 18;

    public function age()
    {
        return $this->age;
    }
}

$user = new User;
let("user")->be($user);

// The age method will be called on the user object
$predicate = varx("user:age")->greaterThan(18);
var_dump($predicate->evaluate());

```

** Array example:**
```PHP
<?php
$user = ["age" => 12];
let("user")->be($user);

// The age key will be access on the user array
$predicate = varx("user:age")->greaterThan(18);
var_dump($predicate->evaluate());

```

### All the predicates
Contracts provide different predicates grouped by data types. There predicates that make sense only for numbers, others for arrays and so on. Helpers are provided so you don't have to instantiate the classes that implement those predicates yourself. Here, the classes `Variable` and `Constant` will instantiate all the predicates (and more) so you can get started using them. But this is not recommended because it  carries a certain overhead you might not need. If for a given specific case you just want to work with numbers (integers and floating point numbers included), use the `Number` helper. And the same goes for all the other data types. Bellow is the list of all the helpers.

```PHP
<?php
// Booleans
use Contracts\Helpers\Boolean;
use function Contracts\Helpers\boolx;

// Numbers: ints and floats
use Contracts\Helpers\Number;
use function Contracts\Helpers\number;

// Strings
use Contracts\Helpers\StringX;
use function Contracts\Helpers\stringx;

// Arrays
use Contracts\Helpers\ArrayX;
use function Contracts\Helpers\arrayx;

// Objects
use Contracts\Helpers\ObjectX;
use function Contracts\Helpers\objectx;

// Resource
use Contracts\Helpers\ResourceX;
use function Contracts\Helpers\resourcex;

// Callables: not included at the moment but sure is coming

```

Some time you might want a combination that is not provided natively by the library. This is easily achieved as follows:

```PHP
<?php
use Contracts\Operators;
use Contracts\Predicates\NumberPredicates;
use Contracts\Predicates\StringPredicates;

function varx($symbol)
{
    $predicates = new StringPredicates(new NumberPredicates(new Operators));
    $predicates->setSymbol($symbol);

    return $predicates;
}

```

You must pass the `Operators` instance as the first argument in the chain whether you intend to use logical operators or not because it does another job not done by predicates. The rest can be passed in any order. `StringPredicates` could have come before `NumberPredicates` without any problem.  
From thereon, you can use `varx` as before.

### Logical operators
You can combine predicates by using logical operators like so:

```PHP
<?php
$age = 17;
// We do not believe people older than 120 use our product
$predicate = constx($age)->greaterThan(18)->andx()->constx($age)->lessThan(120);
var_dump($predicate->evaluate());

```

In fact, if the second predicate will reuse the operand of the first predicate (in this case `$age`), there is no need to have `constx($age)` or `varx($age)` before it. So the following is equally correct and brief:

```PHP
<?php
$age = 17;
// We do not believe people older than 120 use our product
$predicate = constx($age)->greaterThan(18)->andx()->lessThan(120);
var_dump($predicate->evaluate());

```
The following logical operators are available:

```PHP
<?php

andx()
orx()
implies()
isEquivalentTo()

```
### Computations
At times you might want to perform computations on the variables (constants) passed to the predicates before actually running the predicates. That's when computations enter the picture.  
Assume the user gave their year of birth and you want to know whether they're adults:

```PHP
<?php
$yob = 1990;
$predicate = constx(2015)->minus($yob)->greaterThan(18);

var_dump($predicate->evaluate());

```

Computations are meant to simplify things when you want to make transformations on the operand to pass to the constraint without polluting your business logic with extra computations.

### Quantifiers
Contracts provide two quantifiers at the moment: `ForAll` and `ThereExists`.

#### ForAll
Use `ForAll` to make sure all the elements in a traversable obey a given predicate. Back to our example before: assume we want to make sure all our users are legally adults. This is how we would do it:

```PHP
<?php
use Contracts\Quantifiers\ForAll;
use function Contracts\Helpers\forAll; // PHP 5.6+

// PHP 5.5-
function forAll($symbol)
{
    return new ForAll($symbol);
}

$userAges = array(   
    [
        "name" => "John",
        "age" => 11
    ],
    [
        "name" => "Marie",
        "age" => 21
    ],
    [
        "name" => "Paul",
        "age" => 13
    ],
    [
        "name" => "Dupont",
        "age" => 42
    ],
    [
        "name" => "Dixit",
        "age" => 15
    ],
    [
        "name" => "Avinash",
        "age" => 56
    ],
    [
        "name" => "Bora",
        "age" => 27
    ]
);

$allAdults =
forAll("user")->in($userAges)->itHoldsThat(
    varx("user:age")->greaterThan(18)
);

var_dump($allAdults->evaluate()); // Return false

```

#### ThereExists
The principle is the same as for the `ForAll` quantifier.

```PHP
<?php
use Contracts\Quantifiers\ThereExists;
use Contracts\Helpers\thereExists; // PHP 5.6+

// PHP 5.5-
function thereExists($symbol)
{
    return new ThereExists($symbol);
}

$userAges = array(   
    [
        "name" => "John",
        "age" => 11
    ],
    [
        "name" => "Marie",
        "age" => 21
    ],
    [
        "name" => "Paul",
        "age" => 13
    ],
    [
        "name" => "Dupont",
        "age" => 42
    ],
    [
        "name" => "Dixit",
        "age" => 15
    ],
    [
        "name" => "Avinash",
        "age" => 56
    ],
    [
        "name" => "Bora",
        "age" => 27
    ]
);

$oneAdult =
thereExists("user")->in($userAges)->suchThat(
    varx("user:age")->greaterThan(18)
);

var_dump($oneAdult->evaluate()); // Return true

```

#### Quantifier combination
You can pass one quantifier to another as you would pass a predicate.

```PHP
<?php
$set = array(1, 2, 3, 4, 5, 6, 7);

$test =
forAll('x')->in($set)->itHoldsThat(
    thereExists('y')->in($set)->suchThat(
        varx('x')->dividedBy('y')->equalTo(1)
    )
);

var_dump($test->evaluate()); // Will print true

```

Note that with the example above, it is true that for all the elements in the said set, you can always find one other element in the same set (which is just the same element) such that their division will equal one.

### Assert
To run assertions, just pass your predicates or quantifiers to the `AssertThat` function or `Assert::That` static method. An additional argument is required to document the assertion.  
Indeed, you can also pass an array of predicates/quantifiers as the first argument in case you want to group assertions hence make sure to provide a key that identify each assertion to make sense of the message when an exception is thrown upon failure.

```PHP
<?php
use Contracts\Assertions\Assert;
use Contracts\Assertions\AssertionFailedException;
use function Contracts\Helpers\AssertThat; // PHP 5.6+

// PHP 5.5-
function AssertThat($predicate, $doc)
{
    Assert::That($predicate, $doc);
}

$set = array(1, 2, 3, 4, 5, 6, 7);

try {
    AssertThat(
        forAll('x')->in($set)->itHoldsThat(
            varx('x')->greaterThan(0)->andx()->lessThan("7")
        ),
        "All the numbers must be greater than 0 and less than 7"
    );
} catch (AssertionFailedException $exception) {
    echo $exception->getMessage(); // Will print a message with enough details to know the problem.
    
    // Get the constraints that were provided to the predicates
    $exception->getConstraints($assertionId); // The assertion ID in our case would be "unnamed-assertion" because we did not name the assertion
    
    // Get the operands that we provided to the predicates
    $exception->getOperands($assertionId); 
    
    // Get any possible exceptions throw by either the predicates or quantifiers
    $exception->getExceptions($assertionId);   
}

```

To name an assertion, pass an array with the structure `["assertionId" => "predicate|quantifier"]` as the first argument to `AssertThat`. If you passed a predicate or quantifier directly without an assertion ID, it will be given the ID `unnamed-assertion`.

## Conclusion

Th library provides quite a nice API that is intuitive but as usual something had to be sacrificied. In this case, the performance will be lower than in most other "lightweight" assertion/validation libraries. Still I suspect the impact will not be noticeable not to mention this statement is based off the fact that the `__call` method is used and that will be the performance bottleneck.

## Author
Ntwali Bashige - ntwali.bashige@gmail.com - [http://twitter.com/nbashige](http://twitter.com/nbashige)

## License
Contracts is licensed under `MIT`, see LICENSE file.

## Acknowledgment
Internally, Contracts uses internally [dissect](https://github.com/jakubledl/dissect) for properly evaluating boolean expressions.

## Next
1. Strive for full test coverage,
2. Write more predicates and computations,
3. Replace the boolean expression parser by a small recursive descent parser to eliminate the dependency on dissect,
4. Find a way to reply less on `__call`.

Contributions are welcome. Send a pull request if you have something to add. Tests are especially welcome!