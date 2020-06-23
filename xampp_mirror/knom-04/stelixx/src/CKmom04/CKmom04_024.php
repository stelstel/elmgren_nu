<?php
/**
 * class for Kmom 04
 *
 */
class CKmom04 {
 
  /**
   * Members
   */
  private $thisPage;
	private $searchForm;
	private $dataBase;
	private $dbTable;
	private $vars;
	private $wholeURI;
	private $URIRequest;
	private $sqlQuery;
				
  //************************************************************************ 	
	/**
  * Constructor
  */
  public function __construct($db, $URI, $dbTab) {
		if(isset($URI)){  //Används denna??? ////////////////////////////////////////
			if (!strrpos($URI, "") > 0){
				$this->wholeURI = $URI;
			}
			echo "URI: " . $URI . "<br>"; ///////////////////////////////////////////////////////////////
			$temp = explode("?", $URI);  // Split URI into page adress and request
			$this->thisPage = $temp[0];			// Page adress part
		
			if (isset($temp[1])){						
				$this->URIRequest = "&" . $temp[1]; // Request part
				$this->handleHTTPRequest($this->URIRequest);
			}
		}
						
		if(isset($db)){
			$this->dataBase = $db;
		}
		
		if(isset($dbTab)){
			if (!strrpos($dbTab, "") > 0){
				$this->dbTable = $dbTab;
			}
		}
	}
	
	//****************************************************************************
	/**
  * searchForm
  */
	public function searchForm() {
		$this->searchForm .= <<<EOD
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
		return $this->searchForm;
	}
	
	//*****************************************************************************
	// Params database, query, limit of rowsposts to show 
	public function createPage() {
		//if(strlen($this->URIRequest) <= 0 AND strpos($this->URIRequest, "?") <= 0 ){
//			$questionmark = "?"; // Put question mark if needed
//		}else{
//			$questionmark = "";
//		}
		
		$this->table = "";
		$this->putHits($this->URIRequest);
		
		$this->table .= "<table width='800' border='1' align='center' cellspacing='0'><tr>";
		$this->table .= "<th scope='col'>Titel";
		
		$this->tableHeader();
		
		$result = $this->dataBase->ExecuteSelectQueryAndFetchAll($this->sqlQuery); 
		
		foreach($result AS $key=>$value){
			$this->table .=	"<tr>";
  		$this->table .= "<td>" . $value->title . "</td>";
  		$this->table .= "<td>" . $value->YEAR . "</td>";
  		$this->table .=	"</tr>";
		}
		$this->table .= "</table>";
		$this->putPageLinks($this->URIRequest, $rowLimit, $totRows);
				
		return $this->table;
	}
	
	//*******************************************************************
	private function putPageLinks($qry, $rowL, $tRows){
		$questionmark = null;
		
		$this->table .= "<p style='text-align: center;'>";
				
		if(strlen($qry) <= 0 AND strpos($qry, "?")){
			$questionmark = "?"; // Put question mark if needed
		}
		
		$URLWithoutPage = $this->removeKeyVal($this->wholeURI, "&page=" );
				
		for($i = 0; $i < ceil($tRows / $rowL) ; $i++){
			$this->table .= "<a href='" . $URLWithoutPage;
			$this->table .= $questionmark . '&page=' . ($i+1) . " '>" . ($i+1) . "</a>&nbsp;";
		}
		
		$this->table .= "</p>";
	}
	
