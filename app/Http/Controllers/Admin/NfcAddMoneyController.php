<?php

namespace App\Http\Controllers\Admin;

use App\Models\NfcAddMoney;
use App\CentralLogics\helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class NfcAddMoneyController extends Controller
{

    public function __construct(
        private NfcAddMoney    $nfcAddMoney
    )
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nfcAddMoney = $this->nfcAddMoney;
        $nfcAddMoney = $nfcAddMoney->latest()->paginate(Helpers::pagination_limit());
        return view('admin-views.add-money.index', compact('nfcAddMoney'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-views.add-money.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'cashback_amount' => 'required',
        ]);

        $nfcAddMoney = $this->nfcAddMoney;
        $nfcAddMoney->cashback_amount = $request->cashback_amount;
        $nfcAddMoney->amount = $request->amount;
        $nfcAddMoney->save();

        Toastr::success(translate('Money List Added Successfully!'));
        return redirect(route('admin.add-money.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NfcAddMoney  $nfcAddMoney
     * @return \Illuminate\Http\Response
     */
    public function show(NfcAddMoney $nfcAddMoney)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NfcAddMoney  $nfcAddMoney
     * @return \Illuminate\Http\Response
     */
    public function edit(NfcAddMoney $nfcAddMoney)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NfcAddMoney  $nfcAddMoney
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NfcAddMoney $nfcAddMoney)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NfcAddMoney  $nfcAddMoney
     * @return \Illuminate\Http\Response
     */
    public function destroy(NfcAddMoney $nfcAddMoney)
    {
        //
    }
}
