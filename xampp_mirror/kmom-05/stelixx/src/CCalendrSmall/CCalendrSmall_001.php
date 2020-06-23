<?php
class CCalendrSmall extends CCalendr{ //Inherits from CCalendr
	
	private $monthBeforeOrAfter;
	
	// *********************** Contructors ******************************
	public function __construct($yea, $mon, $mboa) { // (string, string, int (1 or -1)
		parent::construct((int)$yea, (int)$month);
		self::$monthBeforeOrAfter = $mboa;
		//self::$year = $yea;
//		self::$intMonth = $mon;
//		if($mon > 0){
//			self::$strMonth = self::$swedishMonths[$mon-1];
//		}elseif($mon==0){
//			self::$strMonth = self::$swedishMonths[11];
//		}
//		
//		self::$startDayOfMonth = date("w", mktime(null, null, null, $mon , 1, $yea));
//		self::$endDayOfMonth = date("t", mktime(null, null, null, $mon , 1, $yea));
//		self::$week = date("W", strToTime($yea . "-" . $mon . "-01"));
	}
	
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