<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$anax['stylesheets'][] = 'css/figure.css'; 
$anax['stylesheets'][] = 'css/gallery.css'; 
$anax['stylesheets'][] = 'css/breadcrumb.css'; 

$gal = new CGallery("");
$breadC = $gal->createBreadcrumb("");

$stelixx['title'] = "Ett galleri";
$stelixx['main'] = <<<EOD
<h1>{$stelixx['title']}</h1>
EOD;
//$breadcrumb
//$gallery

$stelixx['main'] .= $breadC;
$stelixx['main'] .= $gal->getGallery();

// Finally, leave it all to the rendering phase of Anax.
include(STELIXX_THEME_PATH);