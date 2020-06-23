<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 



// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "404";
$stelixx['header'] = "";
$stelixx['main'] = "This is a Stelixx 404. Document is not here.";
$stelixx['footer'] = "";

// Send the 404 header 
header("HTTP/1.0 404 Not Found");


// Finally, leave it all to the rendering phase of Anax.
include(STELIXX_THEME_PATH);
