<?php
//include ("../webroot/filter.php");
/**
 * Content
 *
 */
class CPage {

  /**
   * Member Variables
   */
  private $dBase;		// Database
	private $editPag;
	private $pagePag;
	private $blogPag;
	private $homePag;
	private $tableName = "content";
	
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
  //public function __construct($db) {
//  	$this->dBase = $db;
//		$this->editPag = "edit.php";
//		$this->pagePag = "page.php";
//		$this->blogPag = "blog.php";
//		$this->homePag = "kmom_05.php";
//	}

	public function __construct(){
		
	}
	
	public static function createPage($result, $part){
		echo "<br>PART:" . $part; ////////////////////////////////////////////////////
		//$pageOrBlog = substr($part, 0, 4);
//						
//		if($pageOrBlog == "page"){
//			if(isset($request["url"]) ){
//				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE url='" . strip_tags($request["url"]) . "'";
//			}else{
//				die('Check: Page without URL');	
//			}
//		}else if($pageOrBlog == "blog"){ 
//			if(isset($request["slug"]) ){
//				$slug = $request["slug"];
//				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE slug='" . strip_tags($slug) . "'"; //Show one blog
//			}else{
//				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE TYPE='post'"; //Show all blogs
//			}
//		}else{
//			die('Check: Neither page or blog');
//		}
//		
//		if(isset($sql)){
//			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);		
//		}
		
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
		
		if($part == "pageTitle" OR $part == "blogTitle"){
			if(isset($title)){
				return $title;
			}
		}else	if($part == "pageMain"){
			if(isset($title)){
				$output = "<H1>" . $title . "</H1>";
				$output .= $filt->doFilter($data, $filter);
			}
			return $output;
		}else	if($part == "blogMain"){
			return $this->showBlog($result);
		}
	}
	
}