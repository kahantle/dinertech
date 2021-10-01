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
// Route::get('/',function(){
//     return redirect()->route('customer.index');
// });

//-------------------------- Restaurant Route ---------------------------------------------- //
Route::get('/', 'HomeController@index')->name('home');
Route::post('/contact', 'HomeController@contact')->name('contact');
// Route::prefix('web')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@show')->name('login');
        Route::get('/login', 'LoginController@show')->name('login');
        Route::post('/login', 'LoginController@login')->name('post.login');
        Route::get('/verify', 'VerificationController@index')->name('verify');
        Route::post('/verify', 'VerificationController@verify')->name('post.verify');
        Route::post('/resend', 'VerificationController@resend')->name('resend');
        Route::post('/forgot', 'ForgotPasswordController@sendPasswordResetToken')->name('forgot');
        Route::get('/reset-password/{token}', 'ForgotPasswordController@showPasswordResetForm')->name('forgot.form');
        Route::post('/set-password', 'ResetPasswordController@updatePassword')->name('reset.update');
        Route::get('/register', 'SignupController@show')->name('register');
        Route::post('/register', 'SignupController@create')->name('post.register');
        Route::get('/pay', 'SignupController@showPayment')->name('show.pay');
        Route::post('/pay', 'SignupController@payment')->name('post.pay');
        Route::get('/logout', 'LoginController@logout')->name('logout');
        Route::get('/forgot-pass', 'ForgotPasswordController@showform')->name('forgot-pass');
        Route::post('/send-token', 'ForgotPasswordController@sendPasswordResetToken')->name('send-token.post');
        Route::get('/reset-password/{token}', 'ForgotPasswordController@showPasswordResetForm')->name('reset_password');
        Route::post('/updatePassword', 'ForgotPasswordController@updatePassword')->name('updatePassword.post');
        Route::view('/status','auth.login')->name('status');
    });
    
    Route::group(['middleware' => ['auth:web']], function () {


    Route::prefix('profile')->group(function () {
        Route::get('/', 'ProfileController@index')->name('profile');
        Route::post('/update/profile', 'ProfileController@update')->name('update.profile.post');
        Route::view('/update_status','dashboard')->name('update_status');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', 'AccountController@index')->name('account');
        Route::post('/update-account-settings','AccountController@update')->name('update-account-settings');
    });
    Route::prefix('chat')->group(function () {
        Route::get('/', 'ChatController@index')->name('chat');
        Route::get('/{order_id}', 'ChatController@index')->name('chat.order');
        Route::post('/sendMessages', 'ChatController@sendMessages')->name('chat.send');
        Route::post('/getMessages', 'ChatController@getMessages')->name('chat.get');
    });
    Route::prefix('hours')->group(function () {
        Route::get('/','HoursController@index')->name('hours');
        Route::post('add','HoursController@store')->name('add.hour.post');
        Route::get('add','HoursController@add')->name('add.hours');
        Route::get('edit/{id}','HoursController@edit')->name('edit.hour');
        Route::post('update','HoursController@update')->name('update.hours.post');
        Route::get('delete/{id}','HoursController@delete')->name('delete.hour.post');
    });
    Route::group(['middleware' => ['auth:web']], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/menu', 'MenuController@index')->name('menu');
        Route::get('/category', 'CategoryController@index')->name('category');
        Route::get('add/category', 'CategoryController@add')->name('add.category');
        Route::post('add/category', 'CategoryController@store')->name('add.category.post');
        Route::get('edit/category/{id}', 'CategoryController@edit')->name('edit.category.post');
        Route::post('update', 'CategoryController@update')->name('update.category.post');
        Route::get('delete/{id}', 'CategoryController@delete')->name('delete.category.post');
    });

    Route::prefix('modifier')->group(function () {
        Route::get('/', 'ModifiersController@index')->name('modifier');
        Route::post('/', 'ModifiersController@addModifierGroup')->name('add.modifier.post');
        Route::post('item', 'ModifiersController@addModifierGroupItem')->name('add.modifier.item.post');
        Route::get('edit/{id}', 'ModifiersController@editModifierGroup')->name('edit.modifier.post');
        Route::get('edit-item/{id}', 'ModifiersController@editModifierItem')->name('edit.modifier.item.post');
        Route::get('delete/{id}', 'ModifiersController@deleteGroup')->name('delete.modifier.post');
        Route::get('delete-item/{id}', 'ModifiersController@deleteItem')->name('delete.modifier.item.post');
    });
    Route::prefix('menu')->group(function () {
        Route::get('/', 'MenuController@index')->name('menu');
        Route::get('/add', 'MenuController@add')->name('add.menu');
        Route::post('add', 'MenuController@store')->name('add.menu.post');
        Route::get('edit/{id}', 'MenuController@edit')->name('edit.menu');
        Route::post('update', 'MenuController@update')->name('update.menu.post');
        Route::get('delete/{id}', 'MenuController@delete')->name('delete.menu.post');
        Route::prefix('modifier')->group(function () {
            Route::post('/', 'MenuModifierController@addMenuModifierGroup')->name('add.menu.modifier.post');
            Route::get('/edit/{id}', 'MenuModifierController@editMenuModifierGroup')->name('edit.menu.modifier.post');
            Route::get('/delete/{id}', 'MenuModifierController@deleteGroup')->name('delete.menu.modifier.post');
            Route::get('edit-menu-item/{id}', 'MenuModifierController@editMenuModifierItem')->name('edit.menu.modifier.item.post');
            Route::post('add-item', 'MenuModifierController@addMenuModifierGroupItem')->name('add.menu.modifier.item.post');
            Route::get('delete-item/{id}', 'MenuModifierController@deleteItem')->name('delete.menu.modifier.item.post');
            Route::post('modifier-list', 'MenuModifierController@GetModifierList')->name('ajax.modifier.list');
        });
    });
    Route::prefix('order')->group(function () {
        Route::get('/', 'OrderController@index')->name('order');
        Route::get('/details/{id}', 'OrderController@showOrderDetails')->name('details');
        Route::post('/action/{id}/{action}', 'OrderController@OrderAction')->name('action.order');
        Route::get('/pdf/{id}', 'OrderController@generate_invoice')->name('order.pdf');
        
    });
    Route::prefix('promotion')->group(function () {
        Route::get('/', 'PromotionController@index')->name('promotion');
        Route::get('/type', 'PromotionController@type')->name('promotion.type.list');
        Route::get('/details/{id}', 'PromotionController@details')->name('promotion.details');
        Route::post('/add', 'PromotionController@store')->name('promotion.add.post');
        Route::get('edit/{id}', 'PromotionController@edit')->name('promotion.edit');
        Route::get('delete/{id}', 'PromotionController@delete')->name('promotion.delete');
        Route::post('delete/{id}', 'PromotionController@delete')->name('promotion.delete');
        Route::post('status/{id}/{status}', 'PromotionController@status')->name('promotion.status');
        Route::get('/{id}', 'PromotionController@listTypeForm')->name('promotion.type.form');

        Route::post('/cart', 'PromotionController@storeCart')->name('promotion.add.cart.post');
        Route::get('/cart/edit/{id}/{type}', 'PromotionController@editCart')->name('promotion.edit.cart.post');


        Route::get('/free/edit/{id}/{type}', 'PromotionController@editFreeMethod')->name('promotion.edit.free.post');
        Route::post('/free', 'PromotionController@storefreedelivery')->name('promotion.add.freedelivery.post');


        Route::get('/paymentmethod/edit/{id}/{type}', 'PromotionController@editPaymentMethod')->name('promotion.edit.paymentmethod.post');
        Route::post('/paymentmethod', 'PromotionController@storePaymentMethod')->name('promotion.add.paymentmethod.post');

        Route::get('/select-item/edit/{id}/{type}', 'PromotionController@editSelectedItem')->name('promotion.edit.select.item');
        Route::post('/select-item', 'PromotionController@storeSelectedItems')->name('promotion.add.selecte.items.post');


        Route::get('/free-item/edit/{id}/{type}', 'PromotionController@editFreeItem')->name('promotion.edit.free.item');
        Route::post('/free-item', 'PromotionController@storeFreeItems')->name('promotion.add.free.items.post');

        Route::get('/get-onefree/edit/{id}/{type}', 'PromotionController@editGetOneFreeItem')->name('promotion.edit.getonefree.item');
        Route::post('/get-onefree', 'PromotionController@storeGetOneFreeItems')->name('promotion.add.free.getonefree.post');

        Route::get('/mealbundle/edit/{id}/{type}', 'PromotionController@editMealBundleItem')->name('promotion.edit.mealbundle.item');
        Route::post('/mealbundle', 'PromotionController@storeMealBundleItems')->name('promotion.add.free.mealbundle.post');


        Route::get('/buytwothree/edit/{id}/{type}', 'PromotionController@editBuyTwoThreeItem')->name('promotion.edit.buytwothree.item');
        Route::post('/buytwothree', 'PromotionController@storeBuyTwoThreeItems')->name('promotion.add.free.buytwothree.post');


        Route::get('/fixed-discount/edit/{id}/{type}', 'PromotionController@editFixedDiscountItem')->name('promotion.edit.fixeddiscount.item');
        Route::post('/fixed-discount', 'PromotionController@storeFixedDiscountItems')->name('promotion.add.free.fixeddiscount.post');


        Route::get('/discount-combo/edit/{id}/{type}', 'PromotionController@editDiscountComboItem')->name('promotion.edit.discountcombo.item');
        Route::post('/discount-combo', 'PromotionController@storeDiscountComboItems')->name('promotion.add.free.discountcombo.post');


    });
    Route::prefix('feedback')->group(function () {
        Route::get('/', 'FeedbackController@index')->name('feedback');
        Route::get('/add', 'FeedbackController@add')->name('feedback.add');
        Route::post('/add', 'FeedbackController@store')->name('add.feedback.post');
        Route::get('edit/{id}', 'FeedbackController@edit')->name('feedback.edit');
        Route::post('update', 'FeedbackController@store')->name('edit.feedback.post');
        Route::get('delete/{id}', 'FeedbackController@delete')->name('feedback.delete');
    });

    Route::prefix('contact')->group(function () {
        Route::get('/', 'ContactController@index')->name('contact');
        Route::post('/add', 'ContactController@store')->name('add.contact.post');
    });

    Route::prefix('promotiontype')->group(function () {
        Route::get('/', 'PromotionTypeController@index')->name('promotiontype');
        Route::post('add', 'PromotionTypeController@set_pin')->name('promotionType.set_pin');
    });

    Route::prefix('pin')->group(function () {
        Route::get('/', 'PinController@index')->name('pin.index');
        Route::post('/add', 'PinController@set_pin')->name('promotionType.set_pin');
        Route::post('/verfiy-pin', 'PinController@verfiy_pin')->name('promotionType.verfiy_pin');
    });

    Route::prefix('report')->group(function () {
        Route::get('/', 'ReportController@index')->name('report');
    });

});

