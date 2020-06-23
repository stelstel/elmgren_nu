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
    			<label for="txtSearsh">Titel (delsträng, använd % som *) </label>
      		<input type="text" name="txtSearsh" id="txtSearsh" />
    		</p>
    		<p>
    			<label for="txtYearFrom">Skapad mellan åren</label>
      		<input type="text" name="txtYearFrom" id="txtYearFrom" />
					-
					<label for="txtYearTo"></label>
					<input type="text" name="txtYearTo" id="txtYearTo" />
    		</p>
				<p>
					<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" />
				</p>
			</fieldset>
		</form>
EOD;


	}
	
	public function getSearchForm() {
		return $this->searchForm;
	}
	
	public function getTable($dbas, $request) {
		$sql = "SELECT title, YEAR FROM movie";
		$result = $dbas->ExecuteSelectQueryAndFetchAll($sql);
		echo dump($result); /////////////////////////////////////////////////////////////////////////
		
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






