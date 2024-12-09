<?php

namespace App\Http\Controllers;

use App\Models\HardwareModel;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hardware.index', [
            "devices" => HardwareModel::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function autoUpdate(Request $request)
    {
        HardwareModel::refreshDevices();
        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     */
    public function show(HardwareModel $cameraDevice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HardwareModel $cameraDevice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HardwareModel $cameraDevice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HardwareModel $cameraDevice)
    {
        //
    }
}
