<?php
//include ("../webroot/filter.php");
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
  public function __construct($db) {
  	$this->dBase = $db;
		$this->editPag = "edit.php";
		$this->pagePag = "page.php";
		$this->blogPag = "blog.php";
		$this->homePag = "kmom_05.php";
		// $this->reset($this->tableName); //################# Uncomment to create and populate table ######################
	}
	
	//***************************************************************************************************
	public function showAll(){
		$output =<<<EOD
		<h1>Visa allt innehåll</h1>
		<p>Här är en lista på allt innehåll i databasen.</p>
EOD;
		//$sql = "SELECT *, (published <= NOW()) AS available	FROM content"; //Show only published
		$sql = "SELECT *FROM content"; // Show all
		$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		$output .= "<ul>";
		
		foreach($result AS $key=>$val){
			if( !( ($val->TYPE == "page") OR ($val->TYPE == "post") ) ){ // Check if value is legal
				die('Check: TYPE must be page or post.');		
			}else{
				$TYPE = htmlentities($val->TYPE, null, 'UTF-8'); //Sanitizing			
			}
			
			$id = htmlentities($val->id, null, 'UTF-8'); //Sanitizing
			$title = htmlentities($val->title, null, 'UTF-8'); //Sanitizing			
			$output .= '<li>' . $TYPE;
			$output .= ( (isset($val->published) AND $val->published < date("Y-m-d H:i:s")) OR (isset($val->deleted) AND strlen($val->deleted) > 5) ) ? " (" : "" ;
			$output .= (isset($val->published) AND $val->published < date("Y-m-d H:i:s")) ? "publicerad" : ""; // My first on line if
			$output .= (isset($val->published) AND $val->published < date("Y-m-d H:i:s") AND isset($val->deleted) AND strlen($val->deleted) > 5) ? ", " : "";
			$output .= (isset($val->deleted) AND strlen($val->deleted) > 5) ? "slängd" : "";
			$output .= ( (isset($val->published) AND $val->published < date("Y-m-d H:i:s")) OR (isset($val->deleted) AND strlen($val->deleted) > 5) ) ? ") " : "" ;
			$output .= $title; 
			
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
			$output .= '">visa</a>';
			$output .= ' <a href="' . 'trash.php?trash=true%26id=' . $id . '">släng</a>'; // %26=&
			$output .= ' <a href="' . 'trash.php?delete=true%26id=' . $id . '">radera</a>)</li>'; // %26=&
		}
		$output .= "</ul>";
		$output .= "<p><a href='blog.php'>Visa alla bloggposter</a></p>";
	return $output;
	}
	
	//***************************************************************************************************
	public function show($request, $part){
		$pageOrBlog = substr($part, 0, 4);
		$cfilter = new CTextFilter();
						
		if($pageOrBlog == "page"){
			if(isset($request["url"]) ){
				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE url='" . strip_tags($request["url"]) . "'";
			}else{
				die('Check: Page without URL');	
			}
		}else if($pageOrBlog == "blog"){ 
			if(isset($request["slug"]) ){
				$slug = $request["slug"];
				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE slug='" . strip_tags($slug) . "'"; //Show one blog
			}else{
				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE TYPE='post'"; //Show all blogs
			}
		}else{
			die('Check: Neither page or blog');
		}
		
		if(isset($sql)){
			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);		
		}
		
		$pag = new CPage();
		return "<br>cp:" . $pag->createPage($result, $part) . "<br>";
		
		//if(isset($result[0]->title)){
