<?php

use App\Http\Controllers\Api\V1\Agent\AgentController;
use App\Http\Controllers\Api\V1\Customer\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Customer\WithdrawController;
use App\Http\Controllers\Api\V1\Agent\AgentWithdrawController;
use App\Http\Controllers\Api\V1\Agent\Auth\PasswordResetController as AgentPasswordResetController;
use App\Http\Controllers\Api\V1\Agent\TransactionController as AgentTransactionController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\ConfigController;
use App\Http\Controllers\Api\V1\Customer\Auth\CustomerAuthController;
use App\Http\Controllers\Api\V1\Customer\TransactionController;
use App\Http\Controllers\Api\V1\Customer\NfcCardController;
use App\Http\Controllers\Api\V1\GeneralController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\OTPController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Payment\Api\PaymentOrderController;
use App\Http\Controllers\Api\V1\Agent\Auth\AgentAuthController;
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Api\V1'], function () {

    Route::group(['middleware' => ['deviceVerify']], function () {
        Route::group(['middleware' => ['inactiveAuthCheck', 'trackLastActiveAt', 'auth:api']], function () {
            Route::post('check-customer', [GeneralController::class, 'checkCustomer']);
            Route::post('check-agent', [GeneralController::class, 'checkAgent']);

        });

        Route::group(['prefix' => 'customer', 'namespace' => 'Auth'], function () {

            Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
                Route::post('register', [RegisterController::class, 'customerRegistration']);
                Route::post('login', [LoginController::class, 'customerLogin']);

                Route::post('check-phone', [CustomerAuthController::class, 'checkPhone']);
                Route::post('verify-phone', [CustomerAuthController::class, 'verifyPhone']);
                Route::post('resend-otp', [CustomerAuthController::class, 'resendOTP']);

                Route::post('forgot-password', [PasswordResetController::class, 'resetPasswordRequest']);
                Route::post('verify-token', [PasswordResetController::class, 'verifyToken']);
                Route::put('reset-password', [PasswordResetController::class, 'resetPasswordSubmit']);
            });

            Route::group(['middleware' => ['inactiveAuthCheck', 'trackLastActiveAt', 'auth:api', 'customerAuth', 'checkDeviceId']], function () {
                Route::get('get-customer', [CustomerAuthController::class, 'getCustomer']);
                Route::get('get-purpose', [CustomerAuthController::class, 'getPurpose']);
                Route::get('get-banner', [BannerController::class, 'getCustomerBanner']);
                Route::get('linked-website', [CustomerAuthController::class, 'linkedWebsite']);
                Route::post('nfc-money', [NfcCardController::class, 'getCardMoney']);
                Route::post('nfc-add-money', [NfcCardController::class, 'addMoney']);
                Route::post('nfc-deduct-money', [NfcCardController::class, 'deductMoney']);
                Route::get('get-notification', [NotificationController::class, 'getCustomerNotification']);
                Route::get('get-requested-money', [CustomerAuthController::class, 'getRequestedMoney']);
                Route::get('get-own-requested-money', [CustomerAuthController::class, 'getOwnRequestedMoney']);
                Route::delete('remove-account', [CustomerAuthController::class, 'removeAccount']);
                Route::put('update-kyc-information', [CustomerAuthController::class, 'updateKycInformation']);

                Route::post('check-otp', [OTPController::class, 'checkOtp']);
                Route::post('verify-otp', [OTPController::class, 'verifyOtp']);

                Route::post('verify-pin', [CustomerAuthController::class, 'verifyPin']);
                Route::post('change-pin', [CustomerAuthController::class, 'changePin']);

                Route::put('update-profile', [CustomerAuthController::class, 'updateProfile']);
                Route::post('update-two-factor', [CustomerAuthController::class, 'updateTwoFactor']);
                Route::put('update-fcm-token', [CustomerAuthController::class, 'updateFcmToken']);
                Route::post('logout', [CustomerAuthController::class, 'logout']);

                Route::post('send-money', [TransactionController::class, 'sendMoney']);
                Route::post('cash-out', [TransactionController::class, 'cashOut']);
                Route::post('request-money', [TransactionController::class, 'requestMoney']);
                Route::post('request-money/{slug}', [TransactionController::class, 'requestMoneyStatus']);
                Route::post('add-money', [TransactionController::class, 'addMoney']);
                Route::post('withdraw', [TransactionController::class, 'withdraw']);
                Route::get('transaction-history', [TransactionController::class, 'transactionHistory']);

                Route::get('withdrawal-methods', [TransactionController::class, 'withdrawalMethods']);

                Route::get('withdrawal-requests', [WithdrawController::class, 'list']);
            });

        });

        Route::group(['prefix' => 'agent', 'namespace' => 'Auth'], function () {

            Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
                Route::post('register', [RegisterController::class, 'agentRegistration']);
                Route::post('login', [LoginController::class, 'agentLogin']);

                Route::post('check-phone', [AgentAuthController::class, 'checkPhone']);
                Route::post('verify-phone', [AgentAuthController::class, 'verifyPhone']);
                Route::post('resend-otp', [AgentAuthController::class, 'resendOtp']);

                Route::post('forgot-password', [AgentPasswordResetController::class, 'resetPasswordRequest']);
                Route::post('verify-token', [AgentPasswordResetController::class, 'verifyToken']);
                Route::put('reset-password', [AgentPasswordResetController::class, 'resetPasswordSubmit']);
            });
            Route::group(['middleware' => ['inactiveAuthCheck', 'trackLastActiveAt', 'auth:api', 'agentAuth', 'checkDeviceId']], function () {
                Route::get('get-agent', [AgentController::class, 'getAgent']);
                Route::get('get-notification', [NotificationController::class, 'getAgentNotification']);
                Route::get('get-banner', [BannerController::class, 'getAgentBanner']);
                Route::get('linked-website', [AgentController::class, 'linkedWebsite']);
                Route::get('get-requested-money', [AgentController::class, 'getRequestedMoney']);
                Route::put('update-kyc-information', [CustomerAuthController::class, 'updateKycInformation']);

                Route::post('check-otp', [OTPController::class, 'checkOtp']);
                Route::post('verify-otp', [OTPController::class, 'verifyOtp']);

                Route::post('verify-pin', [AgentController::class, 'verifyPin']);
                Route::post('change-pin', [AgentController::class, 'changePin']);

                Route::put('update-profile', [AgentController::class, 'updateProfile']);
                Route::post('update-two-factor', [AgentController::class, 'updateTwoFactor']);
                Route::put('update-fcm-token', [AgentController::class, 'updateFcmToken']);
                Route::post('logout', [AgentController::class, 'logout']);
                Route::delete('remove-account', [AgentController::class, 'removeAccount']);

                Route::post('send-money', [AgentTransactionController::class, 'cashIn']);
                Route::post('request-money', [AgentTransactionController::class, 'requestMoney']);
                Route::post('add-money', [AgentTransactionController::class, 'addMoney']);
                Route::post('withdraw', [AgentTransactionController::class, 'withdraw']);
                Route::get('transaction-history', [AgentTransactionController::class, 'transactionHistory']);

                Route::get('withdrawal-methods', [AgentTransactionController::class, 'withdrawalMethods']);

                Route::get('withdrawal-requests', [AgentWithdrawController::class, 'list']);
            });
        });

        Route::get('/config', [ConfigController::class, 'configuration']);
        Route::get('/faq', [GeneralController::class, 'faq']);
    });

    Route::post('/create-payment-order', [PaymentOrderController::class, 'createPaymentOrder']);
    Route::post('/payment-success', [PaymentOrderController::class, 'payment_success']);
    Route::post('/payment-verification', [PaymentOrderController::class, 'paymentVerification']);

});
