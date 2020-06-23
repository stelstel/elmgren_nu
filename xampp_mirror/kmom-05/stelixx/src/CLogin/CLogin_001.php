<?php
class CLogin {
	public function __construct() {
		echo $this->putForm();	
	}

	// Check if user is authenticated.
	private function isAuth(){
			$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
	 
		if($acronym) {
			$output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
		}
		else {
			$output = "Du är INTE inloggad.";
		}
	}
	
	public function getLogin(){
		$state = false;
		return $state; 	
	}
	
	//*****************************************************************************
	private function putForm(){
	$frm = <<<EOD
		<form id="form1" name="form1" method="post" action="">
			<fieldset>
				<legend>Logga in</legend>
				<p>Användare: <br />
					<label for="txtUser"></label>
					<input type="text" name="txtUser" id="txtUser" />
				</p>
				<p>Lösenord:<br />
					<label for="txtPassword"></label>
					<input type="text" name="txtPassword" id="txtPassword" />
				</p>
				<p>
					<input type="submit" name="btnLogin" id="btnLogin" value="Logga in" />
					&nbsp;
					<input type="submit" name="btnLogout" id="btnLogout" value="Logga ut" />
				</p>
			</fieldset>
		</form>
EOD;
		return $frm;
	}
}