	//***************************************************************************************************
	private function putHits($qu){
		$questionmark = null;
		
		$this->table .= "<p style='text-align: right;'>";
				
		if(strlen($qu) <= 0 AND strpos($this->URIRequest, "?")){
			$questionmark = "?"; // Put question mark if needed
		}
		
		
		$URLWithoutHits = $this->removeKeyVal($this->wholeURI,"&hits=" );		
		
		$this->table .= "Antal träffar per sida ";
		
		for($i = 2; $i < 10; $i+=2){
			$this->table .= "<a href='" . $URLWithoutHits . $questionmark . "&hits=" . $i . "'>" . $i . "</a>&nbsp;";
			$questionmark = null;
		}
		$this->table .= "</p>";
	}
	//************************************************************************************************
	// 2014-10-22
	private function makeSQLQuery($reqVar){
		$sqlQuery = "";
		$anyValsInReqVar = false;
			
		// Check if there are any values in array
		foreach($reqVar as $r=>$v){
			if($v){
				$anyValsInReqVar = true;	
			}
		}
		
		if($anyValsInReqVar){
			$this->sqlQuery = "SELECT * FROM " . $this->dbTable . " ";
			
			if( ($this->text <> "")  OR ($this->yearFrom > 0) OR ($this->yearTo > 0) ){
				$this->sqlQuery .= "WHERE ";
			}
			
			if($this->text <> ""){
				$this->sqlQuery .= "title LIKE '" . $this->text . ", ";				
			}
			
			echo "thisyearFrom: " . $this->yearFrom . "<br>";
			
			if( ($this->text <> "") AND (($this->yearFrom > 0) OR ($this->yearTo > 0) ) ){
				$this->sqlQuery .= "AND ";	
			}
			
			if($this->yearFrom > 0){
				$this->sqlQuery .= "YEAR >= " . $this->yearFrom . " ";	
			}
			
			if( ($this->yearFrom > 0) AND ($this->yearTo > 0) ){
				$this->sqlQuery .= "AND ";		
			}
			
			if($this->yearTo > 0){
				$this->sqlQuery .= "YEAR <= " . $this->yearTo . " ";	
			}
			
			if($this->orderBy <> ""){
				$this->sqlQuery .= "ORDER BY " . $this->orderBy . " ";	
			}
			
			if($this->ascOrDesc <> ""){
				if($this->ascOrDesc == "a"){
					$this->sqlQuery .= "ASC ";	
				}elseif($this->ascOrDesc == "de"){
					$this->sqlQuery .= "DESC ";	
				}
			}
			
			if($this->limit <> ""){
				$this->sqlQuery .= "LIMIT " . $this->pageNR . ", " . $this->limit ;		
			}
		}else{
			$this->sqlQuery = "SELECT * FROM " . $this->dbTable . " ORDER BY title ASC";
		}
		echo "sqlQuery: " . $this->sqlQuery . "<br>";	
	}
	
	//***********************************************************************************
	// 2014-10-22 19:19
	private function handleHTTPRequest($req){
		echo "req: " . dump($req) . "<br>";
		$handledReqVar["txt"] = $handledReqVar["yearF"] = $handledReqVar["yearT"] = $handledReqVar["limit"] = null;
		$handledReqVar["pag"] = $handledReqVar["sortOrder"] = $handledReqVar["AscendOrDescend"] = null;
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
		
		if(isset($arrInputReq["txtYearTo"])){
			$handledReqVar["yearT"] = $arrInputReq["txtYearTo"];
		}
		
		if(isset($arrInputReq["hits"])){
			$handledReqVar["limit"] = $arrInputReq["hits"];
		}else{
			$handledReqVar["$limit"] = $defaultLimit;
		}
		
		if(isset($arrInputReq["page"])){
			$handledReqVar["pag"] = $arrInputReq["page"];
		}else{
			$handledReqVar["pag"] = 0;
		}
		
		if(isset($arrInputReq["order"])){
			$handledReqVar["sortOrder"] = $arrInputReq["order"];
		}
		
		if(isset($arrInputReq["ascDes"])){
			$handledReqVar["AscendOrDescend"] = $arrInputReq["ascDesc"];
		}
		
		$this->makeSQLQuery($handledReqVar);
	}
	
	//***********************************************************************************
	// 2014-10-22 23:45
	private function removeKeyVal($str, $key){
		echo "str 111: " . $str . "<br>";//////////////////////////////////////////////////////////////////
		echo "key 111: " . $key . "<br>";//////////////////////////////////////////////////////////////////
		if(strpos($str, $key) > -1 ){
			// Remove the key/value from URL
			echo "str: " . $str . "<br>";//////////////////////////////////////////////////////////////////
			$posOfKeyValStart = strripos($str, $key);
			$posOfKeyValEnd = strripos($str, $key, $posOfKeyValStart);
			$part1 = substr( $str , 0 , $posOfKeyValStart ); //The part before
			$part2 = substr( $str , $posOfKeyValStart + $posOfKeyValEnd); // The part after
			$cleanedStr = $part1 . $part2;
			echo "cleanedstr: " . $cleanedStr . "<br>"; /////////////////////////////////////////////////
		}else{
			$cleanedStr = $this->URIRequest;
			echo "cleanedstr 2: " . $cleanedStr . "<br>"; ///////////////////////////////////////////////// 
		}
		return $cleanedStr;	
	}
	
	//************************************************************************************
	// 2014-10-22 23:51
	private function tableHeader(){
		
		if(strlen($this->URI) <= 0 AND strpos($this->URI, "?") <= 0 ){
			$questionmark = "?"; // Put question mark if needed
		}else{
			$questionmark = "";
		}
		
		$URLWithoutSort = $this->removeKeyVal($this->wholeURI, "&order=" );
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$this->table .= "</th>";
		$this->table .= "<th scope='col'>År";
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$this->table .= "</th>";	
	}
}








