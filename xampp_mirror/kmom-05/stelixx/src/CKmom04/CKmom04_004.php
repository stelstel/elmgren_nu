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
					-
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
		$text = $from = $to = null;
		$sql = "SELECT * FROM movie";
		
		parse_str($query); //Extracts the variables from the $_SERVER['QUERY_STRING']
		
		if(isset($txtSearch) AND strlen($txtSearch) > 0){
			$text = $txtSearch;
		}
		
		if(isset($txtfrom) AND strlen($txtFrom) > 0){
			$from = $txtFrom;
		}
		
		if(isset($txtTo) AND strlen($txtTo) > 0){
			$to = $txtTo;
		}
		
		if(isset($text) OR isset($from) OR isset($to)){
				$sql .= " WHERE";
		}
		
		if(isset($text)){
			$sql .= " title LIKE " . $text; 	
		} 
		
		if(isset($text) AND (isset($from) OR isset($to) ) ) {
			$sql .= " AND";		
		}
		
		if(isset($from){
			$sql .= " YEAR >= " .$from ;			
		}
		
		if(isset($to){
			$sql .= " YEAR <= " .$to ;			
		}
		
		
		
		
		//if(isset($txtSearch) AND strlen($txtSearch) > 0){
//			$sql .= " WHERE title LIKE '%" . $txtSearch . "%'";
//		}
		
		if(isset($txtFrom) AND strlen($txtfrom) > 0){
			$sql .= " WHERE title LIKE '%" . $txtSearch . "%'";
		}
		
		
		
		echo "sql: " . $sql;/////////////////////////////////////////////////////
		$result = $dbas->ExecuteSelectQueryAndFetchAll($sql);
		//echo dump($result); /////////////////////////////////////////////////////////////////////////
		
		$table = "<table width='600' border='1' align='center' cellspacing='0'><tr><th scope='col'>Titel</th><th scope='col'>År</th></tr>";

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






