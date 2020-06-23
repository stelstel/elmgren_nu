<?php

$ts = new tableStructure();
$cols = $ts->getColumns();

// Table header
echo '<table width="100%" border="1">';
echo "<tr>";

for($i = 0; $i < sizeof($cols) ; $i++)
{
	echo "<th>";
	echo ucfirst($cols[$i]);
	echo "</th>";
}

echo "</tr>";

// The rest of the table
$td = new tableData();
$rows = $td->getRader();

for($i = 0; $i < sizeof($rows); $i++)
{
	echo "<tr>";
	
	for($j = 0; $j < sizeof($cols); $j++)
	{
		echo "<td>";
		
		if(isset($rows[$i][$j]) )
		{
			echo $rows[$i][$j];
		}
		
		echo "</td>";
	}
	
	echo "</tr>";
}

echo "</table>";

//***************************** Classes **************************************************************** 
class tableStructure
{    
  	private $columns = array("namn", "adress","postnr", "email", "mobilnr", "telefonnr");
	// private $columns = array("namn", "adress","postnr", "email", "mobilnr", "telefonnr", "test", "test2");

	public function getColumns()
	{
		return $this->columns;
	}
}

class tableData
{
	private $row1, $row2, $row3, $row4;
	private $rader;
	
	public function __construct()
	{
		$this->row1 = array("Kalle1","address1", "postnr1", "1@email.se", "070111001", "08111001");
		$this->row2 = array("Kalle2","address2", "postnr2", "2@email.se", "070111002", "08111002");
		$this->row3 = array("Kalle3","address3", "postnr3", "3@email.se", "070111003", "08111003");
		$this->row4 = array("Kalle4","address4", "postnr4", "4@email.se", "070111004", "08111004");

		$this->rader = array($this->row1,$this->row2,$this->row3,$this->row4);
	}
	
	public function getRader()
	{
		return $this->rader;
	}
}

?>