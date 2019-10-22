<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance and assign middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the logged in user's dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $userOrders = auth()->user()->orders;
        $totalOrders = count($userOrders);
        $completed = 0;
        $inProgress = 0;
        foreach($userOrders as $order){
         if($order->order_status == 2){
            $completed++;
         }else{
            $inProgress++;
         }
        }
        return view('users.dashboard')->with([
            'user' => auth()->user(),
            'totalOrders' => $totalOrders,
            'completedOrders' => $completed,
            'inProgressOrders' => $inProgress,
        ]);
    }

    /**
     * Show the form for editing the specified users account.
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('users.edit')->with('user', auth()->user());
    }

    /**
     * Update the specified user data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.auth()->id(), //ignore the current users email in checking the email uniqueness
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'phone' => 'sometimes|nullable|numeric|max:10',
            'address' => 'sometimes|nullable|max:191|regex:/(^[A-Za-z0-9 .]+$)+/',
            'city' => 'sometimes|nullable|max:50|regex:/(^[A-Za-z ]+$)+/',
            'region' => 'sometimes|nullable|max:50|regex:/(^[A-Za-z ]+$)+/',
            'postalcode' => 'sometimes|nullable|numeric|max:10',
        ]);
        
        // get the user object from authenticated user
        $user = auth()->user();

        //save the input for autofill, all fields except password and password confirmation
        $inputData = $request->except('password', 'password_confirmation');

        if(!$request->filled('password')){
            //autofil object with new data from request
            $user->fill($inputData);
            $user->save();
            return back()->with('success_message','Your profile has been updated!');
        }else{
            //encrypt and assign the new password
            $user->password = bcrypt($request->password);
            //autofil the remaining data
            $user->fill($inputData);
            $user->save();
            return back()->with('success_message','Your profile and password has been updated!');
        }
    }
    
    
}
