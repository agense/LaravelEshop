<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BrandsController extends Controller
{
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
        //set the middleware to only allow users with superadmin or admin priviledges
        $this->middleware('adminUser')->except('index','show');
    }
    /**
     * Display a listing of all brands
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $brands = Brand::withCount('products')->orderBy('name')->paginate(10);
        return view('admin.brands.index')->with('brands', $brands);
    }

    /**
     * Redirect back to brands index
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('brands.index');
    }

    /**
     * Store a newly created brand in DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Validate data
         $this->validate($request, array(
            'name' => 'required|max:191|regex:/(^[A-Za-z0-9 ]+$)+/|unique:brands',
         ));
         //Store in DB
         $slug = str_slug($request->name);
         Brand::create(['name' => $request->name, 'slug' => $slug]);
         return redirect()->route('brands.index')->with('success_message', 'Brand has been created');
    }

    /**
     *Redirect back to brands index
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('brands.index');
    }

    /**
     * Show the form for editing the specified brand.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit')->with('brand', $brand);
    }

    /**
     * Update the specified brand in DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        //Validate data
         $this->validate($request, array(
            'name' => ['required','max:191','regex:/(^[A-Za-z0-9 ]+$)+/', Rule::unique('brands')->ignore($brand->id)],
         ));
         //Store in DB
         $brand->name =  $request->name;
         $brand->slug =  str_slug($request->name);
         $brand->save();
         return redirect()->route('brands.index')->with('success_message', 'Brand has been updated');
    }

    /**
     * Remove the specified brand from DB.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('brands.index')->with('success_message', 'Brand has been deleted');
    }

    
    /**
     * Return a list of brands: name and slug
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function brandList(Request $request){
       if (!$request->wantsJson()) {
        return redirect()->route('admin.brands');
       }
       $brands =  DB::table('brands')->select('name', 'slug')->get();
       return response()->json($brands);
    }
}
