<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout','userLogout');
    }

    /**
     * Log the user out of the application.
     */
    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    /**
     * Upon login, redirect users back to the page on which they were before logging in.
     * This method overrides the showLoginForm method of AuthenticatesUsers trait, by adding session to it holding previous url.
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        //save url from which user is coming in session
        session()->put('prevUrl', url()->previous());

        return view('auth.login');
    }
    /**
     * Create a redirect to method, which will be used instead of the default reditectTo() method in RegisterUsers class.
     */
    public function redirectTo(){
        //remove the domain from the url, leaving only the path. Get the path from the session.
        //the last part in session()->get(), i.e. '/', means the if prevUrl does not exists, go to main page.
        return str_replace(url('/'), '', session()->get('prevUrl', '/'));
    }
}
