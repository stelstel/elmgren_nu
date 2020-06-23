<?php

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

// Get parameters for sorting
$title = isset($_GET['title']) ? $_GET['title'] : null;
 
// Do SELECT from a table
if($title) {
	$title = htmlentities($title);
  	// prepare SQL for search
  	$sql = "SELECT * FROM Movie WHERE title LIKE '" . $title . "';";
	echo $sql;////////////////////////////////////
} 
else {
	// prepare SQL to show all
  	$sql = "SELECT * FROM Movie;";
}

$statem = $pdo->prepare($sql); // Statement
$statem->execute();
$result = $statem->fetchAll();

echo <<< EOT
<table border="1">
<tr>
    <th scope="col">Rad</th>
    <th scope="col">Id</th>
    <th scope="col">Bild</th>
    <th scope="col">Titel</th>
    <th scope="col">År</th>
  </tr>
EOT;

$i = 0;

foreach($result as $res){
	echo "<tr>";
	echo "<td>" . $i++ . "</td>";
	echo "<td>" . $res["id"] . "</td>";
    echo "<td>" . $res["image"] . "</td>";
    echo "<td>" . $res["title"] . "</td>";
    echo "<td>" . $res["YEAR"] . "</td>";
    echo "</tr>";
}


echo <<< EOT
	<form>
	<fieldset>
	<legend>Sök</legend>
	<p><label>Titel (delsträng, använd % som *): <input type='search' name='title' value='{$title}'/></label></p>
	<p><a href='?'>Visa alla</a></p>
	</fieldset>
	</form>
EOT;

?>