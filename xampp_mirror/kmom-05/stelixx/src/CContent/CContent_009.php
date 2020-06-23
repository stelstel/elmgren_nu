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
		$output .= "<p><a href='blog.php'>Visa alla bloggposter</a></p>";
	return $output;
	}
	
	//***************************************************************************************************
	public function show($request, $part){
		$pageOrBlog = substr($part, 0, 4);
		
		if($pageOrBlog == "page" AND isset($request["url"]) ){
			$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE url='" . $request["url"] . "'";
		}else if($pageOrBlog == "blog" AND isset($request["slug"]) ){
			$slug = $request["slug"];
			$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE slug='" . $request["slug"] . "'";
		}else if($pageOrBlog == "blog"){
			// ? ///////////////////////////////////////////////////////////////
		}else if($pageOrBlog == "url"){
			// PUT ERROR, blog with no url ///////////////////////////////////////////////////////////////////
		}
		
		if(isset($sql)){
			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);		
		}
		
		if(isset($result[0]->title)){
			$title = htmlentities($result[0]->title, null, 'UTF-8'); //Sanitizing
		}
		
		if(isset($result[0]->DATA) ){
			$data = htmlentities($result[0]->DATA, null, 'UTF-8'); //Sanitizing
		}
		
		if($result[0]->FILTER ){
			$FILTER = htmlentities($result[0]->FILTER, null, 'UTF-8'); //Sanitizing
			$arrFilters = explode(",",$FILTER );
			foreach($arrFilters AS $af){
				if(!in_array($af,$this->validFilters)){
					die('Check: Invalid FILTER: ' . $FILTER);			
				}
			}
			$filter = $result[0]->FILTER;
		}
		
		if($part == "pageTitle" OR $part == "blogTitle"){
			if($title){
				return $title;
			}
		}else	if($part == "pageMain"){
			if($title){
				$output = "<H1>" . $title . "</H1>";
				$output .= doFilter($data, $result[0]->FILTER);
			}
			return $output;
		}else	if($part == "blogMain" AND isset($request["slug"])){
			if(isset($request["slug"])){
				if($title){
					$output = '<H1><a href="?slug=' . $slug . '">' . $title . "</a></H1>"; 
					$output .= doFilter($data, $result[0]->FILTER);
				}
			}
			return $output;
		/*}else	if($part == "blogMain" AND !isset($request["slug"])){
			// Show all blogs	*/
		}else{
			die('Check: part is illegal.');			
		}
		
		/*if($blogPart == "blogTitle"){
			if($title){
				return $title;
			}
		}else	if($blogPart == "blogMain"){
			if($title){
				$output = '<H1><a href="?slug=' . $slug . '">' . $title . "</a></H1>"; 
				$output .= doFilter($data, $result[0]->FILTER);
			}
			return $output;
		}else{
			die('Check: blogPart is illegal.');			
		}	*/
	}
	
	//***************************************************************************************************
	//public function showBlog($request, $blogPart){
		/*if(isset($request["slug"])){
			$slug = $request["slug"];
			$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE slug='" . $request["slug"] . "'";
			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		}else{
			// PUT ERROR.
		}*/
		
		//if(isset($result[0]->title)){
//			$title = htmlentities($result[0]->title, null, 'UTF-8'); //Sanitizing
//		}
		
		/*if($result[0]->DATA){
			$data = htmlentities($result[0]->DATA, null, 'UTF-8'); //Sanitizing
		}*/
		
		/*if($result[0]->FILTER ){
			$arrFilters = explode(",",$result[0]->FILTER ); //separate filters
			
			foreach($arrFilters AS $af){
				if(!in_array($af,$this->validFilters)){
					die('Check: Invalid FILTER: ' . $result[0]->FILTER);			
				}
			}
			$filter = $result[0]->FILTER;
		}*/
		
	/*	if($blogPart == "blogTitle"){
			if($title){
				return $title;
			}
		}else	if($blogPart == "blogMain"){
			if($title){
				$output = '<H1><a href="?slug=' . $slug . '">' . $title . "</a></H1>"; 
				//<a href="url">slug</a>
				//$output = "<H1>" . $title . "</a></H1>";
				$output .= doFilter($data, $result[0]->FILTER);
			}
			return $output;
		}else{
			die('Check: blogPart is illegal.');			
		}	
	}*/
}