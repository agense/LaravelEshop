<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//custom validation
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;

// add model
use App\Category;
use Session;


class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     * Set Controllers Middleware
     *
     * @return void
     */
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
        //set the middleware to only allow users with superadmin or admin priviledges
        $this->middleware('adminUser')->except('index');
    }


    /**
     * Display a listing of all categories
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index')->with('categories', $categories);
    }


    /**
     * Store a newly created category in DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $this->validate($request, array(
           'name' => 'required|max:191|regex:/(^[A-Za-z0-9 ]+$)+/|unique:categories',
        ));
        
        //Store in DB
        $category = new Category;
        $category->name = $request->name;
        $category->slug = str_slug($request->name);

        $category->save();
        return redirect()->route('categories.index')->with('success_message', 'Category has been created');
       
    }

    /**
     * Show the form for editing the specified category
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $category = Category::findOrFail($id);
        return view('admin.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified category in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //find the category
        $category = Category::findOrFail($id);

        //Validate data
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:191',
                'regex:/(^[A-Za-z0-9 ]+$)+/', 
                Rule::unique('categories')->ignore($category->id),
            ],
         ]);
         if($validator->fails()) {
            return redirect('admin/categories/'.$category->id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        //assign data
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
       
        //update db
        $category->save(); 
        return redirect()->route('categories.index')->with('success_message', 'Category has been updated');
    }

    /**
     * Remove the specified category from DB.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success_message', 'Category has been deleted');
    }

    /**
     * Return a list of categories: name and slug
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categoryList(Request $request){
        $categories =  DB::table('categories')->select('name', 'slug')->get();
        return response()->json($categories);
     }
}
