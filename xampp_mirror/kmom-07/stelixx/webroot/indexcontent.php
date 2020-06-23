<?php
$movieTable = "movie";
$blogTable 	= "content";
$imgPath 	= "filmer/";
$imgHeight 	= 250;
$imgWidth 	= 960;
$URI 				= "filmer.php";
$url 				= "img.php?src=ministry_of_silly_thin.png&width=" . $imgWidth . "&sharpen";
$futuMovies = array("dd2.jpg", "mockingjay.jpg", "gone_girl.jpg", "mskpappa.jpg", "sincity2.gif");

$db = new CDatabase($stelixx['database']);
$sql = "SELECT * FROM " . $movieTable . " ORDER BY added DESC LIMIT 3";

$output = "<H1>Välkommen till Moviez</H1>";
$output .= "<p>Den personliga videoaffären</p>";

$output .= "<h3>Kommande filmer</H3>";
$output .= '<p class="centeredImage"><img src="img/' . $imgPath . '/' . $futuMovies[0] . '"/>';
$output .= '&nbsp;<img src="img/' . $imgPath . '/' . $futuMovies[1] . '"/>';
$output .= '&nbsp;<img src="img/' . $imgPath . '/' . $futuMovies[2] . '"/>';
$output .= '&nbsp;<img src="img/' . $imgPath . '/' . $futuMovies[3] . '"/>';
$output .= '&nbsp;<img src="img/' . $imgPath . '/' . $futuMovies[4] . '"/></p>';

// Latest movies *********************************************************
$result = $db->ExecuteSelectQueryAndFetchAll($sql);
$i = 1;

foreach($result AS $key=>$value){
	//${$test.$i} = value
	${"link" . $i} = '<a href="film.php?id=' . $value->id . '">';
	${"movie" . $i} = '<p class="centeredImage">' . ${"link" . $i} . '<img src="img.php?src=' . $imgPath; 
	${"movie" . $i} .= $value->smallimg . '&height=' . $imgHeight . '&sharpen"/></p></a>';
	${"movie" . $i} .= ${"link" . $i} . $value->title . " (" ;
	${"movie" . $i} .= $value->YEAR . ")</a><br>";
	$film = new CFilmer($db, $URI, null);
	${"movie" . $i} .= $value->price . " kr";
	$i++;
}

$output .= "<h3>De senaste tre filmerna</H3>";

$output .= '<table width="70%" align="center">';
//$output .= '<tr><th colspan="3" bgcolor="#999999"" scope="col"><H4>De senaste filmerna</H4></th></tr>';
$output .= "<tr>";
$output .= '<td align="center" scope="col">' . $movie1 .'</td>';
$output .= '<td align="center" scope="col">' . $movie2 .'</td>';
$output .= '<td align="center" scope="col">' . $movie3 .'</td>';
$output .= "</tr>";
$output .= "</table>";

// Latest blogs *****************************************************************************
$output .= '<p class="centeredImage"><img src="' . $url . '"/></p>';
$output .= "<h3>Den senaste blogposten</H3>";
$cont = new CBlogContent($db);
$output .= $cont->show("3latest", "blogMain");
