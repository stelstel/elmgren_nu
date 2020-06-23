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

session_start();

$db = new CDatabase($stelixx['database']);
if(isset($_GET['txtUser']) ){
	$sql = "SELECT acronym, salt FROM user WHERE acronym = '" . $_GET['txtUser'] . "'";
	$res = $db->ExecuteSelectQueryAndFetchAll($sql);
}
//echo "sqldump: " . dump($sql) . "<br>";//////////////////////////////////////////


if(isset($_GET['txtPasswd']) AND strlen($_GET['txtPasswd']) > 0){
	if($_GET['txtPasswd'] == md5($res[0]->acronym . $res[0]->salt) ){
		$_SESSION['acronym'] = $res[0]->acronym;
	}
}

$main = <<<EOD

<form>
  <label for="txtUser">Användarnamn:</label>
  <input type="text" name="txtUser" id="txtUser" />
  <label for="txtPasswd">Lösenord: </label>
  <input type="password" name="txtPasswd" id="txtPasswd" />
  <input type="submit" name="button" id="button" value="Submit" />
	<input type="submit" name="button" id="button" value="Logout" />
</form>
EOD;

if(isset($_GET['button']) AND $_GET['button'] == 'Logout'){

}

$stelixx['main'] = $main;

// Check if user is authenticated.

if(isset($_GET['txtUser']) AND $_GET['txtUser'] == $_SESSION['acronym'] ){
	$output = "Du är inloggad som: " . $_GET['txtUser'] . " (" . $_SESSION['acronym'] . ")";		
}else{
	$output = "Du är INTE inloggad.";	
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
