<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Ny sida";

$clas = "navbar";

//echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] = CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] .= <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Blogg</span>
EOD;

if(!headers_sent()){ 
		session_start();
}

$db = new CDatabase($stelixx['database']);
$cont = new CContent($db);

$stelixx['main'] = CKmom5Links::showLinks();
//$stelixx['main'] .= CBlogForm::showResetForm();

/*if(isset($_POST['restore'])){
			$output = "<br>Databasen är återställd";
		}else{
			$output = "";
		}*/
		
(isset($_POST['restore']) ? $output = "<br>Databasen är återställd" : $output = "");
		

//($var > 2 ? true : false)

$frm = '<form method="post"><input type="submit" name="restore" id="button" value="Återställ databasen"></button>';
$frm .= "<output><br>$output</output></form>";
$stelixx['main'] .= $frm;

/*if(strpos($stelixx['main'], 'Databasen är återställd')){
	$cont->reset();	
}*/ 

(strpos($stelixx['main'], 'Databasen är återställd') ? $cont->reset() : null );

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);