<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormValidationRequest;
use App\Services\ContactService;

class ContactsController extends Controller
{
    /** 
    * Show Contact Form Page
    *  @return \Illuminate\Http\Response
    */
    public function show()
    {
       return view('shop.contact');
    }

    /**
     * Send Email From Conatct Form
     * Redirect back to contact form with success message or errors
     * @param  \App\Http\Requests\ContactFormValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function send(ContactFormValidationRequest $request, ContactService $contactService)
    {
        $contactService->sendContactEmail();
        return redirect()->back()->with('success_message', 'Thank you for your message.');
    }
}
