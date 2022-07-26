<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller{
    public function index(Request $request){
        return Invoice::where('owner', '=' , $request->user()->id)->get();
    }

    public function show($id){
        return Invoice::findOrFail($id);
    }
    
    public function add(Request $request){
        try{
            $request->validate([
                'title' => ['required'],
                'amount' => ['required'],
                'category' => ['required'],
                'src' => ['required']
            ]);
    
            $invoice = Invoice::create([
                'title' => $request->title,
                'amount' => $request->amount,
                'category' =>  $request->category,
                'owner' => $request->user()->id,
                'src' => $request->src
            ]);
            $invoice->save();
            return response()->json([
                'reponse' => true
            ]);
        }catch(error_log){
            return response()->json([
                'reponse' => false
            ]);
        }
        
    }
}
