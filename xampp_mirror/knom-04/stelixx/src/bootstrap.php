<?php
/**
 * Bootstrapping functions, essential and needed for Stelix to work together with some common helpers. 
 *
 */

/**
 * Default exception handler.
 *
 */
function myExceptionHandler($exception) {
  echo "Stelixx: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}
set_exception_handler('myExceptionHandler');


/**
 * Autoloader for classes.
 *
 */
function myAutoloader($class) {
  $path = STELIXX_INSTALL_PATH . "/src/{$class}/{$class}.php";
  if(is_file($path)) {
    include($path);
  }
  else {
    throw new Exception("Classfile '{$class}' does not exists.");
  }
}
spl_autoload_register('myAutoloader');

/** 
 * skriva ut innehållet i en array.
 *
 * @author Mikael Roos <me@mikaelroos.se>
 */

function dump($array) {
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}
