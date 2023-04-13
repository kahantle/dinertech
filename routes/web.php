<?php

use Illuminate\Support\Facades\Route;

//-------------------------- Restaurant Route ---------------------------------------------- //

Route::get('/', 'HomeController@index')->name('home');
Route::post('/contact', 'HomeController@contact')->name('contact');

//-------------------------- Restaurant Web-url Route Start---------------------------------------------- //

Route::get('promotion_type/{id}/restaurant/{restaurant_id}/webview/{formType}/{promotionId?}', 'PromotionController@webViewForm')->name('promotion.type.webViewForm');
Route::post('promotion-add/cart/post', 'PromotionController@storeCart')->name('promotion.add.cart.post.webview');
Route::post('promotion-add/select-item', 'PromotionController@storeSelectedItems')->name('promotion.add.selected.items.webView');
Route::post('promotion-add/free-delivery', 'PromotionController@storefreedelivery')->name('promotion.add.free.delivery.webView');
Route::post('promotion-add/payment-method-reward', 'PromotionController@storePaymentMethod')->name('promotion.add.payment.method.webView');
Route::post('promotion-add/free-item', 'PromotionController@storeFreeItems')->name('promotion.add.freeItem.webView');
Route::post('promotion-add/get-one-free', 'PromotionController@storeGetOneFreeItems')->name('promotion.add.get.one.free.webView');
Route::post('promotion-add/mealBundle/', 'PromotionController@storeMealBundleItems')->name('promotion.add.mealbundle.webView');
Route::post('promotion-add/buy-twoThree-get-one/', 'PromotionController@storeBuyTwoThreeItems')->name('promotion.add.buy-twoThree-get-one.webView');
Route::post('promotion-add/fixed-discount/', 'PromotionController@storeFixedDiscountItems')->name('promotion.add.fixed-discount.webView');
Route::post('promotion-add/discount-combo/', 'PromotionController@storeFixedDiscountItems')->name('promotion.add.discount-combo.webView');
Route::post('promotion-add/getCategory', 'PromotionController@getCategories')->name('promotion.get.categories');
//-------------------------- Restaurant Web-url Route End---------------------------------------------- //

