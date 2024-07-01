<?php

namespace App\Http\Controllers\Merchant;

use App\Models\NfcRecharge;
use App\CentralLogics\helpers;
use App\Models\User;
use App\Models\EMoney;
use App\Models\NfcCard;
use App\Models\Products;
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
        private EMoney         $eMoney,
        private Products    $Products
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
        $products = $this->Products->where('vendor_id',auth()->user()->id)->get();

        return view('merchant-views.recharge.index', compact('products'));
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
        return view('merchant-views.recharge.list', compact('nfcRecharges', 'search'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'card_id' => 'required',
            'amount' => 'required',
        ],[
            'card_id.required' => 'Please tap a card',
        ]);

        $card = NfcCard::where('card_id', $request->card_id)->first();
            if (empty($card)) {
                Toastr::warning(translate('Please add a Card for Customer'));
                return back();
            }

            if (!empty($card) && $card->balance < $request->amount) {
                Toastr::warning('Insufficient balance -'.$card->balance);
                return back();
            }

        DB::transaction(function () use ($request) {
            $card = NfcCard::where('card_id', $request->card_id)->first();
            $card->balance -= $request->amount;
            $card->save();

            $this->customer_deduct_nfc_money_transaction($card->user_id, auth()->user()->id , $card->balance ,$request->amount);

        });

        Toastr::success(translate('Money Deducted Successfully!'));
        return redirect(route('vendor.recharge.add'));
    }

    public function getProduct($pId){
        $products = $this->Products->where('id',$pId)->first();

        return $products->price;
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
