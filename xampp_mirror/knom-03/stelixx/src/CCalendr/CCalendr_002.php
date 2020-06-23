<?php
class CCalendr{
	// ********************** Variables *****************************
	protected static $strMonth;
	protected static $intMonth;
	protected static $year;
	protected static $startDayOfMonth;
	protected static $endDayOfMonth;
	private static $week;
	private $image;
	private $main; //String containing HTML
	
	private static $babes = array(
		"beautiful.jpg",
		"blurred.jpg",
		"woman.jpg",
		"natural.jpg",
		"carmen.jpg",
		"salma.jpg",
		"face.jpg",
		"5.jpg",
		"cute.jpg",
		"girl.jpg",
		"4.jpg",
		"snow.jpg",
	);
	
	private static $swedishMonths = array(
		"Januari",
		"Februari",
		"Mars",
		"April",
		"Maj",
		"Juni",
		"Juli",
		"Augusti",
		"September",
		"Oktober",
		"November",
		"December",
	);
	
	// *********************** Contructors ******************************
	public function __construct($yea, $mon) { // (int, int
		self::$year = $yea;
		self::$intMonth = $mon;
		if($mon > 0){
			self::$strMonth = self::$swedishMonths[$mon-1];
		}elseif($mon==0){
			self::$strMonth = self::$swedishMonths[11];
		}
		
		self::$startDayOfMonth = date("w", mktime(null, null, null, $mon , 1, $yea));
		self::$endDayOfMonth = date("t", mktime(null, null, null, $mon , 1, $yea));
		self::$week = date("W", strToTime($yea . "-" . $mon . "-01"));
	}
	
	// *********************** Methods ******************************
	public static function createTable(){
		$dat=0;
		$main = "<img src=\"img/manadens_babe/" . self::$babes[self::$intMonth-1] . "\"/>";
		
		$main .= "<p class=\"monthHeader\">" . self::$strMonth . " " . self::$year . "</p>";

		$main .= <<<EOD
			<table classborder="0" cellpadding="0" cellspacing="0">
			  <tr>
				<th scope="col">V.</th>
				<th scope="col">Måndag</th>
				<th scope="col">Tisdag</th>
				<th scope="col">Onsdag</th>
				<th scope="col">Torsdag</th>
				<th scope="col">Fredag</th>
				<th scope="col">Lördag</th>
				<th scope="col">Söndag</th>
			  </tr>
EOD;

		$main .= "\r\n"; // To make HTML source code more readable
		while ($dat <= self::$endDayOfMonth){
			$main .= "<tr>";
			
			$main .= "<td class=\"tdWeek\">" . self::$week++ . "</td>";
			
			if($dat <= self::$endDayOfMonth){
				for($j=0; $j < 7; $j++){
					$main .= "<td>";
					
					if($j >= self::$startDayOfMonth - 1 AND $dat == 0) {
						$dat = 1; //Initialize $dat
					}
					
					if($dat > 0 AND $dat <= self::$endDayOfMonth){
						if($j == 6){ //Sunday
							$main .= "<p><span style=\"color: #F00;\">" . $dat++ . "</span></p>";
						}else{ 
							$main .= "<p>" . $dat++ . "</p>";
						}	
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
	
	public static function linkBack(){
		$linkB = "<a href=" . basename($_SERVER['PHP_SELF']);
		// The link
		if(self::$intMonth > 1){ //Not january
			$linkMonth = self::$intMonth - 1;
			$linkYear = self::$year;
		}else{ //january, change to december year before
			$linkYear = self::$year - 1;
			$linkMonth = 12;
		}
		
		$linkB .= "?year=" . $linkYear;
		$linkB .= "&month=" . $linkMonth;
						
		$linkB .= ">";
		
		// The text
		if(self::$intMonth >= 2){
			$linkB .= self::$swedishMonths[self::$intMonth - 2];
		}else{
			$linkB .= self::$swedishMonths[11];	
		}
		
		
		$linkB .= "</a>";
		return $linkB;
	}
	
	public static function linkForward(){
		$linkF = "<a href=" . basename($_SERVER['PHP_SELF']);

		// The link
		if(self::$intMonth < 12){ //Not january
			$linkMonth = self::$intMonth + 1;
			$linkYear = self::$year;
		}else{ // December, change to January year after
			$linkYear = self::$year + 1;
			$linkMonth = 1;
		}
		
		$linkF .= "?year=" . $linkYear;
		$linkF .= "&month=" . $linkMonth;
				
		$linkF .= ">";
		
		// The text
		$linkF .= self::$swedishMonths[$linkMonth-1];
		
		$linkF .= "</a>";
		return $linkF;
	}
	
	public function setYear($y){ // String parameter
		if( strlen($y) <> 4 OR !ctype_digit($y) ) // Validating
		{
			throw new Exception("Function setYear(year) . Parameter year must be a string with 4 numbers. Parameter is now: " . $y );
		}else{
			self::$year = $y;		
		}
	}
	
	public function setMonth($m){ // string parameter
		if( strlen($m) < 1 OR strlen($m) > 2 OR !ctype_digit($m) ){ // Validating
			throw new Exception("Function setMonth(month) . Parameter month must be a string with 2 numbers. Parameter is now: " . $m );
		}else{
			self::$intMonth = $m;
		}
	}
	
	public function getYear(){
		return self::$year;
	}
	
	public function getMonth(){ // Returns integer
		return self::$intMonth;
	}
}