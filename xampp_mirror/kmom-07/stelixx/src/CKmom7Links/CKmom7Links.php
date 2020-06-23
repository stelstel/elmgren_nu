<?php
class CKmom7Links {
	public static function showLinks(){
		$output =<<<EOD
				<div style="text-align:center">    
 					<a href="index.php" >Hem</a> 
					<a href="filmer.php">Filmer</a>
					<a href="nyheter.php">Nyheter</a>
					<a href="om.php">Om</a>
					<a href="login.php">Logga in/ut</a>
				</div>
EOD;
		return $output;
	}

}