<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Gateway\PaymobController;
use App\Http\Controllers\Gateway\PaystackController;
use App\Http\Controllers\Gateway\RazorPayController;
use App\Http\Controllers\Gateway\SenangPayController;
use App\Http\Controllers\Gateway\FlutterwaveController;
use App\Http\Controllers\Gateway\MercadoPagoController;
use App\Http\Controllers\Gateway\BkashPaymentController;
use App\Http\Controllers\Payment\PaymentOrderController;
use App\Http\Controllers\Gateway\PaypalPaymentController;
use App\Http\Controllers\Gateway\StripePaymentController;
use App\Http\Controllers\Gateway\SslCommerzPaymentController;
use App\Http\Controllers\Web\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [LandingPageController::class, 'landingPageHome'])->name('landing-page-home');
Route::post('newsletter/subscribe', [NewsLetterController::class, 'newsLetterSubscribe'])->name('newsletter.subscribe');
Route::post('send-message', [LandingPageController::class, 'contactUsMessage'])->name('send-message');
Route::get('contact-us', [LandingPageController::class, 'contactUs'])->name('contact-us');


Route::get('/home', function() {
    return redirect(\route('admin.auth.login'));
});

Route::group(['prefix' => ''], function () {
    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment-mobile');
    Route::get('set-payment-method/{name}', [PaymentController::class, 'payment'])->name('set-payment-method');
});


Route::get('payment-success', [PaymentController::class, 'success'])->name('payment-success');
Route::get('payment-fail', [PaymentController::class, 'fail'])->name('payment-fail');

Route::get('authentication-failed', function () {
    $errors = [];
    array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
    return response()->json([
        'errors' => $errors
    ], 401);
})->name('authentication-failed');

Route::get('payment-process', [PaymentOrderController::class, 'paymentProcess'])->name('payment-process');
Route::post('send-otp', [PaymentOrderController::class, 'sendOtp'])->name('send-otp');
Route::get('otp', [PaymentOrderController::class, 'otpIndex'])->name('otp');
Route::post('verify-otp', [PaymentOrderController::class, 'verifyOtp'])->name('verify-otp');
Route::get('resend-otp', [PaymentOrderController::class, 'resendOtp'])->name('resend-otp');
Route::get('pin', [PaymentOrderController::class, 'pinIndex'])->name('pin');
Route::post('verify-pin', [PaymentOrderController::class, 'verifyPin'])->name('verify-pin');
Route::get('success', [PaymentOrderController::class, 'successIndex'])->name('success');
Route::get('success-callback', [PaymentOrderController::class, 'paymentSuccessCallback'])->name('success-callback');
Route::get('back-to-callback', [PaymentOrderController::class, 'back_to_callback'])->name('back-to-callback');

Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {
    Route::get('terms-conditions', [PageController::class, 'getTermsAndConditions'])->name('terms-conditions');
    Route::get('privacy-policy', [PageController::class, 'getPrivacyPolicy'])->name('privacy-policy');
    Route::get('about-us', [PageController::class, 'getAboutUs'])->name('about-us');
});

