<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Controller
    |--------------------------------------------------------------------------
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    //show login form
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**Login admin user**/
    public function login(Request $request)
    {
        //Validate form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
  
        //attempt to log the user in
           if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password' => $request->password], $request->remember)){
               //on success, redirect to the intended location (or admin dashboard if location does not exist)
               return redirect()->intended(route('admin.dashboard'));
           }
           //on error, redirect back to login with enetered form data except password
           return redirect()->back()->withInput($request->only('email', 'remember'));
    }

      /**
     * Log the user out of the application.
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
