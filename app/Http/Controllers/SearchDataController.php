<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchDataController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function result(Request  $request)
    {
        $result=\App\Foto::where('header_text', 'LIKE', "{$request->input('query')}%")->get();
        //$result=\App\Foto::where('header_text', 'LIKE', "%över%")->get(); // Doesn't work ///////////////////// 
        //$result=\App\Foto::where('header_text', 'LIKE', "%ste%")->get(); // DOES work ///////////////////// 
        
        return response()->json($result);
    }
}