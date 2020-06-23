<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$db = new CDatabase($stelixx['database']);
$cont = new CContent($db);
$inlogging = new CLogin($db);

$stelixx['title'] = $cont->show($_REQUEST, "blogTitle");

$stelixx['main'] = CKmom5Links::showLinks();

if($inlogging->isAuth() ){
	$stelixx['main'] .= $cont->show($_REQUEST, "blogMain");
}else{
	$stelixx['main'] .= "<br><p>Du måste logga in för att komma åt denna sida</p>";
}

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
