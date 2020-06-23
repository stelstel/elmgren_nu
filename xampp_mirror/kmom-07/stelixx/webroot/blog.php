<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */

// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$db = new CDatabase($stelixx['database']);
$cont = new CBlogContent($db);
$inlogging = new CLogin($db);

$stelixx['header'] .= "<span class='sitetitle'>Nyheter</span>";

$stelixx['title'] = $cont->show($_REQUEST, "blogTitle");

$stelixx['main'] = null;

if($inlogging->isAuth() ){
	$stelixx['main'] = showBlogLinks();
}

$stelixx['main'] .= $cont->show($_REQUEST, "blogMain");

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
