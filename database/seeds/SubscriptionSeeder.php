<?php

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'subscribers' => '0-500',
                'price' => '26.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '501-2500',
                'price' => '53.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '2501-5000',
                'price' => '89.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '5001-10000',
                'price' => '134.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '10001-15000',
                'price' => '224.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '15001-25000',
                'price' => '359.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '25001-50000',
                'price' => '629.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '50000-75000',
                'price' => '764.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '75001-100000',
                'price' => '899.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '100001-150000',
                'price' => '1079.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '150001-200000',
                'price' => '1349.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '200001-250000',
                'price' => '1799.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscribers' => '250000-300000',
                'price' => '2069.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
        ];

        Subscription::insert($data);
    }
}
