<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Requests\StorevendorRequest;
use App\Http\Requests\UpdatevendorRequest;
use App\Models\VendorBank;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

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
    public function store(Request $request)
    {

        $vendor = Vendor::create($request->all());

        $user = User::create([
            'name'=> $request->vendor_name,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);

        DB::table('model_has_roles')->insert(
            [
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => $user->id,
            ]);

        // VendorBank::create([
        //     'vendor_id' => $vendor->id,
        //     'account_no' => $request->account_no,
        //     'bank_name' => $request->bank_name,
        //     'ifsc_code' => $request->ifsc_code,
        //     'branch' => $request->branch
        // ]);

        return redirect()->route('vendor')
                ->withSuccess('New vendor is added successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor,$id)
    {
        // $VendorBank=VendorBank::where('vendor_id',$vendor->id)->first();

        $vendor=Vendor::find($id);
        return view('vendor.show', [
            'vendor' => $vendor,
            // 'VendorBank'=>$VendorBank
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
    public function destroy(Vendor $vendor,$id)
    {
        // $vendor=Vendor::find($id);
        Vendor::where('id',$id)->delete();
        // $vendor->delete();
        return redirect()->route('vendor')
                ->withSuccess('vendor is deleted successfully.');
    }
}
