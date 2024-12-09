<?php

namespace App\Http\Controllers;

use App\Http\Requests\HardwareModel\ShowHardwareSettingsRequest;
use App\Models\HardwareModel;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowHardwareSettingsRequest $request)
    {
        $validated = $request->validated();

        return view('settings.index', [
            "device" => HardwareModel::find($validated['hardware_id'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HardwareModel $model)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HardwareModel $model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HardwareModel $model)
    {
        //
    }
}
