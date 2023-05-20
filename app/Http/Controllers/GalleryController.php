<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->only(['index', 'indexSampling']);
    // }

    public function index()
    {
        return view('gallery.index');
    }
}
