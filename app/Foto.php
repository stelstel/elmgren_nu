<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Foto extends Model
{
    protected $table = 'foton'; // Use table 'foton' in stead of default 'fotos' in db

    //********************* getPhotosFromYear ***********************************************
    public function getPhotosFromYear($year){
        $foton = Foto::
            where('year', '=', $year)
            ->where('noshow','!=', '1')
            ->orderBy('photo_order')
            ->get();
        return $foton;  
    }

    //********************* getPhotosFromSearch ***********************************************
    public function getPhotosFromSearch($search){
        $foton = "";
        $search = mb_strtolower( $search );
        $searchWords = preg_split("/[\s,]+/", $search); // Returns an array of strings, each of which is a substring of string

        for ($i=0; $i < count($searchWords); $i++) { 
            $searchWords[$i] = trim($searchWords[$i]); // Strip whitespace (or other characters) from the beginning and end of a string
            $searchWords[$i] = preg_replace("#[^a-z0-9:åäöÅÄÖ;.,* %_@=?/&-]#i", '', $searchWords[$i]); // Remove any character that isn't A-Ö, a-ö or 0-9
        }

        $query = Foto::select();

        $query->where(function($q) use ($searchWords) {
           $firstCase = array_shift($searchWords);
           $q->where('tags', 'LIKE', '%' . $firstCase . '%');
           foreach($searchWords as $sw) {
              $q->orWhere('tags', 'LIKE', '%' .  $sw . '%');
           }
           // other conditions
        });

        $query->where('noshow','!=', '1');
        $query->orderBy('photo_date');

        // var_dump($query); //////////////////////////////////////// HÄR ÄR ä = %C3%A4 //////////////////////////////////////////

        $foton = $query->get();
        
        // Debug query 
        // $foton = $query->toSql(); /////////////////////
        // dd($foton); ///////////////////////////

        return $foton;  
    }

    //********************* showLatestPhotos ***********************************************
    public function showLatestPhotos(){
        $nrOfPhotosToShow = 9; // Number of photos in the slide show
        $query = Foto::select();
        $query->latest('updated_at')->limit($nrOfPhotosToShow);
        $query->where('noshow','!=', '1');
        $foton = $query->get();

        return $foton;
    }

    //**************** image ******************************************************************
    private function image($indx, $foton) {
        $output = '<a ';

        $output .= 'data-fancybox="gallery" class="gallery" data-caption="';

        if(strlen($foton[$indx]['header_text']) > 0){
            $output .= '<strong>' . $foton[$indx]["header_text"] . '</strong>';
        }
        
        if(strlen($foton[$indx]['header_text']) > 0  && (strlen($foton[$indx]['bread_text']) > 0) || ($foton[$indx]['photo_date'] != '0000-00-00') ){
            $output .= '<br>';
        }
        
        if(strlen($foton[$indx]['bread_text']) > 0){
            $output .= $foton[$indx]['bread_text'];
        }
        
        if( (strlen($foton[$indx]['bread_text']) > 0 || strlen($foton[$indx]['bread_text']) > 0 ) && $foton[$indx]['photo_date'] != '0000-00-00' ){
            $output .= '<br>';    
        }
        
        if($foton[$indx]['photo_date'] != '0000-00-00'){
            $output .= $foton[$indx]['photo_date'];
        }
        
        // Date isn't confirmed
        if($foton[$indx]['guessed_date'] == 1){
            $output .= '  ?';
        }

        return $output;
    }

    //******************* popSlideshow **************************************************************
    // Populate slideshow
    public function popSlideshow($foton){
        $output = "";

        for($i = 0; $i < count($foton); $i++){
            $output .= $this->image($i, $foton);

            if( empty($foton[$i]['movie_thumb'] ) ){ // Photo ,not movie
                $output .= '" href="/public/images/';
                $output .= $foton[$i]->year . '/';
                $output .= $foton[$i]['filename'] . '"';
            }else{ // Youtube movie
                $output .= '" href="' . $foton[$i]['filename'] . '"';    
            }
            
            $output .= ' hidden="true">';
            $output .= '<img src="/public/images/';
            $output .= $foton[$i]->year . '/';
            
            if( empty($foton[$i]['movie_thumb'] ) ){ // Photo ,not movie. Normal thumb nail
                $output .= $foton[$i]['filename'] . '"></a>';
            }else{ // Youtube movie thumb nail
                $output .= 'thumbs/';
                $output .= $foton[$i]['movie_thumb'] . '"></a>';
            }

            $output .= " " . PHP_EOL;
        }
        return $output;
    }
}