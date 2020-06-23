<?php
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

if(isset($_GET['genre']) ){
	$chosenGenre = $_GET['genre'];		
}else{
	$chosenGenre = null;
}

$db = new CDatabase($stelixx['database']);

$sql = "SELECT name FROM Genre";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);
//dump($res);

echo '<form>';
echo '<p>';
echo '<label for="1">Genrer</label>';
echo '<select name="genre" id="genre">';
foreach($res AS $key => $val) {
	echo '<option value="' . $val->name . '"';
	if($chosenGenre == $val->name){
		echo ' selected="selected"';	
	}
	echo '>' . $val->name . '</option>' . "\n"; 
}

echo "</select>";
echo "</p>";
echo "<p>Visa filmer";
echo '<input type="submit" name="btnShow" id="btnShow" value="Submit" />';
echo "</p>";
echo "</form>";

$sql = <<< EOT
	SELECT DISTINCT Title 
	FROM movie
	INNER JOIN movie2Genre
	ON movie.id = movie2Genre.idMovie
	INNER JOIN genre
	ON movie2genre.idGenre = genre.id
EOT;
$sql .= " WHERE genre.name ='"  . $chosenGenre . "'";
$result = $db->ExecuteSelectQueryAndFetchAll($sql);

//echo dump($result);//////////////////////////////////////////////////////////////////

foreach($result AS $key => $val) {
	echo $val->Title . '<br>';
}

// Get a html representation of all queries made, for debugging and analysing purpose.
// @return string with html.
// echo $db->dump(); 
   

$stelixx['main'] = null;

// Add style for csource
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);

?>