<?php
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Månadens Babe";

//$clas = "navbar";

//echo CNavigation::GenerateMenu($menu, $clas);

//$main = ""; //String containing HTML

//$stelixx['header'] .= "<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>";

// Small calender left ******************************************
$smallLeft = new CCalendrSmall($_SERVER['QUERY_STRING'], -1);

$stelixx['header'] .= "<span class='sitetitle'>Månadens babe</span>";

$main = "<div id=\"leftPanel\">";
$main .= $smallLeft->createTable();
$main .= "</div>";

// Big calender ******************************************
$calName = new CCalendr($_SERVER['QUERY_STRING']);

$main .= "<div id=\"middlePanel\">";
$main .= $calName->createTable();
$main .= "<p style=\"text-align: center\">";
$main .= $calName->linkBack() . "&nbsp;";
$main .= $calName->linkForward();
$main .= "</p>";
$main .= "</div>";

// Small calender right ******************************************
$smallRight = new CCalendrSmall($_SERVER['QUERY_STRING'], 1);

$main .= "<div id=\"rightPanel\">";
$main .= $smallRight->createTable();
$main .= "</div>";

$stelixx['main'] = $main;

// Add style for csource
//$stelixx['stylesheets'][] = 'css/nav.css';
$stelixx['stylesheets'][] = 'css/manadens_babe.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
