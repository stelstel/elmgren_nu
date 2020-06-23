<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Filmer";

$db = new CDatabase($stelixx['database']);

//if($inlogging->isAuth() ){
	$filmer = new CFilmer($db, $_SERVER['REQUEST_URI'], "movie");
	$limit = 4;
	$stelixx['main'] = $filmer->createPage();
//}

// Add style
$stelixx['stylesheets'][] = 'css/film_table.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
