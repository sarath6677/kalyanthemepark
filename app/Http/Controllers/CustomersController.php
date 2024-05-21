<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Http\Requests\user\StoreCustomersRequest;
use App\Http\Requests\user\UpdateCustomersRequest;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers =  Customers::latest()->paginate(10);

        return view('users.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomersRequest $request)
    {
        Customers::create([
            'customer_name' => $request->customer_name,
            'mobile_numer' => $request->mobile_numer,
            'address' => $request->address,
            'card_amount' => $request->card_amount,
        ]);

        return redirect(route('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customers $customers)
    {
        return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customers $customers)
    {
        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomersRequest $request, Customers $customers)
    {
        return redirect()->route('user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customers $customers)
    {

        return redirect()->route('user');
    }
}
