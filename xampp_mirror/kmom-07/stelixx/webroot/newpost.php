<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Ny bloggpost";

$db = new CDatabase($stelixx['database']);

$inlogging = new CLogin($db);

$stelixx['main'] = null;


if($inlogging->isAuth() ){
	$cont = new CContent($db);
	if($_SERVER['QUERY_STRING'] != ""){
		$stelixx['main'] .= $cont->addPostOrPage($_SERVER['QUERY_STRING']);	
	}
	$stelixx['main'] .= CBlogForm::showAddForm($db);
}else{
	$stelixx['main'] .= "<br><p>Du måste logga in för att komma åt denna sida</p>";
}

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
