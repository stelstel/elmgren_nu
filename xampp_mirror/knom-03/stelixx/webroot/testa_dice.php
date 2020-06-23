<meta charset="utf-8"> 
<?php

include('config.php');

echo '<a href="testa_dice.php?roll=6?&fac=6">6 slag, 6 sidor</a><br>';
echo '<a href="testa_dice.php?roll=25&fac=12">25 slag, 12 sidor</a>';
echo '<a href="testa_dice.php?roll=100&fac=25">100 slag, 25 sidor</a>';

//$fa = "";

// Roll the dice
if(isset($_GET['fac'])){
	$fa = $_GET['fac']; 
}

// Create an instance of the class  
$dice = new CDice($fa);

// Roll the dice
if(isset($_GET['roll'])){
	$times = $_GET['roll']; 
}else{
	$times = 0;
}

$dice->Roll($times);  
$rolls = $dice->rolls;

foreach ($rolls as $roll){
	echo "<p>";
	echo $roll;
	echo "</p>";
}

echo "<p>Summa av kasten: ".$dice->GetTotal()."</p><br>";
printf ("<p>Medelvärde av kasten: %.2f",$dice->GetAverage() );

$histo = CHistogram::GetHistogram($rolls);
echo "<br>";

for($i=0; $i < count($histo); $i++){
	for($j=0; $j < $histo[$i]; $j++ ){
		echo "*";	
	}
	$throw = $i + 1;
	echo "(" . $throw . ")" . "<br>";
}
