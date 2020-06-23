<?php
//include ("../webroot/filter.php");
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
	
	//******************************************************************************************
	public function createBlog($res, $part){
		$output = "";
		
		foreach($res AS $r){
			if(isset($r->slug)){
				$slug = htmlentities($r->slug, null, 'UTF-8'); //Sanitizing
			}
			
			if(isset($r->title)){
				$title = htmlentities($r->title, null, 'UTF-8'); //Sanitizing
			}
			
			if(isset($r->FILTER) AND strlen($r->FILTER) > 0){
				$FILTER = htmlentities($r->FILTER, null, 'UTF-8'); //Sanitizing
				$arrFilters = explode(",",$FILTER );
				foreach($arrFilters AS $af){
					if(!array_key_exists($af,$this->filt->valid)){
						die('Check: createBlog 666. Invalid FILTER: ' . $FILTER);			
					}
				}
				$filter = $r->FILTER;
			}
			
			if(isset($r->DATA) ){
				$data = htmlentities($r->DATA, null, 'UTF-8'); //Sanitizing
			}
							
			$output .= '<H1><a href="?slug=' . $slug . '">' . $title . "</a></H1>";
			if(isset($filter)){
				$output .= $this->filt->doFilter($data, $filter);			
			}else{
				$output .= $data;			
			}
		}
		return $output;
	}
}