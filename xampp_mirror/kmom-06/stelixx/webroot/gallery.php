<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$stelixx['stylesheets'][] = 'css/figure.css'; 
$stelixx['stylesheets'][] = 'css/gallery.css'; 
$stelixx['stylesheets'][] = 'css/breadcrumb.css'; 

if(isset($_GET["path"] )){
	$path = $_GET["path"];
}else{
	$path = "";
}

$gal = new CGallery($path);

$stelixx['title'] = "Ett galleri";

$stelixx['main'] = "<h1>{$stelixx['title']}</h1>";

$stelixx['main'] .= $gal->getBreadcrumb();;
$stelixx['main'] .= $gal->getGallery();

// Finally, leave it all to the rendering phase of Anax.
include(STELIXX_THEME_PATH);