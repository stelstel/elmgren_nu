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
		
		$sql = "SELECT * FROM movie";
		echo "<br>sql: " . $sql . "<br>";/////////////////////////////////////////////
		$totRows = count($dbas->ExecuteSelectQueryAndFetchAll($sql) );
		dump($totRows); /////////////////////////////////////////////////////////////
		$sql = null;
		
		parse_str($query); //Extracts the variables from the $_SERVER['QUERY_STRING']
		
		if(strlen($query) > 0){
			$sql = "SELECT * FROM movie";
		}else{
			$sql = "SELECT * FROM movie ORDER BY title ASC";
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
				$sql .= " WHERE";
		}
		
		if(isset($text)){
			$sql .= " title LIKE '" . $text . "'"; 	
		} 
		
		if(isset($text) AND (isset($from) OR isset($to) ) ) {
			$sql .= " AND";		
		}
		
		if( isset($from) ){
			$sql .= " YEAR >= " .$from ;			
		}
		
		if( isset($from) and isset($to)){
			$sql .= " AND" ;			
		}
				
		if( isset($to) ){
			$sql .= " YEAR <= " .$to ;			
		}
		
		if(isset($orderBy)){
			$sql .= " ORDER BY " . $orderBy;
			if($scending == "&ascDesc=de"){
				$sql .= " DESC";	
			}else{
				$sql .= " ASC";
			}
		}
		
		if(isset($rowLimit)){
			if(isset($page)){
				$pag = $page;		
				$sql .= " LIMIT " . $rowLimit * ($pag-1) . ", " . $rowLimit; 
			}else{
				$sql .= " LIMIT " . $rowLimit ; 	
			}
		}
		 
		echo "sql: " . $sql;/////////////////////////////////////////////////////
		$result = $dbas->ExecuteSelectQueryAndFetchAll($sql);
		//echo dump($result); /////////////////////////////////////////////////////////////////////////
		
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
		
		
		//echo "thispage: " . $thisPage . "<br>";/////////////////////////////////////////////////////////////////////////
		//echo "phpself" . basename($_SERVER['PHP_SELF']); ///////////////////////////////////////////////////////// 
		
		if(strlen($query) <= 0){
			$questionmark = "?"; // Put question mark if needed
		}
				
		$table = "<table width='600' border='1' align='center' cellspacing='0'><tr>";
		$table .= "<th scope='col'>Titel"; 
		$table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=title" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$table .= "</th>";
		$table .= "<th scope='col'>År";
		$table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=de" . "'><img src='../../stelixx/webroot/img/asc.jpg' /></a>";
		$table .= "<a href='" . $URLWithoutSort . $questionmark . "&order=YEAR" . "&ascDesc=a" . "'><img src='../../stelixx/webroot/img/desc.jpg' /></a>";
		$table .= "</th>";
		
		foreach($result AS $key=>$value){
			$table .=	"<tr>";
  		$table .= "<td>" . $value->title . "</td>";
  		$table .= "<td>" . $value->YEAR . "</td>";
  		$table .=	"</tr>";
		}
		$table .= "</table>";
				
		$table .= "<p style='text-align: center;'>";
		
		if(strlen($query) <= 0){
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
				
		for($i = 0; $i < ceil($totRows / $rowLimit) ; $i++){
			$table .= "<a href='" . $_SERVER['REQUEST_URI'];
			$table .= $questionmark . '&page=' . ($i+1) . " '>" . ($i+1) . "</a>&nbsp;";
		}
		
		$table .= "</p>";
		
		return $table;
	}
}








