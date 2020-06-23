<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Foto;
use App\NewHome;

class NewHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function init(){
    	$latestPhotosPaths /*= $latestPhotosLinks*/ = $foton2 = $latestPhotos = array();
    	$nrOfLatest = 5;
        $foto = new Foto();
        $fotoYear = new Foto();
        $foton= $foto->showLatestPhotos();
        $flagToBreak = false;

        for ($i=0; $i < $nrOfLatest; $i++) { 
        	//$latestPhotosPaths[$i] = 'http://elmgren.nu/public/images/' . $foton[$i]["year"] . '/thumbs/' . strtolower( $foton[$i]["filename"] );
            //$latestPhotos[$i] = '<img src="{{ asset(/images/' . $foton[$i]["year"] . '/' . strtolower( $foton[$i]["filename"]) . '}}" class=" img-fluid mx-auto d-block" alt="' . $foton[$i]["header_text"] . '">';
            

            //<a href="#" class="open-album" data-open-id="album-1" data-index="0"><img class="img-fluid  x-auto d-block" src={{ $latestPhotosPaths[0] }} /></a><br />
            $latestPhotos[$i] = '<a href="#" class="open-album" data-open-id="album-1" data-index="' . $i . '"> ';
            $latestPhotos[$i] .= '<img class="img-fluid  x-auto d-block" '; 
            $latestPhotos[$i] .= 'src="' . 'http://elmgren.nu/public/images/' . $foton[$i]["year"] . '/thumbs/' . strtolower( $foton[$i]["filename"]) . ' "';
            $latestPhotos[$i] .= 'alt="' . $foton[$i]["header_text"] . '"></a>';

            //<a href="#" class="open-album" data-open-id="album-1" data-index="0">Test fancy</a><br />

        	$fotonYear = $fotoYear->getPhotosFromYear($foton[$i]["year"]);

        	$j = 1;

        	foreach ($fotonYear as $k => $v) {
        		if ($foton[$i]->filename == $v->filename) {
        			echo "<br>match found at" . $i . "-" . $j; /////Find index of file in year object//////////////////
        			$index = $j; // Found index of file in year object
        			$flagToBreak = true;
        			break;
        		}

        		$j++;
        	}

        	//$latestPhotosLinks[$i] = 'http://elmgren.nu/public/photos/' . $foton[$i]["year"] . '#gallery-' . $index;
        }

        return view('new_home')->with([
        	'foton' => $foton,
        	'latestPhotos' => $latestPhotos
        	//'latestPhotosLinks' => $latestPhotosLinks
        ]);
    }

    //****************** getPhotosYear *********************************************
    public function getPhotosYear($year){
        $slideshow = "";
        $readableYear = $this->makeReadableYear($year);
        $foto = new Foto();
        $foton= $foto->getPhotosFromYear($year);
        $firstPhoto = $foto->getFirstPhoto($foton);
        $bigYearButton = $foto->getBigYearButton($year, $foton, 'Foton ' . $readableYear);
        $slideshow = $foto->popSlideshow( $foton);
      
        return view('new_home')->with([
            'foton' => $foton, 
            'year' => $year,
            'textOnWhiteSquare' => $readableYear,
            'searchTerms' => $readableYear,
            'firstPhoto' => $firstPhoto,
            'bigYearButton' => $bigYearButton,
            'slideshow' => $slideshow,
            'currentRoute' => Route::currentRouteName()
        ]);
    }

    //****************** getPhotosSearch *********************************************
    public function getPhotosSearch(Request $req){

        $this->validate($req, [
            'searchTerms' => 'max:150' 
        ]);

        $slideShow = "";
        $searchTerms = $req->input('searchTerms');
        session()->put('searchTerms', $searchTerms);
        $foto = new Foto();
        $foton= $foto->getPhotosFromSearch($searchTerms);

        // No search terms, show ALL photos and movies
        if(strlen($searchTerms) == 0){
            $searchTerms = "Alla foton/filmer";
        }
        
        if( count($foton) > 0 ){ 
            $firstPhoto = $foto->getFirstPhoto($foton);

            if ($searchTerms == "Alla foton/filmer") {
                $bigYearButton = $foto->getBigYearButton($foton[0]->year, $foton, $searchTerms);
            }else{
                $bigYearButton = $foto->getBigYearButton($foton[0]->year, $foton, 'Foton ' . $searchTerms);
            }
            
            $slideshow = $foto->popSlideshow( $foton);    
        }else{ // No photos match search criteria
            return view('new_home')->with([
                'msgToUser' => 'Inga foton hittade med orden ' . $searchTerms . ' !',
                'searchTerms' => $searchTerms,
                'currentRoute' => Route::currentRouteName()
            ]);   
        }

        return view('new_home')->with([
            'foton' => $foton, 
            'searchTerms' => $searchTerms,
            'firstPhoto' => $firstPhoto,
            'bigYearButton' => $bigYearButton,
            'slideshow' => $slideshow,
            'currentRoute' => Route::currentRouteName()
        ]);
    }

    //****************** getLatestPhotos *********************************************
    public function getLatestPhotos(){
        $slideShow = "";
        $foto = new Foto();
        $foton= $foto->showLatestPhotos();
        

        
        //$firstPhoto = $foto->getFirstPhoto($foton);


        //$bigYearButton = $foto->getBigYearButton($foton[0]->year, $foton, "Det senaste");
                
        $slideshow = $foto->popSlideshow( $foton);    
        
        return view('new_home')->with([
            'foton' => $foton, 
            //'textOnWhiteSquare' => "Det senaste",
            //'searchTerms' => "Det senaste",
            //'firstPhoto' => $firstPhoto,
            //'bigYearButton' => $bigYearButton,
            'slideshow' => $slideshow,
            'currentRoute' => Route::currentRouteName()
        ]);
    }

    //****************** getFirstPhoto ********************************************* OLD TABORT SEN ////
    private function getFirstPhoto($foton){
    	$foto = new Foto();
    	$firstPhoto = $foto->getFirstPhoto($foton);
    	return $firstPhoto;
    }

    //****************** getOnePhotoThumb *********************************************
    // $index = element index in array
    public static function getOnePhotoThumb($index){
        $foto = new Foto();
        $foton= $foto->showLatestPhotos();
        $thumb = 'http://elmgren.nu/public/images/' . $foton[$index]["year"] . '/thumbs/' . $foton[$index]["filename"];
        $thumb = strtolower($thumb);
        return $thumb;
    }

    //****************** makeReadableYear *********************************************
    private function makeReadableYear($year){
    	// Special case. Make year readable
		if($year == "innan_1960"){
			$readableYear = "Innan 1960";
		}else{
			$readableYear = $year;
		}

		return $readableYear;
    }
}

