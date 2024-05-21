<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Http\Requests\zone\StoreZoneRequest;
use App\Http\Requests\zone\UpdateZoneRequest;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::latest()->paginate(10);

        return view('zone.index',compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('zone.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZoneRequest $request)
    {
        Zone::create([
            'zone_name' => $request->zone_name
        ]);
        return redirect()->route('zone');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        return view('zone.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        return view('zone.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateZoneRequest $request, Zone $zone)
    {
        return redirect()->route('zone');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        return redirect()->route('zone');
    }
}
