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
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_KqzvH2I2SaE01Y',
                'subscribers' => '0-500',
                'price' => '26.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_KrOlXFAuE2cLQh',
                'subscribers' => '501-2500',
                'price' => '53.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxAl1QzYprWqH5',
                'subscribers' => '2501-5000',
                'price' => '89.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxAygrYjPLU3Ed',
                'subscribers' => '5001-10000',
                'price' => '134.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxB1c1m8JCH3wY',
                'subscribers' => '10001-15000',
                'price' => '224.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxB369wr8inca6',
                'subscribers' => '15001-25000',
                'price' => '359.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxB8l4j79HTZx7',
                'subscribers' => '25001-50000',
                'price' => '629.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxBBGWfkGTM2gN',
                'subscribers' => '50000-75000',
                'price' => '764.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxBDtSCK1a4cKn',
                'subscribers' => '75001-100000',
                'price' => '899.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxBEYs8YFAvSlM',
                'subscribers' => '100001-150000',
                'price' => '1079.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxBFMPUFmmIoA1',
                'subscribers' => '150001-200000',
                'price' => '1349.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxBH2fH23D0LNz',
                'subscribers' => '200001-250000',
                'price' => '1799.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.2'),
                'stripe_plan_id'    => 'prod_LxBIZT8DjOcnUp',
                'subscribers' => '250000-300000',
                'price' => '2069.10',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.1'),
                'stripe_plan_id'    => 'prod_KqztEYdA0dWwD0',
                'subscribers'       => null,
                'price' => '79.00',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ],
            [
                'subscription_plan' => Config::get('constants.SUBSCRIPTION_PLAN.3'),
                'stripe_plan_id'    => 'prod_Kqzup2bkqvVvTx',
                'subscribers'       => null,
                'price' => '29.00',
                'subscription_type' => Config::get('constants.SUBSCRIPTION_TYPE.MONTH'),
            ]
        ];

        Subscription::insert($data);
    }
}
