<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Pdfcvcontroller extends Controller
{
    public function getpdf() {
		$fileName = 'cv_stefan_elmgren_H_18_10_31.pdf';
		$filePath = public_path($fileName);
		return response()->download($filePath);
	}

 } 
