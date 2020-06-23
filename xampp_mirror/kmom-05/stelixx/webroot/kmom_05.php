<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Blogg";

$stelixx['header'] .= "<span class='sitetitle'>Blogg</span>";

$db = new CDatabase($stelixx['database']);
$inlogging = new CLogin($db);

$stelixx['main'] = $stelixx['links'];

$cont = new CContent($db);

if($inlogging->isAuth() ){
	$stelixx['main'] .= $cont->showAll();
}else{
	$stelixx['main'] .= $cont->showSome();
}

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
