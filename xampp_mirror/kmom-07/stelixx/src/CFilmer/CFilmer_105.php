<?php
/**
 * class for Filmer
 *
 */
class CFilmer{
 	/**
   * Members
   */
  private $thisPage;
	private $dataBase;
	private $dbTable;
	private $wholeURI;
	private $URIRequest;
	private $sqlQuery;
	private $resultRows;
	private $imgPath 		= "filmer/";
	private $imgHeight 	= 180;
				
  //************************************************************************ 	
	/**
  * Constructor
  */
  public function __construct($db, $URI, $dbTab) {
		if(isset($dbTab)){
			if (!strrpos($dbTab, "") > 0){
				$this->dbTable = $dbTab;
			}
		}
		
		if(isset($URI)){
			if (!strrpos($URI, "") > 0){
				$this->wholeURI = $URI;
			}
			$temp = explode("?", $URI);  // Split URI into page adress and request
			$this->thisPage = $temp[0];			// Page adress part
		
			if (isset($temp[1])){						
				$this->URIRequest = "&" . $temp[1]; // Request part
			}
			$this->handleHTTPRequest($this->URIRequest);
		}
						
		if(isset($db)){
			$this->dataBase = $db;
		}
	}
	
	//****************************************************************************
	public function createPage(){
		$output = $this->putHits($this->URIRequest);
		$output .= $this->createResultTable();
		$output .= $this->putPageLinks($this->URIRequest);
		return $output;
	}
	
	//****************************************************************************
	/**
  * searchForm
  */
	public function searchForm() {
		$outputForm = <<<EOD
		<form>
			<p style="text-align: center">
				<label for="txtSearch">Sök. Titel (delsträng, använd % som *) </label>
				<input type="text" name="txtSearch" id="txtSearch" />
				<label for="txtYearFrom">Skapad mellan åren</label>
				<input type="text" name="txtYearFrom" id="txtYearFrom" size="4" maxlength="4"/>
				och
				<label for="txtYearTo"></label>
				<input type="text" name="txtYearTo" id="txtYearTo" size="4" maxlength="4"/>
				<input type="submit" name="btnSubmit" id="btnSubmit" value="Sök" />
				<a href= $this->thisPage >Visa alla filmer</a>
			</p>
		</form>
EOD;
		return $outputForm;
	}
	
	//*****************************************************************************
	public function createResultTable() {
		$output = "";
				
		$output .= "<table class='film_tbl' cellpadding='3' width='950' align='center' ><tr>";
		$output .= "<th scope='col'>Bild</th>";
		$output .= "<th scope='col'>Titel";
		
		$output .= $this->tableHeader();
		$output .= "<th scope='col'>Kategori</th>";
		$output .= "<th scope='col'>Pris</th>";
		
		$temp = explode("LIMIT", $this->sqlQuery);
		$noLimitSql = $temp[0];
		
		$this->resultRows = count($this->dataBase->ExecuteSelectQueryAndFetchAll($noLimitSql) );
		
		$result = $this->dataBase->ExecuteSelectQueryAndFetchAll($this->sqlQuery);
		
		foreach($result AS $key=>$value){
			$link = '<a href="film.php?id=' . $value->id . '">';
			$output .=	"<tr>";
  		$output .= '<td style="text-align: center">';
			$output .= '<p class="centeredImage">' . $link . '<img src="img.php?src=' . $this->imgPath; 
			$output .= $value->smallimg . '&height=' . $this->imgHeight . '&sharpen"/></p>';
			$output .= "</td>";
			$output .= "<td>" . $link . $value->title . "</td>";
			$output .= '<td style="text-align: center">' . $value->YEAR . "</td>";
			$output .= "<td>" . $this->getCategories($value->id) . "</td>";
			$output .= '<td style="text-align: center">' . $value->price . " kr</td>";
  		$output .=	"</tr>";
		}
		$output .= "</table>";
						
		return $output;
	}
	
