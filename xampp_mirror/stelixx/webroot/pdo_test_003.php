<?php

// Connect to a MySQL database using PHP PDO
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'acronym';
$password = 'password';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

try {
	$pdo = new PDO($dsn, $login, $password, $options);
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$sth = $pdo->prepare($sql); // Statement
$sth->execute();
$res = $sth->fetchAll();

echo $res;

?>
