<?php

namespace Database\Seeders;

use App\Models\Cashier\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                "name" => "Business Plan",
                "slug" => "business-plan",
                "stripe_plan_id" => "price_1NGqAPJOKfqmSnetAQWqyyP7",
                "description" => "Business Plan, for business owners who want to list their offices on our platform",
                "price" => 100,
            ], 
            [
                "name" => "Premium Plan",
                "slug" => "premium-plan",
                "stripe_plan_id" => "price_1NGqDLJOKfqmSnetBWTPhv2F",
                "description" => "Premium Plan, for business owners who want to list their offices on our platform",
                "price" => 200,
            ], 
            [
                "name" => "Platinum Plan",
                "slug" => "platinum-plan",
                "stripe_plan_id" => "price_1NGqDcJOKfqmSnetEzp0lqcL",
                "description" => "Platinum Plan, for business owners who want to list their offices on our platform",
                "price" => 300,
            ]
        ];
        Plan::insert($plans);
    }
}
