<?php

namespace App\Http\Controllers;

use App\Models\CamLapse;
use App\Http\Requests\CamLapseEditRequest;
use App\Http\Requests\CamLapseCreateRequest;
use App\Models\CameraDevice;

class CamLapseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return View('camlapse.index', [
            'all' => CamLapse::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View('camlapse.create', [
            'camlapse' => new CamLapse(),
            'devices' => CameraDevice::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CamLapseCreateRequest $request)
    {
        CamLapse::create($request->validated());

        return View('camlapse.index', [
            'all' => CamLapse::all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CamLapse $camlapse)
    {
        return View('camlapse.show', [
            'camlapse' => $camlapse
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CamLapse $camlapse)
    {
        return View('camlapse.edit', [
            'camlapse' => $camlapse,
            'devices' => CameraDevice::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CamLapseEditRequest $request, CamLapse $camlapse)
    {
        $camlapse->update($request->validated());

        return redirect(route('camlapse.show', [
            'camlapse' => $camlapse
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CamLapse $camlapse)
    {
        $camlapse->delete();
        return redirect(route('camlapse.index'));
    }

    public function activate(CamLapse $camlapse)
    {
        CamLapse::deactivateAll();
        $camlapse->activate();
        return redirect(route('camlapse.index'));
    }

    public function deactivate(CamLapse $camlapse)
    {
        $camlapse->deactivate();
        return redirect(route('camlapse.index'));
    }
}
