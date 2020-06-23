<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Min filmdatabas";

$clas = "navbar";

echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] = <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Min filmdatabas</span>
EOD;

if(!headers_sent()){ 
		session_start();
}

//echo phpinfo(); //////////////////////////////////////////////////////////
$stelixx['main'] = "";

$db = new CDatabase($stelixx['database']);
$inlogging = new CLogin($db);
echo $inlogging->getForm();

if($inlogging->isAuth() ){
	echo "isAuth 056<br>"; ////////////////////////////////////////////////////////////////////////////////
	$kmom04 = new CKmom04($db, $_SERVER['REQUEST_URI'], "movie");
	$limit = 4;
	$stelixx['main'] .= $kmom04->createPage();
}

echo "session dump kmom04 4568-->" . dump( $_SESSION) . "<--<br>"; ////////////////////////////////////////////////////////////////

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