// Route::prefix('web')->group(function () {
Route::namespace ('Auth')->group(function () {
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
    Route::view('/status', 'auth.login')->name('status');
    Route::get('/active-request', 'VerificationController@accountActiveRequest')->name('account.active.request');
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

    Route::prefix('profile')->group(function () {
        Route::get('/', 'ProfileController@index')->name('profile');
        Route::post('/update/profile', 'ProfileController@update')->name('update.profile.post');
        Route::view('/update_status', 'dashboard')->name('update_status');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', 'AccountController@index')->name('account');
        Route::get('/menu_pin', 'AccountController@menuPin')->name('menu.pin');
        Route::post('/set_menu_pin', 'AccountController@setMenuPin')->name('set.menu.pin');
        Route::post('/remove_menu_pin', 'AccountController@removeMenuPin')->name('remove.menu.pin');
        Route::post('/verify_menu_pin', 'AccountController@verifyMenuPin')->name('verify.menu.pin');

        Route::post('/update-account-settings', 'AccountController@update')->name('update-account-settings');
        Route::get('/active-subscriptions','AccountController@showActiveSubscription')->name('account.active.subscription');
        Route::post('/delete','AccountController@deleteAccount')->name('account.delete');
    });
    Route::prefix('chat')->group(function () {
        Route::get('/', 'ChatController@index')->name('chat');
        Route::post('/store-token', 'ChatController@storeToken')->name('store.token');
        Route::get('/{order_number}', 'ChatController@index')->name('chat.order');
        Route::post('/sendMessages', 'ChatController@sendMessages')->name('chat.send');
        Route::post('/getMessages', 'ChatController@getMessages')->name('chat.get');
        Route::post('/message/count/update','ChatController@readChatMessage')->name('chat.message.count');
    });

    Route::prefix('hours')->group(function () {
        Route::get('/', 'HoursController@index')->name('hours');
        Route::post('add', 'HoursController@store')->name('add.hour.post');
        Route::get('add', 'HoursController@add')->name('add.hours');
        Route::get('edit/{id}', 'HoursController@edit')->name('edit.hour');
        Route::post('update', 'HoursController@update')->name('update.hours.post');
        Route::get('delete/{id}', 'HoursController@delete')->name('delete.hour.post');
        Route::get('delete-time/{id}','HoursController@delete_time')->name('delete_time.hour.post');
    });

    Route::prefix('modifier')->group(function () {
        Route::get('/', 'ModifiersController@index')->name('modifier');
        Route::post('/', 'ModifiersController@addModifierGroup')->name('add.modifier.post');
        Route::post('item', 'ModifiersController@addModifierGroupItem')->name('add.modifier.item.post');
        Route::get('edit/{id}', 'ModifiersController@editModifierGroup')->name('edit.modifier.post');
        Route::get('edit-item/{id}', 'ModifiersController@editModifierItem')->name('edit.modifier.item.post');
        Route::get('delete/{id}', 'ModifiersController@deleteGroup')->name('delete.modifier.post');
        Route::get('delete-item/{id}', 'ModifiersController@deleteItem')->name('delete.modifier.item.post');

          /* New Added */
        Route::post('/store', 'ModifiersController@storeModifierGroup')->name('store.modifier.post');
        Route::post('/edit', 'ModifiersController@editModifierGroupNew')->name('edit.modifier.post.new');
        Route::post('item', 'ModifiersController@addModifierGroupItemNew')->name('add.modifier.item.post.new');
        Route::post('item', 'ModifiersController@addModifierGroupItemNew')->name('add.modifier.item.post.new');
        Route::get('delete', 'ModifiersController@deleteGroup')->name('delete.modifier.post.new');
        Route::post('edit-item', 'ModifiersController@editModifierItemNew')->name('edit.modifier.item.post.new');
        Route::get('delete-item', 'ModifiersController@deleteItemNew')->name('delete.modifier.item.post.new');
    });

    Route::prefix('menu')->group(function () {
        Route::get('/', 'MenuController@index')->name('menu');
        Route::get('/add', 'MenuController@add')->name('add.menu');
        Route::post('add', 'MenuController@store')->name('add.menu.post');
        Route::get('edit/{id}', 'MenuController@edit')->name('edit.menu');
        Route::post('update', 'MenuController@update')->name('update.menu.post');
        Route::get('delete/{id}', 'MenuController@delete')->name('delete.menu.post');
        Route::post('remove/image/', 'MenuController@removeMenuImage')->name('remove.menu.image');
        Route::post('store_stock_until', 'MenuController@storeStockUntil')->name('store.stock.until');

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
        Route::post('/status/due','OrderController@orderDueStatus')->name('order.status.due');
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
        Route::post('custom-tips', 'ReportController@customTips')->name('report.custom_tips');
    });

    Route::prefix('subscriptions')->group(function () {
        Route::get('/', 'SubscriptionController@index')->name('subscriptions');
        Route::post('payment/modal', 'SubscriptionController@payment')->name('subscription.payment.modal');
        Route::post('pay', 'SubscriptionController@subscriptionPayment')->name('subscription.pay');
        Route::get('/cancel/subscription/{subscription_id}', 'SubscriptionController@cancel_subscription')->name('subscription.cancel');
        Route::get('/upgrade/subscription', 'SubscriptionController@upgradeSubscription')->name('subscription.upgrade');
    });

    Route::prefix('campaigns')->group(function () {
        Route::get('/', 'CampaignController@index')->name('campaigns');
        Route::get('/create/campaign', 'CampaignController@create')->name('campaign.create');
        Route::post('/report', 'CampaignController@show')->name('campaign.get.report');
        Route::post('/delete', 'CampaignController@destroy')->name('campaign.destroy');
    });

    Route::prefix('loyalty')->group(function () {
        Route::get('/', 'LoyaltyController@index')->name('loyalty.index');
        Route::get('/list', 'LoyaltyController@loyalty_list')->name('loyalty.list');
        Route::post('/pay', 'LoyaltyController@payment')->name('loyalty.payment');

        /* Loyalty */
        Route::post('/add','LoyaltyController@store')->name('loyalty.add');
        Route::post('/change/status','LoyaltyController@changeStatus')->name('loyalty.change.status');
        Route::post('/edit','LoyaltyController@edit')->name('loyalty.edit');
        Route::post('/delete','LoyaltyController@destroy')->name('loyalty.delete');
        Route::get('/cancel/plan/{planId}','LoyaltyController@cancelPlan')->name('loyalty.plan.cancel');

        /* Loyalty Rules */
        Route::get('/rules', 'LoyaltyRuleController@index')->name('loyalty.rules');
        Route::post('/rules/add', 'LoyaltyRuleController@store')->name('loyalty.rules.add');
        Route::get('/rule/data/{ruleId}', 'LoyaltyRuleController@edit')->name('loyalty.rule.get');
        Route::post('/rules/update', 'LoyaltyRuleController@update')->name('loyalty.rules.update');
        Route::post('/rules/delete', 'LoyaltyRuleController@destroy')->name('loyalty.rules.delete');
    });
});

