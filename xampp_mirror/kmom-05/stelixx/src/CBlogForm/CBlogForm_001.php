<?php

class CBlogForm {
		
	//********************************************************************************************
	public static function showAddForm($blogOrPage){
		
		
			$output =<<<EOD
				<form>
				<fieldset>
EOD;
			if($blogOrPage == "blog"){
				$output .= "<legend>Ny post</legend>";
			}else if($blogOrPage == "page"){
				$output .= "<legend>Ny page</legend>";	
			}
			$output .=<<<EOD
					<p>
						<label for="txtTitle">Titel:<br />
						</label>
						<input name="txtTitle" type="text" id="txtTitle" size="50" />
					</p>
					<p>
						<label for="txtSlug">Slug:<br />
						</label>
						<input name="txtSlug" type="text" id="txtSlug" size="50" />
					</p>
					<p>
						<label for="txtURL">URL:<br />
						</label>
						<input name="txtURL" type="text" id="txtURL" size="50" maxlength="50" />
					</p>
					<p>
						<label for="tFieldText">Text:<br />
						</label>
						<textarea name="tFieldText" id="tFieldText" cols="50" rows="5"></textarea>
					</p>
					<p>
						<label for="txtType">Type:</label>
						<br />
			<input name="txtType" type="text" id="txtType" size="50" />
					</p>
					<p>
						<label for="txtFilter">Filter(s):</label>
						<br />
			<input name="txtFilter" type="text" id="txtFilter" size="50" value="Test" />
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
					<p> <a href="aaa">Visa</a> | <a href="bbb">Visa alla</a></p>
				</fieldset>
			</form>
EOD;
		return $output;
	}

}