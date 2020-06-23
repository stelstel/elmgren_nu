<?php
/**
 * class for Trash
 *
 */
class CTrash{
 	/**
   * Members
   */
  	private $dataBase;
		private $dbTable;

  //************************************************************************ 	
	/**
  * Constructor
  */
  public function __construct($db, $table) {
		if(isset($db) AND is_object($db)){
			$this->dataBase = $db;
		}else{
			die("DB needed");	
		}
		
		if(isset($table) AND is_string($table)){
			$this->dbTable = $table;
		}else{
			die("DB table needed");	
		}
	}
	
	//*******************************************************************************************************************************
	// Trash marks as deleted in db. Delete deletes from DB for real
	public function trashDel($query){
		
		parse_str($query, $quVals);	// Extracts the variables from request
		if(isset($quVals["id"]) AND is_numeric($quVals["id"]) AND $quVals["id"] > 0){
			$id = $quVals["id"];
			
		}else{
			die("id needed");
		}
				
		if( isset($quVals["delete"]) AND strcmp($quVals["delete"], "true") == 0 ){
			$sql = "DELETE FROM " . strip_tags($this->dbTable) . " WHERE id=" . strip_tags($id) . " LIMIT 1"; //Limit 1 just for safety
			//$sql = "DELETE FROM " . $this->tableName . " WHERE id=999 LIMIT 1"; // Testing error
			$queryResult = $this->dataBase->ExecuteQuery($sql); 
			if($this->dataBase->RowCount() == 1){ // RowCount() return int number of affected rows of last statement
				return "<br><H2>Raderad</H2><a href='javascript:history.go(-1)'>Gå tillbaks</a>";
			}else{
				return "<br><H2>INTE raderad</H2><a href='javascript:history.go(-1)'>Gå tillbaks</a>" . mysql_error();
			}
		}else if( isset($quVals["trash"]) AND strcmp($quVals["trash"], "true") == 0 ){
			$sql = "UPDATE " . strip_tags($this->dbTable) . " SET deleted='" . date("Y-m-d H:i:s") . "' WHERE id=" . strip_tags($id);
			//$sql = "UPDATE " . $this->tableName . " SET deleted=NOW() WHERE id=999"; // Testing error
			$queryResult = $this->dataBase->ExecuteQuery($sql);
			
			if($this->dataBase->RowCount() == 1){ // RowCount() return int number of affected rows of latest statement
				return "<br><H2>Slängd</H2><a href='javascript:history.go(-1)'>Gå tillbaks</a>";
			}else{
				return "<br><H2>INTE slängd</H2><a href='javascript:history.go(-1)'>Gå tillbaks</a>" . mysql_error();
			}
		}else{
		 die("trash eller delete krävs i trash()");	
		}
		
	}
}