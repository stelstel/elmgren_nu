<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');
include(__DIR__.'/om_content.php'); // Include content

$stelixx['header'] .= "<span class='sitetitle'>Om Moviez</span>";

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Om";

$stelixx['main'] = $content;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
