<?php
//include ("../webroot/filter.php");
/**
 * Content
 *
 */
class CMovies {

  /**
   * Member Variables
   */
  private $dBase;		// Database
	private $editPag;
	private $pagePag;
	private $blogPag;
	private $homePag;
	private $tableName = "movie";
	private $tableMov2Genre = "stel14.movie2genre";
	
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
		
		if($pageOrBlog == "page"){
			$pag = new CPage();
			return $pag->createPage($result, $part);
		}else if ($pageOrBlog == "blog"){
			$blo = new CBlog();
			return $blo->createBlog($result, $part);
		}
	}
	
	//*********************************************************************************************
	public function reset(){
		//$tabl = $this->tableName;
		$sql = file_get_contents('reset_content.sql');
		$this->dBase->ExecuteSelectQueryAndFetchAll($sql);
	}
	
	//********************************************************************************************************************
	public function addMovie($req){
		if(strlen($req) > 0){
			$id = $title = $text = $filter = $slug = $url = $publDate = $createDate = $type = null;
			$blogPre = "blogpost-";
			parse_str($req); //Split request into key-val
			$sqlHighestId = "SELECT * FROM " . strip_tags($this->tableName) . " ORDER BY id DESC LIMIT 0, 1"; //get highest id
			$temp = $this->dBase->ExecuteSelectQueryAndFetchAll($sqlHighestId); 
			$highestId = $temp[0]->id;
			$id = $highestId + 1;
			
			if(isset($txtTitle)){
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
				$sqlInsert .= "','" . strip_tags($filter) . "','";
			}else{
				$sqlInsert .= "',' null ','";
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
	
	//****************************************************************************************
	// Works 2014-12-14
	public function showUpdateForm($servQuery){
		$imgPath 					= "filmer/";
		$imgLimitWidth 		= 400;
		$imgLimitHeight 	= 190;
		$output 					= "";
		$fieldSetWidth 		= $imgLimitWidth + 10;
				
		parse_str($servQuery); //Split into key-val
		
		if(isset($id) AND strlen($id) > 0 AND is_numeric($id)){
			$ide = htmlentities($id, null, 'UTF-8');;
		}else{
			die("id krävs i showUpdateForm");
		}
		
		$sql = "SELECT * FROM " . $this->tableName . " WHERE id='" . strip_tags($ide) . "'";
		$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		$bigImg = $result[0]->bigimg;
		$posterImg = $result[0]->smallimg;
			
		if(isset($servQuery) AND strlen($servQuery) > 0 AND isset($txtTitle) AND strlen($txtTitle) ){ //the real one, not just the id one
			if($this->updateDB($servQuery) ){
				$output .= "<H2>" . $result[0]->title . " blev uppdaterad</H2>";
			}else{
				$output .= "<H2>" . $result[0]->title . " blev INTE uppdaterad</H2>" ;
			}
		}
		
		//$output .= "style=fieldset { width: 200px; }";
		
		$output .=<<<EOD
		<form>
				<p>
						<label for="txtTitle">Titel:<br />
						</label>
						<input name="txtTitle" type="text" id="txtTitle" size="50" 
EOD;
		$output .= 'value="' . $result[0]->title . '" /></p>';
		$output .= '<p><label for="fieldText">Handling:<br /></label>';
		$output .= '<textarea name="fieldText" id="fieldText" cols="75" rows="5">' . $result[0]->plot . '</textarea></p>';
		$output .= '<p><label for="txtÅr">År:<br /></label><input type="text" name="txtYear" id="txtYear" size="5" value="' . $result[0]->YEAR . '"/></p>';
		$output .= '<p><label for="txtPris">Pris:<br /></label><input type="text" name="txtPris" id="txtPris" size="5" value="' . $result[0]->price . '"/></p>';
		$output.= $this->showCategories($ide);
		
		$output .= '<input type="hidden" name="id" id="id" value="' . $result[0]->id . '" />';
		
		$output .= '<fieldset style="width: '. $fieldSetWidth .'px; margin-top: 15px;"><legend>Omslagsbild</legend>';
		$output .= '<p><input type="text" name="txtSmallImg" id="txtSmallImg" value="' . $posterImg . '"/></p>';
		$imgURLPoster = "img.php?src=" . $imgPath . $posterImg . "&width=" . $imgLimitWidth . "&height=" . $imgLimitHeight . "&sharpen";
		$output .= '<p><img src="' . $imgURLPoster . '"/></p>';
		$output .= "</fieldset>";
		
		$output .= '<fieldset style="width: '. $fieldSetWidth .'px; margin-top: 15px;"><legend>Bild</legend>';
		$output .= '<p></label><input type="text" name="txtBigImg" id="txtBigImg" value="' . $bigImg . '"/></p>';
		$imgURL = "img.php?src=" . $imgPath . $bigImg . "&width=" . $imgLimitWidth . "&height=" . $imgLimitHeight . "&sharpen";
		$output .= '<p><img src="' . $imgURL . '"/></p>';
		$output .= "</fieldset>";
		
		$output .= '<p><label for="txtTrailer">Trailer:<br /></label><input type="text" name="txtTrailer" id="txtTrailer" size="58" value="' . $result[0]->trailer . '"/></p>';
		$output .= '<p><label for="txtIMDB">IMDB:<br /></label><input type="text" name="txtIMDB" id="txtIMDB" size="58" value="' . $result[0]->imdb . '"/></p>';
		$output .= '<input type="submit" name="btnSave" id="btnSave" value="Spara" />';
  	$output .= '<input type="reset" name="btnReset" id="button" value="Återställ" />';
		$output .= "</form>";
				
		return $output;
	}
	
	//**********************************************************************************************
	// Works 2014-12-14
	private function updateDB($servQuery){
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
			$plot = $fieldText;
		}else{
			die("Handling krävs");
		}
		
		if(isset($txtYear) AND ( (int)$txtYear > 1900 AND (int)$txtYear < 3000) ){
			$year = $txtYear;
		}else{
			die("Otillåtet år");	
		}
		
		if(isset($txtPris) ){
			$price = $txtPris;
		}else{
			die("Pris krävs");	
		}
		
		if(isset($Kategorier) ){
			$cats = $Kategorier;
		}else{
			$cats= "";
		}
		
		if(isset($txtSmallImg) ){
			$smallImg = $txtSmallImg;
		}
		
		if(isset($txtBigImg) ){
			$bigImg = $txtBigImg;
		}
		
		if(isset($txtTrailer) ){
			$trailer = $txtTrailer;
		}
		
		if(isset($txtIMDB) ){
			$imdb = $txtIMDB;
		}
				
		$sql = 'UPDATE ' . strip_tags($this->tableName) . ' SET ';
		$sql .= "title='" . strip_tags($title) . "', ";
		$sql .= "plot='" . strip_tags($plot) . "', ";
		$sql .= "YEAR='" . $year . "', ";
		$sql .= "price='" . $price . "', ";
		$sql .= "smallimg='" . $smallImg . "', ";
		$sql .= "bigimg='" . $bigImg . "', ";
		$sql .= "trailer='" . $trailer . "', ";
		$sql .= "imdb='" . $imdb . "' ";
		$sql .= "WHERE id='" . strip_tags($ide) . "'";
		$queryResult = $this->dBase->ExecuteQuery($sql);
		
		$this->updateDBmov2genre(strip_tags($ide) ,$servQuery);
		
		if(!$queryResult){
			dump($this->dBase->ErrorCode()) . "-" . dump($this->dBase->ErrorInfo());
		}
		return $queryResult;
	}
		
	//*******************************************************************************************************************************
	// Trash marks as deleted in db. Delete deletes for real from db
	public function trash($query){
		$query = urldecode($query);
		parse_str($query); //Split into key-val
		
		if(isset($id) AND is_numeric($id) AND $id > 0){
				$id = htmlentities($id, null, 'UTF-8');	
			}else{
				die("id krävs i trash()");
			}
		
		if(isset($delete) AND $delete == "true"){
			$sql = "DELETE FROM " . strip_tags($this->tableName) . " WHERE id=" . strip_tags($id) . " LIMIT 1"; //Limit 1 just for safety
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
	
	//**********************************************************************************
	private function showCategories($filmId){
		$table1 = "stel14.genre";
		$tableMov2Genre = "stel14.movie2genre";
		$table1column = "id";
		$tableMov2GenreColumn = "idGenre";
		
		$sqlAllCats = "SELECT id, name FROM " . $table1 . " ORDER BY name"; // All categories
		$allCats = $this->dBase->ExecuteSelectQueryAndFetchAll($sqlAllCats);
		
		$sqlCats1movie = "SELECT " . $tableMov2GenreColumn . " FROM " . $this->tableMov2Genre . " WHERE idMovie =" . $filmId; // Categories 1 movie
		$cats1movie = $this->dBase->ExecuteSelectQueryAndFetchAll($sqlCats1movie);
				
		$output = "<fieldset><legend>Kategorier</legend>";
		
		foreach($allCats AS $key=>$val){
			$output .= '<input type="checkbox" name="cats' . $val->id . '" '; 
			foreach($cats1movie AS $ke=>$va){
				if($va->idGenre == $val->id){
					$output .= ' checked="checked"'; 		
				}
			}
			$output .= '/><label for="cats' . $val->id . '">' . ucfirst($val->name) . '.</label>';
		}
		
		$output .= "</fieldset>";
		return $output;
	}
	
	//******************************************************************************************
	private function updateDBmov2genre($id, $quer){
		$maxCategories = 100;
		parse_str($quer); //Split into key-val
		
		// Delete marked categories from DB
		$sqlDelete = "DELETE FROM " . $this->tableMov2Genre . " WHERE idMovie=" . $id;
		$this->dBase->ExecuteQuery($sqlDelete);	
		
		for($i=1; $i < $maxCategories; $i++){
			$temp = "cats" . $i;
			if( strpos($quer, $temp . "=on") > 1){
				$sql = "INSERT INTO " . $this->tableMov2Genre . " (idMovie, idGenre)";
				$sql .= ' VALUES ("' . $id . '","' . $i . '")';
				$this->dBase->ExecuteQuery($sql);	
			}
		}
	}
}