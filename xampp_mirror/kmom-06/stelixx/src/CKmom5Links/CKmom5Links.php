<?php
class CKmom5Links {
	public static function showLinks(){
		$output =<<<EOD
			<a href="kmom_05.php">Hem</a> 
			<a href="login.php">Logga in/Logga ut</a>
			<a href="newpost.php">Ny blogpost</a>
			<a href="newpage.php">Ny sida</a>
			<a href="blog.php">Visa alla blogposter</a>
			<a href="reset.php">Återställ databasen</a>				
EOD;
		return $output;
	}

}