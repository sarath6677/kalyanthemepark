<?php

namespace App\Http\Controllers;

//use App\Model\Order;
use App\Lib\Payer;
use App\Models\User;
use App\Lib\Receiver;
use App\Models\EMoney;
use Illuminate\Http\Request;
use App\CentralLogics\helpers;
use App\Lib\Payment as Payment;
use App\Models\BusinessSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use App\Traits\Payment as PaymentTrait;
use Illuminate\Contracts\Foundation\Application;

class PaymentController extends Controller
{
    public function __construct(
        private EMoney $eMoney,
        private User $user
    ){}

    /**
     * @param Request $request
     * @return JsonResponse|Redirector|RedirectResponse|Application
     */
    public function payment(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        $unUsedMoney = $this->eMoney->with('user')->whereHas('user', function ($q) {
            $q->where('type', '=', ADMIN_TYPE);
        })->sum('current_balance');

        if($request->amount > $unUsedMoney) {
            Toastr::error(translate('The requested amount is too big'));
        }

        if (session()->has('payment_method') == false) {
            session()->put('payment_method', 'ssl_commerz');
        }

        session()->put('amount', $request->amount);
        session()->put('user_id', $request['user_id']);

        $user = $this->user->where('type', '!=', 0)->find($request['user_id']);


        if (isset($user)) {
            $additionalData = [
                'business_name' => BusinessSetting::where(['key' => 'business_name'])->first()->value,
                'business_logo' => asset('storage/app/public/business') . '/' . BusinessSetting::where(['key' => 'logo'])->first()->value,
            ];

            $payer = new Payer($user['f_name'].' '.$user['l_name'], $user['email'], $user['phone'], '');
            $paymentInfo = new Payment(
                success_hook: 'digital_payment_success',
                failure_hook: 'digital_payment_fail',
                currency_code: Helpers::currency_code(),
                payment_method: $request->payment_method,
                payment_platform: $request->payment_platform,
                payer_id: $user->id,
                receiver_id: null,
                additional_data: $additionalData,
                payment_amount: $request->amount,
                external_redirect_link: $request['callback'] ?? null,
                attribute: 'order',
                attribute_id: time()
            );

            $receiverInfo = new Receiver('receiver_name', 'example.png');
            $redirectLink = PaymentTrait::generate_link($payer, $paymentInfo, $receiverInfo);

            return redirect($redirectLink);
        }

        return response()->json(['errors' => ['code' => 'order-payment', 'message' => 'Data not found']], 403);

    }

    /**
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function success(): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (session()->has('callback')) {
            return redirect(session('callback') . '/success');
        }
        return response()->json(['message' => 'Payment succeeded'], 200);
    }

    /**
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function fail(): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (session()->has('callback')) {
            return redirect(session('callback') . '/fail');
        }
        return response()->json(['message' => 'Payment failed'], 403);
    }
}
