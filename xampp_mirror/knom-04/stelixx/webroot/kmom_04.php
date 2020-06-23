<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Min filmdatabas";

$stelixx['header'] .= "<span class='sitetitle'>Min filmdatabas</span>";

$db = new CDatabase($stelixx['database']);
$inlogging = new CLogin($db);
$stelixx['main'] = $inlogging->getForm();

if($inlogging->isAuth() ){
	$movies = new CMovies($db, $_SERVER['REQUEST_URI'], "movie");
	$limit = 4;
	$stelixx['main'] .= $movies->createPage();
}

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