// });
Route::get('assets/{path}/{file}', 'CommonController@displayImage')->name('display.image');
Route::get('download/{path}/{file}', 'CommonController@getDownload')->name('download');

//-------------------------- Customer Route ---------------------------------------------- //

Route::prefix('customer')->group(function () {
    Route::get('/', 'customer\HomeController@index')->name('customer.index');
    Route::get('/login', 'customer\HomeController@index')->name('customerLogin');
    Route::post('/login', 'customer\LoginController@attemptLogin')->name('customer.login');
    Route::post('/signup', 'customer\LoginController@signup')->name('customer.signup');
    Route::post('/email/unique', 'customer\LoginController@emailUnique')->name('customer.signup.emailUnique');
    Route::post('/mobile/unique', 'customer\LoginController@mobileUnique')->name('customer.signup.mobileUnique');
    Route::post('/logout', 'customer\LoginController@logout')->name('customer.logout');
    Route::post('/forgot-password', 'customer\LoginController@forgotPassword')->name('customer.forgotPassword');
    Route::post('/verify-otp', 'customer\LoginController@verifyOtp')->name('customer.verifyOtp');
    Route::post('/reset-password', 'customer\LoginController@resetPassword')->name('customer.resetPassword');

    /* Promotion */
    Route::get('/promotions', 'customer\PromotionController@index')->name('customer.promotions');
    Route::post('/promotions/menu/getMenuModifier', 'customer\PromotionController@promotionMenuModifier')->name('customer.promotion.menu.modifier');
    Route::post('/promotion/menu/add-to-cart', 'customer\PromotionController@promotionMenuAddCart')->name('customer.promotion.menu.add.cart');

    /*New Prmotion*/
    Route::post('/newpromotion', 'customer\NewPromotionContoller@discountcart');

    /*Remove Couoen */
    Route::post('/remove_coupon_code','customer\NewPromotionContoller@remove_coupon_code');

    /* Google Signing */
    Route::get('auth/google', 'customer\GoogleController@redirectToGoogle')->name('customer.google.login');
    Route::get('auth/google/callback', 'customer\GoogleController@handleGoogleCallback')->name('customer.google.redirectUrl');

    Route::group(['middleware' => ['web', 'is_customer']], function () {
        // Route::get('/home','customer\IndexController@homepage')->name('customer.home');
        Route::get('set-system-time', 'customer\HomeController@setSystemTime')->name('customer.system.time');

        /* Menu Items */
        Route::post('/menu-items', 'customer\HomeController@getMenuItems');
        Route::post('/getMenumodifier', 'customer\HomeController@getMenumodifier');
        Route::post('/search/menuitem', 'customer\HomeController@searchMenu');

        /* Add To Cart */
        Route::post('/add-to-cart', 'customer\CartController@addToCart')->name('customer.addToCart');
        Route::post('/modal-for-plus-with-modifiers', 'customer\CartController@modalForPlusWithModifiers');
        Route::post('/add-to-repeatLast', 'customer\CartController@addToRepeatLast');
        Route::post('/quantity-decrease', 'customer\CartController@quantityDecrease');
        Route::post('/quantity-change', 'customer\CartController@quantityChange');

        /* Promotion */
        Route::get('/promotion', 'customer\PromotionController@show')->name('customer.show.promotions');
        Route::get('/promotion/get/eligible-items/{promotionId}', 'customer\PromotionController@getEligibleItems')->name('customer.promotions.getEligibleItems');
        Route::get('/promotion/apply/{promotionId}', 'customer\PromotionController@applyPromotion')->name('customer.apply.promotion');



        /* Hours */
        Route::get('/restaurant/information', 'customer\HoursController@index')->name('customer.restaurant.information');
        Route::post('contact/restaurant/send-mail', 'customer\HoursController@sendMail')->name('customer.restaurant.sendmail');
        // Route::get('/restaurant/information', 'customer\HoursController@index')->name('customer.restaurant.hours');

        /* Cart */
        Route::get('/cart', 'customer\CartController@index')->name('customer.cart');
        Route::post('/cart/item/delete', 'customer\CartController@removeItem')->name('customer.cart.remove.item');
        Route::post('/cart/customize/', 'customer\CartController@cartCustomize');
        Route::post('/cart/customize/update', 'customer\CartController@cartCustomizeUpdate')->name('customer.cart.customize.update');

        /* Card List */
        Route::get('/cards/list', 'customer\CardController@getCardsList')->name('customer.cards.list');
        Route::post('/cards/list', 'customer\CardController@index')->name('customer.cards');
        Route::get('/cards/add', 'customer\CardController@create')->name('customer.cards.create');
        Route::post('/cards/add', 'customer\CardController@store')->name('customer.cards.store');
        Route::post('/cards/delete', 'customer\CardController@delete')->name('customer.cards.delete');

        /* Orders */
        Route::post('/cart/submit/order', 'customer\OrdersController@placeOrder')->name('customer.cart.submit.order');
        Route::get('/orders', 'customer\OrdersController@index')->name('customer.orders');
        Route::get('/orders/details/{orderId}', 'customer\OrdersController@orderDetail')->name('customer.orders.details');
        // Route::post('/place/order', 'customer\OrdersController@placeOrder')->name('customer.place.order');
        Route::get('/order/success/', 'customer\OrdersController@successOrder')->name('customer.order.success');

        /* Contact Us */
        // Route::get('/contact', 'customer\ContactController@index')->name('customer.contacts');

        /* Profile */
        Route::get('/profile', 'customer\ProfileController@profile')->name('customer.profile');
        Route::post('/profile/update', 'customer\ProfileController@update')->name('customer.profile.update');

        /* Change Password */
        Route::get('/change-password', 'customer\ProfileController@changePassword')->name('customer.changepassword');
        Route::post('/change-password/submit', 'customer\ProfileController@changePasswordSubmit')->name('customer.changepassword.submit');

        /* Setting */
        Route::post('/setting/update', 'customer\SettingController@settingUpdate')->name('customer.settings.update');
        Route::get('/setting', 'customer\SettingController@index')->name('customer.settings');

        /* Feedback */
        Route::get('/feedback', 'customer\FeedbackController@index')->name('customer.feedback.index');
        Route::post('/feedback/submit', 'customer\FeedbackController@store')->name('customer.feedback.store');

        /* Manage Address */
        Route::get('/address-lists', 'customer\AddressController@index')->name('customer.address.index');
        Route::get('/address/addnew', 'customer\AddressController@create')->name('customer.address.create');
        Route::post('/address/addnew', 'customer\AddressController@store')->name('customer.address.store');

        /* Chat */
        Route::get('/chats', 'customer\ChatController@index')->name('customer.chat.index');
        Route::post('/chats/store-token', 'customer\ChatController@storeToken')->name('customer.store.token');
        Route::post('/getChats', 'customer\ChatController@getChat');
        Route::post('/send/message', 'customer\ChatController@sendMessage');
        Route::get('/chat/export/{orderId}', 'customer\ChatController@chatExport');

        //Loyalty

        Route::get('loyalty', 'customer\LoyaltyController@index')->name('customer.loyalty');

        // contact us
        Route::get('contact-us','customer\ContactController@index')->name('customer.contact-us');

    });
});

