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

namespace Contracts;

class Environment
{
    private static $instance = null;
    protected $store = array();

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * This method adds a new symbol and it's associated value in the store
     */
    public function attach($symbol, $value)
    {
        $this->store[$symbol] = $value;
    }

    /**
     * This method resolves a symbol and return the associated value
     */
    public function resolve($symbol)
    {
        // We explode the symbol to find if the client is trying to access object attribute or array keys
        $parts = explode(":", $symbol);
        $length = count($parts);
        $prop = null;

        // If we get a one length array, the we use its unique element as symbol
        if ($length == 1) {
            $symbol = $parts[0];
        } else if ($length == 2) {
            $symbol = $parts[0];
            $prop = $parts[1];
        } else {
            throw new \InvalidArgumentException("Th symbol provided is invalid: trying to access more than one method on the object or key on an array.");
        }


        if (array_key_exists($symbol, $this->store)) {
            return $this->resolveSymbol($symbol, $prop);
        }

        throw new \InvalidArgumentException("Could not resolve symbol '$symbol': not found.");        
    }

    private function resolveSymbol($symbol, $prop)
    {
        $element = $this->store[$symbol];

        // If the property is null, we return the value associated with the symbol
        if (is_null($prop)) {
            return $element;
        }

        // The property is not null, we assume the element found is either an array or an object
        if (is_array($element)) {
            if (array_key_exists($prop, $element)) {
                return $element[$prop];
            }

            // trying to access inexistent key, throw an exception
            throw new \InvalidArgumentException("The key [$prop] does not exist on the variable associated with the symbol [$symbol].");
        }

        // If we have an object, we assume assum $prop is a method as per OO best practices
        if (is_object($element)) {
            if (method_exists($element, $prop)) {
                return call_user_func_array(array($element, $prop), array());
            }

            throw new \InvalidArgumentException("The method [$prop] does not exist on the object referenced by the symbol [$symbol].");
        }

        // if we reached here, then a property was requested on a non-object or array
        throw new \InvalidArgumentException("The value associated with [$symbol] is neither an array not am object hence no key or method can be access from it.");
    }

    /**
     * Clear the store so the environment can be reused
     */
    public function clear()
    {
        unset($this->store);
        $this->store = array();
    }

    /**
     * Get the total number of symbols that have been registered
     */
    public function count()
    {
        return count($this->store);
    }
}
