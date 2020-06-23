<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Min filmdatabas";

$clas = "navbar";

echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] = <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Min filmdatabas</span>
EOD;

$searchForm = new CSearchFormKmom04();

$stelixx['main'] = <<<EOD
EOD;

$stelixx['main'] .= $searchForm->getHtml();

$db = new CDatabase($stelixx['database']);

$sql = "SELECT title, YEAR FROM movie";
$result = $db->ExecuteSelectQueryAndFetchAll($sql);

$stelixx['main'] .= "<table border='1' align='center' cellspacing='0'><tr><th scope='col'>Titel</th><th scope='col'>År</th></tr>";

foreach($result AS $key=>$value){
	$stelixx['main'] .=	"<tr>";
  $stelixx['main'] .= "<td>" . $value->title . "</td>";
  $stelixx['main'] .= "<td>" . $value->YEAR . "</td>";
  $stelixx['main'] .=	"</tr>";
}

$stelixx['main'] .= "</table>";		

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
?>
