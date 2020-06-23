<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Titel";

$clas = "navbar";

echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] = <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Logga in</span>
EOD;



$stelixx['main'] = <<<EOD
<form>
  <label for="txtUser">Användarnamn:</label>
  <input type="text" name="txtUser" id="txtUser" />
  <label for="txtPasswd">Lösenord: </label>
  <input type="password" name="txtPasswd" id="txtPasswd" />
  <input type="submit" name="button" id="button" value="Submit" />
</form>
EOD;

// Check if user is authenticated.
$acronym = isset($_SESSION['txtUser']) ? $_SESSION['txtUser']->acronym : null;
 
if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['txtUser']->name})";
}
else {
  $output = "Du är INTE inloggad.";
	$db = new CDatabase($stelixx['database']);
	//$sql = "SELECT * FROM user";////////////////////////////////////
	$sql = "SELECT acronym, salt FROM user WHERE acronym = '" . $_GET['txtUser'] . "'";
	//$sql = "SELECT name, salt FROM user WHERE acronym = 'arne'"; ///////////////////////////////////////////////
	echo "sqldump: " . dump($sql) . "<br>";//////////////////////////////////////////
	$res = $db->ExecuteSelectQueryAndFetchAll($sql);
	
	echo "resdump: " . dump($res) . "<br>";//////////////////////////////////////////
	echo "pw: " . $_GET['txtPasswd'] . "<br>";
	echo "pw2: " . md5($res[0]->acronym . $res[0]->salt) . "<br>";
	if($_GET['txtPasswd'] == md5($res[0]->acronym . $res[0]->salt) ){
			echo "Inloggad<br>";
	}
}
echo $output;


// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
?>
