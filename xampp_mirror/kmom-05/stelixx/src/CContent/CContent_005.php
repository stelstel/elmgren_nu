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
			
			if(!isNumeric($val->id)){
				die('Check: id must be numeric.');	// Check if value is legal	
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
			// PUT ERROR ///////////////////////////////////////////////////////////////////
		}
		
		if($pagePart == "pageTitle"){
			if(isset($result[0]->title)){
				return $result[0]->title;
			}
		}
		
		if($pagePart == "pageMain"){
			if(isset($result[0]->title)){
				$output = "<H1>" . $result[0]->title . "</H1>";
				$output .= doFilter($result[0]->DATA, $result[0]->FILTER);
			}
			return $output;
		}
	}
}