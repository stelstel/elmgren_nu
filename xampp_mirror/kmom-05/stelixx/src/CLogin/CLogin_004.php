<?php
class CLogin {
	public function __construct() {
		if(!$this->getLogin()){
			echo $this->putForm();	
		}
	}
	
	//****************************************************************************
	// Check if user is authenticated.
	private function isAuth(){
		$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
	 
		if($acronym) {
			$loggedIn = true;
			//$output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
		}
		else {
			$loggedIn = false;
			//$output = "Du är INTE inloggad.";
		}
		return $loggedIn;
	}
	
	//*****************************************************************************
	public function getLogin(){
		if($this->isAuth()){
			echo "truuuue"; //////////////////////////////////////////////////////////
			return true;
		}
		
		$this->loginAttempt();
		
		$state = false;
		//$state = true;//////////////////////////
		echo "state 456" . $state . "<br>"; //////////////////////////////////////////
		return $state; 	
	}
	
	//*****************************************************************************
	private function loginAttempt(){
		echo $_SERVER['QUERY_STRING'];	
	}
	
	//*****************************************************************************
	private function putForm(){
	$frm = <<<EOD
		<form id="form1" style="width:500px;" name="form1" method="post" action="">
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