	//*******************************************************************
	private function putPageLinks($qry){
		$currentPage = $this->findCurrentPage($qry);
		$defaultLimit = 4;
		$ampersand = "&"; //Ampersand or nothing
				
		parse_str($qry, $arrInputQry);		// Extracts the variables from request
		$questionmark = null;
		
		$str = "<p style='text-align: center;'>";
				
		if(strlen($qry) <= 0 AND strpos($qry, "?") <= 0){
			$questionmark = "?"; // Put question mark if needed
			$ampersand = "";
		}
		
		$URLWithoutPage = $this->removeKeyVal($this->wholeURI, "&page=" );
		
		// < To the page before 
		if($currentPage > 0){	
			$str .= '<a href="' . $URLWithoutPage . $questionmark . '&page=' . ($currentPage - 1) . '"><</a>&nbsp;';
		}else{
			$str .= '<a href="' . $URLWithoutPage . $questionmark . '&page=' . $currentPage . '"><</a>&nbsp;';
		}
				
		if(isset($arrInputQry["hits"]) ){
			for($i = 0; $i < ceil($this->resultRows / $arrInputQry["hits"]) ; $i++){
				$str .= "<a href='" . $URLWithoutPage;
				$str .= $questionmark . '&page=' . ($i+1) . " '>" . ($i+1) . "</a>&nbsp;";
			}
		}else{
			for($i = 0; $i < ceil($this->resultRows / $defaultLimit) ; $i++){
				$str .= "<a href='" . $URLWithoutPage;
				$str .= $questionmark . '&page=' . ($i+1) . " '>" . ($i+1) . "</a>&nbsp;";
			}
		}
		
		// > To the next page
		$str .= '<a href="' . $URLWithoutPage . $questionmark . '&page=' . ($currentPage + 1) . '">></a>&nbsp;';
				
		$str .= "</p>";
		return $str;
	}
	
	//***************************************************************************************************
	private function putHits($qu){
		$questionmark = null;
		$ampersand = "&"; //Ampersand or nothing
		
		$output = "<p style='text-align: right;'>";
				
		if(strlen($qu) <= 0 AND strpos($this->URIRequest, "?") <= 0){
			$questionmark = "?"; // Put question mark if needed
			$ampersand = "";
		}
		
		$temp = $this->removeKeyVal($this->wholeURI, "page=" );
		$URLWithoutHits = $this->removeKeyVal($temp, "hits=" );		
				
		$output .= "Antal träffar per sida ";
		
		for($i = 2; $i < 10; $i+=2){
			$output .= "<a href='" . $URLWithoutHits . $questionmark . $ampersand . "hits=" . $i . "'>" . $i . "</a>&nbsp;";
		}
		
		$output .= "</p>";
		
		while(strpos( $output , "&&" ) > 0){ // Replace && with &
			$output = str_replace("&&", "&", $output);	
		}
		
		while(strpos( $output , "?&" ) > 0){ // Replace ?& with ?
			$output = str_replace("?&", "?", $output);	
		}
		
		return $output;
	}
	//************************************************************************************************
	// 2014-10-22
	private function makeSQLQuery($reqVar){
		//$sqlQuery = "";
		$anyValsInReqVar = false;
				
		// Check if there are any values in array
		if(isset($reqVar) AND is_array($reqVar) ){
			foreach($reqVar as $r => $v){
				if($v){
					$anyValsInReqVar = true;	
				}
			}
		}
		
		if($anyValsInReqVar){
			$this->sqlQuery = "SELECT * FROM " . $this->dbTable . " ";
			
			if( ($reqVar["txt"] <> "")  OR ($reqVar["yearF"] > 0) OR ($reqVar["yearT"] > 0) ){
				$this->sqlQuery .= "WHERE ";
			}
			
			if($reqVar["txt"] <> ""){
				$this->sqlQuery .= "title LIKE '" . $reqVar["txt"] . "' ";				
			}
			
			if( ($reqVar["txt"] <> "") AND (($reqVar["yearF"] > 0) OR ($reqVar["yearT"] > 0) ) ){
				$this->sqlQuery .= "AND ";	
			}
			
			if($reqVar["yearF"] > 0){
				$this->sqlQuery .= "YEAR >= " . $reqVar["yearF"] . " ";	
			}
			
			if( ($reqVar["yearF"] > 0) AND ($reqVar["yearT"] > 0) ){
				$this->sqlQuery .= "AND ";		
			}
			
			if($reqVar["yearT"] > 0){
				$this->sqlQuery .= "YEAR <= " . $reqVar["yearT"] . " ";	
			}
						
			if($reqVar["sortOrder"] <> ""){
				$this->sqlQuery .= "ORDER BY " . $reqVar["sortOrder"] . " ";
			}
			
			if($reqVar["ascendOrDescend"] <> ""){
				if($reqVar["ascendOrDescend"] == "de"){
					$this->sqlQuery .= "DESC ";	
				}else{
					$this->sqlQuery .= "ASC "; // Default	
				}
			}
			
			if($reqVar["limit"] <> "" AND $reqVar["pag"]){
				$this->sqlQuery .= "LIMIT " . ($reqVar["pag"]-1)*$reqVar["limit"] . ", " . $reqVar["limit"];		
			}else{
				$this->sqlQuery .= "LIMIT 0, " . $reqVar["limit"];	
			}
		}else{
			$this->sqlQuery = "SELECT * FROM " . $this->dbTable . " ORDER BY title ASC";
		}
	}
	
