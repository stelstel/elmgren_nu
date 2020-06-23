<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Logga in/ut";

$db = new CDatabase($stelixx['database']);

$stelixx['main'] = $stelixx['links'];

$inlogging = new CLogin($db);
$stelixx['main'] .="<H1>Logga in</H1>";
$stelixx['main'] .=$inlogging->getForm();

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
