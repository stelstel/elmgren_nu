<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Logga in/ut";

$stelixx['header'] .= "<span class='sitetitle'>Logga in/ut</span>";

$db = new CDatabase($stelixx['database']);

$inlogging = new CLogin($db);

$stelixx['main'] =$inlogging->getForm();

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
