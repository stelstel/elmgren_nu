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
$filmer = new CFilmer($db, $_SERVER['REQUEST_URI'], "movie");

$stelixx['header'] .= "<span class='sitetitle'>Filmer</span>";
$stelixx['header'] .= $filmer->searchForm();

$stelixx['main'] = $filmer->createPage();

// Add style
$stelixx['stylesheets'][] = 'css/filmer.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
