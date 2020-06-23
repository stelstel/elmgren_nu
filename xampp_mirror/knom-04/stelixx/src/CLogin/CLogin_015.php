<?php
class CLogin {
	public function __construct($dataBase) {
		echo "i CLogin konstruktor<br>"; ///////////////////////////////////////////////////////////
		$frm = "";
		if(headers_sent()){ 
			//echo "Error, Header already sent. 001"; 
		}else{
			if (session_status() == PHP_SESSION_NONE) {
    		session_start();
				echo "Session starting<br>"; ///////////////////////////////////////////////////////////
				}
		}
		
		echo "Session status-->" . session_status() ."<--<br>"; ////////////////////////////////////////////////////
		
		if($this->loginAttempt($dataBase) OR $this->isAuth()){
			$this->putForm("in");
		}else{
			$frm .= "Fel användarnamn eller lösenord. ";
			echo $this->putForm("notIn");		
		}
		echo "session dump CLogin 1212" . dump( $_SESSION) . "<br>"; ////////////////////////////////////////////////////////////////
	}
	
	//****************************************************************************
	// Check if user is authenticated.
	public function isAuth(){
		echo "Session status isAuth-->" . session_status() ."<--<br>"; ////////////////////////////////////////////////////
		//$acronym = isset($_SESSION['user']) ? $_SESSION['user'] : null;
		if(isset($_SESSION['user'])){
			$acronym = $_SESSION['user'];
		}else{
		
		}
	 	
	 	echo "acronym Clogin:" . $acronym . "<-<br>"; //////////////////////////////////////////////////////////////////////
	 	echo "session dump CLogin 7899" . dump( $_SESSION) . "<br>"; ////////////////////////////////////////////////////////////////
	 	echo "session_user CLogin 0013: " . $_SESSION['user'] . "<br>"; ///////////////////////////////////////////////////////// 
	 	//echo "session_status 011: " . session_status() . "<br>"; /////////////////////////////////////////////////////////

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
		
		//echo "session_user 002: " . $_SESSION['user'] . "<br>"; ///////////////////////////////////////////////////////// 

		parse_str($_SERVER['QUERY_STRING']);
		
		//echo $_SERVER['QUERY_STRING']; //////////////////////////////////////////////////////////////////////////////////
		
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
					//echo "session_user 003: " . $_SESSION['user'] . "<br>"; ///////////////////////////////////////////////////////// 
				}
			}
		}
		
		if(isset($btnLogout) ){ // Log out button pressed
				$acronym = null;
				if (session_status() == PHP_SESSION_ACTIVE) {
					session_unset(); 
					echo "session_destroyed<br>"; ///////////////////////////////////////////////////////////////////////////////////// 
					session_destroy();
				}
			}
		echo "session dump CLogin 4545" . dump( $_SESSION) . "<br>"; ////////////////////////////////////////////////////////////////		
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
	echo "session dump CLogin 9632" . dump( $_SESSION) . "<br>"; ////////////////////////////////////////////////////////////////
	}
	
	//*********************************************************************************
	public function getForm(){
		return $this->frm;
		echo "session dump CLogin 7412" . dump( $_SESSION) . "<br>"; ////////////////////////////////////////////////////////////////
	}
}