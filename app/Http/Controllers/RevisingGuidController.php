<?php

namespace App\Http\Controllers;

use App\RevisingGuid;
use Illuminate\Http\Request;

class ReviewGuidController extends Controller
{
    //
    public function index(){
        return RevisingGuid::whereHas('children')->with('children')->get();
    }
}
