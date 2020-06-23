<?php
/**
 * class for Kmom 04
 *
 */
class CKmom04 {
 
  /**
   * Members
   */
  private $searchForm; // The html code
	private $table;
	private $sql;
	
  //************************************************************************ 	
	/**
  * Constructor creating form
  */
  public function __construct() {
		
		//remove query from URl
		$temp = explode("?", $_SERVER["REQUEST_URI"]);
		$thisPage = $temp[0];
		
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
			<a href= $thisPage >Visa alla filmer</a>
		</p>
EOD;
	}
	
	//****************************************************************************
	/**
  * Getter for rearchForm
  */
	public function getSearchForm() {
		return $this->searchForm;
	}
	
	//*****************************************************************************
	// Params database, query, limit of rowsposts to show 
	public function createTable($dbas, $query, $rowLimit) {
		$text = $from = $to = $orderBy = $scending = $questionmark = $ascDesc =$totRows = $pag = null;
		
		$this->sql = "SELECT * FROM movie";
		echo "<br>sql: " . $this->sql . "<br>";/////////////////////////////////////////////
		$totRows = count($dbas->ExecuteSelectQueryAndFetchAll($this->sql) );
		dump($totRows); /////////////////////////////////////////////////////////////
		$this->sql = null;
		
		//-----
		parse_str($query); //Extracts the variables from the $_SERVER['QUERY_STRING']
		
		if(strlen($query) > 0){
			$this->sql = "SELECT * FROM movie";
		}else{
			$this->sql = "SELECT * FROM movie ORDER BY title ASC";
		}
		
		if(isset($txtSearch)){
			$text = $txtSearch;
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
				
		if($ascDesc=="de"){		
			$scending = "&ascDesc=a";	// Every second time ASC(default)/DESC
		}else{
			$scending = "&ascDesc=de"; 
		}
						
		if(isset($text) OR isset($from) OR isset($to)){
				$this->sql .= " WHERE";
		}
		
		if(isset($text)){
			$this->sql .= " title LIKE '" . $text . "'"; 	
		} 
		
		if(isset($text) AND ( (isset($from) AND $from > 0 ) OR (isset($to) AND $to > 0 ) ) ) {
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
		$result = $dbas->ExecuteSelectQueryAndFetchAll($this->sql);
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
				
		if(strlen($query) <= 0){
			$questionmark = "?"; // Put question mark if needed
		}
				
		$this->table = "<table width='600' border='1' align='center' cellspacing='0'><tr>";
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
		
		$this->putPageLinks($query, $rowLimit, $totRows);
				
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
			$part1 = substr( $_SERVER["REQUEST_URI"] , 0 , $posOfPageStart ); //The part before sort
			$part2 = substr( $_SERVER["REQUEST_URI"] , $posOfPageStart + $posOfPageEnd); // The part after sort
			$URLWithoutPage = $part1 . $part2;
		}else{
			$URLWithoutPage = $_SERVER["REQUEST_URI"]; 
		}
				
		for($i = 0; $i < ceil($tRows / $rowL) ; $i++){
			$this->table .= "<a href='" . $_SERVER['REQUEST_URI'];
			$this->table .= $questionmark . '&page=' . ($i+1) . " '>" . ($i+1) . "</a>&nbsp;";
		}
		
		$this->table .= "</p>";
	}
}








