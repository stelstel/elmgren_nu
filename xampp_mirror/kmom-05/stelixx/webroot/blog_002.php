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

$stelixx['title'] = $cont->show($_REQUEST, "blogTitle");

$clas = "navbar";

$stelixx['header'] = CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] .= <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Blogg</span>
EOD;
$stelixx['main'] = CKmom5Links::showLinks();
$stelixx['main'] .= $cont->show($_REQUEST, "blogMain");

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