//-------------------------- Admin Route ---------------------------------------------- //

Route::prefix('admin')->group(function () {
    Route::get('/', 'Admin\LoginController@showLogin')->name('admin.show.login');
    Route::get('/login', 'Admin\LoginController@showLogin')->name('admin.login');
    Route::post('/login', 'Admin\LoginController@attemptLogin')->name('admin.auth.login');
    Route::post('/logout', 'Admin\LoginController@logout')->name('admin.logout');

    /* Forgot Password */
    Route::get('/forgot-password', 'Admin\ForgotpasswordController@forgotPasswordShow')->name('admin.auth.forgot-password');
    Route::post('/forgot-password', 'Admin\ForgotpasswordController@forgotPassword')->name('admin.auth.forget-passsword.getcode');
    Route::get('/forgot-password/verify-process', 'Admin\ForgotpasswordController@verifyProcess')->name('admin.auth.forgot-password.verifyProcess');
    Route::post('/forgot-password/verify-otp', 'Admin\ForgotpasswordController@verifyOtp')->name('admin.auth.forget-passsword.verifyOtp');
    Route::get('/chage-password', 'Admin\ForgotpasswordController@changePasswordShow')->name('admin.auth.change-password.show');
    Route::post('/change-password', 'Admin\ForgotpasswordController@resetPassword')->name('admin.auth.change-password');
    Route::group(['middleware' => ['auth:admin', 'web', 'is_admin']], function () {

        Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.index');
        Route::post('/dashboard/filter', 'Admin\DashboardController@dashboardFilter')->name('admin.dashboard.filter');

        /* Restaurant Users */
        Route::get('/users', 'Admin\UserController@index')->name('admin.users.index');
        Route::get('/users/restaurant/{restaurantId}', 'Admin\UserController@restaurantUsers')->name('admin.users.restaurant.users');
        Route::get('/users/detail/{restaurantId}/{userId}', 'Admin\UserController@userDetail')->name('admin.users.detail');
        Route::get('/users/restaurants/{restaurantId}/export/', 'Admin\UserController@userExport')->name('admin.users.export');

        /* Restaurants */
        Route::get('/restaurants', 'Admin\RestaurantController@index')->name('admin.restaurants.index');
        Route::get('/restaurants/edit/{userId}', 'Admin\RestaurantController@restaurantEdit')->name('admin.restaurants.edit');
        // Route::post('/restaurants/update','Admin\RestaurantController@updateDetail')->name('admin.restaurants.update');
        Route::put('/restaurants/update/{uid}', 'Admin\RestaurantController@updateDetail')->name('admin.restaurants.update');

        /* Restaurant Menu */
        Route::get('/restaurants/manage_menu/{restaurantId}', 'Admin\RestaurantController@manageMenu')->name('admin.restaurants.manage_menu');
        Route::post('/restaurants/menuitem/get', 'Admin\RestaurantController@categoryMenu')->name('admin.restaurants.categoryMenu');
        Route::get('/restaurants/menu/detail/{menuId}', 'Admin\RestaurantController@menuDetail')->name('admin.restaurants.menu.detail');
        Route::get('/restaurants/menu/edit/{menuId}', 'Admin\RestaurantController@edit')->name('admin.restaurants.menu.edit');
        Route::post('/restaurants/menu/type/change/', 'Admin\RestaurantController@menuChangeType')->name('admin.restaurants.menu.typeChange');
        Route::get('/restaurants/menu/add/{restaurantId}', 'Admin\RestaurantController@create')->name('admin.restaurants.menu.create');
        Route::post('/restaurants/menu/store', 'Admin\RestaurantController@store')->name('admin.restaurants.menu.store');
        Route::post('/restaurants/menu/update', 'Admin\RestaurantController@update')->name('admin.restaurants.menu.update');
        // Route::post('restaurant/email/unique','Admin\RestaurantController@emailUinque')->name('admin.restaurants.emailUnique');

        // Route::get('/users/restaurant/{restaurantId}','Admin\UserController@restaurantUsers')->name('admin.users.restaurant.users');
        // Route::get('/users/detail/{restaurantId}/{userId}','Admin\UserController@userDetail')->name('admin.users.detail');

        /* Feedback */
        Route::get('/feedbacks', 'Admin\FeedbackController@index')->name('admin.feedback.index');

        /* Payment Info */
        Route::get('/paymentInfo/{filter?}', 'Admin\PaymentInfoController@index')->name('admin.paymentInfo.index');
        Route::get('payment/report/{restaurantId}', 'Admin\PaymentInfoController@show')->name('admin.paymentInfo.report');
        Route::post('/payment/chart/', 'Admin\PaymentInfoController@getChartDetail')->name('admin.paymentInfo.chart');

        /* Restaurant Panel */
        Route::get('/{restaurantName?}/{restaurantId}/dashboard', 'Admin\RestaurantController@ResDashboard')->name('admin.restaurants.dashboard');

    });
});
