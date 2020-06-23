<?php
/**
 * Content
 *
 */
class CBlog {
  /**
   * Member Variables
   */
  private $editPag;
	private $db;
	private $blogPage;
	public 	$filt;
	
	/**
   * Constructor 
   *
   *
   */
  public function __construct($database){
		$this->db = $database;
		$this->filt = new CTextFilter();
		$this->editPag = "edit.php";
		$this->blogPage = "blog.php";
	}
	
	//******************************************************************
	// Parameters Result, Part
	// Parameter shorten is a flag indicating that the text must be shortened
	public function createBlog($res, $part, $shorten){
		$inlogging = new CLogin($this->db);
		$summaryLength = 300;
		$output = "";
		
		foreach($res AS $r){
			if( !(isset($r->deleted) AND strlen($r->deleted) > 0)){ //Post NOT marked as deleted in database	
				if(isset($r->slug)){
					$slug = htmlentities($r->slug, null, 'UTF-8'); 	//Sanitizing
				}
				
				if(isset($r->title)){
					$title = htmlentities($r->title, null, 'UTF-8'); //Sanitizing
				}
				
				if(isset($r->category)){
					$cat = htmlentities($r->category, null, 'UTF-8'); //Sanitizing
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
					$output .= '<H1><a href="' . $this->blogPage . '?slug=' . $slug . '">' . $title . "</a></H1>";
					
					if(isset($cat)){
						$output .= '<h5>Bloggkategori: <a href="' . $this->blogPage . '?category=' . ucfirst($cat) . '">' . ucfirst($cat) . '</a></h5>';
					}
					
					if(isset($filter)){
						if($shorten){	
							$output .= substr ( $this->filt->doFilter($data, $filter) , 0 , $summaryLength); 		//Shorten text when showing summary
							if(strlen($data) > $summaryLength){
								$output .= "... ";
								$output .= '<a href="' . $this->blogPage . '?slug=' . $slug . '">' . "LÄS MER >></a>";
							}
						}else{
							$output .= $this->filt->doFilter($data, $filter);
						}
					}else{
						if($shorten){
							$output .= substr ( $data , 0 , $summaryLength); 		//Shorten text when showing summary
							if(strlen($data) > $summaryLength){
								//$output .= "... ";	
								$output .= '... <a href="' . $this->blogPage . '?slug=' . $slug . '">' . "LÄS MER >></a>";
							}
						}else{
							$output .= $data;
						}
					}
					
					if($inlogging->isAuth() ){ // Logged in
						$id = htmlentities($r->id, null, 'UTF-8'); //Sanitizing
						$output .= '<br><br>(<a href="' . $this->editPag . '?id=' . $id . '">Editera</a>';
						$output .= ' <a href="' . 'trash.php?trash=true&id=' . $id . '">Släng</a>'; 
						$output .= ' <a href="' . 'trash.php?delete=true&id=' . $id . '">Radera</a>)<br><br>';
					}
					
				}else if($part == "blogTitle"){
					if(isset($title)){
						return $title;
					}
				}
			}
		} // End of foreach
		
		return $output;
	}
}