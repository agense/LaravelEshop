<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\SliderValidationRequest;
use App\Http\Controllers\Controller;
use App\Services\SliderService;
use App\Models\Slider;

class SliderController extends Controller
{
    private $slider;
    /**
     * Create a new controller instance.
     * Set Controllers Middleware
     * @return void
     */
    public function __construct(SliderService $slider)
    {   
        $this->slider = $slider;
    }

    /**
     * Display a listing of all slides
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = $this->slider->getSlides();
        return view('admin.settings.slider')->with('slides', $slides);
    }

   /**
     * Store a new  slide in DB
     * @param  \App\Http\Requests\SliderValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderValidationRequest $request)
    {
        $slide = $this->slider->saveSlide();
        session()->flash('success_message', 'Slide has been created.');
        return response()->json($slide, 201);
    }
    
    /**
     * Show slide data for editing
     * @param Slider $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slide)
    {
        return response()->json($slide);
        
    }

    /**
     * Update a slide in DB
     * @param  \App\Http\Requests\SliderValidationRequest $request
     * @param  Slider $slide
     * @return \Illuminate\Http\Response
     */
    public function update(SliderValidationRequest $request, Slider $slide)
    {
        $slide = $this->slider->saveSlide($slide);
        session()->flash('success_message', 'Slide has been updated.');
        return response()->json($slide);
    }

    /**
     * Remove a slide from DB.
     * @param  Slider $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slide)
    {
        $this->slider->deleteSlide($slide);
        return redirect()->route('admin.settings.slides.index')
        ->with('success_message', 'Slide has been deleted');
    }

}
