<?php
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
		//dump($request);////////////////////////////////////
		//echo $request["url"];//////////////////////////////
		if(isset($request["url"])){
			$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE url='" . $request["url"] . "'";
			//echo $sql; ///////////////////////////////////////////
			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		}else{
			//Put error ///////////////////////////////////////////////////////////////////
		}
		
		if($pagePart == "pageTitle"){
			if(isset($result[0]->title)){
				return $result[0]->title;
			}
		}
		
		if($pagePart == "pageMain"){
			if(isset($result[0]->title)){
				$output = "<H1>" . $result[0]->title . "</H1>";
				$output .= $this->doFilter($result[0]->DATA, $result[0]->FILTER);
			}
			return $output;
		}
	}
	
	//**********************************************************************************************************
		/**
	 * Call each filter.
	 *
	 * @param string $text the text to filter.
	 * @param string $filter as comma separated list of filter.
	 * @return string the formatted text.
	 */
	private function doFilter($text, $filter) {
		// Define all valid filters with their callback function.
		$valid = array(
			'bbcode'   => 'bbcode2html',
			'link'     => 'make_clickable',
			'markdown' => 'markdown',
			'nl2br'    => 'nl2br',  
		);
	 
		// Make an array of the comma separated string $filter
		$filters = preg_replace('/\s/', '', explode(',', $filter));
	 
		// For each filter, call its function with the $text as parameter.
		foreach($filters as $func) {
			if(isset($valid[$func])) {
				$text = $valid[$func]($text);
			} 
			else {
				throw new Exception("The filter '$filter' is not a valid filter string.");
			}
		}
	 	return $text;
	}
}