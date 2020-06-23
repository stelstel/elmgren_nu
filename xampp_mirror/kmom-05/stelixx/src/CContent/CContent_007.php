<?php
include ("../webroot/filter.php");
/**
 * Content
 *
 */
class CContent {

  /**
   * Member Variables
   */
  private $dBase;		// Database
	private $editPag;
	private $pagePag;
	private $blogPag;
	private $validFilters = array( 
  	'bbcode',
    'link',
    'markdown',
    'nl2br',  
  );						
  
  /**
   * Constructor 
   *
   * @param  $db database
   *
   */
  public function __construct($db) {
  	$this->dBase = $db;
		$this->editPag = "edit.php";
		$this->pagePag = "page.php";
		$this->blogPag = "blog.php"; 
  }
	
	//***************************************************************************************************
	public function showAll(){
		$output =<<<EOD
		<h1>Visa allt innehåll</h1>
		<p>Här är en lista på allt innehåll i databasen.</p>
EOD;
		$sql = "SELECT *, (published <= NOW()) AS available	FROM content";
		$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		$output .= "<ul>";
		
		foreach($result AS $key=>$val){
			if( !( ($val->TYPE == "page") OR ($val->TYPE == "post") ) ){ // Check if value is legal
				die('Check: TYPE must be page or post.');		
			}else{
				$TYPE = htmlentities($val->TYPE, null, 'UTF-8'); //Sanitizing			
			}
			
			$title = htmlentities($val->title, null, 'UTF-8'); //Sanitizing			
			
			$output .= '<li>' . $TYPE . ' (publicerad): '	. $title; 
			
			if(!is_numeric($val->id)){ // Check if value is legal	
				die('Check: id must be numeric.');	
			}else{
				$id = htmlentities($val->id, null, 'UTF-8'); //Sanitizing				
			}
						
			$output .= ' (<a href="' . $this->editPag . '?id=' . $id . '">editera</a>';
			$output .= ' <a href="';
			
			$slug = htmlentities($val->slug, null, 'UTF-8'); //Sanitizing				
			
			if($TYPE == "page"){
				$output .= $this->pagePag . '?url=' . $slug;
			}else if($TYPE == "post"){
				$output .= $this->blogPag . '?slug=' . $slug;
			}
			$output .= '">visa</a>)</li>';
		}
		$output .= "</ul>";
		$output .= "<p><a href='#'>Visa alla bloggposter</a></p>";
	return $output;
	}
	
	//***************************************************************************************************
	public function showPage($request, $pagePart){
		if(isset($request["url"])){
			$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE url='" . $request["url"] . "'";
			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		}else{
			// PUT ERROR, Set to nul??? ///////////////////////////////////////////////////////////////////
		}
		
		if(isset($result[0]->title)){
			$title = htmlentities($result[0]->title, null, 'UTF-8'); //Sanitizing
		}
		
		if($result[0]->DATA){
			$data = htmlentities($result[0]->DATA, null, 'UTF-8'); //Sanitizing
		}
		
		if($result[0]->FILTER ){
			//AND in_array ( $result[0]->FILTER , $validFilters)
			$arrFilters = explode(",",$result[0]->FILTER );
			
			foreach($arrFilters AS $af){
				if(!in_array($af,$this->validFilters)){
					die('Check: Invalid FILTER: ' . $result[0]->FILTER);			
				}
			}
			$filter = $result[0]->FILTER;
		}
		
		if($pagePart == "pageTitle"){
			if($title){
				return $title;
			}
		}else	if($pagePart == "pageMain"){
			if($title){
				$output = "<H1>" . $title . "</H1>";
				$output .= doFilter($data, $result[0]->FILTER);
			}
			return $output;
		}else{
			die('Check: pagePart is illegal.');			
		}
	}
	
	//***************************************************************************************************
	public function showBlog($request, $blogPart){
		if(isset($request["slug"])){
			$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE slug='" . $request["slug"] . "'";
			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		}else{
			// PUT ERROR.
		}
		
		if(isset($result[0]->title)){
			$title = htmlentities($result[0]->title, null, 'UTF-8'); //Sanitizing
		}
		
		if($result[0]->DATA){
			$data = htmlentities($result[0]->DATA, null, 'UTF-8'); //Sanitizing
		}
		
		if($result[0]->FILTER ){
			//AND in_array ( $result[0]->FILTER , $validFilters)
			$arrFilters = explode(",",$result[0]->FILTER );
			
			foreach($arrFilters AS $af){
				if(!in_array($af,$this->validFilters)){
					die('Check: Invalid FILTER: ' . $result[0]->FILTER);			
				}
			}
			$filter = $result[0]->FILTER;
		}
		
		if($blogPart == "blogTitle"){
			if($title){
				return $title;
			}
		}else	if($blogPart == "blogMain"){
			if($title){
				$output = "<H1>" . $title . "</H1>";
				$output .= doFilter($data, $result[0]->FILTER);
			}
			return $output;
		}else{
			die('Check: blogPart is illegal.');			
		}	
	}
}