//			$title = htmlentities($result[0]->title, null, 'UTF-8'); //Sanitizing
//		}
//		
//		if(isset($result[0]->DATA) ){
//			$data = htmlentities($result[0]->DATA, null, 'UTF-8'); //Sanitizing
//		}
//		if( isset($result[0]->FILTER) AND strlen($result[0]->FILTER) > 0 ){
//			$FILTER = htmlentities($result[0]->FILTER, null, 'UTF-8'); //Sanitizing
//			if(!$this->isFilterValid($FILTER) AND strlen($FILTER) ){
//				die('Check: Invalid FILTER: ' . $FILTER);	
//			}
//			$filter = $result[0]->FILTER;
//		}
//		
//		if($part == "pageTitle" OR $part == "blogTitle"){
//			if(isset($title)){
//				return $title;
//			}
//		}else	if($part == "pageMain"){
//			if(isset($title)){
//				$output = "<H1>" . $title . "</H1>";
//				$output .= "<p>" . $data . "</p>";
//				if(isset($result[0]->FILTER) ){
//					$output .= $cfilter->doFilter($data, $result[0]->FILTER);
//				}
//			}
//			return $output;
//		}else	if($part == "blogMain"){
//			return $this->showBlog($result);
//		}
	}
	
	//*******************************************************************
	private function showBlog($res){
		//dump($res); ///////////////////////////////////////////////////////////////////////////
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
					if(!in_array($af,$this->validFilters)){
						die('Check: Invalid FILTER: ' . $FILTER);			
					}
				}
				$filter = $r->FILTER;
			}
			
			if(isset($r->DATA) ){
				$data = htmlentities($r->DATA, null, 'UTF-8'); //Sanitizing
			}
							
			$output .= '<H1><a href="?slug=' . $slug . '">' . $title . "</a></H1>";
			if(isset($filter)){
				$output .= doFilter($data, $filter);			
			}else{
				$output .= $data;			
			}
		}
		return $output;
	}
	
	//*********************************************************************************************
	public function reset(){
		//$tabl = $this->tableName;
		$sql = file_get_contents('reset_content.sql');
		$this->dBase->ExecuteSelectQueryAndFetchAll($sql);
	}
	
	//********************************************************************************************************************
	public function addPostOrPage($req){
		if(strlen($req) > 0){
			$id = $title = $text = $filter = $slug = $url = $publDate = $createDate = $type = null;
			$blogPre = "blogpost-";
			parse_str($req); //Split request into key-val
			$sqlHighestId = "SELECT * FROM " . strip_tags($this->tableName) . " ORDER BY id DESC LIMIT 0, 1"; //get highest id
			$temp = $this->dBase->ExecuteSelectQueryAndFetchAll($sqlHighestId); 
			$highestId = $temp[0]->id;
			$id = $highestId + 1;
			
			if(isset($txtTitle)){
				//$title= htmlentities($txtTitle, null, 'UTF-8'); //Sanitizing
				$title = $txtTitle;
			}else{
				die("Title krävs");
			}
			
			if(strtolower($txtType) == "page"){
				$type = "page";
				$url = $slug = slugify($title);
			}else if(strtolower($txtType) == "blog"){
				$type = "post";
				$slug = $blogPre . ($this->findHighestBlogPost() + 1);
			}else{
				die("Type is requiered");	
			}
			
			if(isset($fieldText)){
				//$text= htmlentities($fieldText, null, 'UTF-8'); //Sanitizing
				$text= $fieldText;
			}else{
				die("Text/innehåll krävs");
			}
			
			if(isset($txtFilter)){
				$filter= htmlentities($txtFilter, null, 'UTF-8'); //Sanitizing
				
				if(!$this->isFilterValid($filter) AND strlen($filter) > 0){
					die('Check: Invalid FILTER: ' . $filter);	
				} 
			}
			
			$createDate = date("Y-m-d H:i:s");
			
			// If publish date don´t exist, publish date = creation date
			if(isset($txtPublDate) AND strlen($txtPublDate) > 0){ 
				$publDate = $txtPublDate;
			}else{
				$publDate = $createDate;	
			}
			
			$sqlInsert = "INSERT INTO " . strip_tags($this->tableName) . " (" . "id, slug, url, TYPE, title, DATA, FILTER, published, created) ";
			
			$sqlInsert .= "VALUES ( " . strip_tags($id) . ",'" . strip_tags($slug);
		
			if($type == "post"){
				$sqlInsert .= "', null ,'";	
			}else if($type == "page"){
				$sqlInsert .= "','" . strip_tags($url) . "','";	
			}
			
			$sqlInsert .=  strip_tags($type) . "','" . strip_tags($title) . "','" . strip_tags($text); 
			if(isset($filter) AND strlen($filter) > 0){
				$sqlInsert .= "'," . strip_tags($filter) . ",'";
			}else{
				$sqlInsert .= "', null ,'";
			}
			
			$sqlInsert .= strip_tags($publDate) . "','" . strip_tags($createDate) . "')";
			
			$queryResult = $this->dBase->ExecuteQuery($sqlInsert);
			if($type == "post" AND $this->dBase->RowCount() == 1){ //Insert successful
				return "<h2>Posten " . $title . " skapades.</h2>";
			}else if($type == "page" AND $this->dBase->RowCount() == 1){
				return "<h2>Sidan " . $title . " skapades.</h2>";
			}else{
				return "<h2>Sql insert fungerade inte. Post ej skapad</h2>" . dump($this->dBase->ErrorCode()) . "-" . dump($this->dBase->ErrorInfo() );	
			} 
		}
	}
	
	//******************************************************************************************************
	private function isFilterValid($filt){
		$arrFilters = explode(",",$filt );
		foreach($arrFilters AS $af){
			if(!in_array($af,$this->validFilters)){
				return false;			
			}
		}
		return true;
	}
	
	//****************************************************************************************
	public function showUpdateForm($servQuery){
		parse_str($servQuery); //Split into key-val
		
		if(isset($id) AND strlen($id) > 0 AND is_numeric($id)){
			$ide = htmlentities($id, null, 'UTF-8');;
		}else{
			die("id krävs i showUpdateForm");
		}
		
		$sql = "SELECT * FROM " . $this->tableName . " WHERE id='" . strip_tags($ide) . "'";
		$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		$output = "";
		
		if(isset($servQuery) AND strlen($servQuery) > 0 AND isset($txtTitle) AND strlen($txtTitle) ){ //the real one, not just the id one
			if($this->updateDB($servQuery) ){
				$output .= "<H2>" . $result[0]->title . " blev uppdaterad</H2>";
			}else{
				$output .= "<H2>" . $result[0]->title . " blev INTE uppdaterad</H2>" ;
			}
		}
		
		$output .=<<<EOD
		<H1>Uppdatera innehåll</H1>
		<form>
				<fieldset>
				<legend>Uppdatera innehåll</legend>
				<p>
						<label for="txtTitle">Titel:<br />
						</label>
						<input name="txtTitle" type="text" id="txtTitle" size="50" 
EOD;
		$output .= 'value="' . $result[0]->title . '" /></p>';
		$output .= '<input type="hidden" name="id" id="id" value="' . $result[0]->id . '" />';
		$output .= '<p><label for="txtSlug">Slug:<br /></label><input type="text" name="txtSlug" id="txtSlug" readonly="readonly" value="' . $result[0]->url . '"/></p>';
		$output .= '<p><label for="txtURL">URL:<br /></label><input type="text" name="txtURL" id="txtURL" readonly="readonly" value="' . $result[0]->url . '"/></p>';
		$output .= '<p><label for="fieldText">Text:<br /></label>';
		$output .= '<textarea name="fieldText" id="fieldText" cols="50" rows="5">';
		$output .= $result[0]->DATA . '</textarea></p>';
		$output .= '<p><label for="txtType">Type:<br /></label><input type="text" name="txtType" id="txtType" readonly="readonly" value="' . $result[0]->TYPE . '"/></p>';
		$output .= '<p><label for="txtFilter">Filter:<br /></label><input type="text" name="txtFilter" id="txtFilter" value="' . $result[0]->FILTER . '"/></p>';
		$output .= '<p><label for="txtPubl">Publiceringsdatum:<br /></label><input type="text" name="txtPubl" id="txtPubl" value="' . $result[0]->published . '"/></p>';
		$output .= '<input type="submit" name="btnSave" id="btnSave" value="Spara" />';
  	$output .= '<input type="reset" name="btnReset" id="button" value="Återställ" />';
		$output .= '<p> <a href="aaa">Visa</a> | <a href="../webroot/' . $this->homePag . '">Visa alla</a></p>';
		$output .= "</form>";
		
		return $output;
	}
	
	//**********************************************************************************************
	private function updateDB($servQuery){
		//dump($servQuery);////////////////////////////////////////////////////////////////////
		
		parse_str($servQuery); //Split into key-val
		
		if(isset($id) AND is_numeric($id) ){
			$ide = $id;
		}else{
			die("id krävs i updateDB");
		}
				
		if(isset($txtTitle)){
			$title = $txtTitle;
		}else{
			die("Titel krävs i updateDB");
		}
		
		if(isset($fieldText)){
			$text = $fieldText;
		}else{
			die("Text krävs");
		}
		
		if(isset($txtFilter) AND $this->isFilterValid($txtFilter) AND strlen($txtFilter) > 0){
			$filter = htmlentities($txtFilter, null, 'UTF-8');
		}else{
			$filter = 'null';
		}
		
		if(isset($txtPubl)){
			$publishedDate = htmlentities($txtPubl, null, 'UTF-8');
		}
		
		$updatedDate = date("Y-m-d H:i:s");
		
		
		/*UPDATE table_name
		SET column1=value, column2=value2,...
		WHERE some_column=some_value*/  
		$sql = 'UPDATE ' . strip_tags($this->tableName) . ' SET ';
		$sql .= "title='" . strip_tags($title) . "', ";
		$sql .= "DATA='" . strip_tags($text) . "', ";
		$sql .= 'FILTER=' . $filter . ', ';
		$sql .= "published='" . strip_tags($publishedDate) . "', ";
		$sql .= "updated='" . strip_tags($updatedDate) . "' WHERE id='" . strip_tags($ide) . "'";
		$queryResult = $this->dBase->ExecuteQuery($sql);
		
		if(!$queryResult){
			dump($this->dBase->ErrorCode()) . "-" . dump($this->dBase->ErrorInfo());
		}
		return $queryResult;
	}
		
	//**********************************************************************************************************************************		
	private function findHighestBlogPost(){
		$sqlHighestBlogPost = "SELECT SUBSTRING(slug FROM 10) AS postIndex FROM " . strip_tags($this->tableName) . " WHERE TYPE = 'post' ORDER BY CONVERT(postIndex, UNSIGNED INTEGER) DESC LIMIT 0, 1";				
		$temp = $this->dBase->ExecuteSelectQueryAndFetchAll($sqlHighestBlogPost);
		$highestBlogPost = $temp[0]->postIndex; //Get highest blogpost number. i.e. blogpost-9
		return $highestBlogPost;
	}
	
	//*******************************************************************************************************************************
	// Trash marks as deleted in db. Delete deletes for real from db
	public function trash($query){
		$query = urldecode($query);
		//echo "<br>query" . $query . "<br>";///////////////////////////////////////////////////////////////////////////////////
		parse_str($query); //Split into key-val
		
		if(isset($id) AND is_numeric($id) AND $id > 0){
				$id = htmlentities($id, null, 'UTF-8');	
			}else{
				die("id krävs i trash()");
			}
		
		if(isset($delete) AND $delete == "true"){
			$sql = "DELETE FROM " . strip_tags($this->tableName) . " WHERE id=" . strip_tags($id) . " LIMIT 1"; //Limit 1 just for safety
			//$sql = "DELETE FROM " . $this->tableName . " WHERE id=999 LIMIT 1"; // Testing error
			$queryResult = $this->dBase->ExecuteQuery($sql); 
			if($this->dBase->RowCount() == 1){ // RowCount() return int number of affected rows of last statement
				return "<br><H2>Blogpost/sida raderad</H2>";
			}else{
				return "<br><H2>Blogpost/sida INTE raderad</H2>" . mysql_error();
			}
		}else if(isset($trash) AND $trash == "true"){
			$sql = "UPDATE " . strip_tags($this->tableName) . " SET deleted=NOW() WHERE id=" . strip_tags($id);
			//$sql = "UPDATE " . $this->tableName . " SET deleted=NOW() WHERE id=999"; // Testing error
			$queryResult = $this->dBase->ExecuteQuery($sql);
			
			if($this->dBase->RowCount() == 1){ // RowCount() return int number of affected rows of last statement
				return "<br><H2>Blogpost/sida slängd</H2>";
			}else{
				return "<br><H2>Blogpost/sida INTE slängd</H2>" . mysql_error();
			}
		}else{
		 die("trash eller delete krävs i trash()");	
		}
	}
	
	//*********************************************************************************************
	//// Restore the database to its original settings
//	public function reset(){
//		$this->createContentTable($this->tableName);
//	}
}