<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Återställ databasen";

$db = new CDatabase($stelixx['database']);
$inlogging = new CLogin($db);
$cont = new CContent($db);

$stelixx['main'] = CKmom5Links::showLinks();

if($inlogging->isAuth() ){		
	(isset($_POST['restore']) ? $output = "<br>Databasen är återställd" : $output = "");
	$frm = '<p></p><form method="post"><input type="submit" name="restore" id="button" value="Återställ databasen"></button>';
	$frm .= "<output><br>$output</output></form>";
	$stelixx['main'] .= $frm;
	(strpos($stelixx['main'], 'Databasen är återställd') ? $cont->reset() : null );
}else{
	$stelixx['main'] .= "<br><p>Du måste logga in för att komma åt denna sida</p>";	
}

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);