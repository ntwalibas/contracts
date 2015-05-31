<?php
/**
 * Credit for this code goes to <Josh Loackart> of the <Slim framework>
 *
 * MIT License
 */

set_include_path(dirname(__FILE__) . '/../' . PATH_SEPARATOR . get_include_path());

// We use the composer autoloader to load Reshi //
require_once 'vendor/autoload.php';

//Register non-Reshi (originally non-Slim) autoloader
function customAutoLoader( $class )
{
    $file = rtrim(dirname(__FILE__), '/') . '/' . $class . '.php';
    if ( file_exists($file) ) {
        require $file;
    } else {
        return;
    }
}
spl_autoload_register('customAutoLoader');
