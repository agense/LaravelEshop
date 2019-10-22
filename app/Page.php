<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DOMDocument;  // using PHP's built-in DOMDocument() class to extract images out of summernote content
use Image; //intervention image class
use File;
use Purifier;

class Page extends Model
{
    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'type', 'content'];
    
    /** Page types */
    private $types = ['standard', 'terms'];


    /** Return page types */
    public static function getTypes(){
      $page = new Self();
      return $page->types;
    }

    /**
     * Process Summernote text editor content with images for upload
     * @param string $content
     * @return string purified and html entities encoded $content 
     */
     public static function processEditorContent($content){

        /* If any images are present in text editor
           * Upload the images from summernote to public/img/pages folder
           * Update the DOM to contain uploaded img urls instead of base64 converted images
        */
        $dom = new DomDocument();
		$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $contentImages = $dom->getElementsByTagName('img');

        //check if there are any images 
        if($contentImages->length > 0){
            foreach($contentImages as $img){
                $src = $img->getAttribute('src');
                /*check if a new image is being uploaded or an old one is being edited, 
                i.e. new images will be in base 64 format and will need conversion, while old ones will not, 
                therefore check if the img source is 'data-url'
                */
                if(preg_match('/data:image/', $src)){  
                    // get the mimetype & file extension from it
                    $mimetype  = mime_content_type ($src);
                    $ext = explode('/', $mimetype)[1];
        
                    //create file name and upload location
                    $filename = 'page_image_'.uniqid().'.'.$ext;
                    $location = 'img/pages/'.$filename;
                    //set upload path 
                    $uploadPath = public_path($location);
        
                    //upload image to folder
                    $image = Image::make($src);
                    if($image->width() > 1080){
                        $image->resize(1080, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }elseif($image->height() > 750){
                        $image->resize(null, 750, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $image->save($uploadPath);
        
                    //get a full file name of uploaded file, 
                    //change the current image src (i.e. the base 64) to a file location name
                    $imgUrl = asset($location);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $imgUrl);
                }         
            }
            //update the content of the summernote field to contain image links
             $content = $dom->saveHTML();
        }
        $content = Purifier::clean($content);
        return htmlentities($content, ENT_QUOTES, 'UTF-8');
   }
    
   /**
     * Delete single image embedded in Summernote text editor content
     * @param string $image full url
     * @return bool true on success, false otherwise
    */
    public static function deletePageImage($fileurl){
        //Get image name
        if(strrchr($fileurl, '\\')){
            $fileArr = explode('\\', $fileurl);
        }else{
            $fileArr = explode('/', $fileurl);
        }
        $filename = array_reverse($fileArr)[0];
        $path = public_path('img/pages/'.$filename);
        File::delete($path);
        if(!file_exists($path)){
            return true;
        }
        return false;
    }
  }   