<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Redovisning";

$stelixx['header'] .= "<span class='sitetitle'>Redovisning</span>";

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
  <p>Jag har jobbat en del med mySQL och MS Access tidigare.</p>
  <p>Jag jobbade igenom SQL-övningen i mySQL Workbench. Övningen var en bra repetition för mig. Den var ganska lagom,</p>
  <p>Tyvärr   lyckades jag aldrig koppla upp mig mot BTHs SQL server, så jag använde   min egen server på localhost. Det senaste problemet var att jag tydligen   har blockerat mig pga &quot;many correction errors&quot; Jag ska lösa detta genom   att använa mig av&quot;mysqladmin flush-hosts&quot; så fort jag har förstått hur   detta går till.</p>
  <p>Edit 2014-10-16. Nu har jag lyckats koppla upp mig mot BTHs SQL-server.</p>
  <p><strong>Är du bekant med databaser sedan tidigare? Vilka?</strong></p>
  <p>Jag   har jobbat en del med MS Access och klassisk ASP tidigare för att göra   webbsidor med formulär och dylikt. Bl.a. för förskolorna där jag jobbar.   Ett tidrapporteringssystem där fröknarna kan registrera sin barnlösa   tid. En maillista för föräldrarnas epostadresser och en webbsida där   föräldrarna registrerar när barnen ska vara närvarande och frånvarande   över sommaren och julen.</p>
  <p> Jag har senare förstått att det   är PHP och mySQL som gäller. Detta har jag hållt på med sedan ett   halvår. Jag gick bl.a. en kurs om detta.</p>
  <p> <strong>Hur känns det att jobba med MySQL och dess olika klienter, utvecklingsmiljö och BTH driftsmiljö?</strong></p>
  <p>Jag har så gott som endast använt mySQL Workbench men det var bra att titta på andra klienter som man kan använda vid behov.</p>
  <p><strong>Hur gick SQL-övningen, något som var lite svårare i övningen, kändes den lagom?</strong></p>
  <p>Jag   jobbade igenom SQL-övningen i mySQL Workbench. Övningen var en bra   repetition för mig. Den tog lite tid att gå igenom. Det som var lite   svårare var joins. Speciellt när fler än två tabeller ska joinas.</p>
<hr>
<h2>Kmom04: PHP PDO och MySQL
</h2>
<p>Denna övning skapade stora problem för mig. Jag försökte göra övningen på mitt eget sätt. Det blev kod med alldeles för många rader. Jag bröt sedan uppp koden i ett antal funktioner och fick på det sättet ner antal rader en del. Dessutom så löste det ett antal problem och gjorde koden mer lättläst.</p>
<p>Sedan när jag hade slagit ihop inloggningssidan med filmsidan så uppstod nya problem. Inget visades förutom loginen, förutom direkt efter inloggning. Det visade sig att session user &quot;försvann&quot; så fort man gjorde en sökning eller klickade på &quot;alla filmer&quot;. Jag letade efter var den försvann/förstördes.</p>
<p>Jag lade in några session_status() för att se vad som hände. </p>
<p>Efter ett tag så kom jag fram till att detta problem bara uppstod på BTHs server, på localhost fungerade det. Jag skrev ett inlägg i forumet.</p>
<p>Efter mycket letande och googlande så kom jag fram till att det som saknades var ett &quot;session_start()&quot; i början på sidan &quot;kmom_04.php&quot;</p>
<p><strong>Hur kändes det att jobba med PHP PDO?</strong></p>
<p>Det kändes ungefär som att jobba direkt mot mySql.</p>
<p><strong>Gjorde du guiden med filmdatabasen, hur gick det?</strong></p>
<p>Jag gjorde guiden med databasen. Det tog en stund och var lärorikt. När jag väl gjorde inlämningsuppgiften så valde jag dock att försöka med mina egna lösningar. Vilket gjorde att det blev mycket svårare.</p>
<p><strong>Du har nu byggt ut ditt Anax med ett par moduler i form av klasser,   hur tycker du det konceptet fungerar så här långt, fördelar, nackdelar?</strong></p>
<p>Jo det är väl meningen att man ska ha kod i moduler. Fördelarna är att man delar upp koden i eventuellt återanvändbara delar. Nackdelen är att man kanske ibland får lite dålig översikt över koden.</p>

EOD;

// Add style
$stelixx['stylesheets'][] = 'css/nav.css';


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
?>