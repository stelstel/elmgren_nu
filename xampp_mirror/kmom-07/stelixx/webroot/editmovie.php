<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$db = new CDatabase($stelixx['database']);
$cont = new CMovies($db);

$inlogging = new CLogin($db);

$stelixx['title'] = "Redigera film";

$stelixx['header'] .= "<span class='sitetitle'>Redigera film</span>";

if($inlogging->isAuth() ){
	$stelixx['main'] = $cont->showUpdateForm($_SERVER['QUERY_STRING']);
}else{
	$stelixx['main'] = '<br><p>Du måste <a href="login.php">logga in</a> för att komma åt denna sida</p>';
}

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
