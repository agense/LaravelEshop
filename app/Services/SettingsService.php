<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use App\Services\ImageUploader;
use App\Models\Setting;

class SettingsService {

    /**
     * Return all site settings
     * @return App\Models\Setting;
     */
    public function getSettings()
    {
        try{
            return Setting::firstOrFail();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Return tax inclusion options for settings
     * @return Array
     */
    public function getTaxOptions()
    {
        return Setting::taxInclusionOptions();
    }
    
    /**
     * Updates app settings in DB
     * @param String $type (Type options: 'general','company') - defines which settigs to update
     * @return App\Model\Settings
     */
    public function updateSettings(String $type){
        try{
            $settings = Setting::firstOrFail();
            $dataList = $this->setSettingsType($type);
            $settings->fill(request()->only($dataList));
            $settings->save();
            return $settings;
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Sets the type of settings to be updated - helper function
     * @param String $type
     * @return Array
     */
    private function setSettingsType(String $type){
        if($type == 'general'){
           return Setting::getSiteSettings();
        }elseif($type == 'company'){
            return Setting::getCompanySettings();
        }else{
            abort(400, 'Settings type not recognized');
        }
    }

    /**
     * Uploads app logo
     * @return App\Model\Settings
     */
    public function uploadLogo(){
        try{
            $settings = Setting::firstOrFail();

            $uploader = new ImageUploader();
            $uploader->setUploadDimensions(100, 100);
            $uploader->upload(request()->logo, 'logo_');
            //Delete previous logo (except app default)
            if($settings->logo !== 'logo-default.png'){
                $uploader->delete($settings->logo);
            }
            $settings->logo = $uploader->getFilename();
            $settings->save();
            return $settings;
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

}