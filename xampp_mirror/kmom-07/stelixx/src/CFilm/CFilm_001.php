<?php
/**
 * class for en film
 *
 */
class CFilm{
 	/**
   * Members
   */
  
	private $output;
				
  //************************************************************************ 	
	/**
  * Constructor
  */
  public function __construct($database, $request) {
		$id = 0;
		if(isset($request)){
			if($this->processReq($request) > 0){
				$id = $this->processReq($request);
				$this->createContent($database, $id);
			}else{
				$output = "Error. id is illegal.";
			}
		}
	}
	
	/**
  * Functions
  */
	
	//******************************************************************************
	// Process input
	private function processReq($req) {
		$maxAntalFilmer = 99999;
		parse_str($req, $reqVars);						// Extracts the variables from request
		
		if(isset($reqVars["id"]) AND $reqVars["id"] > 0 AND $reqVars["id"] <= $maxAntalFilmer AND count($reqVars) == 1 AND is_numeric($reqVars["id"])){
			return $reqVars["id"];
		}
		else{
			return 0;	
		}
	}
	
	//******************************************************************************
	// Create page
	private function createContent($database, $filmId) {
		$imgPath = "filmer/";
		$imgLimitWidth = 970;
		$imgLimitHeight 	= 475;
		
		$sql = "SELECT * FROM movie WHERE id=" . $filmId;
		$result = (array)$database->ExecuteSelectQueryAndFetchAll($sql);
		
		$filmTitle = $result[0]->title;
		$bigImage = $result[0]->bigimg;
		$plot = $result[0]->plot;
		$imdb = $result[0]->imdb;
		$trailer = $result[0]->trailer;
		
		$imgURL = "img.php?src=" . $imgPath . $bigImage . "&width=" . $imgLimitWidth . "&height=" . $imgLimitHeight . "&sharpen";
		
		if(isset($filmTitle)){	
			$this->output = "<H1>" . $filmTitle . "</H1>";
		}
		
		if(isset($imgURL)){	
			$this->output .= '<p class="centeredImage"><img src="' . $imgURL . '"/></p>';
		}
		
		if(isset($plot)){	
			$this->output .= '<p>Handling: ' . $plot . '</p>';
		}
		
		if(isset($imdb)){	
			$this->output .= '<a href="' . $imdb . '">Sida på IMDB</a><br>';
		}
		
		if(isset($trailer)){	
			$this->output .= '<a href="' . $trailer . '">Trailer</a>';
		}
	}
	
	
	
	//******************************************************************************
	public function getContent() {
		return $this->output;
	}
}