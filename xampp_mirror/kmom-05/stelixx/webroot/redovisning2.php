<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Anax container.
$stelixx['title'] = "Redovisning";

//$clas = "navbar";
//
//echo CNavigation::GenerateMenu($menu, $clas);
//$stelixx['header'] = <<<EOD
//<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>
//<span class='sitetitle'>Stefans redovisning</span>
$stelixx['header'] .= "<span class='sitetitle'>Redovisning</span>";
//EOD;


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
<h2>KMOM 03: SQL och databasen MySQL</h2>
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
<h2>KMOM 04: PHP PDO och MySQL
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

<hr>
<h2>KMOM 05</h2>
<p>Denna uppgift tog väldigt lång tid. Dock så var den bättre än den förra uppgiften för mig då det denna gång uppstod ett antal stora och små problem som jag efter kort eller lång tid kunde lösa. KMOM4 däremot blev bara till en kodgröt som tog lång tid för mig att strukturera upp.</p>
<p>I denna uppgift valde jag att "prova mina vingar" lite mindre än i KMOM4. Det blev ändå vissa utsvävningar i egna lösningar.</p> 
<p>Jag började med att läsa &quot;Lagra innehåll i databas för webbsidor och bloggposter&quot;</p>
<p>Sedan så började jag med övningen &ldquo;Skapa en klass för innehåll i databasen, CContent&rdquo;. Därefter följde page.php. Jag fick problem med layouten vilket jag frågade om i forumet, <a href="http://dbwebb.se/forum/viewtopic.php?f=37&t=3155&p=25908&sid=d464e7991f23940a7503da4d3c92e989">Layoutproblem</a>.</p>
<p>Sedan fick jag problem med markdown. Det hade även någon annan fått problem med, så jag hittade lösningen på forumet. </p>
<p>Jag började sedan med blog.php. Efter att ha gjort en funktion för page i CContent, showPage(), och en funktion för blog, showBlog(), så såg jag att de var snarlika. Jag satte ihop dessa till en funktion, show(). Sedan så gjorde jag en ny lite mindre funktion, showBlog(), som visar en eller alla bloggar.</p>
<p>Sedan gjorde jag en funktion i CContent.php som skapar tabellen content i databasen, createContentTable(tabl). Jag gjorde även en funktion som populerar tabellen, populateContentTable(tabl).</p>
<p>Efter att ha pillat ett tag i kmom_05 och att par css-filer så lyckades jag äntligen att få min navbar att hamna där den ska vara, inte över hela browsern längst upp, åtminstone i kmom_05.php</p>
<p>Sedan gjorde jag sidorna för att lägga till blogpost och sida. Fick problem med att ÅÄÖ inte lagrades som de skulle i databasen. Efter några timmar så kom jag på att detta orsakades av htmlentities(), så jag tog bort dessa på ett par ställen.</p>
<p>Gjorde en ny funktion, isFilterValid(filt), för att kolla om angivna filter är giltiga.</p>
<p>Sedan försökte jag få så att man kan skriva in publiceringsdatum vid sid/blogskapande, det sparades i databasen som 000-00-00... Det visade sig att den inbyggda funktionen strToTime inte fungerade som jag trott.</p>
<p>Efter att ha gjort sidan update.php som ska ta emot en slug som argument så upptäckte jag att alla länkarna från &quot;editera&quot; på kmom_05.php-sidan ju är länkar till edit.php med ett id som argument :( Jag hoppas att jag kan fixa till detta lite snabbt.</p>
<p>Fick ett problem med att &amp; blev &amp;amp; men fixade det ganska snabbt. Ett problem med att få dit null i filtret kom jag också på ganska snabbt. Det berodde på dubbelfnutt/enkelfnutt.</p>
<p>Jag förstod inte riktigt hur man skulle kunna se de poster/sidor som var &quot;raderade&quot; eller inte var publicerade, så jag gjorde så att man kan se icke publicerade och &quot;deletade&quot; poster/sidor under &quot;Visa alla&quot;/hemsidan.</p>
<p>Dumt nog så hade jag inte läst igenom uppgifterna helt och hållet. CPage och CBlog fick jag göra på slutet med hjälp av klipp och klistra. Koden för detta fanns innan i CContent.</p>
<p>När jag sedan skulle göra login/logout-funktionaliteten så snodde jag denna från KMOM04, det gick förvånansvärt enkelt. När jag höll på med detta så såg jag att &quot;Title&quot; på sidan blog.php bestod av hela bloggen/bloggarna. Inte bra. Detta måste ha hänt när jag lade den funktionaliteten i CBlog.php. Detta fixades snabbt till så att titeln bara blev titeln.</p>
<p>Nu kändes det som om allt var på plats. Jag provade lite fram och tillbaka. Hittade ett error  när man skulle spara editerad sida. Det visade sig att jag hade glömt enkelfnuttarna runt filtret i sqlfrågan.</p>
<p><strong>Det blir en del moduler till ditt Anax nu, hur känns det?</strong></p>
<p>Det blir en del att hålla reda på, men det är ju trevligt att man kan återanvända modulerna som jag gjorde med CLogin.</p>
<p><strong>Berätta hur du tänkte när du löste uppgifterna, hur tänkte du när du strukturerade klasserna och sidkontrollerna?</strong></p>
<p>Se lång text ovan. Jag hade ju kunna tänkt lite mer innan jag började koda. Nästa gång kommer jag garanterat att göra så. Man lär sig eftersom, den hårda vägen.</p>
<p><strong>Börjar du få en känsla för hur du kan strukturera din kod i klasser och moduler, eller kanske inte?</strong></p>
<p>Jag tycker att jag förstår mer och mer fördelarna med att ha koden i klasser och moduler. Det tar dock ett tag att lära om sig då man som jag tidigare har haft allt i en och samma sida (Klassisk ASP)</p>
<p><strong>Snart har du grunderna klara i ditt Anax, grunderna som kan skapa många   webbplatser, är det något du saknar så här långt, kanske några moduler   som du känner som viktiga i ditt Anax?</strong></p>
<p>Jag kan inte komma på några moduler som saknas. Det får man väl fixa eftersom? Däremot kan det nog behövas att snygga till ett antal av modulerna som jag har gjort så att de blir mer &quot;självgående&quot;.</p>
<p>För att logga in: <br>Användarnamn: bajenbrud <br>Lösenord: 4ee320eca8923f72aa82731cd248784a82260a17783a36a790660eb6</p>

EOD;

// Add style
//$stelixx['stylesheets'][] = 'css/nav.css';

//$stelixx['footer'] = <<<EOD
//<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
//EOD;


// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
?>