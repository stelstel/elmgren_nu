<?php
/**
 * Content
 *
 */
class CBlog {
  public $filt;
	/**
   * Constructor 
   *
   *
   */
  public function __construct(){
		$this->filt = new CTextFilter();	
	}
	
	//******************************************************************
	// Parameters Result, Part
	// Parameter shorten is a flag indicating that the text must be shortened
	public function createBlog($res, $part, $shorten){
		$summaryLength = 300;
		$output = "";
		
		foreach($res AS $r){
			if(isset($r->slug)){
				$slug = htmlentities($r->slug, null, 'UTF-8'); 	//Sanitizing
			}
			
			if(isset($r->title)){
				$title = htmlentities($r->title, null, 'UTF-8'); //Sanitizing
			}
			
			if(isset($r->FILTER) AND strlen($r->FILTER) > 0){
				$FILTER = htmlentities($r->FILTER, null, 'UTF-8'); //Sanitizing
				$arrFilters = explode(",",$FILTER );
				foreach($arrFilters AS $af){
					if(!array_key_exists($af,$this->filt->valid)){
						die('Check: createBlog. Invalid FILTER: ' . $FILTER);			
					}
				}
				$filter = $r->FILTER;
			}
			
			if(isset($r->DATA) ){
				$data = htmlentities($r->DATA, null, 'UTF-8'); //Sanitizing
			}
							
			if($part == "blogMain"){
				$output .= '<H1><a href="?slug=' . $slug . '">' . $title . "</a></H1>";
				
				if(isset($filter)){
					if($shorten){	
						$output .= substr ( $this->filt->doFilter($data, $filter) , 0 , $summaryLength); 		//Shorten text when showing summary
						if(strlen($data) > $summaryLength){
							$output .= "... ";
							$output .= '<a href="?slug=' . $slug . '">' . "LÄS MER</a>";
						}
					}else{
						$output .= $this->filt->doFilter($data, $filter);
					}
				}else{
					if($shorten){
						$output .= substr ( $data , 0 , $summaryLength); 		//Shorten text when showing summary
						if(strlen($data) > $summaryLength){
							//$output .= "... ";	
							$output .= '... <a href="?slug=' . $slug . '">' . "LÄS MER >></a>";
						}
					}else{
						$output .= $data;
					}
				}
				
			}else if($part == "blogTitle"){
				if(isset($title)){
					return $title;
				}
			}
		}
		
		return $output;
	}
}