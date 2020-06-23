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
	
   	
	/**
  * Constructor creating form
  */
  public function __construct() {
		
		// Include the essential config-file which also creates the $stelixx variable with its defaults.
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
EOD;


	}
	
	public function getSearchForm() {
		return $this->searchForm;
	}
	
	public function createTable($dbas, $query) {
		$text = $from = $to = $orderBy = $scending = $questionmark = $ascDesc = null;
				
		parse_str($query); //Extracts the variables from the $_SERVER['QUERY_STRING']
		
		if(strlen($query) > 0){
			$sql = "SELECT * FROM movie";
		}else{
			$sql = "SELECT * FROM movie ORDER BY title ASC";
		}
		
		if(isset($txtSearch) AND strlen($txtSearch) > 0){
			$text = $txtSearch;
		}
		
		if(isset($txtYearFrom) AND strlen($txtYearFrom) > 0){
			$from = $txtYearFrom;
		}
		
		if(isset($txtYearTo) AND strlen($txtYearTo) > 0){
			$to = $txtYearTo;
		}
		
		if(isset($order) AND strlen($order) > 0){
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
		
		
		
		//echo "sql: " . $sql;/////////////////////////////////////////////////////
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
		$table .= "<th scope='col'><a href=" . $URLWithoutSort . $questionmark . "&order=title" . $scending . ">Titel</a></th>";
		$table .= "<th scope='col'><a href=" . $URLWithoutSort . $questionmark . "&order=YEAR" . $scending . ">År</a></th>";

		//echo "phpself" . basename($_SERVER['PHP_SELF']); /////////////////////////////////////////////////////////

		foreach($result AS $key=>$value){
			$table .=	"<tr>";
  		$table .= "<td>" . $value->title . "</td>";
  		$table .= "<td>" . $value->YEAR . "</td>";
  		$table .=	"</tr>";
		}
		$table .= "</table>";
		return $table;
	}
}






