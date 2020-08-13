<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PageService;
use App\Models\Page;

class PagesController extends Controller
{
    /**
     * Display a single page
     * @param String $slug - page slug
     * @return \Illuminate\Http\Response
     */
    public function index(String $slug, PageService $pageService)
    {
        $page = $pageService->getOneBySlug($slug);
        return view('shop.page', compact('page'));
    }
}
