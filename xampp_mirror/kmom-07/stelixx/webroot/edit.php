<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$db = new CDatabase($stelixx['database']);
$cont = new CContent($db);
//$cont->showPage($_REQUEST);

$stelixx['title'] = "Uppdatera";

$clas = "navbar";

//$stelixx['header'] = CNavigation::GenerateMenu($menu, $clas);
//$stelixx['header'] .= <<<EOD
//<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
//<span class='sitetitle'>Blogg</span>
//EOD;

//$stelixx['main'] = CKmom5Links::showLinks();
//SLUG (eller ID) måste komma utifrån från länk "editera" på sidan kmom_05 //////////////////////////////////////////////////////////////////////
$stelixx['main'] = $cont->showUpdateForm($_SERVER['QUERY_STRING']);

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
