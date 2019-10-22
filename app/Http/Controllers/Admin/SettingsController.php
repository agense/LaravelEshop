<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Setting;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     * Set Controllers Middleware
     *
     * @return void
     */
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
    }

    /**
     * Show settings editting form
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
       $this->authorize('isSuperadmin');
       $settings = Setting::firstOrFail();
       return view('admin.settings')->with('settings', $settings);
    }

    /**
     * Update Settings 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $this->authorize('isSuperadmin');
       $settings = Setting::firstOrFail();
       $currencyCodes = $settings->currencyCodes();

       $validator = Validator::make($request->all(), [
        'site_name' => ['required','max:191','regex:/(^[A-Za-z0-9 ]+$)+/'],
        'currency' => ['required', Rule::in($currencyCodes)],
        'email_primary' => 'nullable|max:191|email',
        'email_secondary' => 'nullable|max:191|email',
        'phone_primary' => 'nullable|min:8|max:15|regex:/^[0-9()+\\s-]*$/',
        'phone_secondary' => 'nullable|min:8|max:15|regex:/^[0-9()+\\s-]*$/',
        'address' => 'nullable|max:191|regex:/^[a-zA-Z0-9,.\\s-]*$/',
        'first_slide_title' => 'nullable|max:191|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
        'first_slide_subtitle' => 'nullable|max:191|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
        'first_slide_btn_text' => 'required|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
        'first_slide_btn_link' => 'required|max:191|url',
        'second_slide_title' => 'nullable|max:191|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
        'second_slide_subtitle' => 'nullable|max:191|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
        'second_slide_btn_text' => 'required|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
        'second_slide_btn_link' => 'required|max:191|url',
       ]);
       if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
       }

       $settings->site_name = $request->site_name;
       $settings->currency = $request->currency;
       $settings->email_primary = $request->email_primary;
       $settings->email_secondary = $request->email_secondary;
       $settings->phone_primary = $request->phone_primary;
       $settings->phone_secondary = $request->phone_secondary;
       $settings->address = $request->address;
       // Slider Settings
       $settings->first_slide_title = $request->first_slide_title;
       $settings->first_slide_subtitle = $request->first_slide_subtitle;
       $settings->first_slide_btn_text = $request->first_slide_btn_text;
       $settings->first_slide_btn_link = $request->first_slide_btn_link;

       $settings->second_slide_title = $request->second_slide_title;
       $settings->second_slide_subtitle = $request->second_slide_subtitle;
       $settings->second_slide_btn_text = $request->second_slide_btn_text;
       $settings->second_slide_btn_link = $request->second_slide_btn_link;

       $settings->save();
       return redirect()->back()->with('settings', $settings)->with('success_message', 'Settings have been updated');;
    }
}
