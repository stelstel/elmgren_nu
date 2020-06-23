<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Redovisning";

$clas = "navbar";

echo CNavigation::GenerateMenu($menu, $clas);
$stelixx['header'] = <<<EOD
<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
<span class='sitetitle'>Stefans redovisning</span>
EOD;


$stelixx['main'] = <<<EOD
<h2>Kmom01: Kom igång med programmering i PHP</h2>
<p>Jag använder Windows 7 och XAMPP. </p>
<p>När jag började med Kmom01 så var det mycket på en gång. Jag hade redan XAMPP installerad då jag har jobbat lite med PHP förut. Objekt-PHP har jag dock inte pysslat med. Jag har nyligen pluggat Java och tidigare lite C++, så objekttänket finns där.</p>
<p>&nbsp;</p>
<p><strong>&ldquo;20 steg för att komma igång PHP&rdquo;</strong></p>
<p>Då jag tidigare har jobbat med klassisk ASP/VBScript och lite med PHP så var de första kapitlen 1-2, 4-5, 8. 10-13, 15, 16 mest repetition. Nyttigt att läsa igenom ändå. Kapitel 3 om felmeddelanden var bra att lära sig. I kapitel 6 och 7 så fick jag lära mig en hel del. INCLUDE har jag dock använt förut. I kapitel 9 så fick jag lära mig om Heredoc. Kapitel 14 handlade om alternativ syntax för kontrollstrukturer. Jag är inte förtjust i den alternativa if-satsen, men det kanske bara är en vanesak. Sessions och cookies har jag använt i VBScript och kapitel 17 visade för mig hur det går till i PHP. Headerfunktionen i kapitel 18 var ny information för mig.</p>
<p>&nbsp;</p>
<p>Jag döpte min webmall till Stelixx. Jag tog bort filen &quot;.htaccess&quot; p.g.a. att jag inte kunde se innehållet i mappen &quot;webroot&quot; i min browser annars. &quot;Source.php&quot; gjorde jag som modul.</p>
<p>Jag gjorde inte extrauppgiften med GitHub. Jag kanske gör den senare om tid finnes.</p>
<p>Jag hade problem med att fixa den dynamiska menyn, men efter att jag förstått att jag var tvungen att returnera något (variabeln html) från metoden GenerateMenu så blev det enklare.</p>
<p>Det var många filer i Anax/Stelixx. Lite rörigt än så länge</p>
<p>Jag vill gärna höra vad det blir för feedback på denna uppgift</p>
<hr>
<h2>Kmom02: Objektorienterad programmering i PHP</h2>
<p>Jag har tidigare läst Java samt lite C++ så jag känner till en del av objektorienterade koncept och programmeringssätt.<br />
  <br />
  Efter att ha läst kapitlen i boken och läst igenom och gjort de flesta övningar i oophp20-guiden så satte jag igång med uppgiften Månadens Babe.<br />
  Jag bestämde mig för att göra en stor kalender i mitten med en liten kalender på vardera sida om den stora. De små kalendrarna med föregående och följande månad. Den stora kalendern var en klass. De små kalendrarna (lilla kalendern) ärver av den stora.<br />
  <br />
  Då jag använde mig av date() funktionen så blev månadsnamnen engelska. Jag tänkte att jag kunde använda mig av funktionen setlocale() för att få svenska namn. Detta visade sig vara så gott som omöjligt, så jag gjorde en array med de svenska månadsnamnen.<br />
  <br />
Använde mig av CSS för att få tre horisontella områden. De högra och vänstra för de små kalendrarna. Det i mitten för den stora kalendern och länkarna till föregående och följande månad. Jag tycker att CCS är bökigt. Det är mycket skriva och titta vad som hände. Till slut blev jag dock hyggligt nöjd med min kalender.</p>

Jag gjorde setter och getter-funktioner för år och dag, och lade även in valideringsfunktionalitet i setter och getter-funktionerna
och gjorde en sida, <a href="testCCalendr.php">testCCalendr</a>, som testar klassen CCalendar. Setter och getter-funktionerna gjorde jag bara för att prova då jag inte använde dessa.
<hr>
<h2>Kmom03: SQL och databasen MySQL</h2>
<p>Jag har jobbat en del med mySQL och MS Access tidigare. </p>
<p>Jag jobbade igenom SQL-övningen i mySQL Workbench. Övningen  var en bra repetition för mig. Den var ganska lagom, </p>
<p>Tyvärr lyckades jag aldrig  koppla upp mig mot BTHs SQL server, så jag använde min egen server på localhost. Det senaste problemet var att jag tydligen har blockerat mig pga &quot;many correction errors&quot; Jag ska lösa detta genom att använa mig av&quot;mysqladmin flush-hosts&quot; så fort jag har förstått hur detta går till.</p>

EOD;

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
?>