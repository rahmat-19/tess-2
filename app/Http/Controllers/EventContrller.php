<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventContrller extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->only(['index', 'indexSampling']);
    // }

    public function index()
    {
        return view('event.index');
    }
}
