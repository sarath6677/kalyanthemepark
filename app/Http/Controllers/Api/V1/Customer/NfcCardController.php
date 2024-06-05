<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Models\NfcCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\TransactionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NfcCardController extends Controller
{
    use TransactionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCardMoney()
    {
        $card = NfcCard::find('user_id',$request->user()->id);

        return response()->json(['success' => true, 'balance' => $card->balance], 200);
    }

    public function addMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'card_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $card = NfcCard::firstOrCreate(['card_id' => $request->card_id], ['user_id' => $request->user()->id]);
        $card->balance += $request->amount;
        $card->save();

        $customerTransaction = $this->customer_add_nfc_money_transaction($request->user()->id, $card->balance ,$request->amount);

        if (is_null($customerTransaction)) return response()->json(['message' => translate('fail')], 501);

        return response()->json(['success' => true, 'balance' => $card->balance], 200);
    }

    public function deductMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'card_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $card = NfcCard::where('card_id', $request->card_id)->first();
        if (!$card || $card->balance < $request->amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance'], 400);
        }

        $card->balance -= $request->amount;
        $card->save();

        $customerTransaction = $this->customer_deduct_nfc_money_transaction($request->user()->id, 11 , $card->balance ,$request->amount);

        if (is_null($customerTransaction)) return response()->json(['message' => translate('fail')], 501);

        return response()->json(['success' => true, 'balance' => $card->balance], 200);
    }
}