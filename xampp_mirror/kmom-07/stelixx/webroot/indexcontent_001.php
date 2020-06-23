<?php
$table = "movie";
$imgPath 		= "filmer/";
$imgHeight 	= 180;

$db = new CDatabase($stelixx['database']);
$sql = "SELECT * FROM " . $table . " ORDER BY added DESC LIMIT 3";

$output = "<H1>Välkommen till Moviez</H1>";
$output .= "<p>Vi vet att du har ett meningslöst tomt liv så här kommer våra tre senaste rullar</p>";

$result = $db->ExecuteSelectQueryAndFetchAll($sql);

foreach($result AS $key=>$value){
	$link = '<a href="film.php?id=' . $value->id . '">';
	$output .= '<p class="centeredImage">' . $link . '<img src="img.php?src=' . $imgPath; 
	$output .= $value->smallimg . '&height=' . $imgHeight . '&sharpen"/></p>';
	$output .= $link . $value->title;
	$output .= $value->YEAR;
	//$output .= "<td>" . $this->getCategories($value->id) . "</td>";
	$output .= $value->price . " kr";
	$output .=	"</tr>";
}

/*
<table>
  <tr>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
</table>
*/


