<?php

if(isset($_GET['genre']) ){
	$chosenGenre = $_GET['genre'];		
}else{
	$chosenGenre = null;
}

// Connect to a MySQL database using PHP PDO
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'stefanRoot';
$password = 'canip5311';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

try {
	$pdo = new PDO($dsn, $login, $password, $options);
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

//echo '<form id="form1" name="form1" method="post" action="">';
echo '<form>';
echo '<p>';
echo '<label for="1">Genrer</label>';
echo '<select name="genre" id="genre">';
$sql = "SELECT name FROM Genre;";
$statem = $pdo->prepare($sql); // Statement
$statem->execute();
$result = $statem->fetchAll();
foreach($result as $res){
	echo '<option value="' . $res["name"] . '"';
	if($chosenGenre == $res["name"]){
		echo ' selected="selected"';	
	} 
	echo '>' . $res["name"] . '</option>' . "\n";
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
//echo "sql: " . $sql;
$statem = $pdo->prepare($sql); // Statement
$statem->execute();
$result = $statem->fetchAll();

//echo "<pre>" . htmlentities(print_r($result, 1)) . "</pre>";

foreach($result as $res){
	echo $res[0] . "<br>";	
}

?>