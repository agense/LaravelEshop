<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ConfirmationController extends Controller
{
    /**
     * Display a thank you page upon order confirmation
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! session()->has('success_message')){
            return redirect('/');
        }
        return view('thankyou');
    }

}
