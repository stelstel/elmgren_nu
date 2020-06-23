<?php
class CLogin {
	public function __construct($dataBase) {
		session_start();
		
		if($this->loginAttempt($dataBase) ){
			echo $this->putForm("in");	
			header("location:kmom_04_008.php");
		}else{
			echo "Wrong Username or Password";
			echo $this->putForm("notIn");		
		}
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
	private function loginAttempt($dataB){
		$table = "user";
		$success = false;
		
		parse_str($_SERVER['QUERY_STRING']);
		
		if(isset($btnLogin) ){ // Log in button pressed
			if(isset($txtUser) ){
				$userName = $txtUser;
				if($this->isAuth($userName)){
					return true;
				}
			}
			
			if(isset($txtPassword) ){
				$passwd = $txtPassword;
								
				$sql = "SELECT acronym, name FROM USER WHERE acronym ='" . $userName . "' AND password='" . $passwd . "'";
				
				$result = $dataB->ExecuteSelectQueryAndFetchAll($sql);
				
				if($result){
					$_SESSION['user'] = $userName;
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
EOD;
						
$frm .= <<<EOD
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