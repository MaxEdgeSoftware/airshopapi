<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    public function index(){
        return view('main.index');
    }

    public function whatsnew(){
        return view('main.whatsnew');
    }

    public function pricing(){
        
        return view('main.pricing');
    }

    public function support(){
        return view('main.support');
    }
}
