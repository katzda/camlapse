<?php

namespace App\Http\Controllers;

use App\Models\CamLapse;
use Illuminate\Http\Request;
use App\Http\Requests\CamLapseCreateRequest;

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
            'all' => CamLapse::all()
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
    public function show(CamLapse $camLapse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CamLapse $camLapse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CamLapse $camLapse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CamLapse $camLapse)
    {
        //
    }
}
