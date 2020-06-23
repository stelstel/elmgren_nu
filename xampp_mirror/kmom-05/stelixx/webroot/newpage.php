<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Ny sida";

$db = new CDatabase($stelixx['database']);

$stelixx['main'] = $stelixx['links'];

$inlogging = new CLogin($db);

if($inlogging->isAuth() ){
	$cont = new CContent($db);
	if($_SERVER['QUERY_STRING'] != ""){
		$stelixx['main'] .= $cont->addPostOrPage($_SERVER['QUERY_STRING']);	
	}
	$stelixx['main'] .= CBlogForm::showAddForm("page");
}else{
	$stelixx['main'] .= "<br><p>Du måste logga in för att komma åt denna sida</p>";
}

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
