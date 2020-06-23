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
	private $table; ////tabort
	private $dataBase;
	private $dbTable;
	private $vars;
	private $requestURI;
	private $query; /// tabort
	//private $URIRequest;
	//private $hits;
	//private $text;
	//private $yearFrom;
	//private $yearTo;
	private $sqlQuery;
	//private $orderBy;
	//private $limit;
//	private $ascOrDesc;
	//private $pageNR;
		
  //************************************************************************ 	
	/**
  * Constructor
  */
  public function __construct($db, $URI, $dbTab) {
		echo "URI: " . $URI . "<br>"; ////////////////////////////////// 
		//$this->thisPage = null;
		
		$temp = explode("?", $URI);  // Split URI into page adress and request
		$this->thisPage = $temp[0];			// Page adress
		
		if (isset($temp[1])){						
			$URIRequest = "&" . $temp[1]; // Request	
			
			echo "requ: " . $URIRequest . "<br>"; //////////////////////////////////// 
			
			$this->handleHTTPRequest($URIRequest);
		}
				
		if(isset($db)){
			$this->dataBase = $db;
		}
		
		if(isset($dbTab)){
			if (!strrpos($dbTab, "") > 0){
				$this->dbTable = $dbTab;
			}
		}
		
		if(isset($reqURI)){
			if (!strrpos($reqURI, "") > 0){
				$this->requestUri = $reqURI;
			}
		}
		
		//if(isset($txtSearch)){
//			$this->text = $txtSearch;
//		}
		
		//if(isset($txtYearFrom)){
//			$this->yearFrom = $txtYearFrom;
//		}
		
		//if(isset($txtYearTo)){
//			$this->yearTo = $txtYearTo;
//		}
		
		//if(isset($order)){
//			$this->orderBy = $order;
//		}
		
		//if(isset($hits)){
//			$this->limit = $hits;
//		}else{
//			$this->limit = $defaultLimit;
//		}
		
		//if(isset($ascDesc)){						//Skicka alla dessa till funtionen i stället
//			$this->ascOrDesc = $ascDesc;
//		}
		
		//if(isset($page)){
//			$this->pageNR = $page;
//		}else{
//			$this->pageNR = 0;	
//		}
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
		$this->makeSql();
		$from = $to = $orderBy = $scending = $questionmark = $ascDesc =$totRows = $pag = null;
		$this->sql = "SELECT * FROM " . $this->dbTable;
		echo "<br>sql: " . $this->sql . "<br>";/////////////////////////////////////////////
		$totRows = count($this->dataBase->ExecuteSelectQueryAndFetchAll($this->sql) );
		$this->sql = null;
		
		parse_str($this->requestURI); //Extracts the variables from the $_SERVER['QUERY_STRING']
		
		if(strlen($this->requestURI) > 0){
			$this->sql = "SELECT * FROM " . $this->dbTable;
		}else{
			$this->sql = "SELECT * FROM " . $this->dbTable . " ORDER BY title ASC";
		}
		
		if(isset($txtYearFrom) ){
			$from = $txtYearFrom;
		}
		
		if(isset($txtYearTo)){
			$to = $txtYearTo;
		}
		
		if(isset($order)){
			$orderBy = $order;
		}
		
		if(isset($this->hits)){
			$rowLimit = $this->hits;
		}else{
			$rowLimit = 4;
		}
				
		if($ascDesc=="de"){		
			$scending = "&ascDesc=a";	// Every second time ASC(default)/DESC
		}else{
			$scending = "&ascDesc=de"; 
		}
						
		if(isset($this->text) OR isset($from) OR isset($to)){
				$this->sql .= " WHERE";
		}
		
		if(isset($this->text)){
			$this->sql .= " title LIKE '" . $this->text . "'"; 	
		} 
		
		if(isset($this->text) AND ( (isset($from) AND $from > 0 ) OR (isset($to) AND $to > 0 ) ) ) {
			$this->sql .= " AND";		
		}
		
		if( isset($from) AND $from > 0 ){
			$this->sql .= " YEAR >= " .$from ;			
		}
		
		if( isset($from) and isset($to) AND $from > 0 AND $to > 0 ){
			$this->sql .= " AND" ;			
		}
		
		if( isset($to) AND $to > 0){
			$this->sql .= " YEAR <= " .$to ;			
		}
		
		if(isset($orderBy)){
			$this->sql .= " ORDER BY " . $orderBy;
			if($scending == "&ascDesc=de"){
				$this->sql .= " DESC";	
			}else{
				$this->sql .= " ASC";
			}
		}
		
		if(isset($rowLimit)){
			if(isset($page)){
				$pag = $page;		
				$this->sql .= " LIMIT " . $rowLimit * ($pag-1) . ", " . $rowLimit; 
			}else{
				$this->sql .= " LIMIT " . $rowLimit ; 	
			}
		}
		echo "sql: " . $this->sql;/////////////////////////////////////////////////////
		$result = $this->dataBase->ExecuteSelectQueryAndFetchAll($this->sql);
		$thisPage = $_SERVER["REQUEST_URI"];
		
		if(strpos($_SERVER["REQUEST_URI"], "order=") > -1 ){
									
			// Remove the order key/value from URL
			$posOfOrderStart = strripos($_SERVER["REQUEST_URI"], "&order=");
			$posOfOrderEnd = strripos($_SERVER["REQUEST_URI"], "&order=", $posOfOrderStart);
			$part1 = substr( $_SERVER["REQUEST_URI"] , 0 , $posOfOrderStart ); //The part before sort
			$part2 = substr( $_SERVER["REQUEST_URI"] , $posOfOrderStart + $posOfOrderEnd); // The part after sort
			$URLWithoutSort = $part1 . $part2;
		}else{
			$URLWithoutSort = $_SERVER["REQUEST_URI"]; 
		}
				
		if(strlen($this->requestURI) <= 0){
			$questionmark = "?"; // Put question mark if needed
		}
		
		$this->table = "";
		$this->putHits($this->requestURI);
		
		$this->table .= "<table width='800' border='1' align='center' cellspacing='0'><tr>";
		$this->table .= "<th scope='col'>Titel"; 
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$this->table .= "</th>";
		$this->table .= "<th scope='col'>År";
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$this->table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$this->table .= "</th>";
		
		foreach($result AS $key=>$value){
			$this->table .=	"<tr>";
  		$this->table .= "<td>" . $value->title . "</td>";
  		$this->table .= "<td>" . $value->YEAR . "</td>";
  		$this->table .=	"</tr>";
		}
		$this->table .= "</table>";
		$this->putPageLinks($this->requestURI, $rowLimit, $totRows);
				
		return $this->table;
	}
	
	//*******************************************************************
	private function putPageLinks($qry, $rowL, $tRows){
		$questionmark = null;
		
		$this->table .= "<p style='text-align: center;'>";
				
		if(strlen($qry) <= 0){
			$questionmark = "?"; // Put question mark if needed
		}
				
		if(strpos($_SERVER["REQUEST_URI"], "&page=") > -1 ){
			// Remove the page key/value from URL
			$posOfPageStart = strripos($_SERVER["REQUEST_URI"], "&page=");
			$posOfPageEnd = strripos($_SERVER["REQUEST_URI"], "&page=", $posOfPageStart);
			$part1 = substr( $_SERVER["REQUEST_URI"] , 0 , $posOfPageStart ); //The part before
			$part2 = substr( $_SERVER["REQUEST_URI"] , $posOfPageStart + $posOfPageEnd); // The part after
			$URLWithoutPage = $part1 . $part2;
		}else{
			$URLWithoutPage = $_SERVER["REQUEST_URI"]; 
		}
				
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
				
		if(strlen($qu) <= 0){
			$questionmark = "?"; // Put question mark if needed
		}
				
		if(strpos($_SERVER["REQUEST_URI"], "&hits=") > -1 ){
			// Remove the hits key/value from URL
			$posOfHitsStart = strripos($_SERVER["REQUEST_URI"], "&hits=");
			$posOfHitsEnd = strripos($_SERVER["REQUEST_URI"], "&hits=", $posOfHitsStart);
			$part1 = substr( $_SERVER["REQUEST_URI"] , 0 , $posOfHitsStart ); //The part before
			$part2 = substr( $_SERVER["REQUEST_URI"] , $posOfHitsStart + $posOfHitsEnd); // The part after
			$URLWithoutHits = $part1 . $part2;
		}else{
			$URLWithoutHits = $_SERVER["REQUEST_URI"]; 
		}
		
		$this->table .= "Antal träffar per sida ";
		
		for($i = 2; $i < 10; $i+=2){
			$this->table .= "<a href='" . $URLWithoutHits . $questionmark . "&hits=" . $i . "'>" . $i . "</a>&nbsp;";
			$questionmark = null;
		}
		$this->table .= "</p>";
	}
	//************************************************************************************************
	private function makeSQL(){
		if(strlen($this->URIRequest) > 0){
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
						
			// good sql
			// SELECT * FROM movie WHERE title LIKE '%a%' AND YEAR >= 1999 AND YEAR <= 2010 ORDER BY title ASC LIMIT 0, 5;		
		
		}else{
			$this->sqlQuery = "SELECT * FROM " . $this->dbTable . " ORDER BY title ASC";
		}
		echo "sqlQuery: " . $this->sqlQuery . "<br>";	
	}
	
	//***********************************************************************************
	private function handleHTTPRequest($req){
		
		$handledReqVar["txt"] = $handledReqVar["yearF"] = $handledReqVar["yearT"] = $handledReqVar["limit"] = null;
		$handledReqVar["pag"] = $handledReqVar["sortOrder"] = $handledReqVar["AscendOrDescend"] = null;
		$defaultLimit = 4;
		
		parse_str($req, $arrInputReq);						// Extracts the variables from request
		
		dump($arrInputReq); ////////////////////////////////////////////////////////////////////////
		
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
	}
}








