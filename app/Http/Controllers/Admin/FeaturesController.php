<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FeatureValidationRequest;
use App\Http\Requests\FeatureOptionValidationRequest;
use App\Http\Resources\FeatureResource;
use App\Services\FeatureService;
use App\Models\Feature;

class FeaturesController extends Controller
{  
    private $featureService;

    /**
     * Instantiate controller class
     * Inject FeatureService
     */
    public function __construct(FeatureService $service)
    {
        $this->featureService = $service;
    }

    /**
     * Display a listing of all features
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = $this->featureService->getAll();
        return view('admin.features.index', compact('features'));
    }

    /**
     * Store a newly created feature in DB.
     *
     * @param  \App\Http\Requests\FeatureValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeatureValidationRequest $request)
    {
        $feature = $this->featureService->create();
        session()->flash('success_message', 'Feature has been created.');
        return response()->json($feature, 201);
    }

    /**
     * Return specific feature data for editing
     *
     * @param  \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return response()->json(new FeatureResource($feature));
    }

    /**
     * Update the specified feature in DB
     *
     * @param  \App\Http\Requests\FeatureValidationRequest $request
     * @param  \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function update(FeatureValidationRequest $request, Feature $feature)
    {
        $feature = $this->featureService->update($feature);
        session()->flash('success_message', 'Feature has been updated.');
        return response()->json($feature, 200);
    }

    /**
     * Remove the specified feature from DB.
     *
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        $this->featureService->delete($feature);
        return redirect()->route('admin.features.index')->with('success_message', 'Feature has been deleted');
    }

    /**
     * Add an option to specific features options array
     * @param \App\Http\Requests\FeatureOptionValidationRequest $request
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function addOption(FeatureOptionValidationRequest $request, Feature $feature)
    {
        $feature = $this->featureService->addOption($feature);
        return response()->json($feature, 200);
    }

    /**
     * Delete an option from specific features options array
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function deleteOption(Request $request, Feature $feature)
    {
        $feature = $this->featureService->deleteOption($feature);
        return response()->json($feature, 200);
    }
}
