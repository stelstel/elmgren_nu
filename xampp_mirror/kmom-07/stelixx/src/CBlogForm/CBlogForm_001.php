<?php
class CBlogForm {
	public static function showAddForm($database){
			//if($blogOrPage == "blog"){
				$output = "<h1>Ny blogpost</H1>";
			//}else if($blogOrPage == "page"){
			//	$output = "<h1>Ny sida</H1>";
			//}
			
			$output .=<<<EOD
				<form>
				<fieldset>
EOD;
			//if($blogOrPage == "blog"){
				$output .= "<legend>Ny post</legend>";
				$output.= '<input type="hidden" name="txtType" value="blog">';
			//}else if($blogOrPage == "page"){
//				$output .= "<legend>Ny page</legend>";
//				$output.= '<input type="hidden" name="txtType" value="page">';	
//			}
			
			$output .=<<<EOD
					<p>
						<label for="txtTitle">Titel:<br />
						</label>
						<input name="txtTitle" type="text" id="txtTitle" size="50" /> 
					</p>
EOD;
					$cats = self::getCategories($database);
					
					$output .= '<label for="ddCat">Kategori: </label>'; // categories dropdown menu/list
					$output .= '<select name="ddCat" id="ddCat">';
					foreach($cats as $val) {
    				if(strlen($val) > 0){	
							$output .= '<option value="' . $val . '">' . ucfirst($val) . '</option>';
						}
					}
					$output .= "</select>"; 
										
					/*
						<option value="ny film">Ny film</option>
    				<option value="filmtips">Filmtips</option>
  					</select>
					*/
					
			$output .=<<<EOD
					<p>
						<label for="fieldText">Text:<br />
						</label>
						<textarea name="fieldText" id="fieldText" cols="50" rows="5"></textarea>
					</p>
					<p>
					<p>
						<label for="txtFilter">Filter(s):</label>
						<br />
			<input name="txtFilter" type="text" id="txtFilter" size="50"/>
					</p>
					<p>
						<label for="txtPublDate">Publiceringsdatum:</label>
						<br />
			<input name="txtPublDate" type="text" id="txtPublDate" size="50" />
					</p>
					<p>
						<input type="submit" name="btnSave" id="btnSave" value="Spara" />
						<input type="reset" name="btnReset" id="btnReset" value="Återställ" />
					</p>
					//<p> <a href="aaa">Visa</a> | <a href="../webroot/kmom_05.php">Visa alla</a></p>
				</fieldset>
			</form>
EOD;
		return $output;
	}
	
	//***************************************************************************************
	// Get categories from database
	private static function getCategories($db){
		$cats = array(null, null, null, null, null, null, null, null, null, null, null, null, null);
		dump($db);//////////////////////////////////////////////////////////////
		$DBTable = "stel14.content";
		$sql = "SELECT category FROM " . $DBTable . " WHERE length(category) GROUP BY category";
		$result = $db->ExecuteSelectQueryAndFetchAll($sql);
		
		$i = 0;
		foreach($result AS $key=>$val){
			$cats[$i] .= $val->category;
			$i++;		
		}
		dump($cats);////////////////////////////////////////////////////////////////////////
		return $cats;
	}
}