<?php
/**
 * class for movies
 *
 */
class CMovies {
 
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
		$output = $this->searchForm();
		$output .= $this->putHits($this->thisPage, $this->URIRequest);
		$output .= $this->createResultTable();
		$output .= $this->putPageLinks($this->thisPage, $this->URIRequest);
		return $output;
	}
	
	//****************************************************************************
	/**
  * searchForm
  */
	private function searchForm() {
		$outputForm = <<<EOD
		<form>
  		<fieldset>
    		<legend>Sök</legend>
    		<p>
    			<label for="txtSearch">Titel (delsträng, använd % som *) </label>
      		<input type="text" name="txtSearch" id="txtSearch" />
    		</p>
    		<p>
    			<label for="txtYearFrom">Skapad mellan åren</label>
      		<input type="text" name="txtYearFrom" id="txtYearFrom" />
					och
					<label for="txtYearTo"></label>
					<input type="text" name="txtYearTo" id="txtYearTo" />
    		</p>
				<p>
					<input type="submit" name="btnSubmit" id="btnSubmit" value="Sök" />
				</p>
			</fieldset>
		</form>
		<p>
			<a href= $this->thisPage >Visa alla filmer</a>
		</p>
EOD;
		return $outputForm;
	}
	
	//*****************************************************************************
	public function createResultTable() {
	
		$output = "";
				
		$output .= "<table width='800' border='1' align='center' cellspacing='0'><tr>";
		$output .= "<th scope='col'>Titel";
		
		$output .= $this->tableHeader();
		
		$temp = explode("LIMIT", $this->sqlQuery);
		$noLimitSql = $temp[0];
		
		$this->resultRows = count($this->dataBase->ExecuteSelectQueryAndFetchAll($noLimitSql) );
		
		$result = $this->dataBase->ExecuteSelectQueryAndFetchAll($this->sqlQuery); 
		
		foreach($result AS $key=>$value){
			$output .=	"<tr>";
  		$output .= "<td>" . $value->title . "</td>";
  		$output .= "<td>" . $value->YEAR . "</td>";
  		$output .=	"</tr>";
		}
		$output .= "</table>";
						
		return $output;
	}
	
	//*******************************************************************
	// Put "< 1 2 3 etc >"-links
	private function putPageLinks($pageURL, $queryPart){
		$defaultLimit = 4;
		$str = "<p style='text-align: center;'>";
				
		// < To the page before 
		if($this->currentPage > 1){
			$this->handledReqVar["pag"] = $this->currentPage - 1;	
			$str .= '<a href="' . $pageURL . $this->addKeyValsToOutURL();
			$str .= '"><</a>&nbsp;';
		}
				
		// page numbers
		for($i = 0; $i < ceil($this->resultRows / $this->handledReqVar["limit"]) ; $i++){
			$this->handledReqVar["pag"] = $i+1; 
			$str .= "<a href='" . $pageURL . $this->addKeyValsToOutURL(); 
			$str .= " '>" . ($i+1) . "</a>&nbsp;"; 
		}
		
		// > To the next page
		if($this->currentPage < ceil($this->resultRows / $this->handledReqVar["limit"])){
			$this->handledReqVar["pag"] = $this->currentPage + 1;
			$str .= '<a href="' . $pageURL . $this->addKeyValsToOutURL();
			$str .= '">></a>';
		}
		
		$str .= "</p>";
		
		return $str;
	}
	
	//***************************************************************************************************
	// Put number of films shown on a page, 2, 4, 6, etc. 
	private function putHits($pageURL, $queryPart){
		$output = "<p style='text-align: right;'>Antal träffar per sida ";
				
		for($i = 2; $i < 12; $i+=2){
			$output .= "<a href='" . $pageURL . "?hits=" . $i . "'>" . $i . "</a>&nbsp;";
		}
		
		$output .= "</p>";
		return $output;
	}
	
	//************************************************************************************************
	// 2014-10-22
	private function makeSQLQuery($reqVar){
		$sqlQuery = "";
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
	private function handleHTTPRequest($req){
		$this->handledReqVar["txt"] = $this->handledReqVar["yearF"] = $this->handledReqVar["yearT"] = $this->handledReqVar["limit"] = null;
		$this->handledReqVar["pag"] = $this->handledReqVar["sortOrder"] = $this->handledReqVar["ascendOrDescend"] = null;
		$defaultLimit = 4;
		
		parse_str($req, $arrInputReq); // Extracts the variables from request
		
		if(isset($arrInputReq["txtSearch"])){
			$this->handledReqVar["txt"] = $arrInputReq["txtSearch"];
		}
		
		if(isset($arrInputReq["txtYearFrom"])){
			$this->handledReqVar["yearF"] = $arrInputReq["txtYearFrom"];
		}
		
		if(isset($arrInputReq["txtYearTo"])){
			$this->handledReqVar["yearT"] = $arrInputReq["txtYearTo"];
		}
		
		if(isset($arrInputReq["hits"])){
			$this->handledReqVar["limit"] = $arrInputReq["hits"];
		}else{
			$this->handledReqVar["limit"] = $defaultLimit;
		}
		
		if(isset($arrInputReq["page"])){
			$this->handledReqVar["pag"] = $arrInputReq["page"];
		}else{
			$this->handledReqVar["pag"] = 1;
		}
		
		$this->currentPage = $this->handledReqVar["pag"];
		
		if(isset($arrInputReq["order"])){
			$this->handledReqVar["sortOrder"] = $arrInputReq["order"];
		}else{
			$this->handledReqVar["sortOrder"] = "title"; // Default
		}
		
		if(isset($arrInputReq["ascDesc"])){
			$this->handledReqVar["ascendOrDescend"] = $arrInputReq["ascDesc"];
		}
		$this->makeSQLQuery($this->handledReqVar);
	}
	
	////***********************************************************************************
//	// 2014-10-22 23:45
//	private function removeKeyVal($str, $key){
//		if(strpos($str, $key) > -1 ){
//			// Remove the key/value from URL
//			$posOfKeyValStart = strripos($str, $key);
//			$posOfKeyValEnd = strripos($str, $key, $posOfKeyValStart);
//			$part1 = substr( $str , 0 , $posOfKeyValStart ); //The part before
//			$part2 = substr( $str , $posOfKeyValStart + $posOfKeyValEnd); // The part after
//			$cleanedStr = $part1 . $part2;
//		}else{
//			$cleanedStr = $this->wholeURI;
//		}
//		return $cleanedStr;		
//	}
	
	//************************************************************************************
	private function tableHeader(){
		$imgAsc = "../../stelixx/webroot/img/asc.jpg";
		$imgDesc = "../../stelixx/webroot/img/desc.jpg";
		$this->handledReqVar["sortOrder"] = "title";
		$this->handledReqVar["ascendOrDescend"] = "a";
		$output = "<a href='" . $this->thisPage . $this->addKeyValsToOutURL(). "'><img src='" . $imgAsc . "'/></a>";
		$this->handledReqVar["ascendOrDescend"] = "de";
		$output .= "<a href='" . $this->thisPage . $this->addKeyValsToOutURL() . "'><img src='" . $imgDesc . "'/></a>";
		$output .= "</th>";
		$output .= "<th scope='col'>År";
		$this->handledReqVar["sortOrder"] = "YEAR";
		$this->handledReqVar["ascendOrDescend"] = "a";
		$output .= "<a href='" . $this->thisPage . $this->addKeyValsToOutURL() . "'><img src='" . $imgAsc . "' /></a>";
		$this->handledReqVar["ascendOrDescend"] = "de";
		$output .= "<a href='" . $this->thisPage . $this->addKeyValsToOutURL() . "'><img src='" . $imgDesc . "' /></a>";
		$output .= "</th>";
		
		$this->handledReqVar["ascendOrDescend"] = null; //reset
		$this->handledReqVar["sortOrder"] = null;	//reset
		
		return $output;
	}
	
	
	//*************************************************************************
	private function addKeyValsToOutURL(){
		$output = "?";
		if(isset($this->handledReqVar["pag"]) AND strlen($this->handledReqVar["pag"]) > 0 ){
			$output .= '&page=' . $this->handledReqVar["pag"];	
		}
		if(isset($this->handledReqVar["limit"]) AND strlen($this->handledReqVar["limit"]) > 0 ){
			$output .= '&hits=' . $this->handledReqVar["limit"];	
		}
		if(isset($this->handledReqVar["txt"]) AND strlen($this->handledReqVar["txt"]) > 0 ){
			$output .= '&txtSearch=' . $this->handledReqVar["txt"];
		}
		if(isset($this->handledReqVar["yearF"]) AND strlen($this->handledReqVar["yearF"]) > 0 ){
			$output .= '&txtYearFrom=' . $this->handledReqVar["yearF"];	
		}
		if(isset($this->handledReqVar["yearT"]) AND strlen($this->handledReqVar["yearT"]) > 0 ){
			$output .= '&txtYearTo=' . $this->handledReqVar["yearT"];	
		}
		if(isset($this->handledReqVar["sortOrder"]) AND strlen($this->handledReqVar["sortOrder"]) > 0 ){
			$output .= '&order=' . $this->handledReqVar["sortOrder"];	
		}
		if(isset($this->handledReqVar["ascendOrDescend"]) AND strlen($this->handledReqVar["ascendOrDescend"]) > 0 ){
			$output .= '&ascDesc=' . $this->handledReqVar["ascendOrDescend"];	
		}
		
		while(strpos( $output , "?&" ) > -1){ // Replace ?& with ?
			$output = str_replace("?&", "?", $output);	
		}
				
		return $output;
	}
}