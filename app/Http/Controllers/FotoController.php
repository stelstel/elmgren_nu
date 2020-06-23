<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Foto;

class FotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
      
        return view('photos')->with([
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
            return view('photos')->with([
                'msgToUser' => 'Inga foton hittade med orden ' . $searchTerms . ' !',
                'searchTerms' => $searchTerms,
                'currentRoute' => Route::currentRouteName()
            ]);   
        }

        return view('photos')->with([
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
        
        $firstPhoto = $foto->getFirstPhoto($foton);


        $bigYearButton = $foto->getBigYearButton($foton[0]->year, $foton, "Det senaste");
                
        $slideshow = $foto->popSlideshow( $foton);    
        
        return view('photos')->with([
            'foton' => $foton, 
            'textOnWhiteSquare' => "Det senaste",
            'searchTerms' => "Det senaste",
            'firstPhoto' => $firstPhoto,
            'bigYearButton' => $bigYearButton,
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
