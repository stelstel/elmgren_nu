<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Add post";

$clas = "navbar";

//echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] = CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] .= <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Blogg</span>
EOD;

if(!headers_sent()){ 
		session_start();
}

$db = new CDatabase($stelixx['database']);
$cont = new CContent($db);

$stelixx['main'] = CBlogForm::showAddForm("blog");

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
