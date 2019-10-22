<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//custom validation
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Admin;

class AdministratorsController extends Controller
{
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of administrators.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('admin.admins.index')->with('admins', $admins);
    }

    /**
     * Show the form for creating a new administrator
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $roles = Admin::adminRoles();
        return view('admin.admins.add')->with('roles', $roles);
    }

    /**
     * Store a newly created administrator in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => 'required|string|email|max:191|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'role' => Rule::in(Admin::adminRoles()),
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
 
        $admin = new Admin;
        $admin->role = $request->role;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();

        return redirect()->route('administrators.index')->with('success_message', 'Administrator has been created');
    }

    /**
     * Redirect back to Admin index
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('administrators.index');
    }

    /**
     * Show the form for editing the specified administrator.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $admin = Admin::findOrFail($id);
        $roles = Admin::adminRoles();
        return view('admin.admins.edit')->with('admin', $admin)->with('roles', $roles);
    }

    /**
     * Update the specified resource in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => 'required|string|email|max:191|unique:admins,email,'.$admin->id,
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'role' => Rule::in(Admin::adminRoles()),

        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
         //save the input for autofill, all fields except password and password confirmation
         $inputData = $request->except('password', 'password_confirmation');

         if(!$request->filled('password')){
             //autofil object with new data from request
             $admin->fill($inputData);
             $admin->save();
             return back()->with('success_message','Administrator info has been updated!');
         }else{
             //encrypt and assign the new password
             $admin->password = bcrypt($request->password);
             //autofil the remaining data
             $admin->fill($inputData);
             $admin->save();
             return back()->with('success_message','Administrator info and password has been updated!');
         }
    }

    /**
     * Remove the specified administrator from DB.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin= Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('administrators.index')->with('success_message', 'Administrator has been deleted');
    }
}
