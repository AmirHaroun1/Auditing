<?php

namespace App\Http\Controllers;

use App\agent;
use App\institution;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    //

    public function store(Request $request,Institution $institution)
    {
        $request['password'] = Hash::make($request->password);
        $newAgent =  agent::create($request->except('password_confirmation'));

        $institution->agent()->associate($newAgent);
        $institution->save();

        return response()->json($newAgent,200);
    }

}
