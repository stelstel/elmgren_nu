<?php
/**
 * Form wrapper. Returns html code for searchform
 *
 */
class CSearchFormKmom04 {
 
  /**
   * Members
   */
  private $html; // The html code
	
   	
	/**
  * Constructor creating form
  */
  public function __construct() {
		$this->html .= <<<EOD
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
  		</fieldset>
		</form>
EOD;
	}
	
	public function getHtml() {
		return $this->html;
	}
}






