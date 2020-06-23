<link href="css/manadens_babe_curr_month.css" rel="stylesheet" type="text/css">
<?php
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Månadens Babe";

$clas = "navbar";

echo CNavigation::GenerateMenu($menu, $clas);

$stelixx['header'] = <<<EOD
EOD;

if(isset($_GET['month'])){
	$intMonth = $_GET['month'];
}else
{
	$intMonth = date("n");		
}

if(isset($_GET['year'])){
	$year = $_GET['year']; 
}else
{
	$year = date("Y");		
}

$strMonth = date("F", mktime(null, null, null, $intMonth));
$startDayOfMonth = date("w", mktime(null, null, null, $intMonth , 1, $year));
$endDayOfMonth = date("t", mktime(null, null, null, $intMonth , 1, $year));
$weeksInMonth = 6; //denna måste ändras på något sätt

if(isset($_GET['fac'])){
	$fa = $_GET['fac']; 
}

//int mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )


$main = "<p class=\"monthHeader\">" . $strMonth. " " . $year . "</p>"; //Header

$main .= <<<EOD
	<table border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<th height="25" scope="col">Måndag</th>
		<th scope="col">Tisdag</th>
		<th scope="col">Onsdag</th>
		<th scope="col">Torsdag</th>
		<th scope="col">Fredag</th>
		<th scope="col">Lördag</th>
		<th scope="col">Söndag</th>
	  </tr>
EOD;

$main .= "\r\n"; // To make HTML source code more readable

$dat=0;

//for ($i=0; $i < $weeksInMonth; $i++){
while ($dat <= $endDayOfMonth){
	$main .= "<tr>";

	if($dat <= $endDayOfMonth){
		for($j=0; $j < 7; $j++){
			$main .= "<td>";
			
			if($j >= $startDayOfMonth - 1 AND $dat == 0) {
				$dat = 1; //Initialize $dat
			}
			
			if($dat > 0 AND $dat <= $endDayOfMonth){
				$main .= "<p>" . $dat++ . "</p>";
			}else{
				$main .= "&nbsp;";
			}
			$main .= "</td>";
		}
	}
	
	$main .= "</tr>";
	$main .= "\r\n"; // To make HTML source code more readable	
}

$main .="</table>";

$main .= "<a href=" . basename($_SERVER['PHP_SELF']);

// The link
if($intMonth > 1){ //Not january
	$linkMonth = $intMonth - 1;
	$linkYear = $year;
}else{ //january, change to december year before
	$linkYear = $year - 1;
	$linkMonth = 12;
}

$main .= "?year=" . $linkYear;
$main .= "&month=" . $linkMonth;
$main .= "&month=" . $linkMonth;

$main .= ">";

$main .= date("F", mktime(null, null, null, $linkMonth));

$main .= "</a>";

$stelixx['main'] = $main;	  

// Add style for csource
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
