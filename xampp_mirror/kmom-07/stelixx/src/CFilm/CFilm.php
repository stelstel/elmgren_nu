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
		$imgLimitHeight 	= 520;
		
		$sql = "SELECT * FROM movie WHERE id=" . $filmId;
		$result = (array)$database->ExecuteSelectQueryAndFetchAll($sql);
		
		$filmTitle = $result[0]->title;
		$bigImage = $result[0]->bigimg;
		$plot = $result[0]->plot;
		$imdb = $result[0]->imdb;
		$trailer = $result[0]->trailer;
		$categories = $this->getCategories($database, $filmId);
		
		$imgURL = "img.php?src=" . $imgPath . $bigImage . "&width=" . $imgLimitWidth . "&height=" . $imgLimitHeight . "&sharpen";
		
		if(isset($filmTitle)){	
			$this->output = "<H1>" . $filmTitle . "</H1>";
		}
		
		if(isset($imgURL)){	
			$this->output .= '<p class="centeredImage"><img src="' . $imgURL . '"/></p>';
		}
		
		if(isset($categories)){	
			$this->output .= "<H3>Kategori(er): " . $categories . "</H3>";
		}
		
		if(isset($plot)){	
			$this->output .= '<p>Handling: ' . $plot . '</p><br>';
		}
		
		if(isset($imdb)){	
			$this->output .= '<a href="' . $imdb . '">Sida på IMDB</a><p></p>';
		}
		
		if(isset($trailer)){	
			$this->output .= '<a href="' . $trailer . '">Trailer</a><p></p>';
		}
		
		$this->output .= "<p> <<< <A HREF=javascript:history.go(-1)>Tillbaka</A></p>";
	}
	
	//************************************************************************************
	private function getCategories($db, $id){
		$sql = "SELECT name FROM genre INNER JOIN movie2genre ON movie2genre.idGenre = genre.id WHERE movie2genre.idMovie =" . $id;
		$result = $db->ExecuteSelectQueryAndFetchAll($sql);
				
		$nrOfCats = count($result);
		
		$i = 0;
		$output = "";
		
		foreach($result AS $key=>$value){
				$output .= ucfirst($value->name);
				if($i < $nrOfCats - 1 ){
					$output .= ", ";	
				}
				$i++;
		}
		return $output;
	}
		
	//******************************************************************************
	public function getContent() {
		return $this->output;
	}
}