<?php
return [
    'OTP_VALID_DURATION' => 15,
    'PAGINATION_PER_PAGE' => 10,
    'OTP_NO_OF_DIGIT' => 1000,
    'ROLES' => [
        'SUPERADMIN' => 'SUPERADMIN',
        'ADMIN'      => 'ADMIN',
        'RESTAURANT'  => 'RESTAURANT',
        'CUSTOMER'      => 'CUSTOMER',
    ],
    'STATUS' => [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE'
    ],
    'PAYMENT_STATUS' => [
        'PAID' => 'PAID',
        'UNPAID' => 'UNPAID',
        'REFUND' => 'REFUND'
    ],
    'IMAGES' => [
        'USER_IMAGE_PATH'   =>  'users',
        'CATEGORY_IMAGE_PATH' => 'category_image',
        'MENU_IMAGE_PATH' => 'menu_image',
        'RESTAURANT_USER_IMAGE_PATH' => 'restaurant_user_image'
    ],
    'ORDER_STATUS' => [
        'INITIAL'   =>  'INITIAL',
        'PROGRESS' => 'PROGRESS',
        'ACCEPTED' => 'ACCEPTED',
        'PREPARED' => 'PREPARED',
        'COMPLETED' => 'COMPLETED',
        'CANCEL' => 'CANCEL',
        'CANCELREFUND' => 'CANCEL AND REFUND',
        'REFUND' => 'REFUND'
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
		"hideMethod" => "fadeOut"
	],
    'COMMON_MESSAGES' => [
        'DB_ERRORS' => 'Please try again!!',
        'CATCH_ERRORS' => 'Please try again!!',
        'COMMON_MESSAGE' =>'Something wrong please try again!!'
    ],
    'SNICH_KEY' => [
        'FROM' => '447537404817',
        'TOKEN' => 'Bearer a0a605c3c2644138aa3e37712a7c7207',
        'PLAN_ID' => 'aa97d8b8af8d4440a1d45b328c7abf17',
        'MESSAGE' => 'Dear User,Your OTP is'
    ],
    'PUBLIC_ASSETS_PATH' => 'web/',
    'RESTAURANT_CHARGE'=>'79.99',
    'CLIENT_TYPE' => [
        '1' => 'Any Client,new or Returning',
        '2' => 'Only new Clients',
        '3' => 'Only Returning'
    ],
    'ORDER_TYPE' => [
        '1' => 'Any Type',
        '2' => 'Pickup Time'
    ],
    'MARK_PROMO_AS' => [
        '1' => 'Not Exclusive',
        '2' => 'Exclusive',
        '3' => 'Master Promo Deal'
    ],
    'DISPLAY_TIME' => [
        '1' => 'Always Shows to eligible clients',
        '2' => 'Hide for menu reedeem with coupon code',
        '3' => 'Limited to show times'
    ],
    'NO_EXTRA_CHARGES' => [
        '1' => 'No extra charges',
        '2' => 'Charges extra for Choices/Addons',
        '3' => 'Charges extra for Choices/Addons & Sizes'
    ],
    'AUTO_DISCOUNT' => [
        '1' => 'Autometically set discount',
        '2' => 'Manually set discount'
    ],
    'FIREBASE_DB_NAME' => 'chats',
    'CONTACT_MAIL'=>'kwest@dinertech.io',
    'CUSTOMER_FEEDBACK_TYPE' => [
        '1' => 'General Feedback',
        '2' => 'Quality Feedback',
        '3' => 'Delivery Feedback',
        '4' => 'Order Error',
    ],
    'PROMOTION_STATUS' => [
        'AnyClient' => 'Any Client,new or Returning',
        'NewClient' => 'Only new Clients',
        'OneOrder' => 'Only Returning'
    ]
];
