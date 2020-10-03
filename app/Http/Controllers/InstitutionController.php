<?php

namespace App\Http\Controllers;

use App\institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    //
    public function store(Request $request){

        $newCompany =  institution::create($request->except('password_confirmation'));

        return response()->json($newCompany,200);
    }
}
