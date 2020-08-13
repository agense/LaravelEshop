<?php
namespace App\Services;
use DOMDocument;  // using PHP's built-in DOMDocument() class to extract images out of summernote content
use Image; //intervention image class
use File;
use Purifier;
use App\Services\ImageUploader;
use App\Models\Page;

class EditorContentProcessor
{
    private $uploader;
    private $path;
    private $errors = [];

    public function __construct()
    {
        $this->path = Page::getImageUploadPath();
        $this->uploader = new ImageUploader($this->path, 1080, 750);
    }
    /**
     * Decodes editor content for display
     * @param String $content
     * @return String decoded content 
     */
    public function decodeContent($content)
    {
        return htmlspecialchars_decode($content);
    }

     /**
     * Process Summernote text editor content with images for upload
     * @param String $content
     * @return String purified and html entities encoded $content 
     */
    public function processContent($content)
    {
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
                if($this->checkBase64Format($src)){  
                    $originalName = $img->getAttribute('data-filename');
                    //change the current image src (i.e. the base 64) to the uploaded file name
                    $this->uploader->uploadBase64($src, 'page_image_', $originalName);
                    $uploadedFileName = $this->path.$this->uploader->getFileName();
                    $imgUrl = $uploadedFileName;
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
     * @param String $fileUrl full url
     * @return Bool 
    */
    public function deleteEditorImage($fileurl)
    {
        //Get image name
        if(strrchr($fileurl, '\\')){
            $fileArr = explode('\\', $fileurl);
        }else{
            $fileArr = explode('/', $fileurl);
        }
        $filename = array_reverse($fileArr)[0];
        return $this->uploader->delete($filename);
    }

    /**
     * Delete all page images embedded in Summernote text editor content
     * @param String $content
     * @return Void
    */
    public function deleteAllImages($content)
    {
        $images = [];
        $dom = new DOMDocument();
        $dom->loadHTML($this->decodeContent($content));
        $tags= $dom->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $images[] =  $tag->getAttribute('src');
        }
        if(count($images) > 0){
            foreach($images as $img){
                $this->deleteEditorImage($img);
            }
        }
    }
    
    /**
     * Check if an image is in base 64 format, i.e. if the img source is 'data-url'
     * @param String $src = base64 formatted image
     * @return Bool
    */
    private function checkBase64Format($src)
    {
        if(preg_match('/data:image/', $src)){  
            return true;
        }
        return false;
    }

}