//-------------------------- Customer Route ---------------------------------------------- //

Route::prefix('customer')->group(function(){
    Route::get('/','customer\HomeController@index')->name('customer.index');
    Route::get('/login','customer\HomeController@index')->name('customerLogin');
    Route::post('/login','customer\LoginController@attemptLogin')->name('customer.login');
    Route::post('/signup','customer\LoginController@signup')->name('customer.signup');
    Route::post('/email/unique','customer\LoginController@emailUnique')->name('customer.signup.emailUnique');
    Route::post('/mobile/unique','customer\LoginController@mobileUnique')->name('customer.signup.mobileUnique');
    Route::post('/logout','customer\LoginController@logout')->name('customer.logout');
    Route::post('/forgot-password','customer\LoginController@forgotPassword')->name('customer.forgotPassword');
    Route::post('/verify-otp','customer\LoginController@verifyOtp')->name('customer.verifyOtp');
    Route::post('/reset-password','customer\LoginController@resetPassword')->name('customer.resetPassword');
    
    /* Menu Items */
    Route::post('/menu-items','customer\HomeController@index');
    Route::post('/getMenumodifier','customer\HomeController@getMenumodifier');
    Route::post('/search/menuitem','customer\HomeController@searchMenu');

    /* Add To Cart */
    Route::post('/add-to-cart','customer\CartController@addToCart')->name('customer.addToCart');
    Route::post('/opencart-alert-modal','customer\CartController@cartAlert');
    Route::post('/add-to-repeatLast','customer\CartController@addToRepeatLast');
    Route::post('/quantity-decrease','customer\CartController@quantityDecrease');  
    Route::post('/quantity-increment','customer\CartController@quantityIncrement');
    Route::post('/quantity-decrement','customer\CartController@quantityDecrement');

    /* Promotion */
    Route::get('/promotions','customer\PromotionController@index')->name('customer.promotions');

    Route::group(['middleware' => ['web','is_customer']], function () {
        // Route::get('/home','customer\IndexController@homepage')->name('customer.home');

        /* Promotion */
        Route::get('/promotion','customer\PromotionController@show')->name('customer.show.promotions');
        Route::get('/promotion/apply/{promotionId}','customer\PromotionController@applyPromotion')->name('customer.apply.promotion');
        
         /* Hours */
        Route::get('/restaurant/hours','customer\HoursController@index')->name('customer.restaurant.hours');

        /* Cart */
        Route::get('/cart','customer\CartController@index')->name('customer.cart');
        Route::get('/cart/item/delete/{removeKey}/{menuId}','customer\CartController@removeItem')->name('customer.cart.remove.item');
        Route::post('/cart/customize/','customer\CartController@cartCustomize');
        Route::post('/cart/customize/update','customer\CartController@cartCustomizeUpdate')->name('customer.cart.customize.update');

        /* Card List */
        Route::get('/cards/list','customer\CardController@getCardsList')->name('customer.cards.list');
        Route::post('/cards/list','customer\CardController@index')->name('customer.cards');
        Route::get('/cards/add','customer\CardController@create')->name('customer.cards.create');
        Route::post('/cards/add','customer\CardController@store')->name('customer.cards.store');

        /* Orders */
        Route::post('/cart/submit/order','customer\OrdersController@submitToOrder')->name('customer.cart.submit.order');
        Route::get('/orders','customer\OrdersController@index')->name('customer.orders');
        Route::get('/orders/details/{orderId}','customer\OrdersController@orderDetail')->name('customer.orders.details');
        Route::post('/place/order','customer\OrdersController@placeOrder')->name('customer.place.order');
        Route::get('/order/success/','customer\OrdersController@successOrder')->name('customer.order.success');

        /* Contact Us */
        Route::get('/contact','customer\ContactController@index')->name('customer.contacts');

        /* Profile */
        Route::get('/profile/{userId}','customer\ProfileController@profile')->name('customer.profile');
        Route::post('/profile/update','customer\ProfileController@update')->name('customer.profile.update');


        /* Change Password */
        Route::get('/change-password','customer\ProfileController@changePassword')->name('customer.changepassword');
        Route::post('/change-password/submit','customer\ProfileController@changePasswordSubmit')->name('customer.changepassword.submit');

        /* Setting */
        Route::post('/setting/update','customer\SettingController@settingUpdate');

        /* Feedback */
        Route::get('/feedback','customer\FeedbackController@index')->name('customer.feedback.index');
        Route::post('/feedback/submit','customer\FeedbackController@store')->name('customer.feedback.store');

        /* Manage Address */
        Route::get('/address-lists','customer\AddressController@index')->name('customer.address.index');        
        Route::get('/address/addnew','customer\AddressController@create')->name('customer.address.create');
        Route::post('/address/addnew','customer\AddressController@store')->name('customer.address.store');

        /* Chat */
        Route::get('/chat','customer\ChatController@index')->name('customer.chat.index');
        Route::post('/getChats','customer\ChatController@getChat');
        Route::post('/send/message','customer\ChatController@sendMessage');
        Route::get('/chat/export/{orderId}','customer\ChatController@chatExport');
    });
});

