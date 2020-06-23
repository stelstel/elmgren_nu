<?php 
/**
 * This is a Stelixx pagecontroller. a PHP skript to process images using PHP GD.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$stelixx['title'] = "";

$img = new CImage($_REQUEST);

$stelixx['main'] = $img->getImage();

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);

