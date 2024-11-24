<?php

namespace App\Http\Controllers;

use App\Models\CameraDevice;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.index', [
            "devices" => CameraDevice::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        CameraDevice::refreshDevices();
        return redirect(route('home'));
    }
}
