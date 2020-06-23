<?php
class CHistogram {
	
	public static function GetHistogram($arr){
		$faces = new SplFixedArray(count($arr));
		$faces = $faces->toArray();
		//$faces = array();
		
		foreach($arr as $ar){
			$faces[$ar-1]++;
		}
		return $faces;
	}
	
	public function __construct() { //Skriver ut något när den anropas
  		echo __METHOD__;
	}
}