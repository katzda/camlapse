<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HardwareModel;
use App\Http\Requests\HardwareModel\ShowHardwareSettingsRequest;

class ShootingController extends Controller
{
    public function Snapshot(ShowHardwareSettingsRequest $request)
    {
        $validated = $request->validated();
        $hardware = HardwareModel::find($validated['hardware_id']);


    }
}
