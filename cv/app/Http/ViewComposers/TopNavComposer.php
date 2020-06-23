<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;

class TopNavComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navigation', $this->getNav() );
    }

    //********************* getNav ********************************************************
    // Top navigation
    private function getNav(){
            $output = "";
            $output .= '<li class="nav-item"><a class="nav-link" href="' . route('kompetens') . '">Teknisk kompetens</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" href="' . route('yrkeserf') . '">Yrkeserfarenhet</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" href="' . route('utbildning') . '">Utbildning</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" href="' . route('languages') . '">Språkkunskaper</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" href="' . route('samples') . '">Arbetsprover</a></li>';
            $output .= '<li class="nav-item"><a class="nav-link" href="' . route('pdfcv') . '">Ladda ner CV som PDF</a></li>';
            return $output;
    }
}