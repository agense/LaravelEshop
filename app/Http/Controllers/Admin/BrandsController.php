<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BrandValidationRequest;
use App\Services\BrandsService;
use App\Models\Brand;

class BrandsController extends Controller
{
    private $brandService;

    /**
     * Set the middleware to only allow users with superadmin or admin priviledges
     * Inject BrandService 
     */
    public function __construct(BrandsService $brandService)
    {   
        $this->middleware('adminUser');
        $this->brandService = $brandService;
    }

    /**
     * Display a listing of all brands
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $brands = $this->brandService->getAll();
        return view('admin.brands.index')->with('brands', $brands);
    }

    /**
     * Store a newly created brand in DB
     * @param  \App\Http\Requests\BrandValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandValidationRequest $request)
    {
        $brand = $this->brandService->create();
        session()->flash('success_message', 'Brand has been created.');
        return response()->json($brand, 201);
    }
    
    /**
     * Show the form for editing the specified brand.
     * @param App\Models\Brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return response()->json($brand);
    }

    /**
     * Update the specified brand in DB
     * @param  \App\Http\Requests\BrandValidationRequest $request
     * @param  App\Models\Brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandValidationRequest $request, Brand $brand)
    {
        $brand = $this->brandService->update($brand);
        session()->flash('success_message', 'Brand has been updated.');
        return response()->json($brand);
    }

    /**
     * Remove the specified brand from DB.
     * @param  App\Models\Brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $this->brandService->delete($brand);
        return redirect()->route('admin.brands.index')->with('success_message', 'Brand has been deleted');
    }

}
