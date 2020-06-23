<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Foto;
use \File;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;

require '../vendor/autoload.php';

// msgToUser[0] = flag either "" or string
// msgToUser[1] = Bootstrap modal title
// msgToUser[1] = Bootstrap modal body text

class HomeController extends Controller
{
    private $imagePath;
    private $yearsArr;
    private $filePath;
    private $birthdaysFileContent; 

    public function __construct()
    {
        $this->middleware('auth');
        $this->imagePath = "/public/images/";
        $this->filePath = 'app/birthdays.txt';
        $this->birthdaysFileContent = File::get( storage_path($this->filePath) );
    }

    //****************** init *********************************************
    public function init(){
        $birthdayMsg = "";
        $sentMailOutcome = $sentMailHead = $sentMailBody = "";
        $yearOrSearchSlides = "";
        $imagePath = $this->imagePath;
        $galleryName = "album-1";
        $latestPhotos = array();
        
        // Number of latest thumbnails. Must also be changed in "home.blade" ( {!! $latestPhotos[4] !!} )
        $nrOfLatest = 5;
        
        $foto = new Foto();
        $foton = $foto->showLatestPhotos();

        $birthdayMsg = $this->birthdayReminder();

        $this->yearsArr = $this->populateYearArrays();
        $years = $this->yearsArr[0];

        if ( isset( $_GET['year'] ) ) {
            if ($this->validateYearDecade($_GET['year']) ){
                $yearDecade = $this->validateYearDecade($_GET['year']);
                $yearOrSearchSlides = $this->photosYear($yearDecade);
            }else{
                echo "Error: year \"" . $_GET['year'] . "\" is invalid";
                error_log("init(). Year \"" . $_GET['year'] . "\" is invalid", 0);
            }
        }else if (isset( $_GET['search'] ) ) {
            
            $photoSearchResult = $this->photosSearch( $_GET['search'] );

            if ( $photoSearchResult ) { // Photos found in search
                $yearOrSearchSlides = $photoSearchResult;
            }else{ // No photos found in search
                Session::put('msgToUser[0]', 'No files found');
                Session::put('msgToUser[1]', 'Inga foton funna');
                Session::put('msgToUser[2]', 'Inga foton funna med sökfrasen "' . $_GET['search'] . '"');
            }
        }

         $birthdays = $this->birthdaysFromFile();

         $updateLog = $this->updateLog();

        // Creates latest photos thumbnails with links
        for ($i=0; $i < $nrOfLatest; $i++) { 
            $latestPhotos[$i] = '<a rel="album-1" href="#" class="open-album" data-open-id="' . $galleryName . '" data-index="' . $i . '"> ';
            $latestPhotos[$i] .= '<img class="img-fluid x-auto d-block img-thumbnail border border-dark rounded"'; 
            $latestPhotos[$i] .= 'src="' . $imagePath . $foton[$i]["year"] . '/thumbs/' . mb_strtolower( $foton[$i]["filename"]) . ' "';
            $latestPhotos[$i] .= 'alt="' . $foton[$i]["header_text"] . '"></a>' . PHP_EOL;
        }

        $slides = '<div id="' . $galleryName . '">';
        $slides .= implode ( $this->createLatestslides($foton, $galleryName) );
        $slides .= '</div>';

        $dropdownItems = $this->yearDropdownItems();

        $albumSlides = "";

        return view('home')->with([
            'latestPhotos' => $latestPhotos,
            'slides' => $slides,
            'dropdownItems' => $dropdownItems,
            'yearOrSearchSlides' => $yearOrSearchSlides,
            'birthdays' => $birthdays,
            'updateLog' => $updateLog,
            'sentMailOutcome' => $sentMailOutcome,
            'sentMailHead' => $sentMailHead,
            'sentMailBody' => $sentMailBody,
            'birthdayMsg' => $birthdayMsg
        ]);
    }

