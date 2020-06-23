<?php

/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Källkod";

//$clas = "navbar";

//echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] .= "<span class='sitetitle'>Stefans källkod</span>";

// Add style for csource
$stelixx['stylesheets'][] = 'css/nav.css';
$stelixx['stylesheets'][] = 'css/source.css';

 
// Create the object to display sourcecode
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));

// Do it and store it all in variables in the Anax container.
$stelixx['main'] = "<h1>Visa källkod</h1>\n" . $source->View();

//$stelixx['footer'] = <<<EOD
//<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
//EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);