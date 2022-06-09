<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller{
    public function add(Request $request){
        try{
            $request->validate([
                'title' => ['required'],
                'amount' => ['required'],
                'category' => ['required'],
                'owner' => ['required']
            ]);
    
            $invoice = Invoice::create([
                'title' => $request->title,
                'amount' => $request->amount,
                'category' =>  $request->category,
                'owner' => $request->owner,
            ]);
            $invoice->save();
            return true;
        }catch(error_log){
            return false;
        }
        
    }
}
