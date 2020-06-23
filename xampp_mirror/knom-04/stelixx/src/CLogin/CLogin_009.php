<?php
class CLogin {
	public function __construct() {
		session_start();
				
		if($this->loginAttempt() ){
			//echo $this->putForm("in");	
			//header("location:kmom_04_008.php");
		}else{
			echo "Wrong Username or Password";
			echo $this->putForm("notIn");		
		}
				
		//$_SESSION["acronym"] = "green"; ////////////////////////////////////////////////////
		echo "<br>session: " . print_r($_SESSION) . "<br>"; /////////////////////////////////
	}
	
	//****************************************************************************
	// Check if user is authenticated.
	private function isAuth(){
		//$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
		$acronym = isset($_SESSION['user']) ? $_SESSION['user'] : null;
	 	
		echo "acronym" . $acronym . "<br>"; ////////////////////////////////////////
		
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
	private function loginAttempt(){
		$success = false;
		parse_str($_SERVER['QUERY_STRING']);
		
		if(isset($btnLogin) ){ // Log in button pressed
			if(isset($txtUser) ){
				$userName = $txtUser;
			}
			
			if(isset($txtPassword) ){
				$passwd = $txtPassword;
				if($this->isAuth($userName)){
					echo "truuuue"; //////////////////////////////////////////////////////////
					return true;
				}
				
				if($userName == "Stefan" AND $passwd == "banan"){
					$_SESSION["user"] = "Stefan"; ////////////////////////////////////////////////////
					$success = true;
				}
			}
		}
		
		if(isset($btnLogout) ){ // Log out button pressed
				$acronym = null;
				session_unset(); 
				session_destroy();
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