<?php
class CLogin {
	public function __construct($dataBase) {
		$frm;
		if(headers_sent()){ 
			echo "Error, Header already sent. 001"; 
		}else[
			session_start();
		}
		
		if($this->loginAttempt($dataBase) OR $this->isAuth()){
			$this->putForm("in");	
		}else{
			echo "Fel användarnamn eller lösenord. ";
			echo $this->putForm("notIn");		
		}
	}
	
	//****************************************************************************
	// Check if user is authenticated.
	private function isAuth(){
		//$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
		$acronym = isset($_SESSION['user']) ? $_SESSION['user'] : null;
	 	
		if($acronym) {
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
		
					//$frm = "<form style='width:800px;'><p>";
					$this->frm = "<form><p>";
					if($inOrNot == "notIn"){
						echo "Du är INTE inloggad. Logga in";	
					}elseif($inOrNot == "in"){
						echo "Du är inloggad som: {$_SESSION['user']}";
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
		
			//return $this->frm;
	}
	
	//*********************************************************************************
	public function getForm(){
		return $this->grm;
	}
}