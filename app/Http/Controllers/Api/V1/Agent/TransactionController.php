<?php

namespace App\Http\Controllers\Api\V1\Agent;

use App\CentralLogics\helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\EMoney;
use App\Models\RequestMoney;
use App\Models\Transaction;
use App\Models\TransactionLimit;
use App\Models\User;
use App\Models\WithdrawalMethod;
use App\Models\WithdrawRequest;
use App\Traits\TransactionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    use TransactionTrait;

    public function __construct(
        private WithdrawalMethod $withdrawalMethod,
        private WithdrawRequest $withdrawRequest,
        private User $user,
        private EMoney $eMoney,
        private RequestMoney $requestMoney
    ){}

    /**
     * CASH IN or send money
     * @param Request $request
     * @return JsonResponse
     */
    public function cashIn(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|min:4|max:4',
            'phone' => 'required',
            'amount' => 'required|min:0|not_in:0',
        ],
            [
                'amount.not_in' => translate('Amount must be greater than zero!'),
            ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $sendMoneyStatus = Helpers::get_business_settings('send_money_status');

        if (!$sendMoneyStatus)
            return response()->json(['message' => translate('send money feature is not activate')], 403);

        $receiverPhone = Helpers::filter_phone($request->phone);
        $user = $this->user->where('phone', $receiverPhone)->first();

        if (!isset($user))
            return response()->json(['message' => translate('Receiver not found')], 403);

        if($user->is_kyc_verified != 1)
            return response()->json(['message' => translate('Receiver is not verified')], 403);

        if($request->user()->is_kyc_verified != 1)
            return response()->json(['message' => translate('Complete your account verification')], 403);

        if ($request->user()->phone == $receiverPhone)
            return response()->json(['message' => translate('Transaction should not with own number')], 400);

        if($user->type != 2)
            return response()->json(['message' => translate('Receiver must be a user')], 400);

        if (!Helpers::pin_check($request->user()->id, $request->pin))
            return response()->json(['message' => translate('PIN is incorrect')], 403);

        $sendMoneyLimit = Helpers::get_business_settings('agent_send_money_limit');

        if(isset($sendMoneyLimit) && $sendMoneyLimit['status'] == 1){
            $check = Helpers::check_customer_transaction_limit($request->user(), $request['amount'], 'send_money', $sendMoneyLimit);
            if (!$check['status']){
                return response()->json(['message' => translate($check['message'])], 400);
            }
        }

        $customerTransaction = $this->cash_in_transaction($request->user()->id, Helpers::get_user_id($receiverPhone), $request['amount']);

        if(isset($sendMoneyLimit) && $sendMoneyLimit['status'] == 1){
            $transactionLimit = TransactionLimit::where(['user_id' => $request->user()->id, 'type' => 'send_money'])->first();
            $transactionLimit->user_id = $request->user()->id;
            $transactionLimit->todays_count += 1;
            $transactionLimit->todays_amount += $request['amount'];
            $transactionLimit->this_months_count += 1;
            $transactionLimit->this_months_amount += $request['amount'];
            $transactionLimit->type = 'send_money';
            $transactionLimit->updated_at = now();
            $transactionLimit->update();
        }

        if (is_null($customerTransaction)) return response()->json(['message' => translate('failed')], 501);
        return response()->json(['message' => 'success', 'transaction_id' => $customerTransaction], 200);
    }

    /**
     * Request money to admin
     * @param Request $request
     * @return JsonResponse
     */
    public function requestMoney(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|min:0|not_in:0',
            'note' => '',
        ],
            [
                'amount.not_in' => translate('Amount must be greater than zero!'),
            ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $sendMoneyRequestStatus = Helpers::get_business_settings('send_money_request_status');

        if (!$sendMoneyRequestStatus)
            return response()->json(['message' => translate('request money feature is not activate')], 403);

        $user = $this->user->where('type', 0)->first();
        $receiverPhone = $user->phone;

        if (!isset($user))
            return response()->json(['message' => 'Receiver not found'], 403);

        if($request->user()->is_kyc_verified != 1)
            return response()->json(['message' => 'Complete your account verification'], 403);

        if ($request->user()->phone == $receiverPhone)
            return response()->json(['message' => 'Transaction should not with own number'], 400);
        if($user->type !=  ADMIN_TYPE)
            return response()->json(['message' => 'Receiver must be an admin'], 400);

        $sendMoneyRequestLimit = Helpers::get_business_settings('agent_send_money_request_limit');

        if(isset($sendMoneyRequestLimit) && $sendMoneyRequestLimit['status'] == 1){
            $check = Helpers::check_customer_transaction_limit($request->user(), $request['amount'], 'send_money_request', $sendMoneyRequestLimit);
            if (!$check['status']){
                return response()->json(['message' => translate($check['message'])], 400);
            }
        }

        $requestMoney = $this->requestMoney;
        $requestMoney->from_user_id = $request->user()->id;
        $requestMoney->to_user_id = Helpers::get_user_id($receiverPhone);
        $requestMoney->type = 'pending';
        $requestMoney->amount = $request->amount;
        $requestMoney->note = $request->note;
        $requestMoney->save();

        if(isset($sendMoneyRequestLimit) && $sendMoneyRequestLimit['status'] == 1){
            $transactionLimit = TransactionLimit::where(['user_id' => $request->user()->id, 'type' => 'send_money_request'])->first();
            $transactionLimit->user_id = $request->user()->id;
            $transactionLimit->todays_count += 1;
            $transactionLimit->todays_amount += $request['amount'];
            $transactionLimit->this_months_count += 1;
            $transactionLimit->this_months_amount += $request['amount'];
            $transactionLimit->type = 'send_money_request';
            $transactionLimit->updated_at = now();
            $transactionLimit->update();
        }

        Helpers::send_transaction_notification($requestMoney->from_user_id, $request->amount, 'request_money');
        Helpers::send_transaction_notification($requestMoney->to_user_id, $request->amount, 'request_money');

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * add money from bank
     * @param Request $request
     * @return JsonResponse
     */
    public function addMoney(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'payment_method' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $addMoneyStatus = Helpers::get_business_settings('add_money_status');

        if (!$addMoneyStatus)
            return response()->json(['message' => translate('add money feature is not activate')], 403);

        if($request->user()->is_kyc_verified != 1) {
            return response()->json(['message' => 'Complete your account verification'], 403);
        }

        $amount = $request->amount;
        $bonus = Helpers::get_add_money_bonus($amount, $request->user()->id, 'agent');
        $totalAmount = $amount + $bonus;

        $adminEmoney = $this->eMoney->where('user_id', Helpers::get_admin_id())->first();
        if($adminEmoney && $totalAmount > $adminEmoney->current_balance) {
            return response()->json(['message' => translate('The amount is too big. Please contact with admin')], 403);
        }

        $addMoneyLimit = Helpers::get_business_settings('agent_add_money_limit');

        if(isset($addMoneyLimit) && $addMoneyLimit['status'] == 1){
            $check = Helpers::check_customer_transaction_limit($request->user(), $request['amount'], 'add_money', $addMoneyLimit);
            if (!$check['status']){
                return response()->json(['message' => translate($check['message'])], 400);
            }
        }

        $userId = $request->user()->id;
        $amount = $request->amount;
        $paymentMethod = $request->payment_method;
        $link = route('payment-mobile', ['user_id' => $userId, 'amount' => $amount, 'payment_method' => $paymentMethod]);
        return response()->json(['link' => $link], 200);
    }

    /**
     * filtered transaction history
     * @param Request $request
     * @return array
     */
    public function transactionHistory(Request $request): array
    {
        $limit = $request->has('limit') ? $request->limit : 10;
        $offset = $request->has('offset') ? $request->offset : 1;

        $search = $request['search'];
        $key = explode(' ', $request['search']);

        $transactions = Transaction::where('user_id', $request->user()->id);

        $transactions->when(request('transaction_type') == CASH_IN, function ($q) {
            return $q->where('transaction_type', CASH_IN);
        });
        $transactions->when(request('transaction_type') == CASH_OUT, function ($q) {
            return $q->where('transaction_type', CASH_OUT);
        });
        $transactions->when(request('transaction_type') == SEND_MONEY, function ($q) {
            return $q->where('transaction_type', SEND_MONEY);
        });
        $transactions->when(request('transaction_type') == RECEIVED_MONEY, function ($q) {
            return $q->where('transaction_type', RECEIVED_MONEY);
        });
        $transactions->when(request('transaction_type') == ADD_MONEY, function ($q) {
            return $q->where('transaction_type', ADD_MONEY);
        });

        $transactions = $transactions
            ->when($request->has('search'), function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->where('transaction_id', 'like', "%{$value}%");
                }
            })
            ->agent()
            ->where('transaction_type', '!=', ADMIN_CHARGE)
            ->orderBy("created_at", 'desc')
            ->paginate($limit, ['*'], 'page', $offset);

        $transactions = TransactionResource::collection($transactions);

        return [
            'total_size' => $transactions->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'transactions' => $transactions->items()
        ];
    }

    /**
     * @return JsonResponse
     */
    public function withdrawalMethods(): JsonResponse
    {
        $withdrawalMethods = $this->withdrawalMethod->latest()->get();
        return response()->json(response_formatter(DEFAULT_200, $withdrawalMethods, null), 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function withdraw(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|min:4|max:4',
            'amount' => 'required|min:0|not_in:0',
            'note' => 'max:255',
            'withdrawal_method_id' => 'required',
            'withdrawal_method_fields' => 'required',
        ],
            [
                'amount.not_in' => translate('Amount must be greater than zero!'),
            ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $withdrawRequestStatus = Helpers::get_business_settings('withdraw_request_status');

        if (!$withdrawRequestStatus)
            return response()->json(['message' => translate('withdraw request feature is not activate')], 403);

        if($request->user()->is_kyc_verified != 1) {
            return response()->json(['message' => translate('Your account is not verified, Complete your account verification')], 403);
        }

        $withdrawalMethod = $this->withdrawalMethod->find($request->withdrawal_method_id);
        $fields = array_column($withdrawalMethod->method_fields, 'input_name');

        $values = (array)json_decode(base64_decode($request->withdrawal_method_fields))[0];

        foreach ($fields as $field) {
            if(!key_exists($field, $values)) {
                return response()->json(response_formatter(DEFAULT_400, $fields, null), 400);
            }
        }

        $withdrawRequestLimit = Helpers::get_business_settings('agent_withdraw_request_limit');

        if(isset($withdrawRequestLimit) && $withdrawRequestLimit['status'] == 1){
            $check = Helpers::check_customer_transaction_limit($request->user(), $request['amount'], 'withdraw_request', $withdrawRequestLimit);
            if (!$check['status']){
                return response()->json(['message' => translate($check['message'])], 400);
            }
        }

        $amount = $request->amount;
        $charge = helpers::get_withdraw_charge($amount);
        $totalAmount = $amount + $charge;

        $withdrawRequest = $this->withdrawRequest;
        $withdrawRequest->user_id = $request->user()->id;
        $withdrawRequest->amount = $amount;
        $withdrawRequest->admin_charge = $charge;
        $withdrawRequest->request_status = 'pending';
        $withdrawRequest->is_paid = 0;
        $withdrawRequest->sender_note = $request->sender_note;
        $withdrawRequest->withdrawal_method_id = $request->withdrawal_method_id;
        $withdrawRequest->withdrawal_method_fields = $values;


        $agentEmoney = $this->eMoney->where('user_id', $request->user()->id)->first();
        if ($agentEmoney->current_balance < $totalAmount) {
            return response()->json(['message' => translate('Your account do not have enough balance')], 403);
        }

        $agentEmoney->current_balance -= $totalAmount;
        $agentEmoney->pending_balance += $totalAmount;

        DB::transaction(function () use ($withdrawRequest, $agentEmoney) {
            $withdrawRequest->save();
            $agentEmoney->save();
        });

        if(isset($withdrawRequestLimit) && $withdrawRequestLimit['status'] == 1){
            $transactionLimit = TransactionLimit::where(['user_id' => $request->user()->id, 'type' => 'withdraw_request'])->first();
            $transactionLimit->user_id = $request->user()->id;
            $transactionLimit->todays_count += 1;
            $transactionLimit->todays_amount += $request['amount'];
            $transactionLimit->this_months_count += 1;
            $transactionLimit->this_months_amount += $request['amount'];
            $transactionLimit->type = 'withdraw_request';
            $transactionLimit->updated_at = now();
            $transactionLimit->update();
        }

        return response()->json(response_formatter(DEFAULT_STORE_200, null, null), 200);
    }
}