Route::get('assets/{path}/{file}', 'CommonController@displayImage')->name('display.image');
Route::get('download/{path}/{file}', 'CommonController@getDownload')->name('download');

//-------------------------- Admin Route ---------------------------------------------- //

Route::prefix('admin')->group(function(){
    
        Route::get('/login','Admin\LoginController@showLogin')->name('admin.login');
        Route::post('/login','Admin\LoginController@attemptLogin')->name('admin.auth.login');
        Route::post('/logout','Admin\LoginController@logout')->name('admin.logout');
        
        /* Forgot Password */
        Route::get('/forgot-password','Admin\ForgotpasswordController@forgotPasswordShow')->name('admin.auth.forgot-password');
        Route::post('/forgot-password','Admin\ForgotpasswordController@forgotPassword')->name('admin.auth.forget-passsword.getcode');
        Route::get('/forgot-password/verify-process','Admin\ForgotpasswordController@verifyProcess')->name('admin.auth.forgot-password.verifyProcess');
        Route::post('/forgot-password/verify-otp','Admin\ForgotpasswordController@verifyOtp')->name('admin.auth.forget-passsword.verifyOtp');
        Route::get('/change-password','Admin\ForgotpasswordController@changePasswordShow')->name('admin.auth.change-password.show');
        Route::post('/change-password','Admin\ForgotpasswordController@resetPassword')->name('admin.auth.change-password');
        Route::group(['middleware' => ['auth:admin','web','is_admin']], function () {
            
            Route::get('/dashboard','Admin\DashboardController@index')->name('admin.index');
            Route::post('/dashboard/filter','Admin\DashboardController@dashboardFilter')->name('admin.dashboard.filter');

            /* Restaurant Users */
            Route::get('/users','Admin\UserController@index')->name('admin.users.index');
            Route::get('/users/restaurant/{restaurantId}','Admin\UserController@restaurantUsers')->name('admin.users.restaurant.users');
            Route::get('/users/detail/{restaurantId}/{userId}','Admin\UserController@userDetail')->name('admin.users.detail');
            Route::get('/users/restaurants/{restaurantId}/export/','Admin\UserController@userExport')->name('admin.users.export');

            /* Restaurants */
            Route::get('/restaurants','Admin\RestaurantController@index')->name('admin.restaurants.index');
            Route::get('/restaurants/edit/{userId}','Admin\RestaurantController@restaurantEdit')->name('admin.restaurants.edit');
            Route::post('/restaurants/update','Admin\RestaurantController@updateDetail')->name('admin.restaurants.update');
            
            
            /* Restaurant Menu */
            Route::get('/restaurants/manage_menu/{restaurantId}','Admin\RestaurantController@manageMenu')->name('admin.restaurants.manage_menu');
            Route::post('/restaurants/menuitem/get','Admin\RestaurantController@categoryMenu')->name('admin.restaurants.categoryMenu');
            Route::get('/restaurants/menu/detail/{menuId}','Admin\RestaurantController@menuDetail')->name('admin.restaurants.menu.detail');
            Route::get('/restaurants/menu/edit/{menuId}','Admin\RestaurantController@edit')->name('admin.restaurants.menu.edit');
            Route::post('/restaurants/menu/type/change/','Admin\RestaurantController@menuChangeType')->name('admin.restaurants.menu.typeChange');
            Route::get('/restaurants/menu/add/{restaurantId}','Admin\RestaurantController@create')->name('admin.restaurants.menu.create');
            Route::post('/restaurants/menu/store','Admin\RestaurantController@store')->name('admin.restaurants.menu.store');
            Route::post('/restaurants/menu/update','Admin\RestaurantController@update')->name('admin.restaurants.menu.update');
            // Route::post('restaurant/email/unique','Admin\RestaurantController@emailUinque')->name('admin.restaurants.emailUnique');
            
            // Route::get('/users/restaurant/{restaurantId}','Admin\UserController@restaurantUsers')->name('admin.users.restaurant.users');
            // Route::get('/users/detail/{restaurantId}/{userId}','Admin\UserController@userDetail')->name('admin.users.detail');

            /* Feedback */
            Route::get('/feedbacks','Admin\FeedbackController@index')->name('admin.feedback.index');

            /* Payment Info */
            Route::get('/paymentInfo/{filter?}','Admin\PaymentInfoController@index')->name('admin.paymentInfo.index');
            Route::get('payment/report/{restaurantId}','Admin\PaymentInfoController@show')->name('admin.paymentInfo.report');
            Route::post('/payment/chart/','Admin\PaymentInfoController@getChartDetail')->name('admin.paymentInfo.chart');

            /* Restaurant Panel */
            Route::get('/{restaurantName?}/{restaurantId}/dashboard','Admin\RestaurantController@ResDashboard')->name('admin.restaurants.dashboard');
                
           
        });
});



