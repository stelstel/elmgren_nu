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
			//is_numeric($id) or die('Check: Id must be numeric.');
			if( !( ($val->TYPE == "page") OR ($val->TYPE == "post") ) ){
				die('Check: TYPE must be page or post.';		
			}
			$output .= '<li>' . $val->TYPE . ' (publicerad): '	. $val->title; 
			$output .= ' (<a href="' . $this->editPag . '?id=' . $val->id . '">editera</a>';
			$output .= ' <a href="';
			
			if($val->TYPE == "page"){
				$output .= $this->pagePag . '?url=' . $val->slug;
			}else if($val->TYPE == "post"){
				$output .= $this->blogPag . '?slug=' . $val->slug;
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