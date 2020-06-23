<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$db = new CDatabase($stelixx['database']);

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "FILMNAMN";

$film = new CFilm($db, $_SERVER['QUERY_STRING']);

$stelixx['main'] = $film->getContent();

// Add style
//$stelixx['stylesheets'][] = 'css/filmer.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
