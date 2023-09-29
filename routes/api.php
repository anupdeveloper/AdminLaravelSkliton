<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth Route
// register

// FALLBACK BEGIN
Route::fallback(function(){
    return response()->json(['message' => 'URL NOT FOUND'], 404);
});


Route::group(['middleware' => ['localization','log.route']], function () {

    
    Route::get('/make-call',[\App\Http\Controllers\Api\UserController::class,'makeCall'])->name('make.call');

    Route::get('/get-status',[\App\Http\Controllers\Api\WorkOrderController::class,'get_status'])->name('get_status');
    /* Server Time */
    Route::get('/get-server-time',[\App\Http\Controllers\Api\MasterController::class,'get_server_time'])->name('get_server_time');
    /* Version No */
    Route::get('/get-version',[\App\Http\Controllers\Api\MasterController::class,'get_version'])->name('get_version');
    // hide subsription yes or no
    Route::get('/terms-and-condition',[\App\Http\Controllers\Api\MasterController::class,'terms_and_condition']);

   

    Route::get('/onboarding',[\App\Http\Controllers\Api\OnBoardingController::class,'onboarding'])->name('api_onboarding');
    Route::post('/register',[\App\Http\Controllers\Api\AuthController::class,'register'])->name('api_register');
    Route::post('/resend-otp',[\App\Http\Controllers\Api\AuthController::class,'resendOtp'])->name('otp.resend');
    Route::post('/verify-otp',[\App\Http\Controllers\Api\AuthController::class,'verifyOtp'])->name('otp.verify');
    Route::post('/login',[\App\Http\Controllers\Api\AuthController::class,'login'])->name('api_login');     
    Route::post('/logout',[\App\Http\Controllers\Api\AuthController::class,'logout'])->name('api-logout')->middleware('auth:sanctum');      
    // @ registrations steps
    Route::match(array('GET'),'/user-info/{id?}',[\App\Http\Controllers\Api\UserController::class,'getUserInfo'])->name('user.profile-info')->middleware('auth:sanctum');

    Route::match(array('GET'),'/member-info/{id?}',[\App\Http\Controllers\Api\UserController::class,'getMemberInfo'])->name('user.member-info')->middleware('auth:sanctum');
    
    Route::post('/user-info/{selected_user_id?}',[\App\Http\Controllers\Api\UserController::class,'setUserInfo'])->name('user.fields_check')->middleware('auth:sanctum');
    // @end registrations steps
    Route::post('/user-profile',[\App\Http\Controllers\Api\UserController::class,'userProfileUpdate'])->middleware('auth:sanctum');
    // User Profile Image Seperate API
    Route::post('/user-profile-image-upload',[\App\Http\Controllers\Api\UserController::class,'userProfileImageAdd'])->middleware('auth:sanctum');
    Route::post('/user-profile-image-update-upload/{member_id?}',[\App\Http\Controllers\Api\UserController::class,'userProfileImageUpdate'])->middleware('auth:sanctum');
    Route::post('/user-family-profile-image-update-upload/{member_id?}',[\App\Http\Controllers\Api\UserFamilyController::class,'userFamilyMemberProfileImageUpdate'])->middleware('auth:sanctum');
    // End seperate profile image
    Route::post('/user-gallery-image/{member_id?}',[\App\Http\Controllers\Api\UserController::class,'userGalleryImageAdd'])->middleware('auth:sanctum');
    Route::post('/familymember-profile-image/{member_id?}',[\App\Http\Controllers\Api\UserFamilyController::class,'userFamilyMemberProfileImageAdd'])->middleware('auth:sanctum');
    Route::post('/user-gallery-image-update/{id?}/{member_id?}',[\App\Http\Controllers\Api\UserController::class,'userGalleryImageUpdate'])->middleware('auth:sanctum');
    Route::post('/user-profile-image-default/{id}',[\App\Http\Controllers\Api\UserController::class,'userProfileImageDefault'])->middleware('auth:sanctum');
    Route::post('/user-gallery-image-delete/{id}/{member_id?}',[\App\Http\Controllers\Api\UserController::class,'userGalleryImageDelete'])->middleware('auth:sanctum');
    
    
    // @user default info
    Route::post('/user-default-info',[\App\Http\Controllers\Api\UserController::class,'setUserDefaultInfo'])->middleware('auth:sanctum');


    // @ user family apis
    Route::post('/add-family-member',[\App\Http\Controllers\Api\UserFamilyController::class,'addFamilyMember'])->middleware('auth:sanctum');
    Route::put('/update-family-member/{id}',[\App\Http\Controllers\Api\UserFamilyController::class,'updateFamilyMember'])->middleware('auth:sanctum');
    Route::post('/user-family-member-profile-image/{family_user_id}',[\App\Http\Controllers\Api\UserFamilyController::class,'userFamilyMemberGalleryImageAdd'])->middleware('auth:sanctum');
    // Username validate
    Route::post('/user-username-validate',[\App\Http\Controllers\Api\UserController::class,'usernameValidate'])->middleware('auth:sanctum');
    // Email validate
    Route::post('/user-email-validate',[\App\Http\Controllers\Api\UserController::class,'emailValidate'])->middleware('auth:sanctum');

    //Update User Profile
    Route::post('/user-profile-edit/{member_id?}',[\App\Http\Controllers\Api\UserController::class,'user_profile_edit'])->middleware('auth:sanctum');

    Route::post('/user-basic-profile-edit',[\App\Http\Controllers\Api\UserController::class,'user_basic_profile_edit'])->middleware('auth:sanctum');

    // For Like, block, Hide
    Route::post('/user-likes-hide-blocked/{user_type}/{member_id}/{reason_id?}',[\App\Http\Controllers\Api\UserController::class,'user_likes_hide_blocked'])->middleware('auth:sanctum');
    // For LIKE Gallery Images
    Route::post('/user-liked-gallery-image/{user_type}/{user_id_or_member_id}/{image_id}',[\App\Http\Controllers\Api\UserController::class,'user_liked_gallery_image'])->middleware('auth:sanctum');

    // Delete API
    Route::post('/delete',[\App\Http\Controllers\Api\UserController::class,'delete_user'])->middleware('auth:sanctum');

    // Terms & conditions API
    Route::get('/get-page-content/{page}',[\App\Http\Controllers\Api\MasterController::class,'get_page_content'])->middleware('auth:sanctum');
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['localization','log.route']], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        
        Route::post('/task-list/{date?}',[\App\Http\Controllers\Api\WorkOrderController::class,'task_list'])->name('task_list');
        Route::post('/task-detail/{id?}',[\App\Http\Controllers\Api\WorkOrderController::class,'task_detail'])->name('task_list');
        Route::post('/task-update/{id?}',[\App\Http\Controllers\Api\WorkOrderController::class,'task_update'])->name('task_update');
        

        Route::post('/leads-list/{date?}',[\App\Http\Controllers\Api\LeadController::class,'leads_list'])->name('leads_list');
        Route::post('/lead-detail/{id?}',[\App\Http\Controllers\Api\LeadController::class,'lead_detail'])->name('lead_detail');
        Route::post('/lead-update/{id?}',[\App\Http\Controllers\Api\LeadController::class,'lead_update'])->name('lead_update');
        

        Route::post('/create_complaint',[\App\Http\Controllers\Api\UserController::class,'create_complaint'])->name('create_complaint');

        Route::post('/products/{category?}',[\App\Http\Controllers\Api\ProductController::class,'get_all_products'])->name('products');
        Route::post('/create_order',[\App\Http\Controllers\Api\OrderController::class,'create_order'])->name('create_order');
        Route::post('/order-list',[\App\Http\Controllers\Api\OrderController::class,'orders_list'])->name('orders_list');
        /* Pre Member API */
        Route::get('/select-account/{account_id}/{device_type?}/{device_token?}',[\App\Http\Controllers\Api\AuthController::class,'select_account'])->name('select_account');
        /* Pre Member API */
        Route::get('/pre-member-screens',[\App\Http\Controllers\Api\OnBoardingController::class,'pre_member_screens'])->name('api_pre_member_screens');
        /* Subscription List APIS */
        Route::get('/subscriptions',[\App\Http\Controllers\Api\SubscriptionController::class,'subscriptions'])->name('subscriptions');
        Route::get('/user-detail',[\App\Http\Controllers\Api\UserController::class,'user_detail'])->name('userdetail');
        /* personality dimension */
        Route::get('/personality-dimension',[\App\Http\Controllers\Api\UserController::class,'personality_dimension'])->name('personality.dimension');
        /* Master Educational */
        Route::get('/educational-list',[\App\Http\Controllers\Api\MasterController::class,'educational_list'])->name('educational.list');
        /* Master SkinColor */
        Route::get('/skin-color-list',[\App\Http\Controllers\Api\MasterController::class,'skincolor_list'])->name('skincolor.list');
        /* Get Other User Home Page API */
        Route::post('/get-other-avaliable-users/{account_type?}/{send_connection?}',[\App\Http\Controllers\Api\UserController::class,'get_other_avaliable_users'])->name('avaliable.users');
        Route::post('/get-other-avaliable-users-optimized/{account_type?}/{send_connection?}',[\App\Http\Controllers\Api\UserController::class,'get_other_avaliable_users_optimized'])->name('avaliable.users.optimized');
        Route::get('/get-member-details',[\App\Http\Controllers\Api\UserController::class,'member_details'])->name('member.details');
        Route::get('/list-educational-content',[\App\Http\Controllers\Api\EducationController::class,'educational_content_list'])->name('educational.content.list');
        Route::get('/get-educational-content-detail/{id}',[\App\Http\Controllers\Api\EducationController::class,'get_education_content_detail'])->name('educational.content.detail');
        Route::get('/reason-list',[\App\Http\Controllers\Api\MasterController::class,'reason_list'])->name('master.reason_list');

        /* Suggestion */
        Route::get('/get-suggestion-category-list',[\App\Http\Controllers\Api\SuggestionController::class,'get_suggestion_category_list'])->name('suggestional.category.list');
        Route::post('/send-suggestion',[\App\Http\Controllers\Api\SuggestionController::class,'send_suggestion'])->name('suggestion.send');
        /* Connections */
        Route::post('/send-connection_request',[\App\Http\Controllers\Api\ConnectionController::class,'send_connection_request'])->name('send.connection.request');
        Route::post('/accept-connection-request',[\App\Http\Controllers\Api\ConnectionController::class,'accept_connection_request'])->name('accept.connection.request');
        Route::post('/cancel-connection-request',[\App\Http\Controllers\Api\ConnectionController::class,'cancel_connection_request'])->name('cancel.connection.request');
        /* all connected users */
        Route::get('/all-connected-users-list/{type?}',[\App\Http\Controllers\Api\ConnectionController::class,'all_connected_users_list'])->name('all_connected_users_list');
        Route::get('/all-connected-users-list-optimized/{type?}',[\App\Http\Controllers\Api\ConnectionController::class,'all_connected_users_list_optimized'])->name('all_connected_users_list_optimized');
        Route::get('/all-favroite-users-list',[\App\Http\Controllers\Api\ConnectionController::class,'all_favroite_users_list'])->name('all_favroite_users_list');

        Route::get('/all-favroite-users-list-optimized',[\App\Http\Controllers\Api\ConnectionController::class,'all_favroite_users_list_optimized'])->name('all_favroite_users_list_optimized');
        Route::get('/all-connected_users/{by_status?}',[\App\Http\Controllers\Api\ConnectionController::class,'all_connected_users'])->name('all_connected_users');

        Route::post('/add-connections/{type}',[\App\Http\Controllers\Api\ConnectionController::class,'add_connection'])->name('add.connection');

        Route::post('/connection-removed',[\App\Http\Controllers\Api\ConnectionController::class,'connection_removed'])->name('connection.removed');

        
        
        
        //Sent payment link for member extension
        
        Route::get('/member-extention-payment',[\App\Http\Controllers\Api\UserController::class,'member_extention_payment'])->name('member_extention_payment');
        // Extend subscription
        Route::get('/subscription-extention-payment',[\App\Http\Controllers\Api\UserController::class,'subscription_extention_payment'])->name('subscription_extention_payment');

        /*messages*/
        Route::post('/get-all-user-messages',[\App\Http\Controllers\Api\MessageController::class,'get_all_user_messages'])->name('get_all_user_messages');
        Route::post('/get-user-messages',[\App\Http\Controllers\Api\MessageController::class,'get_user_messages'])->name('get_user_messages');
        Route::post('/send-message',[\App\Http\Controllers\Api\MessageController::class,'send_message'])->name('send_message');
        Route::get('/delete-message/{id}',[\App\Http\Controllers\Api\MessageController::class,'delete_message'])->name('delete_message');
        Route::post('/read-message/{message_id}/{reciver_id}',[\App\Http\Controllers\Api\MessageController::class,'read_message'])->name('read_message');
        Route::get('/user-has-unread-message/{user_id}',[\App\Http\Controllers\Api\MessageController::class,'user_has_unread_message'])->name('mesage.unread.status');
        // user status
        Route::post('user-status',[\App\Http\Controllers\Api\StatusController::class,'changeUserStatus']);
        // User Subscription
        Route::post('user-my-subscription',[\App\Http\Controllers\Api\UserController::class,'user_subscription']);

        // Hijab type list
        Route::get('/hijab-types',[\App\Http\Controllers\Api\HijabTypeController::class,'index']);
        // Work list
        Route::get('/work',[\App\Http\Controllers\Api\WorkController::class,'index']);
        // Children list
        Route::get('/children',[\App\Http\Controllers\Api\ChildrenController::class,'index']);
        // Children list
        Route::get('/children',[\App\Http\Controllers\Api\ChildrenController::class,'index']);
        // Family origin list
        Route::get('/family-origin',[\App\Http\Controllers\Api\FamilyOriginController::class,'index']);
        // Master Sect list
        Route::get('/sect',[\App\Http\Controllers\Api\MasterSectController::class,'index']);
        // Height list
        Route::get('/height-list',[\App\Http\Controllers\Api\MasterController::class,'height_list']);
        // tribe list
        Route::get('/tribe-list',[\App\Http\Controllers\Api\MasterController::class,'tribe_list']);
        // talk before marriage
        Route::get('/talk-before-marriage-list',[\App\Http\Controllers\Api\MasterController::class,'talk_before_marriage_list']);
        

        // Notifications APIS
        Route::get('/notifications-lists',[\App\Http\Controllers\Api\ConnectionController::class,'notifications_lists'])->name('notifications.lists');
        Route::get('/notifications-lists-optimized',[\App\Http\Controllers\Api\ConnectionController::class,'notifications_lists_optimized'])->name('notifications.lists.optimized');
        Route::get('/notifications-unread-count',[\App\Http\Controllers\Api\ConnectionController::class,'notifications_unread_count'])->name('notifications.unread.count');
        Route::get('/notification-clearall',[\App\Http\Controllers\Api\ConnectionController::class,'notifications_clear_all'])->name('notifications.clearall');
        //Invoice
        Route::get('/generate-invoice/{checkout_id}/{download?}',[\App\Http\Controllers\Api\UserController::class,'generate_invoice'])->name('generate.invoice');

       
        
    });
});



// flipflop test
Route::post('/test-validation',[\App\Http\Controllers\Api\TestController::class,'testValidation']);

// Herpay notification api
Route::post('get-hyper-pay-payment-status', [\App\Http\Controllers\HomeController::class, 'hyperpaypaymentstatus'])->name('admin.hyperpaypayment.status');

Route::post('/send-fcm-notification',[\App\Http\Controllers\Api\UserController::class,'send_notification_api_FCM'])->name('fcm.notiu');