    //****************** sendMail *********************************************
    public function sendMail(Request $request){
    
        $mail = new PHPMailer(true);      // Passing `true` enables exceptions
        $msgToUser = collect("", "", "");
        Session::push('msgToUser', $msgToUser);

        try {
            //Server settings
            // SMTP::DEBUG_OFF (0): Disable debugging (you can also leave this out completely, 0 is the default).
            // SMTP::DEBUG_CLIENT (1): Output messages sent by the client.
            // SMTP::DEBUG_SERVER (2): as 1, plus responses received from the server (this is the most useful setting).
            // SMTP::DEBUG_CONNECTION (3): as 2, plus more information about the initial connection - this level can help diagnose STARTTLS failures.
            // SMTP::DEBUG_LOWLEVEL (4): as 3, plus even lower-level information, very verbose, don't use for debugging SMTP, only low-level problems.

            $mail->SMTPDebug = 0;                                 // Debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.unoeuro.com';                     // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'stefan@elmgren.nu';                // SMTP username
            $mail->Password = 'prtE78u63-';                       // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Some cleaning of input text
            $msgFromForm = htmlspecialchars($_POST['msg']);
            $msgFromForm = htmlentities($msgFromForm);

            //Recipients
            $mail->setFrom($_POST['email'], 'Mailer@elmgren.nu');
            $mail->addAddress('stefan@elmgren.nu', 'Stefan Elmgren');   // Add a recipient
            
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Mail from site elmgren.nu, ' . $_POST['email'];
            $mail->Body    = '<b>Emailadress: </b>' . $_POST['email'] . '<br>' . '<b>Meddelande: </b>' . $msgFromForm;
            $mail->AltBody = 'Emailadress: ' . $_POST['email'] . '---' . 'Meddelande: ' . $msgFromForm; // Non HTML

            $mail->send();
            
            Session::put('msgToUser[0]', 'mailSentSucess');
            Session::put('msgToUser[1]', 'Epostmeddelande skickat');
            Session::put('msgToUser[2]', 'Tack för ditt meddelande!<br> Vi återkommer till dig så snart som möjligt.<br><hr id="hr-mail"><br><small>Din epostadress: ' . $_POST['email'] . '<br>Ditt meddelande: ' . $msgFromForm . '</small>');
        }catch (Exception $e) {
            //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            Session::put('msgToUser[0]', 'mailSentFailure');
            Session::put('msgToUser[1]', 'Epostmeddelande INTE skickat.');
            Session::put('msgToUser[2]', 'Något gick fel<br> Mailer error: ' .  $mail->ErrorInfo );
        }

        return redirect()->route('home');
    }

    //****************** updateLog *********************************************
    private function updateLog(){
        $filePath = 'app/uppdateringslogg.txt';
        $fileContent = File::get(storage_path($filePath));

        $fileContent = str_replace('<br>', '', $fileContent); //Get rid of "<br>"
        $fileContent = str_replace('</br>', '', $fileContent);
        $fileContent = str_replace('</a>', '', $fileContent);
        $fileContent = str_replace('<b>', '<p class="update-log-date">', $fileContent);
        $fileContent = str_replace('</b>', '</p><p class="update-log-text">', $fileContent);

        // Get rid of that space
        $fileContent = str_replace('<p class="update-log-text"> ', '<p class="update-log-text">', $fileContent);

        $lines = explode("\n", $fileContent); //Split string into array
        $output = "";

        for($i = 0; $i < count($lines); $i++) {
            $output .= $lines[$i] . '</p>' . PHP_EOL;     
        }

         return $output;
    }

    //****************** photosYear *********************************************
    private function photosYear($year){
        $foto = new Foto();
        //$year = $this->validateYearDecade($year);
        $foton= $foto->getPhotosFromYear($year);
        $yearOrSearchSlides = $foto->popSlideshow( $foton );

        return $yearOrSearchSlides;
    }

    //****************** photosSearch *********************************************
    private function photosSearch($searchTerms){
        $foto = new Foto();
        
        $searchTerms = htmlspecialchars($searchTerms);
        $searchTerms = htmlentities($searchTerms);
        $foton= $foto->getPhotosFromSearch($searchTerms);
        $yearOrSearchSlides = $foto->popSlideshow( $foton );

        return $yearOrSearchSlides;
    }

    //****************** birtdaysFromFile *********************************************
    private function birthdaysFromFile(){
        $txt = '';
        $monthsArr = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];
        $monthShown = [0,0,0,0,0,0,0,0,0,0,0,0]; // Array of flags to see if month already has been printed to screen

        $lines = explode("\n", $this->birthdaysFileContent); //Split string into array

        for($i = 0; $i < count($lines); $i++) {
            $month = substr( $lines[$i] ,0 ,2 );  //Extract month number
            $date = substr( $lines[$i] ,3 ,2 );   //Extract date number
            $name = substr( $lines[$i] ,6 );      //Extract person name
            
            if( ($month-1)!==null AND $monthShown[$month-1] == 0 ){
                $txt .= '<div class="row">';
                $txt .= '<p class="month-name">' . $monthsArr[$month-1] . '</p>';
                $txt .= '</div>';

                $monthShown[$month-1] = 1; //Set flag
            }
            $txt .= '<div class="row">';
            $txt .= '<p class="birthdays-date-name">' . $date . ', ' . $name . '</p>';

            $txt .= '</div>';
        } 

