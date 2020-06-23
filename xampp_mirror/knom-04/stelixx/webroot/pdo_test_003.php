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

//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //Sets object style fetching

// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$statem = $pdo->prepare($sql); // Statement
$statem->execute();
$result = $statem->fetchAll();

echo "<pre>" . htmlentities(print_r($result, 1)) . "</pre>";

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

$i = 0;

//foreach (array_expression as $key => $value)
//    statement

//This form will additionally assign the current element's key to the $key variable on each iteration. 

// Below a variant of teachers solution. Result is the same

echo <<< EOT
<br>
<table border="1">
<tr>
    <th scope="col">Rad</th>
    <th scope="col">Id</th>
    <th scope="col">Bild</th>
    <th scope="col">Titel</th>
    <th scope="col">År</th>
  </tr>
EOT;

foreach($result as $key=>$val){
	echo "<tr>";
	echo "<td>" . $key . "</td>";
	echo "<td>" . $val["id"] . "</td>";
    echo "<td>" . $val["image"] . "</td>";
    echo "<td>" . $val["title"] . "</td>";
    echo "<td>" . $val["YEAR"] . "</td>";
    echo "</tr>";
}

echo "</table>";

?>
