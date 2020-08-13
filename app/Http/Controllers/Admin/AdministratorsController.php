<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminValidationRequest;
use App\Services\AdminManagementService;
use App\Models\Admin;

class AdministratorsController extends Controller
{
    private $adminService;

    /**
     * Set the middleware to only allow users with superadmin or admin priviledges
     * Inject AdminManagementService
     */
    public function __construct(AdminManagementService $service)
    {   
        $this->middleware('adminUser');
        $this->adminService = $service;
    }
    /**
     * Display a listing of administrators.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins =  $this->adminService->getAll();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Store a newly created administrator in DB
     * @param  \App\Http\Requests\AdminValidationRequest
     * @return \Illuminate\Http\Response
     */
    public function store(AdminValidationRequest $request)
    {
        $administrator = $this->adminService->saveAdmin();
        session()->flash('success_message', 'Administrator has been created.');
        return response()->json($administrator, 201);
    }
    
    /**
     * Show the form for editing the specified administrator.
     * @param  App\Models\Admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $administrator)
    {   
        return response()->json($administrator);
    }

    /**
     * Update the specified resource in DB.
     * @param  \App\Http\Requests\AdminValidationRequest
     * @param  App\Models\Admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminValidationRequest $request, Admin $administrator)
    {
        $administrator = $this->adminService->saveAdmin($administrator);
        session()->flash('success_message', 'Administrator has been updated.');
        return response()->json($administrator);
    }

    /**
     * Remove the specified administrator from DB.
     * @param  App\Models\Admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $administrator)
    {
        $this->adminService->delete($administrator);
        return redirect()->route('admin.administrators.index')
        ->with('success_message', 'Administrator has been deleted');
    }
}
