<?php

namespace App\Http\Controllers;

use App\reviser;
use Illuminate\Http\Request;

class ReviserController extends Controller
{
    //

    public function index(){

        $revisers = reviser::get(['id','name']);

        return response()->json(['revisers' => $revisers],200);
    }
}
