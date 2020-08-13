<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserAccountUpdateRequest;
use App\Services\OrderService;
use App\Services\UserService;

class UsersController extends Controller
{

    /**
     * Show the logged in user's dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index(OrderService $orderService)
    {   
        $user = auth()->user();
        $orderCount = $orderService->getUserOrderCounts();
        return view('users.dashboard', compact('user', 'orderCount'));
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
     * @param  \App\Http\Requests\UserAccountUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserAccountUpdateRequest $request, UserService $userService)
    {
        $userService->updateAccount();
        return back()->with('success_message','Your account has been updated!');
    }  
    
}
