<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralSettingsValidationRequest;
use App\Http\Requests\CompanySettingsValidationRequest;
use App\Http\Requests\LogoUploadValidationRequest;
use App\Services\SettingsService;
use App\Models\Setting;

class SettingsController extends Controller
{
   private $settingsService;
   /**
    * Instantiate contlroller class
    * Inject SettingsService
    */
    public function __construct(SettingsService $service)
    {
      $this->settingsService = $service;
    }

    /**
     * Show settings editting form
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
       $this->authorize('isSuperadmin');

       $settings = $this->settingsService->getSettings();
       $taxOptions = $this->settingsService->getTaxOptions();
       return view('admin.settings.general', compact('settings', 'taxOptions'));
    }

    /**
     * Update General Site Settings 
     * @param  \App\Http\Requests\GeneralSettingsValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateGeneralSettings(GeneralSettingsValidationRequest $request)
    {
       $this->authorize('isSuperadmin');

       $settings = $this->settingsService->updateSettings('general');
       return redirect()->back()->with('settings', $settings)
       ->with('success_message', 'Site settings have been updated');
    }
    
    /**
     * Update Contact Settings 
     * @param  \App\Http\Requests\CompanySettingsValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateCompanySettings(CompanySettingsValidationRequest $request)
    {
       $this->authorize('isSuperadmin');
       
       $settings = $this->settingsService->updateSettings('company');
       return redirect()->back()->with('settings', $settings)
       ->with('success_message', 'Company settings have been updated');
    }

   /**
     * Uplaod/Change Site Logo
     * @param  \App\Http\Requests\LogoUploadValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function uploadLogo(LogoUploadValidationRequest $request){
         $this->authorize('isSuperadmin');

         $settings = $this->settingsService->uploadLogo();
         return back()->with('settings', $settings)
         ->with('success_message', 'Logo image has been updated.');
    }
}
