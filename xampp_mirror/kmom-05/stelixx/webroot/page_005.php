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

$db = new CDatabase($stelixx['database']);
$cont = new CContent($db);
//$cont->showPage($_REQUEST);

$stelixx['title'] = $cont->showPage($_REQUEST, "pageTitle");

$clas = "navbar";

echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] = <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Blogg</span>
EOD;

$stelixx['main'] = $cont->showPage($_REQUEST, "pageMain");
//$stelixx['main'] = "<h1>Hem</h1>"; //- SKALL ERSÄTTAS AV TITLE FRÅN CCONTENT

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
