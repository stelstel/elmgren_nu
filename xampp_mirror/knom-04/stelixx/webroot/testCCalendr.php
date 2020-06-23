<?php

/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Test";

/*$clas = "navbar";

echo CNavigation::GenerateMenu($menu, $clas);*/

$stelixx['header'] = "";

$cal = new CCalendr("1970","10");

echo "<br>Created new CCalendr object<br>";

echo "<br>Testing if object was created: " . is_object($cal) . " <-should be 1<br>";

$cal->setYear("1950");

echo "<br>Tested setYear() and getYear(): " . $cal->getYear() . " <- should be 1950<br>";

$cal->setMonth("2");

echo "<br>Tested setMonth() and getMonth(): " . $cal->getmonth() . " <- should be 2<br>";

echo "<br>Exception expected below. Change exception test by commenting/uncommenting in code<br><br>";

// TESTING SETTER VALIDATORS. Remove comments to test
$cal->setYear("195"); //Should produce an exception. Wrong length
//$cal->setYear("19566"); //Should produce an exception. Wrong length
//$cal->setYear("195A"); //Should produce an exception. Contains characters that aren't digits
//$cal->setmonth("5A"); //Should produce an exception. Contains characters that aren't digits
//$cal->setmonth(""); //Should produce an exception. Wrong length
//$cal->setmonth("1234"); //Should produce an exception. Wrong length


$stelixx['main'] = "";

// Add style for csource
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
