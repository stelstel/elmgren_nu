<?php

$imgWidth = 960;

$url = "img.php?src=ministry_of_silly_cropped.png&width=" . $imgWidth . "&sharpen";
$url2 = "img.php?src=robocop.jpg&width=" . $imgWidth . "&sharpen";
$urlStefan = "img.php?src=stel_small.png";
$urlCaro = "img.php?src=caro_small.png";

$content = '<p class="centeredImage"><img src="' . $url . '"/></p>';

$content .= <<<EOD
	<p>Moviez är en sida som har haft sina portar öppna sedan 1999. 
	Vi koncentrerar oss på att ha kvalitetsfilmer för alla intressen.</p><br>
EOD;

$content .= '<p class="centeredImage"><img src="' . $url2 . '"/></p>';

$content .= <<<EOD
	<p>Ända sedan starten så har vi försökt att vara en mer personlig videoaffär. Våra olika medarbetare kan rekommendera olika typers film. Kanske du har samma smak som en av våra medarbetare? </p><br>
EOD;

$content .= '<p><img src="' . $urlStefan . '" style="float:left;margin:0 5px 5px 0;"/></p>';

$content .= <<<EOD
	<H3>Stefan Elmgren</H3>
	<p>Har varit med länge. Han pratar fortfarande om när färgfilmen kom. Han tycker om action och skräckfilmer.</p>
	<H4>Favoritfilmer:</H4><p>Robocop (1987), Evil Dead 2, Rovdjuret</p>
	<p><a href="mailto:stefan@moviez.se">stefan@moviez.se</a></p>
	<p style="clear: both;"></p>
EOD;

$content .= '<img src="' . $urlCaro . '" style="float:left;margin:0 5px 5px 0;"/>';

$content .= <<<EOD
	<H3>Carolina Urrea</H3>
	<p>Har inte sett så mycket än. Bondfilmer och romantiska komedier är hennes tekopp.</p>
	<H4>Favoritfilmer:</H4><p>Notting Hill, Love Actually, For Your Eyes Only</p>
	<p><a href="mailto:carolina@moviez.se">carolina@moviez.se</a></p>
	<p style="clear: both;"></p>
EOD;

$content .= <<<EOD
	<br><p>Moviez<br />
  Gatan 1<br />
	123 45 Stockholm</p>
	<p><a href="mailto:info@moviez.se">info@moviez.se</a></p>
EOD;
