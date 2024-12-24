<?php

namespace App\Http\Controllers;

use App\Models\JobMeta;
use App\Models\Camlapse;
use App\Models\HardwareModel;
use App\Http\Requests\Camlapse\CamlapseEditRequest;
use App\Http\Requests\Camlapse\CamlapseCreateRequest;

class CamlapseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lapseModels = Camlapse::all();
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
            'camlapse' => new Camlapse(),
            'devices' => HardwareModel::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CamlapseCreateRequest $request)
    {
        Camlapse::create($request->validated());

        return redirect(route('camlapse.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Camlapse $camlapse)
    {
        return View('camlapse.show', [
            'camlapse' => $camlapse
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camlapse $camlapse)
    {
        return View('camlapse.edit', [
            'camlapse' => $camlapse,
            'devices' => HardwareModel::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CamlapseEditRequest $request, Camlapse $camlapse)
    {
        $camlapse->update($request->validated());

        return redirect(route('camlapse.show', [
            'camlapse' => $camlapse
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camlapse $camlapse)
    {
        $dir = public_path('timelapse/' . $camlapse->id);

        shell_exec("rm -rf $dir");

        JobMeta::where('camlapse_id', '=', $camlapse->id)->delete();
        $camlapse->delete();
        return redirect(route('camlapse.index'));
    }

    public function activate(Camlapse $camlapse)
    {
        Camlapse::deactivateAll();
        $camlapse->activate();
        return redirect(route('camlapse.index'));
    }

    public function deactivate(Camlapse $camlapse)
    {
        $camlapse->deactivate();
        return redirect(route('camlapse.index'));
    }
}
