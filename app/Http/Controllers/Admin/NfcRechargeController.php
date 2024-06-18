<?php

namespace App\Http\Controllers\Admin;

use App\Models\NfcRecharge;
use App\CentralLogics\helpers;
use App\Models\User;
use App\Models\EMoney;
use App\Models\NfcCard;
use Illuminate\Http\Request;
use App\Traits\TransactionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class NfcRechargeController extends Controller
{
    use TransactionTrait;

    public function __construct(
        private User           $user,
        private NfcRecharge           $nfcRecharge,
        private EMoney         $eMoney
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
        $customers = $this->user->where(['type' => CUSTOMER_TYPE])->get();

        return view('admin-views.recharge.index', compact('customers'));
    }

        /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function list(Request $request): Factory|View|Application
    {
        $queryParam = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $nfcRecharges = $this->nfcRecharge->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $queryParam = ['search' => $request['search']];
        } else {
            $nfcRecharges = $this->nfcRecharge;
        }

        $nfcRecharges = $nfcRecharges->with('user')->latest()->paginate(Helpers::pagination_limit())->appends($queryParam);
        return view('admin-views.recharge.list', compact('nfcRecharges', 'search'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required',
            'amount' => 'required',
        ],[
            'customer_id.required' => 'Please select customer',
        ]);

        $card = NfcCard::where('user_id', $request->customer_id)->first();
            if (empty($card)) {
                Toastr::warning(translate('Please add NFC Card'));
                return back();
            }

        DB::transaction(function () use ($request) {
            $card = NfcCard::where('user_id', $request->customer_id)->first();
            $card->balance += $request->amount;
            $card->save();

            $nfcRecharge = $this->nfcRecharge;
            $nfcRecharge->user_id = $request->customer_id;
            $nfcRecharge->card_id = $card->card_id;
            $nfcRecharge->amount = $request->amount;
            $nfcRecharge->save();

            $this->customer_add_nfc_money_transaction($request->customer_id, $card->balance ,$request->amount);

        });

        Toastr::success(translate('Recharge Added Successfully!'));
        return redirect(route('admin.recharge.list'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NfcRecharge  $nfcRecharge
     * @return \Illuminate\Http\Response
     */
    public function show(NfcRecharge $nfcRecharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NfcRecharge  $nfcRecharge
     * @return \Illuminate\Http\Response
     */
    public function edit(NfcRecharge $nfcRecharge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NfcRecharge  $nfcRecharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NfcRecharge $nfcRecharge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NfcRecharge  $nfcRecharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(NfcRecharge $nfcRecharge)
    {
        //
    }
}