	//***********************************************************************************
	// 2014-10-22 19:19
	private function handleHTTPRequest($req){
		$handledReqVar["txt"] = $handledReqVar["yearF"] = $handledReqVar["yearT"] = $handledReqVar["limit"] = null;
		$handledReqVar["pag"] = $handledReqVar["sortOrder"] = $handledReqVar["ascendOrDescend"] = null;
		$defaultLimit = 4;
		
		parse_str($req, $arrInputReq);						// Extracts the variables from request
		
		if(isset($arrInputReq["txtSearch"])){
			$handledReqVar["txt"] = $arrInputReq["txtSearch"];
		}
		
		if(isset($arrInputReq["txtYearFrom"])){
			$handledReqVar["yearF"] = $arrInputReq["txtYearFrom"];
		}
		
		if(isset($arrInputReq["txtYearTo"])){
			$handledReqVar["yearT"] = $arrInputReq["txtYearTo"];
		}
		
		if(isset($arrInputReq["hits"])){
			$handledReqVar["limit"] = $arrInputReq["hits"];
		}else{
			$handledReqVar["limit"] = $defaultLimit;
		}
		
		if(isset($arrInputReq["page"])){
			$handledReqVar["pag"] = $arrInputReq["page"];
		}else{
			$handledReqVar["pag"] = 0;
		}
		
		if(isset($arrInputReq["order"])){
			$handledReqVar["sortOrder"] = $arrInputReq["order"];
		}
		
		if(isset($arrInputReq["ascDesc"])){
			$handledReqVar["ascendOrDescend"] = $arrInputReq["ascDesc"];
		}
		$this->makeSQLQuery($handledReqVar);
	}
	
	//***********************************************************************************
	// 2014-10-22 23:45
	private function removeKeyVal($str, $key){
		if(strpos($str, $key) > -1 ){
			// Remove the key/value from URL
			$posOfKeyValStart = strripos($str, $key);
			$posOfKeyValEnd = strripos($str, $key, $posOfKeyValStart);
			$part1 = substr( $str , 0 , $posOfKeyValStart ); //The part before
			$part2 = substr( $str , $posOfKeyValStart + $posOfKeyValEnd); // The part after
			$cleanedStr = $part1 . $part2;
		}else{
			$cleanedStr = $this->wholeURI;
		}
		return $cleanedStr;		
	}
	
	//************************************************************************************
	// 2014-10-22 23:51
	private function tableHeader(){
		if(strlen($this->URIRequest) <= 0 AND strpos($this->URIRequest, "?") <= 0 ){
			$questionmark = "?"; // Put question mark if needed
		}else{
			$questionmark = "";
		}
				
		$URLWithoutSort = $this->removeKeyVal($this->wholeURI, "&order=" );
		$output = "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$output .= "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$output .= "</th>";
		$output .= "<th scope='col'>År";
		$output .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$output .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$output .= "</th>";
		return $output;	
	}
	
	//************************************************************************************
	private function getCategories($filmId){
		$sql = "SELECT name FROM genre INNER JOIN movie2genre ON movie2genre.idGenre = genre.id WHERE movie2genre.idMovie =" . $filmId;
		$result = $this->dataBase->ExecuteSelectQueryAndFetchAll($sql);
				
		$arrSize = count($result);
		
		$i = 0;
		$output = "";
		
		foreach($result AS $key=>$value){
				$output .= ucfirst($value->name);
				if($i < $arrSize - 1 ){
					$output .= ", ";	
				}
				$i++;
		}
		return $output;
	}
	
	//************************************************************************************
	private function findCurrentPage($query){
		$startPos = strpos( $query , "page=") + 5;
		if($startPos > 5){
			$endPos = strpos( $query, "&", $startPos);
					
			if($endPos > 0){
				$length = $endPos-$startPos;
			}else{
				$length = 1;
			}
			
			return substr ( $query , $startPos , $length );
		}else{
			return -1;
		}
	}
}