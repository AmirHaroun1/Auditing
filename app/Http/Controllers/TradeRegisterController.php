<?php

namespace App\Http\Controllers;

use App\institution;
use App\TradeRegister;
use Illuminate\Http\Request;

class TradeRegisterController extends Controller
{
    public function search($TradeRegisterNumber){

        $TradeRegister = TradeRegister::where('number',$TradeRegisterNumber)->with('institution')->get();

        return response()->json(['TradeRegister' => $TradeRegister],200);
    }
    //
    public function store(Request $request,institution $institution){

        $newTradeRegister = TradeRegister::create($request->all());

        $institution->TradeRegisters()->save($newTradeRegister);
        $institution->refresh();

        return response()->json($newTradeRegister,200);
    }
}
