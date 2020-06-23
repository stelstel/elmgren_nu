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
if(isset($_GET['year1']) ){
	$year1 = $_GET['year1'];		
}

if(isset($_GET['year2']) ){
	$year2 = $_GET['year2'];		
}

//$year2 = isset($_GET['year2']);
//echo $_GET['year1'] . "<br>";/////////////////////////////////////////////
//echo "year1" . $year1; ////////////////////////////////////////////////////
//echo "year2" . $year2; //////////////////////////////////////////////////// 
// Do SELECT from a table
if($year1 AND $year2) {
	$year1 = htmlentities($year1);
	$year2 = htmlentities($year2);
  	// prepare SQL for search
  	$sql = "SELECT * FROM Movie WHERE YEAR >= " . $year1 . " AND YEAR <=" . $year2 . ";";
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
			<p><label>Skapad mellan åren: 
    		<input type='text' name='year1' value='{$year1}'/>
    		- 
    		<input type='text' name='year2' value='{$year2}'/>
  			</label>
			</p>
			<p><input type='submit' name='submit' value='Sök'/></p>
			<p><a href='?'>Visa alla</a></p>
		</fieldset>
	</form>
EOT;

?>