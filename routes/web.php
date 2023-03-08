<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/terms-conditions', function () {
    return view('terms-conditions');
});

Route::get('/signup', [\App\Http\Controllers\HomeController::class, 'signup'])->name('signup');
Route::get('/verify-otp', [\App\Http\Controllers\HomeController::class, 'verify_otp'])->name('verify_otp');
Route::match(array('GET', 'POST'), '/register', [\App\Http\Controllers\HomeController::class, 'register'])->name('register');
Route::get('/resend-otp', [\App\Http\Controllers\HomeController::class, 'resendOtp'])->name('otp.resend');
Route::post('/verify-otp', [\App\Http\Controllers\HomeController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/verify-otp-new-user', [\App\Http\Controllers\HomeController::class, 'verifyOtpNewUser'])->name('otp.verify.new.user');
Route::get('/start-registration', [\App\Http\Controllers\HomeController::class, 'start_registration'])->name('start_registration');
Route::post('/set-user-info', [\App\Http\Controllers\HomeController::class, 'setUserInfo'])->name('set_user_info');
Route::get('/complete-registration', [\App\Http\Controllers\HomeController::class, 'complete_registration'])->name('complete_registration');
Route::post('/submit-complete-registration', [\App\Http\Controllers\HomeController::class, 'submit_complete_registration'])->name('submit_complete_registration');
Route::post('/getRegionByCountry', [\App\Http\Controllers\HomeController::class, 'getRegionByCountry'])->name('getRegionByCountry');
Route::post('/getCityByRegion', [\App\Http\Controllers\HomeController::class, 'getCityByRegion'])->name('getCityByRegion');

//@test script
Route::get('/run-script', [\App\Http\Controllers\HomeController::class, 'run_script'])->name('run_script');
Route::get('/fix-script', [\App\Http\Controllers\TestController::class, 'fix_script'])->name('fix_script');
Route::get('/update-payment-response-script', [\App\Http\Controllers\TestController::class, 'update_payment_response_id'])->name('update_payment_response_id');

//@main subscription
Route::get('/get-subscription/{token?}', [\App\Http\Controllers\HomeController::class, 'get_subscripton'])->name('get_subscripton');
Route::get('/pay/{id?}', [\App\Http\Controllers\HomeController::class, 'pay'])->name('pay');
// Route::post('/select-subscription', [\App\Http\Controllers\HomeController::class, 'select_subscripton'])->name('select.subscripton');
Route::post('/subscription-checkout', [\App\Http\Controllers\HomeController::class, 'subscription_checkout'])->name('user.checkout.subscription');
// Route::get('/pay-subscription', [\App\Http\Controllers\HomeController::class, 'pay_subscription'])->name('user.pay.subscription');
Route::match(array('GET', 'POST'), '/pay-subscription', [\App\Http\Controllers\HomeController::class, 'pay_subscription'])->name('user.pay.subscription');
//@ extends member addon
Route::get('/add-member-addon/{token?}', [\App\Http\Controllers\HomeController::class, 'add_member_addon'])->name('add_member_addon');
Route::post('/add-member-checkout', [\App\Http\Controllers\HomeController::class, 'add_member_checkout'])->name('add_member_checkout');
Route::post('/pay-add-member', [\App\Http\Controllers\HomeController::class, 'pay_add_member'])->name('pay_add_member');

Route::get('/get-payment-link-expired/{user_id}', [\App\Http\Controllers\HomeController::class, 'get_payment_expired'])->name('get_payment_expired');

Route::get('/hyperpay/finalize', [\App\Http\Controllers\HomeController::class, 'paymentStatus'])->name('admin.hyperpay.finalize');

Route::get('/hyperpay/status/{id?}', [\App\Http\Controllers\HomeController::class, 'hyper_payment_status'])->name('admin.hyper_payment_status');

Route::get('/admin', [\App\Http\Controllers\Auth\LoginController::class, 'loginForm'])->name('login');
Route::post('/admin-login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('ck_login');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
// language change routes
//Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('changeLanguage');
Route::match(array('GET', 'POST'), '/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('changeLanguage');


Route::get('/home', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/reset-password', [\App\Http\Controllers\Admin\AdminController::class, 'reset_password'])->name('admin.resetpassword');
        Route::post('/reset-password', [\App\Http\Controllers\Admin\AdminController::class, 'save_reset_password'])->name('admin.resetpassword');

        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/user', [\App\Http\Controllers\Admin\AdminController::class, 'user'])->name('admin.users.list');
        Route::get('/download-user', [\App\Http\Controllers\Admin\UserController::class, 'downloadUser'])->name('admin.users.downloaduser');
        Route::post('/user-blocked', [\App\Http\Controllers\Admin\UserController::class, 'user_blocked'])->name('admin.user.block_user');
        Route::get('/user-reports', [\App\Http\Controllers\Admin\UserController::class, 'user_report_list'])->name('user.report.list');
        Route::get('/view-reports/{id}', [\App\Http\Controllers\Admin\UserController::class, 'view_reports'])->name('user.report');
        // User Subscrption
        Route::get('/user-transaction', [\App\Http\Controllers\Admin\TransactionController::class, 'user_transaction'])->name('admin.user_transaction.index');

        Route::post('user-subscription-update', [\App\Http\Controllers\Admin\UserSubscriptionController::class, 'user_subscription_update'])->name('admin.user.subscription.update');

        // SEND NOTIFICATIONS
        Route::get('/user-send-notification', [\App\Http\Controllers\Admin\UserSuggestionController::class, 'send_notification_index'])->name('admin.notification.index');
        Route::post('/user-send-notification', [\App\Http\Controllers\Admin\UserSuggestionController::class, 'send_notification'])->name('admin.user.send.notification');

         //list
        Route::get('user/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.index');
        Route::post('user/export', [\App\Http\Controllers\Admin\UserController::class, 'userExport'])->name('admin.users.export');
        //add
        Route::get('user/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.create');
        Route::post('user/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
        //view
        Route::get('user/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.user.show');
        //edit
        Route::get('user/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.user.edit');
        Route::patch('user/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
        //delete
        Route::post('user', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.destroy');
        //Route::get('user/enb-disb/{id}',[\App\Http\Controllers\Admin\UserController::class,'enbDisb'])->name('admin.user.enb-disb');

    
    
        // Master POPUP MESSAGE

        //list
        Route::get('master-popup-message/', [\App\Http\Controllers\Admin\MasterPopupMessageController::class, 'index'])->name('admin.master-popup-message.index');
        //add
        Route::get('master-popup-message/create', [\App\Http\Controllers\Admin\MasterPopupMessageController::class, 'create'])->name('admin.master-popup-message.create');
        Route::post('master-popup-message/', [\App\Http\Controllers\Admin\MasterPopupMessageController::class, 'store'])->name('admin.master-popup-message.store');
        //view
        Route::get('master-popup-message/{id}', [\App\Http\Controllers\Admin\MasterPopupMessageController::class, 'show'])->name('admin.master-popup-message.show');
        //edit
        Route::get('master-popup-message/{id}/edit', [\App\Http\Controllers\Admin\MasterPopupMessageController::class, 'edit'])->name('admin.master-popup-message.edit');
        Route::patch('master-popup-message/{id}', [\App\Http\Controllers\Admin\MasterPopupMessageController::class, 'update'])->name('admin.master-popup-message.update');
        //delete
        Route::delete('master-popup-message/{id}', [\App\Http\Controllers\Admin\MasterPopupMessageController::class, 'destroy'])->name('admin.master-popup-message.destroy');
        //Route::get('master-popup-message/enb-disb/{id}',[\App\Http\Controllers\Admin\MasterPopupMessageController::class,'enbDisb'])->name('admin.master-popup-message.enb-disb');

   

    });
});


// ADMIN

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category.index');
    });
});
