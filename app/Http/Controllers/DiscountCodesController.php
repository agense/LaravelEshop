<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DiscountCodeApplicationRequest;
use App\Services\DiscountCodesService;

class DiscountCodesController extends Controller
{
    private $codeService;

    /**
     * Inject DiscountCodesService
     */
    public function __construct(DiscountCodesService $service)
    {   
        $this->codeService = $service;
    }

    /**
     * Set code dicsount on the session if the passed discount code is valid
     * @param \App\Http\Requests\DiscountCodeApplicationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountCodeApplicationRequest $request){
        $this->codeService->applyCode();
        return back()->with('success_message','Discount has been applied.');
    }

     /**
     * Remove the discount code data from the session
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $this->codeService->removeCode();
        return back()->with('success_message','Discount has been removed.');
    }
}
