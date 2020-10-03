<?php

namespace App\Http\Controllers;

use App\document;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    //
    public function index(){
        $documents = document::all();

        return response()->json(['RequiredDocuments' => $documents],200);
    }
    public function AddDocument(Request $request , $transaction_id){



    }

}
