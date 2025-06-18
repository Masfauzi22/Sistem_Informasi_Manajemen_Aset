<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Tugasnya hanya menampilkan view bernama 'landing.blade.php'
        return view('landing');
    }
}