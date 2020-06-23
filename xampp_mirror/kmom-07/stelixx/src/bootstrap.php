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

/** 
 * skriva ut innehållet i en variabel.
 *
 * @author Stefan Elmgren
 */
function debu($name, $var) {
  echo "<br><pre>DEBU " . strtoupper($name) . ": " .$var . "</pre>";
}

function showBlogLinks(){
	$output =<<<EOD
	<a href="newpost.php">Ny blogpost</a>
	<a href="reset.php">Återställ databasen</a>				
EOD;
	return $output;
}



/**
 * Create a slug of a string, to be used as url.
 *
 * @param string $str the string to format as slug.
 * @returns str the formatted slug. 
 */
function slugify($str) {
  $str = mb_strtolower(trim($str));
  $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
  $str = trim(preg_replace('/-+/', '-', $str), '-');
  return $str;
}

/** 
 * En bra-att-ha funktion är en funktion som ger dig länken till nuvarande sida. 
 * Det är något du kan använda för att skapa en permalänk till en sida. 
 * Informationen som behövs för att återskapa länken finns i $_SERVER. Så här kan funktionen se ut.
 *
 * @author Mikael Roos <me@mikaelroos.se>
 */
 
function getCurrentUrl() {
  $url = "http";
  $url .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
  $url .= "://";
  $serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :
    (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
  $url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars($_SERVER["REQUEST_URI"]);
  return $url;
}
