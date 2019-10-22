<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DOMDocument;  // using PHP's built-in DOMDocument() class to extract images out of summernote content
use Image; //intervention image class

class PagesController extends Controller
{    
    /**
    * Create a new controller instance.
    * Set Controllers Middleware
    * @return void
    */
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
        //set the middleware to only allow users with superadmin or admin privileges
        $this->middleware('adminUser')->except('index','show');
    }
    /**
     * Display a listing of all pages.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.pages.index')->with('pages', $pages);
    }

    /**
     * Show the form for creating a new page.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Page::getTypes();
        return view('admin.pages.add')->with('types', $types);
    }

    /**
     * Store a newly created page in DB.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191|regex:/(^[A-Za-z0-9 ]+$)+/|unique:pages',
            'type' => ['required', Rule::in(Page::getTypes())],
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('admin/pages/create')->withErrors($validator)->withInput();
        }
         //Store in DB
         $page = new Page;
         $page->title = $request->title;
         $page->slug = str_slug($request->title);
         $page->type = $request->type;
         //Process editor content
         $page->content = Page::processEditorContent($request->content);
         $page->save();
         return redirect()->route('pages.index')->with('success_message', 'Page has been created');
    }

    /**
     * Display the specified page.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        $page->content = htmlspecialchars_decode($page->content);
        return view('admin.pages.show')->with('page', $page);
    }

    /**
     * Show the form for editing the page
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $types = Page::getTypes();
        return view('admin.pages.edit')->with('page', $page)->with('types', $types);
    }

    /**
     * Update the specified page in DB
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $page = Page::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'max:191',
                'regex:/(^[A-Za-z0-9 ]+$)+/', 
                Rule::unique('pages')->ignore($page->id)
            ],
            'type' => ['required', Rule::in(Page::getTypes())],
            'content' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
         
         //Store record in DB
         $page->title = $request->title;
         $page->slug = str_slug($request->title);
         $page->type = $request->type;
         //Process editor content
         $page->content = Page::processEditorContent($request->content);
         $page->save();
         return redirect()->route('pages.index')->with('success_message', 'Page has been updated');
    }

    /**
     * Remove specified page from DB
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete all content editors images from file
        $page = Page::findOrFail($id);
        $images = [];
        $dom = new DOMDocument();
        $dom->loadHTML(htmlspecialchars_decode($page->content));
        $tags= $dom->getElementsByTagName('img');
        foreach ($tags as $tag) {
        $images[] =  $tag->getAttribute('src');
        }
        if(count($images) > 0){
            foreach($images as $img){
                Page::deletePageImage($img);
            }
        }
        //Delete the page from db
        $page->delete();
        return redirect()->route('pages.index')->with('success_message', 'Page has been deleted');
    }

    /**
     * Delete image embeded in Summernote Editors text, when deleted from the editor
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response - json response
     */
    public function deletePageImage(Request $request){
        if (!$request->wantsJson()) {
            return redirect()->back();
        }
        $fileurl= $request->fileurl;
        $result = Page::deletePageImage($fileurl);
        return response()->json($result);
    }
}
