<?php

use Illuminate\Database\Seeder;
use App\Models\PromotionType;
use Config;

class PromotionTypeSeeder extends Seeder
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
                'promotion_name' =>  '% or Discount in Cart',
                'promotion_details' => '% or Discount in Cart',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  '% or Discount on Selected items',
                'promotion_details' => '% or Discount on Selected items',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  'Free Delivery',
                'promotion_details' => 'Free Delivery',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  'Payment Method Reward',
                'promotion_details' => 'Payment Method Reward',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  'Get a free Item',
                'promotion_details' => 'Get a free Item',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  'buy one get one free',
                'promotion_details' => 'buy one get one free',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  'Meal Bundle',
                'promotion_details' => 'Meal Bundle',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  'Buy 2,3...get one free',
                'promotion_details' => 'Buy 2,3...get one free',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  'Fixed discount amount on a Combo deal',
                'promotion_details' => 'Fixed discount amount on a Combo deal',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
            [
                'promotion_name' =>  '% Discount on combo deal',
                'promotion_details' => '% Discount on combo deal',
                'promotion_icon'    => null,
                'status'            => Config::get('constants.STATUS.ACTIVE'),
            ],
        ];
        PromotionType::insert($data);
    }
}
