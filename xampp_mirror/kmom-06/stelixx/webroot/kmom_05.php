<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
if(!headers_sent()){ 
	session_start();
}
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Blogg";

$db = new CDatabase($stelixx['database']);
$inlogging = new CLogin($db);

$stelixx['main'] = CKmom5Links::showLinks();

if($inlogging->isAuth() ){
	$cont = new CContent($db);
	$stelixx['main'] .= $cont->showAll();
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
