<?php
/**
 * Content
 *
 */
class CContent {

  /**
   * Member Variables
   */
  private $dBase;		// Database
	private $editPag;						
  
  /**
   * Constructor 
   *
   * @param  $db database
   *
   */
  public function __construct($db) {
  	$this->dBase = $db;
		$this->editPag = $editPag; 
  }
	
	public function showAll(){
		$output =<<<EOD
		<h1>Visa allt innehåll</h1>
		<p>Här är en lista på allt innehåll i databasen.</p>
EOD;
		$sql = "SELECT *, (published <= NOW()) AS available	FROM content";
		$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		$output .= "<ul>";
		
		foreach($result AS $key=>$val){
			$output .= '<li>' . $val->TYPE . ' (publicerad): '	. $val->title . '(<a href"edit.php?id=' . $key . '">editera</a>';
			$output .= ' visa)</li>';	
			//<a href="edit.php?id=1">editera</a>
		}
		
		$output .= "</ul>";
		$output .= "<p><a href='#'>Visa alla bloggposter</a></p>";

	
	return $output;
	}
}