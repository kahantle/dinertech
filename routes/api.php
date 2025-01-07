<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\customer\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|------------------------------------   --------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/search/menu','Api\Customer\MenuItemController@searchMenu');
Route::prefix('customer')->namespace('Api\Customer')->group(function () {
    Route::post('/login', 'UserController@login')->name('customer.login');
    Route::post('/signup', 'UserController@signup')->name('customer.signup');
    Route::post('/verify-otp', 'UserController@verifyOtp')->name('customer.verify-otp');
    Route::post('/forgot-password', 'UserController@forgotPassword')->name('customer.forgot');
    Route::post('/verify-forgot-otp', 'UserController@forgotVerifyOtp')->name('customer.otp.verfy.forgot');
    Route::post('/reset-password', 'UserController@resetPassword')->name('customer.otp.verfy.resetPassword');
    Route::post('/delete-account', 'UserController@deleteAccount')->name('customer.delete-account');
});

  Route::namespace ('Api')->group(function () {

    //API FOR CUSTOMER
    Route::prefix('customer')->namespace('Customer')->group(function () {
        Route::post('/login', 'UserController@login')->name('customer.login');
        Route::post('/signup', 'UserController@signup')->name('customer.signup');
        Route::post('/verify-otp', 'UserController@verifyOtp')->name('customer.verify-otp');
        Route::post('/forgot-password', 'UserController@forgotPassword')->name('customer.forgot');
        Route::post('/verify-forgot-otp', 'UserController@forgotVerifyOtp')->name('customer.otp.verfy.forgot');
        Route::post('/reset-password', 'UserController@resetPassword')->name('customer.otp.verfy.resetPassword');
        // Route::post('/logout', 'UserController@login')->name('customer.logout');
        Route::post('/category-list', 'CategoryController@getCategoryList')->name('customer.category.without.auth.list');
        Route::post('/category-menu-list', 'MenuItemController@getMenuList')->name('category.menu.without.auth.list');
        Route::post('/category-search', 'MenuItemController@searchMenu')->name('customer.menu.without.auth.search');
        Route::post('/modifier-list', 'ModifierController@getModifierList')->name('customer.modifier.without.auth.list');
        Route::post('/promotion-list', 'PromotionController@getRecords')->name('customer.promotion.without.auth.get');
        Route::post('/logout', 'UserController@logout')->name('customer.logout');

        //Role Customer
        Route::middleware(['auth:api'])->group(function () {

            Route::get('check-cart-points','LoyaltyRuleController@checkCartPoints');
            Route::post('/category', 'CategoryController@getCategoryList')->name('customer.category.list');
            Route::post('/profile', 'UserController@profile')->name('customer.profile');
            Route::post('/category-menu', 'MenuItemController@getMenuList')->name('customer.category.menu.list');
            Route::post('/modifier', 'ModifierController@getModifierList')->name('customer.modifier.list');
            Route::post('/menu', 'MenuItemController@getMenuList')->name('customer.menu.list');
            Route::post('/search/menu', 'MenuItemController@searchMenu')->name('customer.menu.search');
            Route::post('/hours', 'RestaurantHoursController@get')->name('customer.menu.hours');
            Route::post('/check-availability','RestaurantHoursController@checkAvailability')->name('customer.check-availability');
            Route::post('/change-password', 'UserController@changePassword')->name('customer.change.password');
            Route::prefix('promotion')->group(function () {
                Route::post('/list', 'PromotionController@getRecords')->name('customer.promotion.get');
                Route::post('/items', 'PromotionController@getItems')->name('customer.promotion.items.get');
            });
            Route::prefix('address')->group(function () {
                Route::post('/', 'AddressController@getAddressList')->name('address.list');
                Route::post('/add', 'AddressController@addAddress')->name('add.address');
                Route::post('/delete', 'AddressController@deleteAddress')->name('delete.address.list');
            });
            Route::prefix('feedback')->group(function () {
                Route::post('/add', 'FeedbackController@addFeedback')->name('feedback.add');
            });
            Route::prefix('card')->group(function () {
                Route::post('/', 'CardController@list')->name('cards.list');
                Route::post('/add', 'CardController@add')->name('add.card');
                Route::post('/delete', 'CardController@delete')->name('delete.cards.list');
            });
            Route::prefix('order')->group(function () {
                Route::post('/add', 'OrderController@add')->name('order.add');
                Route::post('/list', 'OrderController@getOrderList')->name('order.list');
                Route::post('/id', 'OrderController@getOrderById')->name('order.id');
            });
            Route::prefix('setting')->group(function () {
                Route::post('/get', 'UserSettingController@get')->name('setting.list');
                Route::post('/set', 'UserSettingController@add')->name('setting.set');
            });
            Route::prefix('payment')->group(function () {
                Route::post('/', 'PaymentController@payment')->name('stripe.payment');
            });
            Route::prefix('chat')->group(function () {
                Route::post('/notification', 'UserController@sendChatNotification')->name('customer.chat.notification');
            });
            Route::prefix('stripe')->group(function () {
                Route::post('/create/connection/token', 'StripeController@getConnectionToken')->name('customer.stripe.createConnectionToken');
                Route::post('/create/charge', 'StripeController@createCharge')->name('customer.stripe.createCharge');
            });
            Route::prefix('loyalties')->group(function(){
                Route::post('/','LoyaltyRuleController@index')->name('customer.loyalties');
            });


            Route::prefix('cart')->group(function(){
                Route::post('/',[CartController::class,'index'])->name('customer.carts');
                Route::post('/apply-promotion', [CartController::class, 'applyPromotion']);
                Route::post('/remove-promotion', [CartController::class, 'removePromotion']);
                Route::post('/add',[CartController::class,'store'])->name('customer.carts.add');
                Route::post('/quantity/decrement','CartController@quantityDecrement')->name('customer.cart.quantityDecrement');
                Route::post('/getMenu/modifier','CartController@getCartMenuModifier')->name('customer.cart.getMenu.modifier');
                Route::post('/customize/modifier','CartController@customizeModifier')->name('customer.cart.customize.modifier');
                Route::post('/delete',[CartController::class,'destroy'])->name('customer.cart.delete');
                Route::post('/delete-loyalty',[CartController::class,'destroyLoyalty'])->name('customer.cart.delete.loyalty');
                Route::post('/quantity/increment','CartController@quantityIncrement')->name('customer.cart.quantityIncrement');

            });
        });

    });

    

    //API FOR restaurant

    Route::prefix('restaurant')->namespace('Restaurant')->group(function () {
        Route::post('/login', 'UserController@login')->name('restaurant.login');
        Route::post('/store_pin', 'UserController@store_pin')->name('restaurant.store.pin');
        Route::post('/signup', 'UserController@signup')->name('restaurant.signup');
        Route::post('/verify-otp', 'UserController@verifyOtp')->name('restaurant.verify-otp');
        Route::post('/forgot-password', 'UserController@forgotPassword')->name('restaurant.forgot');
        Route::post('/verify-forgot-otp', 'UserController@forgotVerifyOtp')->name('restaurant.otp.verfy.forgot');
        Route::post('/reset-password', 'UserController@resetPassword')->name('restaurant.otp.verfy.resetPassword');
        Route::post('/logout', 'UserController@logout')->name('restaurant.logout');
        Route::post('set-sales-tax', 'UserController@setSalesTax')->name('restaurant.set.sales.tax');

        //-------------------------- Restaurant Web-url Route Start---------------------------------------------- //
        //Subscription Route
        Route::prefix('subscriptions')->group(function () {
            Route::get('/{uid?}', 'EmailSubscriptionController@index')->name('restaurant.email.subscriptions.list');
            Route::post('/payment/modal', 'EmailSubscriptionController@paymentModal')->name('restaurant.email.subscriptions.payment');
            Route::post('pay', 'EmailSubscriptionController@subscriptionPayment')->name('restaurant.email.subscription.pay');
            Route::get('/cancel/subscription/{subscription_id}/{uid}', 'EmailSubscriptionController@cancel_subscription')->name   ('restaurant.email.subscription.cancel');
            Route::get('/upgrade/subscription/{uid?}', 'EmailSubscriptionController@upgradeSubscription')->name('restaurant.email.subscription.upgrade');
        });

        //Campaign Route
        Route::prefix('campaigns')->group(function () {
            Route::get('/{userId?}', 'EmailSubscriptionController@campaigns')->name('restaurant.email.campaigns');
            Route::get('/create/campaign/{userId}', 'EmailSubscriptionController@createCampaigns')->name('restaurant.email.campaign.create');
            Route::post('/report', 'EmailSubscriptionController@getReport')->name('restaurant.email.campaign.get.report');
            Route::post('/delete', 'EmailSubscriptionController@destroy')->name('restaurant.email.campaign.destroy');
        });
        //-------------------------- Restaurant Web-url Route End---------------------------------------------- //

        Route::middleware(['auth:api', 'role-restaurant'])->group(function () {

            Route::post('/category', 'CategoryController@getCategoryList')->name('customer.category.list');
            Route::post('/category/item', 'CategoryController@getCategoryItemList')->name('customer.category.item.list');
            Route::post('/category/add', 'CategoryController@addCategory')->name('customer.category.add');
            Route::post('/category/update', 'CategoryController@addCategory')->name('update.update.post');
            Route::post('/category/delete', 'CategoryController@delete')->name('category.delete');

            Route::post('/modifier/add', 'ModifierController@addModifierGroup')->name('customer.modifier.add');
            Route::post('/modifier/edit', 'ModifierController@editModifierGroup')->name('customer.modifier.edit');
            Route::post('/modifier', 'ModifierController@getModifierList')->name('customer.modifier.list');
            Route::post('/modifier-item', 'ModifierController@addModifierGroupItem')->name('customer.modifier.add');
            Route::post('/modifier-edit-item', 'ModifierController@editModifierGroupItem')->name('customer.modifier.edit');
            Route::post('/modifier/delete', 'ModifierController@delete')->name('modifier.delete');
            Route::post('/modifier-item/delete', 'ModifierController@deleteItem')->name('modifier.item.delete');
            Route::post('/modifier_sequence', 'ModifierController@storeModifierSequence')->name('store.modifier.sequence');

            Route::post('/menu', 'MenuItemController@getMenuList')->name('restaurant.menu.list');
            Route::post('/menu/add', 'MenuItemController@addMenuItem')->name('restaurant.menu.add');
            Route::post('/menu/update', 'MenuItemController@addMenuItem')->name('restaurant.menu.update');
            Route::post('/menu/delete', 'MenuItemController@delete')->name('menu.delete');

            Route::post('/category-menu', 'MenuItemController@getMenuListByCategory')->name('customer.category.menu.list');
            Route::prefix('promotion-type')->group(function () {
                Route::post('/', 'PromotionTypeController@getRecords')->name('restaurant.promotion.type.list');
            });
            Route::prefix('promotion')->group(function () {
                Route::post('/add', 'PromotionController@addRecord')->name('restaurant.promotion.add');
                Route::post('/list', 'PromotionController@getRecords')->name('restaurant.promotion.get');
                Route::post('/active', 'PromotionController@active')->name('restaurant.promotion.active');
                Route::post('/eligible', 'PromotionController@getRecordById')->name('restaurant.promotion.get.by.id');
                Route::post('/category/add', 'PromotionController@addCategoryRecord')->name('restaurant.promotion.add');
                Route::post('/status', 'PromotionController@status')->name('restaurant.promotion.status');
                Route::post('/delete', 'PromotionController@delete')->name('restaurant.promotion.delete');
                Route::post('/webview', 'PromotionController@getWebview')->name('restaurant.promotion.getWebview');
            });
            Route::prefix('hour')->group(function () {
                Route::post('/', 'RestaurantHoursController@get')->name('menu');
                Route::post('/add', 'RestaurantHoursController@add')->name('add.hour.post');
                Route::post('/update', 'RestaurantHoursController@update')->name('update.hour.post');
                Route::post('/delete', 'RestaurantHoursController@delete')->name('update.hour.delete');
            });
            Route::prefix('contact')->group(function () {
                Route::post('/', 'ContactController@add')->name('contact');
            });
            Route::prefix('feedback')->group(function () {
                Route::post('/', 'FeedbackController@add')->name('contact');
            });

            Route::prefix('report')->group(function () {
                Route::post('/', 'ReportController@index')->name('contact');
            });

            Route::prefix('outofstock')->group(function () {
                Route::post('/', 'StockController@index')->name('outofstock');
            });

            Route::prefix('chat-number')->group(function () {
                Route::post('/', 'ChatNumberController@index')->name('outofstock');
            });

            Route::prefix('pin')->group(function () {
                Route::post('/add', 'PinController@add')->name('set.pin');
                Route::post('/status', 'PinController@status')->name('pin.status');
            });
            Route::prefix('order')->group(function () {
                Route::post('/list', '  @getOrderList')->name('order.list');
                Route::post('/recent', 'OrderController@getRecentOrder')->name('order.recent');
                Route::post('/id', 'OrderController@getOrderById')->name('order.id');
                Route::post('/accept', 'OrderController@makeOrder')->name('order.accept');
                Route::post('/prepared', 'OrderController@preparedOrder')->name('order.prepared');
                Route::post('/cancel', 'OrderController@cancelOrder')->name('order.cancel');
                Route::post('/due','OrderController@dueOrder')->name('order.due');
                Route::post('/refund', 'OrderController@refundOrder')->name('order.refund');
                Route::post('/refund', 'OrderController@refundOrder')->name('order.refund');
            });
            Route::prefix('chat')->group(function () {
                Route::post('/notification', 'ChatNumberController@sendChatNotification')->name('customer.chat.notification');
                Route::post('/message/read','ChatNumberController@readChatMessage')->name('chat.read.message');
            });

            Route::prefix('account')->group(function () {
                Route::post('subscriptions', 'AccountController@getSubscriptions');
                Route::post('/setting/update', 'AccountController@updateSetting')->name('account.update.setting');
                Route::post('/settings', 'AccountController@getSettings');
                Route::post('/delete', 'AccountController@deleteAccount');
            });

        });

        Route::prefix('loyalties')->group(function () {
            Route::get('/list/{user_id}', 'LoyaltiController@index')->name('mobile_view.loyalties.list');
            Route::post('/add/{user_id}', 'LoyaltiController@store')->name('mobile_view.loyalties.add');
            Route::post('/edit/{user_id}', 'LoyaltiController@edit')->name('mobile_view.loyalties.edit');
            Route::post('/delete/{user_id}', 'LoyaltiController@destroy')->name('mobile_view.loyalties.destroy');
            Route::post('/change/status/{user_id}','LoyaltiController@changeStatus')->name('mobile_view.change.status');
        });
    });
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('client-id', [CampaignController::class, 'getClients']);
    Route::post('sub-list', [CampaignController::class, 'getAllSubscribers']);
});

Route::post('/customer/search-address', [ProfileController::class, 'searchAddress']);
