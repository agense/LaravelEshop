<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use App\Services\ImageUploader;
use App\Models\Slider;
use App\Models\DiscountCode;
use App\Services\DiscountCodesService;

class SliderService {

    private $imageUploader;

    /**
     * Instantiate ImageUploader Service
     */
    public function __construct()
    {   
        $this->imageUploader =  new ImageUploader('img/slider/', 550, 550);
    }

    /**
     * Returns a list of all slides
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getSlides(){
        return Slider::all();
    }

    /**
     * Creates a new slide or updates existing one
     * @param App\Models\Slider $slide (optional)
     * @return App\Models\Slider
     */
    public function saveSlide($slide = null){
        $slide =  $slide instanceof Slider ? $slide : new Slider();

        $slide->fill(request()->only('title', 'subtitle', 'link', 'link_text'));
        if(request()->has('image')){
            $this->imageUploader->uploadBase64(request()->image);

            //delete current image
            if($slide->imageExists() && !in_array($slide->image, Slider::getDefaultImages())){
                $this->imageUploader->delete($slide->image);
            }
            $slide->image = $this->imageUploader->getFilename();
        }
        $slide->save();
        return $slide;
    }
    
    /**
     * Deletes a single slide
     * @param App\Models\Slider $slide 
     * @return Void
     */
    public function deleteSlide(Slider $slide){
        try{
            //Delete Slide Image
            if(!in_array($slide->image, Slider::getDefaultImages())){
                $this->imageUploader->delete($slide->image);
            }
            $slide->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Format an array of slides including simple and promotional slides
     * @return Array
     */
    public function getDisplaySlides(){
        $slider = [];
        $infoSlides = $this->getSlides();
        $promoSlides = (new DiscountCodesService())->getPublicActive();
        
        if($infoSlides->count() > 0){
            $slider['info_slides'] = $infoSlides;
        }
        if($promoSlides->count() > 0){
            $slider['promo_slides'] = $promoSlides;
        }
        return $slider;
    }
}