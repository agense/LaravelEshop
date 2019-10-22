<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PagesController extends Controller
{
    /**
     * Display a sigle page
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page)
    {
        $page = Page::where('slug', $page)->firstOrFail();
        $page->content = htmlspecialchars_decode($page->content);
        return view('page')->with('page', $page);
    }
}
