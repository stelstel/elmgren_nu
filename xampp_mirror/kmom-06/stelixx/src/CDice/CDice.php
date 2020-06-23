<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CDice {
 
  /**
   * Properties
   *
   */
  public $rolls = array();
  private $faces = 0;
 
 
  /**
   * Roll the dice
   *
   */
  public function Roll($times) {
    $this->rolls = array();
 
    for($i = 0; $i < $times; $i++) {
      $this->rolls[] = rand(1, $this->faces);
    }
  }
  
  /**
   * Get the total from the last roll(s).
   *
   */
  public function GetTotal() {
    return array_sum($this->rolls);
  }
  
  public function GetAverage() {
    //return array_sum($this->rolls)/array_count_values($this->rolls);
	return array_sum($this->rolls)/count($this->rolls);
  }
  
  	public function __construct($faces=6) {
  		$this->faces = $faces;
	}
 
}
