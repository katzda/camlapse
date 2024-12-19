<?php

namespace App\Http\Controllers;

use App\Models\LapseModel;
use App\Models\HardwareModel;
use App\Http\Requests\LapseModel\LapseModelEditRequest;
use App\Http\Requests\LapseModel\LapseModelCreateRequest;

class LapseModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lapseModels = LapseModel::all();
        $lapses = [];
        foreach($lapseModels as $index => $lapseModel)
        {
            $videoPath = public_path('timelapse/'.$lapseModel['id'].'/video.mp4');

            $lastModified = "";
            if (file_exists($videoPath)) {
                $lastModified = filemtime($videoPath);
                $videoPath .= '?v=' . $lastModified;
            }

            $lapses[] = [
                'id' => $lapseModel['id'],
                'lastModified' => $lastModified,
                'name' => $lapseModel['name'],
                'cron' => $lapseModel->cron,
                'is_active' => $lapseModel['is_active'],
            ];
        };

        return View('camlapse.index', [
            'camlapses' => $lapses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View('camlapse.create', [
            'camlapse' => new LapseModel(),
            'devices' => HardwareModel::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LapseModelCreateRequest $request)
    {
        LapseModel::create($request->validated());

        return View('camlapse.index', [
            'all' => LapseModel::all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(LapseModel $camlapse)
    {
        return View('camlapse.show', [
            'camlapse' => $camlapse
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LapseModel $camlapse)
    {
        return View('camlapse.edit', [
            'camlapse' => $camlapse,
            'devices' => HardwareModel::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LapseModelEditRequest $request, LapseModel $camlapse)
    {
        $camlapse->update($request->validated());

        return redirect(route('camlapse.show', [
            'camlapse' => $camlapse
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LapseModel $camlapse)
    {
        $camlapse->delete();
        return redirect(route('camlapse.index'));
    }

    public function activate(LapseModel $camlapse)
    {
        LapseModel::deactivateAll();
        $camlapse->activate();
        return redirect(route('camlapse.index'));
    }

    public function deactivate(LapseModel $camlapse)
    {
        $camlapse->deactivate();
        return redirect(route('camlapse.index'));
    }
}
