<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodesValidationRequest;
use App\Services\DiscountCodesService;
use App\Models\DiscountCode;

class DiscountCodesController extends Controller
{
    private $codeService;

    /**
     * Set the middleware to only allow users with superadmin or admin priviledges
     * Inject DiscountCodesService
     */
    public function __construct(DiscountCodesService $service)
    {   
        $this->middleware('adminUser')->except('index', 'deactivated', 'expired');
        $this->codeService = $service;
    }

    /**
     * Display a listing of all dicount codes.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discountCodes = $this->codeService->getActiveAndFuture();
        return view('admin.discount_codes.index', compact('discountCodes'));
    }

    /**
     * Store a new discount code in db.
     * @param  \App\Http\Requests\DiscountCodesValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountCodesValidationRequest $request)
    {   
        $code = $this->codeService->saveCode($request->validated());
        session()->flash('success_message', 'Disocunt code has been created.');
        return response()->json($code, 201);
    }

    /**
     * Show the form for editing the discount card.
     * @param  \App\Models\DiscountCode $code
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountCode $code)
    {
        return response()->json($code);
    }

      /**
     * Update the discount code in DB.
     * @param  \App\Http\Requests\DiscountCodesValidationRequest $request
     * @param  \App\Models\DiscountCode $code
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountCodesValidationRequest $request, DiscountCode $code)
    {
        $code = $this->codeService->saveCode($request->validated(), $code);
        session()->flash('success_message', 'Discount code has been updated.');
        return response()->json($code);
    }

    /**
     * Deactivate a discount code, i.e. sof delete.
     * @param  \App\Models\DiscountCode $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountCode $code)
    {
        $this->codeService->deactivate($code);
        return back()->with('success_message', 'Disocunt code has been deactivated');
    }

    // SOFT DELETE/DEACTIVATION FUNCTIONALITY
    /**
     * Show all deactivated dicount codes
     * @return \Illuminate\Http\Response
     */
    public function deactivated()
    {    
        $discountCodes = $this->codeService->getInactive();
        return view('admin.discount_codes.deactivated', compact('discountCodes'));
    }

     /**
     * Restore a deactivated discount code
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {  
        $this->codeService->restore($id);
        return redirect()->back()->with('success_message', 'Discount code has been restored');
    }

    /**
     * Delete a deactivated code from DB
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteInactive($id)
    {
        $this->codeService->delete($id);
        return redirect()->back()->with('success_message', 'Discount code has been deleted'); 
    }

    /**
     * Show all deactivated dicount codes
     * @return \Illuminate\Http\Response
     */
    public function expired()
    {  
       $discountCodes = $this->codeService->getExpired();
       return view('admin.discount_codes.expired', compact('discountCodes'));
    }

    /**
     * Toggle public property of discount codes.
     * Publicaly accessible codes are displayed in front end slider.
     * @param \Illuminate\Http\Request $request
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function toggeAccess(Request $request, $id){
        $newPublic = $this->codeService->toggleAccess($id);
        $message = ($newPublic == 1) ? 'Code has been set to publicly visible!' : 'Code has been set to publicly invisible!';
        return response()->json(['message' => $message, 'newvalue' => $newPublic]);
    }
   
}
