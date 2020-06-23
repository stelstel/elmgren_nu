<?php
//include ("../webroot/filter.php");
/**
 * Content
 *
 */
class CPage {
  /**
   * Constructor 
   *
   *
   */
  public function __construct(){
		
	}
	
	public static function createPage($result, $part){
		$filt = new CTextFilter();
		
		if(isset($result[0]->title)){
			$title = htmlentities($result[0]->title, null, 'UTF-8'); //Sanitizing
		}
		
		if(isset($result[0]->DATA) ){
			$data = htmlentities($result[0]->DATA, null, 'UTF-8'); //Sanitizing
		}
		if( isset($result[0]->FILTER) AND strlen($result[0]->FILTER) > 0 ){
			$FILTER = htmlentities($result[0]->FILTER, null, 'UTF-8'); //Sanitizing
			if(strlen($FILTER) > 0 ){
				$filter = $result[0]->FILTER;	
			}
		}
		
		if($part == "pageTitle"){
			if(isset($title)){
				return $title;
			}
		}else	if($part == "pageMain"){
			if(isset($title)){
				$output = "<H1>" . $title . "</H1>";
				$output .= $filt->doFilter($data, $filter);
			}
			return $output;
		}
	}
	
}