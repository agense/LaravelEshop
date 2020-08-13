<?php
namespace App\Services;
use Image; //intervention image class
use File;

class ImageUploader
{
  private $path;
  private $imageWidth;
  private $imageHeight;
  private $uploadLocation;
  protected $uploadedFileName;

  public function __construct($path = 'img/', $imageWidth = 640, $imageHeight = 480)
  {
    $this->path = $path;
    $this->imageWidth = $imageWidth;
    $this->imageHeight = $imageHeight;
  }

   /**
     * Set upload dimensions via setter
     * @param Int $imageWidth
     * @param Int $imageHeight
     * @return Void
     */
    public function setUploadDimensions(Int $imageWidth, Int $imageHeight)
    {
      $this->imageWidth = $imageWidth;
      $this->imageHeight = $imageHeight;
    }
    /**
     * Set upload path via setter
     * @param String $path
     * @return Void
     */
    public function setUploadPath(String $path)
    {
      $this->path = $path;
    }

  /** 
  * Upload a single image 
  * @param UploadedFile class
  * @param String $prefix - custom name prefix
  * @return Function 
  */
  public function upload($image, String $prefix = '')
  {
      $ext = $image->getClientOriginalExtension();
      $filename = $prefix.'image_'.uniqid().'.'.$ext;
      $this->uploadLocation = public_path($this->path.$filename);
      return self::imageUpload($image, $filename);
  }

    /**
     * Delete Image 
     * @param  String $img 
     * @return Bool
     */
    public function delete(String $img)
    {
      if($this->fileExists($img)){
        if(!File::delete(public_path($this->path.$img))){
          return false;
        }
      }
      return true;
   }

    /**
     * BASE 64 IMAGE UPLOADER
     * @param String base64 encoded image
     * @param String $prefix 
     * @param String $originalName (optional) - uploadable files original name
     * @return Function
     */
    public function uploadBase64(String $image, String $prefix = 'image_', String $originalName = null)
    {
      $mimetype  = mime_content_type ($image);
      $ext = explode('/', $mimetype)[1];

      //create file name and upload location
      $filename = $prefix.uniqid().'.'.$ext;
      $filePath = $this->path.$filename;
      //set upload path 
      $this->uploadLocation = public_path($filePath);
      return self::imageUpload($image, $filename, $originalName);
    }

    /**
     * Return uploaded file name
     * @return String 
     */
    public function getFileName()
    {
      return $this->uploadedFileName;
    }

    /**
     * Check if file exists in filesystem
     * @param String $img
     * @return Bool
     */
    private function fileExists(String $img)
    {
      return file_exists(public_path($this->path.$img));
    }

    /**
    * Resize Images To a specified size
    */
    private function defaultResize($img)
    {
      if($img->width() > $this->imageWidth){
        $img->resize($this->imageWidth, null, function ($constraint) {
            $constraint->aspectRatio();
        });
      }elseif($img->height() > $this->imageHeight){
          $img->resize(null, $this->imageHeight, function ($constraint) {
              $constraint->aspectRatio();
          });
      }
      return $img;
    }

    /**
     * Uploads and resizes the image
     * @param $image
     * @param String $filename - name to give a file when uploading
     * @param String $originalName (optional) - uploadable files original name
     * @return void
     */
    private function imageUpload($image, $filename, $originalName = null)
    {
      try{
        $img = Image::make($image);
        $img = self::defaultResize($img);
        $img->save($this->uploadLocation);
        $this->uploadedFileName = $filename;
      }catch(\Exception $e){
        $message = $originalName == null ? 'Image Upload Failed' : 'Image '.$originalName. ' cannot be uploaded.';
        abort(400, $message);
      }
    }

}