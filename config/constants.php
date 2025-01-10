<?php
return [
    'OTP_VALID_DURATION' => 15,
    'PAGINATION_PER_PAGE' => 12,
    'OTP_NO_OF_DIGIT' => 1000,
    'ROLES' => [
        'SUPERADMIN' => 'SUPERADMIN',
        'ADMIN' => 'ADMIN',
        'RESTAURANT' => 'RESTAURANT',
        'CUSTOMER' => 'CUSTOMER',
    ],
    'STATUS' => [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE',
        'SCHEDULE' => 'SCHEDULE'
    ],
    'PAYMENT_STATUS' => [
        'PAID' => 'PAID',
        'UNPAID' => 'UNPAID',
        'REFUND' => 'REFUND',
        'SUCCESS' => 'SUCCESS',
        'NOT_STARTED' => 'NOT STARTED',
    ],
    'IMAGES' => [
        'USER_IMAGE_PATH' => 'users',
        'CATEGORY_IMAGE_PATH' => 'category_image',
        'MENU_IMAGE_PATH' => 'menu_image',
        'RESTAURANT_USER_IMAGE_PATH' => 'restaurant_user_image',
    ],
    'ORDER_STATUS' => [
        'INITIAL' => 'INITIAL',
        'PROGRESS' => 'PROGRESS',
        'ACCEPTED' => 'ACCEPTED',
        'PREPARED' => 'PREPARED',
        'COMPLETED' => 'COMPLETED',
        'CANCEL' => 'CANCEL',
        'CANCELREFUND' => 'CANCEL AND REFUND',
        'REFUND' => 'REFUND',
        'ORDER_DUE' => 'ORDER DUE',
    ],
    'DISCOUNT_TYPE' => [
        'USD' => 'USD',
        'PERCENT' => 'PERCENT',
    ],
    'toster' => [
        "closeButton" => false,
        "debug" => false,
        "newestOnTop" => false,
        "progressBar" => false,
        "positionClass" => "toast-top-right",
        "preventDuplicates" => false,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "5000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut",
    ],
    'COMMON_MESSAGES' => [
        'DB_ERRORS' => 'Please try again!!',
        'CATCH_ERRORS' => 'Please try again!!',
        'COMMON_MESSAGE' => 'Something wrong please try again!!',
    ],
    'SNICH_KEY' => [
        // 'FROM' => '447537404817',
        'FROM'  => '4242317961',
        'TOKEN' => 'Bearer a0a605c3c2644138aa3e37712a7c7207',
        // 'PLAN_ID' => 'aa97d8b8af8d4440a1d45b328c7abf17',
        'PLAN_ID'   => 'aa97d8b8af8d4440a1d45b328c7abf17',
        'MESSAGE' => 'Dear User,Your OTP is',
    ],
    'PUBLIC_ASSETS_PATH' => 'web/',
    'RESTAURANT_CHARGE' => '79.99',
    'LOYALTY_CHARGE'    => '29.00',
    // 'CLIENT_TYPE' => [
    //     '1' => 'Any Client,new or Returning',
    //     '2' => 'Only new Clients',
    //     '3' => 'Only Returning'
    // ],
    'CLIENT_TYPE' => [
        '1' => 'Any Customer,New or Returning',
        '2' => 'Only New Customer',
        '3' => 'Only Returning Customer',
    ],
    'ORDER_TYPE' => [
        '1' => 'Any Type',
        '2' => 'Pickup Type',
        // '3' => 'Delhivery'
    ],
    'MARK_PROMO_AS' => [
        '1' => 'Not Exclusive',
        '2' => 'Exclusive',
        '3' => 'Master Promo Deal',
    ],
    'DISPLAY_TIME' => [
        '1' => 'Always Shows to eligible clients',
        '2' => 'Hide for menu redeem with coupon code',
        '3' => 'Limited to show times',
    ],
    'NO_EXTRA_CHARGES' => [
        '1' => 'No extra charges',
        '2' => 'Charges extra for Choices/Addons',
        '3' => 'Charges extra for Choices/Addons & Sizes',
    ],
    'AUTO_DISCOUNT' => [
        '1' => 'Automatically set discount',
        '2' => 'Manually set discount',
    ],
    'FIREBASE_DB_NAME' => 'chats',
    'CONTACT_MAIL' => 'kwest@dinertech.io', 
    'CUSTOMER_FEEDBACK_TYPE' => [
        '1' => 'General Feedback',
        '2' => 'Quality Feedback',
        '3' => 'Delivery Feedback',
        '4' => 'Order Error',
    ],
    'PROMOTION_STATUS' => [
        'AnyClient' => 'Any Customer,New or Returning',
        'NewClient' => 'Only new Clients',
        'OneOrder' => 'Only Returning',
    ],
    'PROMOTION_FUNCTION' => [
        '1' => 'Principle',
        '2' => 'Closed',
        '3' => 'Open',
    ],
    'PROMOTION_TYPES' => [
        'FIRST'  => "% or Discount in Cart",
        'TWO' => "% or Discount on Selected items",
        'THREE'  => "Free Delivery",
        'FOUR'   => "Payment Method Reward",
        'FIVE'   => "Get a free Item",
        'SIX'    => "buy one get one free",
        'SEVEN'  => "Meal Bundle",
        'EIGHT'  => "Buy 2,3...get one free",
        'NINE'   => "Fixed discount amount on a Combo deal",
        'TEN'    => "% Discount on combo deal"
    ],
    'AVAILABILITY' => [
        // '1' => 'Availability',
        '2' => 'Always Available',
        '3' => 'Restricted',
        '4' => 'Hidden',
    ],
    'CARD_TYPE' => [
        'VISA' => 'VISA',
        'AMERICAN_EXPRESS' => 'AMERICAN_EXPRESS',
        'DISCOVER' => 'DISCOVER',
        'MASTER_CARD' => 'MASTER_CARD',
    ],
    'SUBSCRIPTION_TYPE' => [
        'MONTH' => 'MONTH',
        'YEAR' => 'YEAR',
    ],
    'SUBSCRIPTION_PLAN' => [
        '1' => 'Restaurant Registration',
        '2' => 'Email Marketing',
        '3' => 'Loyalty',
    ],
    'SUBSCRIPTION' => [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE',
        'ACTIVE_MESSAGE' => 'Email Marketing Subscription Successfully.',
        'UPGRADE_MESSAGE' => 'Subscription Upgrade Successfully.',
    ],
    'ORDER_PAYMENT_TYPE' => [
        'CASH' => 1,
        'CARD' => 0,
        'CARD_PAYMENT' => 0,//'Credit Card'
        'CASH_PAYMENT' => 1//'Cash'
    ],
    'CAMPAIGN_MONITOR' => [
//        'EMAIL' => 'krayjada@dinertech.io',
        'EMAIL' => 'kevin@sohosushi.com',
        'CHROME' => 'None',
    ],
    'LOYALTY_TYPE' => [
        'NO_OF_ORDERS' => 'NO OF ORDER',
        'AMOUNT_SPENT' => 'AMOUNT SPENT',
        'CATEGORY_BASED' => 'CATEGORY BASED',
    ],
    'LOYALTY_MENU_STATUS' => [
        'ELIGIBLE' => 'ELIGIBLE',
        'NOT_ELIGIBLE' => 'NOT ELIGIBLE'
    ],
    'ORDER_POINT_COUNT' => [
        'YES' => 'YES',
        'NO'  => 'NO'
    ],
    'MODIFIER_TYPE'  => [
        'SINGLE_MODIFIER'    => 'SINGLE', 
        'MULTIPLE_MODIFIER'  => 'MULTIPLE'
    ],
];
