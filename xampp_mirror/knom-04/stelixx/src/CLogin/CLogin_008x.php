<?php
class CLogin {
	public function __construct() {
		session_start();
				
		if(!$this->loginAttempt() ){
			echo $this->putForm("notIn");	
		}else{
			echo $this->putForm("in");	
		}
		
		
		//$_SESSION["acronym"] = "green"; ////////////////////////////////////////////////////
		echo "<br>session: " . print_r($_SESSION) . "<br>"; /////////////////////////////////
	}
	
	//****************************************************************************
	// Check if user is authenticated.
	private function isAuth(){
		//$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
		$acronym = isset($_SESSION['user']) ? $_SESSION['user'] : null;
	 
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
	public function loginAttempt(){
		$success = false;
		parse_str($_SERVER['QUERY_STRING']);
		
		if(isset($btnLogin) ){ // Log in button pressed
			if(isset($txtUser) ){
				$userName = $txtUser;
			}
			
			if(isset($txtPassword) ){
				$passwd = $txtPassword;
				echo "password" . $passwd . "<br>"; //////////////////////////////////////////////
				if($this->isAuth($userName)){
					echo "truuuue"; //////////////////////////////////////////////////////////
					return true;
				}
				
				if($userName == "Stefan" AND $passwd == "banan"){
					$_SESSION["user"] = "Stefan"; ////////////////////////////////////////////////////
					echo "success!!<br>"; //////////////////////////////////////////////////
					$success = true;
				}
			}
		}
		
		if(isset($btnLogout) ){ // Log out button pressed
			echo "in log out<br><br>"; /////////////////////////////////////////////////////////////////////
			unset($_SESSION['user']);
			session_unset(); 
			if(isset($_SESSION['user']) ){
				session_destroy();
			}
			echo "<br>session after destro: " . print_r($_SESSION) . "<br>"; /////////////////////////////////
		}		
		
		
		return $success;	
	}
	
	//*****************************************************************************
	private function putForm($inOrNot){
		if($inOrNot == "notIn"){
			$frm = <<<EOD
				<form style="width:500px;">
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
		}else{
			$frm = <<<EOD
				<form style="width:500px;">
					<fieldset>
						<legend>Logga ut</legend>
						<p>
							<input type="submit" name="btnLogout" id="btnLogout" value="Logga ut" />
						</p>
					</fieldset>
				</form>
EOD;
		}
			return $frm;
	}
}