        return $txt;
    }

    //****************** birthdayReminder *********************************************
    private function birthdayReminder(){
        $msg = "";
        $datesFromFile = array();

        $today                  = date("Y-m-d");
        $tomorrow               = date('Y-m-d', strtotime($today. ' + 1 days'));
        $theDayAfterTomorrow    = date('Y-m-d', strtotime($today. ' + 2 days'));
        $today                  = date('m-d', strtotime($today) ); // Lose the year
        $tomorrow               = date('m-d', strtotime($tomorrow) ); // Lose the year
        $theDayAfterTomorrow    = date('m-d', strtotime($theDayAfterTomorrow) ); // Lose the year
        $lines = explode("\n", $this->birthdaysFileContent); //Split string into array

        for($i = 0; $i < count($lines); $i++) {
            $month  = substr( $lines[$i] ,0 ,2 );  //Extract month number
            $date   = substr( $lines[$i] ,3 ,2 );   //Extract date number
            $datesFromFile[$i] = date( 'm-d', mktime( 0, 0, 0, $month, $date, 0 ) );

            if ($datesFromFile[$i] == $today OR $datesFromFile[$i] == $tomorrow OR $datesFromFile[$i] == $theDayAfterTomorrow) {
                $when = "";
                $name = substr( $lines[$i] ,6 ); // Extract person name
                
                if ($datesFromFile[$i] == $today) {
                    $when = "idag";
                }elseif ($datesFromFile[$i] == $tomorrow) {
                    $when = "morgon";
                }elseif ($datesFromFile[$i] == $theDayAfterTomorrow) {
                    $when = "övermorgon";
                }

                $msg = $name . " fyller år i " . $when . "!";
            }
        }
        return $msg; 
    }

    //****************** dropdownItems *********************************************
    private function yearDropdownItems(){
        $items = "";
        //$yearsArr = $this->populateYearArrays();
        $years = $this->yearsArr[0];
        $readableYears = $this->yearsArr[1];

        for ($i=0; $i < sizeof($years) ; $i++) {
            $items .= '<a class="dropdown-item open-album" href="' . url()->current() . '?year=' . $years[$i] . '">' . $readableYears[$i] . '</a>';
        }

        return $items;
    }

    //****************** populateYearArrays *********************************************
    private function populateYearArrays(){
        $yearsDecadesTmp = Array();
        $yearsDecades = Array();
        $yearsDecadesSorted = Array();
        $yearsDecadesSortedReadable  = array();
        $firstDecadeYear = "innan_1960";
        $firstReadableDecadeYear = "innan 1960";

        $yearsDecadesTmp = Foto::distinct()->get(['year']);

        for ($i=0; $i < count($yearsDecadesTmp); $i++) { 
            $yearsDecades[$i] = $yearsDecadesTmp[$i]->year;
            $yearsDecadesSorted[$i] = "";
        }

        sort($yearsDecades);

        // "Innan_1960" is the last value in the array. move it to the first. Move all other values up 1 index
        $yearsDecadesSorted[0] = $firstDecadeYear;

        for ($i=0; $i < count($yearsDecades) - 1; $i++) {
            $yearsDecadesSorted[$i+1] = $yearsDecades[$i];
        }

        // Make readable years
        foreach ($yearsDecadesSorted as $yer){
            array_push($yearsDecadesSortedReadable, $yer );
        }

        // "Innan 1960" to index[0]
        $yearsDecadesSortedReadable[0] = $firstReadableDecadeYear;

        $yearsDecadesSortedReadable = array_reverse( $yearsDecadesSortedReadable);
        $yearsDecadesSorted = array_reverse( $yearsDecadesSorted);
        $yearsDecadesArr = array($yearsDecadesSorted, $yearsDecadesSortedReadable);

        return $yearsDecadesArr;
    }       

    //****************** createLatestSlides *********************************************
    // Creates a big "blob" of slides for latest photos
    // Returns array with slides
    public function createLatestSlides($foton, $galleryName){
        $slides = array();
        $imgPath = $this->imagePath;
        
        for ($i=0; $i < count($foton); $i++) { 
            $slides[$i]  = '<a rel="' . $galleryName . '" class="image-show" data-fancybox="' . $galleryName . '" data-caption="';
            $slides[$i] .= '<strong>' . $foton[$i]->header_text . '</strong><br>';
            $slides[$i] .= $foton[$i]->bread_text . '<br>';
            
            if ($foton[$i]->photo_date != "0000-00-00") {
                $slides[$i] .= $foton[$i]->photo_date;  
            }

            // Date isn't confirmed
            if($foton[$i]['guessed_date'] == 1){
                $slides[$i] .= '  ?';
            }

            $slides[$i] .= '" href="' . $imgPath . '/' . $foton[$i]->year . '/' . $foton[$i]->filename . '" hidden="true">';
            $slides[$i] .= '<img src="' . $imgPath . '/' . $foton[$i]->year . '/' . $foton[$i]->filename . '"></a>' . PHP_EOL;
        }

        return $slides;
    }

    //****************** validateYearDecade *********************************************
    // Validates if year is in DB
    // Returns year if true
    // Returns false if false
    private function validateYearDecade($yearDecade){
        if( in_array($yearDecade, $this->yearsArr[0]) ){
            return $yearDecade;
        }else{
            return false;
        }
        
    }

    
}

