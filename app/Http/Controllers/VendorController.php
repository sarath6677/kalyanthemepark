<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Requests\StorevendorRequest;
use App\Http\Requests\UpdatevendorRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $vendors = Vendor::get();
        // return view('vendor.index',compact('vendors'));

        return view('vendor.index', [
            'vendors' => Vendor::latest()->paginate(10)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorevendorRequest $request)
    {

        Vendor::create($request->all());
        return redirect()->route('vendor.index')
                ->withSuccess('New vendor is added successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        return view('vendor.show', [
            'vendor' => $vendor
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatevendorRequest $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendor.index')
                ->withSuccess('vendor is deleted successfully.');
    }
}
