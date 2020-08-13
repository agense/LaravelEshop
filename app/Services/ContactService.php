<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use App\Models\Setting;

class ContactService {

    private $recipient;
    private $email;

    /**
     * Set recipient property and format email content
     */
    public function __construct(){
        $this->recipient = Setting::appEmail();
        if(!$this->recipient){
            abort(400, 'Sorry, the email cannot be sent.');
        }
        $this->formatContactEmail();
    }

    /**
     * Send email
     * @return Void
     */
    public function sendContactEmail(){
        try{
            Mail::to($this->recipient)->send(new Contact($this->email));
        }catch(\Exception $e){
            abort(400, 'Sorry, the email cannot be sent.');
        }
    }

    /**
     * Format email from request
     */
    private function formatContactEmail(){
        $email = new \stdClass();
        $email->name = request()->name;
        $email->email = request()->email;
        $email->title = request()->title;
        $email->content = request()->content;
        $this->email = $email;
    }
}