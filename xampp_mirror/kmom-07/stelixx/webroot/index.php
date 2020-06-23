<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');
include(__DIR__.'/indexcontent.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Moviez";

$stelixx['header'] .= "<span class='sitetitle'>Moviez</span>";

$stelixx['main'] = $output;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
