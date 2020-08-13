<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PageValidationRequest;
use App\Services\PageService;
use App\Models\Page;

class PagesController extends Controller
{    
    private $pageService;
    /**
    * Create a new controller instance.
    * Set Controllers Middleware
    * Inject PagesManagementService
    */
    public function __construct(PageService $service)
    {   
        //set the middleware to only allow users with superadmin or admin privileges
        $this->middleware('adminUser');
        $this->pageService = $service;
    }

    /**
     * Display a listing of all pages.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->pageService->getAll();
        return view('admin.pages.index')->with('pages', $pages);
    }

    /**
     * Show the form for creating a new page.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.add')->with(['page' => new Page()]);
    }

    /**
     * Store a newly created page in DB.
     * @param  \App\Http\Requests\PageValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageValidationRequest $request)
    {
        $this->pageService->savePage();
        return redirect()->route('admin.pages.index')->with('success_message', 'Page has been created');
    }

    /**
     * Redirect to the edit view
     * @param  App\Models\Page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return redirect()->route('admin.pages.edit', $page->id);
    }

    /**
     * Show the form for editing the page
     * @param  App\Models\Page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit')->with('page', $page);
    }

    /**
     * Update the specified page in DB
     * @param  App\Http\Requests\PageValidationRequest $request
     * @param  App\Models\Page
     * @return \Illuminate\Http\Response
     */
    public function update(PageValidationRequest $request, Page $page)
    {   
        $this->pageService->savePage($page);
        return redirect()->route('admin.pages.index')->with('success_message', 'Page has been updated');
    }

    /**
     * Remove specified page from DB
     * @param  App\Models\Page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $this->pageService->delete($page);
        return redirect()->route('admin.pages.index')->with('success_message', 'Page has been deleted');
    }

    /**
     * Delete image embeded in Summernote Editors text, when deleted from the editor
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response - json response
     */
    public function deletePageImage(Request $request){
        $this->pageService->deleteContentImage();
        return response()->json(true, 200);
    }
}
