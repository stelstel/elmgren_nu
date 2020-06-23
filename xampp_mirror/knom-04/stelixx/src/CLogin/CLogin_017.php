<?php
class CLogin {
	public function __construct($dataBase) {
		$frm = "";
		if(headers_sent()){ 
			//echo "Error, Header already sent. 001"; 
		}else{
			if (session_status() == PHP_SESSION_NONE) {
    		session_start();
			}
		}
		
		if($this->loginAttempt($dataBase) OR $this->isAuth()){
			$this->putForm("in");
		}else{
			$frm .= "Fel användarnamn eller lösenord. ";
			echo $this->putForm("notIn");		
		}
	}
	
	//****************************************************************************
	// Check if user is authenticated.
	public function isAuth(){
		//$acronym = isset($_SESSION['user']) ? $_SESSION['user'] : null;
		if(isset($_SESSION['user'])){
			$acronym = $_SESSION['user'];
		}else{
		
		}
	 	
	 	if(isset($acronym) ) {
			$loggedIn = true;
		}
		else {
			$loggedIn = false;
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
				if($this->isAuth()){
					$_SESSION['user'] = $userName;
					echo "return true 753<br>";
					return true;
				}
			}
			
			if(isset($txtPassword) ){
				$passwd = $txtPassword;
								
				$sql = "SELECT acronym, name FROM user WHERE acronym ='" . $userName . "' AND password='" . $passwd . "'";
				$result = $dataB->ExecuteSelectQueryAndFetchAll($sql);
				
				if($result){
					$_SESSION['user'] = $userName;
					$success = true;
				}
			}
		}
		
		if(isset($btnLogout) ){ // Log out button pressed
				$acronym = null;
				if (session_status() == PHP_SESSION_ACTIVE) {
					session_unset(); 
					session_destroy();
				}
			}
		return $success;	
	}
	
	//*****************************************************************************
	private function putForm($inOrNot){
		
					//$frm = "<form style='width:800px;'><p>";
					$this->frm = "<form><p>";
					if($inOrNot == "notIn"){
						$this->frm .= "Du är INTE inloggad. Logga in";	
					}elseif($inOrNot == "in"){
						$this->frm .= "Du är inloggad som: {$_SESSION['user']}";
					}
					$this->frm .= "</p>";
					$this->frm .= <<<EOD

	
						<p>Användare: 
							<label for="txtUser"></label>
							<input type="text" name="txtUser" id="txtUser" />
	Lösenord:
	<label for="txtPassword"></label>
							<input type="text" name="txtPassword" id="txtPassword" />
							<input type="submit" name="btnLogin" id="btnLogin" value="Logga in" />
							&nbsp;
							<input type="submit" name="btnLogout" id="btnLogout" value="Logga ut" />
	</p>
				</form>
EOD;
	}
	
	//*********************************************************************************
	public function getForm(){
		return $this->frm;
	}
}