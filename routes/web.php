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

Route::get('/',[\App\Http\Controllers\HomeController::class, 'home'])->name('index');
Route::get('/about',[\App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/product-detail/{id}',[\App\Http\Controllers\HomeController::class, 'product_detail'])->name('product-detail');
Route::get('/contact',[\App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

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
        Route::post('user/save', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
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

    Route::group(['prefix' => 'staff'], function () {
        Route::get('staff/', [\App\Http\Controllers\Admin\StaffController::class, 'index'])->name('admin.staff.index');
        Route::post('staff/export', [\App\Http\Controllers\Admin\StaffController::class, 'userExport'])->name('admin.staff.export');
        Route::get('staff/create', [\App\Http\Controllers\Admin\StaffController::class, 'create'])->name('admin.staff.create');
        Route::post('user/save', [\App\Http\Controllers\Admin\StaffController::class, 'store'])->name('admin.staff.store');
        Route::get('staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'show'])->name('admin.staff.show');
        Route::get('staff/{id}/edit', [\App\Http\Controllers\Admin\StaffController::class, 'edit'])->name('admin.staff.edit');
        Route::patch('staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'update'])->name('admin.staff.update');
        Route::post('staff', [\App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('admin.staff.destroy');
    });


    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/add', [\App\Http\Controllers\Admin\CategoryController::class, 'add'])->name('admin.category.add');
        Route::post('/save', [\App\Http\Controllers\Admin\CategoryController::class, 'save'])->name('admin.category.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::patch('{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.category.update');
        Route::post('{id?}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/add', [\App\Http\Controllers\Admin\ProductController::class, 'add'])->name('admin.product.add');
        Route::post('/save', [\App\Http\Controllers\Admin\ProductController::class, 'save'])->name('admin.product.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::patch('{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.product.update');
        Route::post('{id?}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.product.destroy');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/add', [\App\Http\Controllers\Admin\ProductController::class, 'add'])->name('admin.product.add');
        Route::post('/save', [\App\Http\Controllers\Admin\ProductController::class, 'save'])->name('admin.product.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::patch('{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.product.update');
        Route::post('{id?}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.product.destroy');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.order.index');
        //Route::get('/add', [\App\Http\Controllers\Admin\ProductController::class, 'add'])->name('admin.product.add');
        //Route::post('/save', [\App\Http\Controllers\Admin\ProductController::class, 'save'])->name('admin.product.save');
        Route::get('{id}/view', [\App\Http\Controllers\Admin\OrderController::class, 'view'])->name('admin.order.view');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('admin.order.edit');

        Route::patch('{id}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('admin.order.update');
        Route::post('{id?}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.order.destroy');
    });


    Route::prefix('lead')->namespace('Admin')->group(function () {
        Route::get('/index/{type?}', [\App\Http\Controllers\Admin\LeadController::class, 'index'])->name('admin.lead.index');
        Route::get('/getdata/{type?}', [\App\Http\Controllers\Admin\LeadController::class, 'getdata'])->name('admin.lead.getdata');
        
        Route::get('/filter', [\App\Http\Controllers\Admin\LeadController::class, 'filter'])->name('admin.lead.filter');
        //for uploading to database
        Route::post('/leads-import',[\App\Http\Controllers\Admin\LeadController::class,'lead_import'])->name('admin.lead.import');
        Route::get('/add', [\App\Http\Controllers\Admin\LeadController::class, 'add'])->name('admin.lead.add');
        Route::post('/save', [\App\Http\Controllers\Admin\LeadController::class, 'save'])->name('admin.lead.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\LeadController::class, 'edit'])->name('admin.lead.edit');
        Route::post('{id}/update', [\App\Http\Controllers\Admin\LeadController::class, 'update'])->name('admin.lead.update');
        Route::post('delete', [\App\Http\Controllers\Admin\LeadController::class, 'destroy'])->name('admin.lead.destroy');
        Route::post('/assign-leads', [\App\Http\Controllers\Admin\LeadController::class, 'assignleads'])->name('admin.lead.assignleads');
    });

    Route::prefix('pages')->namespace('Admin')->group(function () {
        Route::get('/index', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('admin.page.index');
        Route::get('/getdata', [\App\Http\Controllers\Admin\PageController::class, 'getdata'])->name('admin.page.getdata');
        Route::get('/add', [\App\Http\Controllers\Admin\PageController::class, 'add'])->name('admin.page.add');
        Route::post('/save', [\App\Http\Controllers\Admin\PageController::class, 'save'])->name('admin.page.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\PageController::class, 'edit'])->name('admin.page.edit');
        Route::post('{id}/update', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('admin.page.update');
        Route::post('{id?}/delete', [\App\Http\Controllers\Admin\PageController::class, 'destroy'])->name('admin.page.destroy');
        
    });

    Route::prefix('workorder')->namespace('Admin')->group(function () {

        Route::get('/index/{wo_type?}', [\App\Http\Controllers\Admin\WorkOrderController::class, 'index'])->name('admin.workorder.index');
        Route::get('/getdata/{wo_type?}', [\App\Http\Controllers\Admin\WorkOrderController::class, 'getdata'])->name('admin.workorder.getdata');
        
        
        

        Route::get('/add-work-order', [\App\Http\Controllers\Admin\WorkOrderController::class, 'add_work_order'])->name('admin.workorder.add_work_order');
        Route::get('/add', [\App\Http\Controllers\Admin\WorkOrderController::class, 'add'])->name('admin.workorder.add');
        Route::post('/save', [\App\Http\Controllers\Admin\WorkOrderController::class, 'save'])->name('admin.workorder.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\WorkOrderController::class, 'edit'])->name('admin.workorder.edit');
        Route::post('{id}/update', [\App\Http\Controllers\Admin\WorkOrderController::class, 'update'])->name('admin.workorder.update');
        Route::post('delete', [\App\Http\Controllers\Admin\WorkOrderController::class, 'destroy'])->name('admin.workorder.destroy');
        Route::post('/assign-workorders', [\App\Http\Controllers\Admin\WorkOrderController::class, 'workorders'])->name('admin.workorder.assignworkorders');
        Route::post('/get-user-slots', [\App\Http\Controllers\Admin\WorkOrderController::class, 'getUserslots'])->name('admin.workorder.userslots');
        
    });

    Route::prefix('ticket')->namespace('Admin')->group(function () {
        Route::get('/index', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('admin.ticket.index');
        Route::get('/getdata', [\App\Http\Controllers\Admin\TicketController::class, 'getdata'])->name('admin.ticket.getdata');
        Route::get('/add', [\App\Http\Controllers\Admin\TicketController::class, 'add'])->name('admin.ticket.add');
        Route::post('/save', [\App\Http\Controllers\Admin\TicketController::class, 'save'])->name('admin.ticket.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\TicketController::class, 'edit'])->name('admin.ticket.edit');
        Route::post('{id}/update', [\App\Http\Controllers\Admin\TicketController::class, 'update'])->name('admin.ticket.update');
        Route::post('delete', [\App\Http\Controllers\Admin\TicketController::class, 'destroy'])->name('admin.ticket.destroy');
    });

    
    Route::prefix('setting')->namespace('Admin')->group(function () {
        Route::get('/index', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.setting.index');
        Route::get('/getdata', [\App\Http\Controllers\Admin\SettingController::class, 'getdata'])->name('admin.setting.getdata');
        Route::get('/add', [\App\Http\Controllers\Admin\SettingController::class, 'add'])->name('admin.setting.add');
        Route::post('/save', [\App\Http\Controllers\Admin\SettingController::class, 'save'])->name('admin.setting.save');
        Route::get('{id}/edit', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.setting.edit');
        Route::post('{id}/update', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.setting.update');
        Route::post('delete', [\App\Http\Controllers\Admin\SettingController::class, 'destroy'])->name('admin.setting.destroy');
    });

    
});
