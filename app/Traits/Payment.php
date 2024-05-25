<?php

namespace App\Traits;

use InvalidArgumentException;
use App\Models\PaymentRequest;

trait Payment
{
    public static function generate_link(object $payer, object $payment_info, Object $receiver)
    {
        if ($payment_info->getPaymentAmount() === 0) {
            throw new InvalidArgumentException('Payment amount can not be 0');
        }

        if (!in_array(strtoupper($payment_info->getCurrencyCode()), array_column(GATEWAYS_CURRENCIES, 'code'))) {
            throw new InvalidArgumentException('Need a valid currency code');
        }

        if (!in_array($payment_info->getPaymentMethod(), array_column(GATEWAYS_PAYMENT_METHODS, 'key'))) {
            throw new InvalidArgumentException('Need a valid payment gateway');
        }

        if (!is_array($payment_info->getAdditionalData())) {
            throw new InvalidArgumentException('Additional data should be in a valid array');
        }

        $payment = new PaymentRequest();
        $payment->payment_amount = $payment_info->getPaymentAmount();
        $payment->success_hook = $payment_info->getSuccessHook();
        $payment->failure_hook = $payment_info->getFailureHook();
        $payment->payer_id = $payment_info->getPayerId();
        $payment->receiver_id = $payment_info->getReceiverId();
        $payment->currency_code = strtoupper($payment_info->getCurrencyCode());
        $payment->payment_method = $payment_info->getPaymentMethod();
        $payment->additional_data = json_encode($payment_info->getAdditionalData());
        $payment->payer_information = json_encode($payer->information());
        $payment->receiver_information = json_encode($receiver->information());
        $payment->external_redirect_link = $payment_info->getExternalRedirectLink();
        $payment->attribute = $payment_info->getAttribute();
        $payment->attribute_id = $payment_info->getAttributeId();
        $payment->payment_platform = $payment_info->getPaymentPlatForm();
        $payment->save();

        // Define the payment method to URL mapping
        $paymentMethodUrls = [
            'ssl_commerz' => 'payment/sslcommerz/pay',
            'stripe' => 'payment/stripe/pay',
            'paymob_accept' => 'payment/paymob/pay',
            'flutterwave' => 'payment/flutterwave-v3/pay',
            'paytm' => 'payment/paytm/pay',
            'paypal' => 'payment/paypal/pay',
            'paytabs' => 'payment/paytabs/pay',
            'liqpay' => 'payment/liqpay/pay',
            'razor_pay' => 'payment/razor-pay/pay',
            'senang_pay' => 'payment/senang-pay/pay',
            'mercadopago' => 'payment/mercadopago/pay',
            'bkash' => 'payment/bkash/make-payment',
            'paystack' => 'payment/paystack/pay',
            'fatoorah' => 'payment/fatoorah/pay',
            'xendit' => 'payment/xendit/pay',
            'amazon_pay' => 'payment/amazon/pay',
            'iyzi_pay' => 'payment/iyzipay/pay',
            'hyper_pay' => 'payment/hyperpay/pay',
            'foloosi' => 'payment/foloosi/pay',
            'ccavenue' => 'payment/ccavenue/pay',
            'pvit' => 'payment/pvit/pay',
            'moncash' => 'payment/moncash/pay',
            'thawani' => 'payment/thawani/pay',
            'tap' => 'payment/tap/pay',
            'viva_wallet' => 'payment/viva/pay',
            'hubtel' => 'payment/hubtel/pay',
            'maxicash' => 'payment/maxicash/pay',
            'esewa' => 'payment/esewa/pay',
            'swish' => 'payment/swish/pay',
            'momo' => 'payment/momo/pay',
            'payfast' => 'payment/payfast/pay',
            'worldpay' => 'payment/worldpay/pay',
            'sixcash' => 'payment/sixcash/pay',
        ];

        // Check if the payment method exists in the mapping
        $paymentMethod = $payment->payment_method;

        if (array_key_exists($paymentMethod, $paymentMethodUrls)) {
            // Construct the payment URL
            $paymentUrl = url("{$paymentMethodUrls[$paymentMethod]}/?payment_id={$payment->id}");

            // Redirect to the payment URL or perform any other necessary action
            return $paymentUrl;
        } else {
            return false;
        }
    }
}
