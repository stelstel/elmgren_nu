<?php
$table = "movie";
$imgPath 		= "filmer/";
$imgHeight 	= 180;
//$movie1 = $movie2 = $movie3 = null;

$db = new CDatabase($stelixx['database']);
$sql = "SELECT * FROM " . $table . " ORDER BY added DESC LIMIT 3";

$output = "<H1>Välkommen till Moviez</H1>";
$output .= "<p>Vi vet att du har ett meningslöst tomt liv så här kommer våra tre senaste rullar</p>";

$result = $db->ExecuteSelectQueryAndFetchAll($sql);

$i = 1;

foreach($result AS $key=>$value){
	//${$test.$i} = value
	${"link" . $i} = '<a href="film.php?id=' . $value->id . '">';
	${"movie" . $i} = '<p class="centeredImage">' . ${"link" . $i} . '<img src="img.php?src=' . $imgPath; 
	${"movie" . $i} .= $value->smallimg . '&height=' . $imgHeight . '&sharpen"/></p></a>';
	${"movie" . $i} .= ${"link" . $i} . $value->title . " (" ;
	${"movie" . $i} .= $value->YEAR . ")</a><br>";
	//$output .= "<td>" . $this->getCategories($value->id) . "</td>";
	${"movie" . $i} .= $value->price . " kr";
	$i++;
}

$output .= "<table>";
$output .= "<tr>";
$output .= '<td scope="col">' . $movie1 .'</td>';
$output .= '<td scope="col">' . $movie2 .'</td>';
$output .= '<td scope="col">' . $movie3 .'</td>';
$output .= "</tr>";
$output .= "</table>";



