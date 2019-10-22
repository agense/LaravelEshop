<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class ContactsController extends Controller
{
    /** 
    * Show Contact Form Page
    *  @return \Illuminate\Http\Response
    */
    public function show()
    {
       return view('contact');
    }

    /**
     * Send Email From Conatct Form
     * Redirect back to contact form with success message or errors
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => 'required|max:191|email',
            'title' => 'required|string|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
            'content' => 'required|string|max:5000|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
        ));

        $email = new \stdClass();
        $email->name = $request->name;
        $email->email = $request->email;
        $email->title = $request->title;
        $email->content = $request->content;

        $recipient = Setting::appEmail();
        if(!$recipient){
            return redirect()->back()->with('error_message', 'Sorry, the email cannot be sent.');
        }
       
       //Send email using queue method and return a success message
        Mail::to($recipient)->queue(new Contact($email));
        return redirect()->back()->with('success_message', 'Thank you for your message.');
    }
}
