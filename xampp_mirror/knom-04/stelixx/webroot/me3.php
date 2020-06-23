<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Stefans me sida";

$stelixx['header'] .= "<span class='sitetitle'>Me</span>";

$stelixx['main'] = <<<EOD
<h1>Hej!</h1>
<p>Jag heter Stefan Elmgren är 47 år gammal och bor i Stockholm.</p>
<p align="center"><img src="img/stel.jpg" alt="Stefan Elmgren" width="432" height="465" /></p>
EOD;

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
?>
