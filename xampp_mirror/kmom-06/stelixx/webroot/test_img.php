<?php 
/**
 * This is a Stelixx pagecontroller. a PHP skript to process images using PHP GD.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$stelixx['title'] = "";

$url = "img.php?src=kodim15.png";
$url2 = "img.php?src=kodim08.png&width=500&height=150&crop-to-fit";
$url3 = "img.php?src=kodim13.png&width=300&height=150&stretch";

$stelixx['main'] = '<p>Testar testar testar';
$stelixx['main'] .= '<img src="' . $url . '"/>';
$stelixx['main'] .= '<p>Testar testar testar';
$stelixx['main'] .= '<img src="' . $url2 . '"/>';


// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);

