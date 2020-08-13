<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductManagementService;
use App\Services\SliderService;

class LandingPageController extends Controller
{
    /**
     * Display landing page
     * @return \Illuminate\Http\Response
     */
    public function index(ProductManagementService $productService, SliderService $sliderService)
    {
        $categories = $productService->featuredProductsByCategory();
        $slider = $sliderService->getDisplaySlides();
        return view('shop.landing-page', compact('categories','slider'));
    }

}
