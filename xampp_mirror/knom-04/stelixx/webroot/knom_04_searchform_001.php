<?php

<?php
/**
 * Form wrapper. Returns html codwe for searchform
 *
 */
class CSearchFormKmom04 {
 
  /**
   * Members
   */
  private $html;                   // Options used when creating the PDO object
  private $db   = null;               // The PDO object
  private $stmt = null;               // The latest statement used to execute a query
  private static $numQueries = 0;     // Count all queries made
  private static $queries = array();  // Save all queries for debugging purpose
  private static $params = array();   // Save all parameters for debugging purpose
 	
   /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct() {
		$html = <<<EOD
		<form>
  		<label for="txtSearsh">Titel (delsträng, använd % som *) </label>
  		<input type="text" name="txtSearsh" id="txtSearsh" />
		</form>
EOD;

		return $htmlForm;
	}
}

----




