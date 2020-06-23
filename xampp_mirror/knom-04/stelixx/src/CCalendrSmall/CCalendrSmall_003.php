<?php
class CCalendrSmall extends CCalendr{ //Inherits from CCalendr
	
	private static $mon;
	private static $yea;
	
	// *********************** Contructor ******************************
	public function __construct($get, $mboa) {
		// Parameter $get: array containing the whole $_SERVER['QUERY_STRING' for example "year=2014&month=11"
		// Parameter $mboa int (1 or -1). 1 stands for month after. -1 stands for month before
		
		$outputStr = ""; // String to send to parent constructor
		
		parse_str($get); //Extracts the variables from the $_SERVER['QUERY_STRING': $month, $year
		if(!isset($year) OR !isset($month)){
			self::$mon = $month = date('m');
			self::$yea = $year = date('Y');
		}else{
			self::$mon = $month;
			self::$yea = $year;	
		}
		
		if($mboa == -1){
			if($month > 1){	
				self::$mon--;
			}elseif($month == 1){
				self::$yea--;
				self::$mon = 12;
			}
		}else if($mboa == 1){
			if($month < 12){	
				self::$mon++;
			}elseif($month == 12){
				self::$yea++;
				self::$mon = 1;	
			}		
		}
		if(isset(self::$yea) AND isset(self::$mon)){
			$outputStr = "year=" . self::$yea . "&month=" . self::$mon;
		}
		
		parent::__construct($outputStr);
	}
	// ******************************* Functions **************************************
	
	public static function createTable(){
		$dat=0;
		$main = "<p class=\"monthHeaderSmall\">" . self::$strMonth. " " . self::$year . "</p>"; //Header

		$main .= <<<EOD
			<table class="tableSmall" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<th scope="col">M</th>
				<th scope="col">T</th>
				<th scope="col">O</th>
				<th scope="col">T</th>
				<th scope="col">F</th>
				<th scope="col">L</th>
				<th scope="col">S</th>
			  </tr>
EOD;

		$main .= "\r\n"; // To make HTML source code more readable
		
		while ($dat <= self::$endDayOfMonth){
			$main .= "<tr>";
		
			if($dat <= self::$endDayOfMonth){
				for($j=0; $j < 7; $j++){
					$main .= "<td>";
					
					if($j >= self::$startDayOfMonth - 1 AND $dat == 0) {
						$dat = 1; //Initialize $dat
					}
					
					if($dat > 0 AND $dat <= self::$endDayOfMonth){
						if($j == 6){ //Sunday
							$main .= "<p><span style=\"color: #F00;\">" . $dat . "</span></p>";
						}else{ 
							$main .= "<p>" . $dat . "</p>";
						}
						$dat++;	
					}else{
						$main .= "&nbsp;";
					}
					$main .= "</td>";
				}
			}
			
			$main .= "</tr>";
			$main .= "\r\n"; // To make HTML source code more readable	
		}
		$main .="</table>";
		return $main;
	}
}