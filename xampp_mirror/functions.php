<?php

/** 
 * skriva ut innehållet i en array.
 *
 * @author Mikael Roos <me@mikaelroos.se>
 */

function dump($array) {
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}

//*************************************************************

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
