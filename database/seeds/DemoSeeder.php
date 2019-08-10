<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        \App\User::truncate();
        \App\Seller::truncate();
        \App\Buyer::truncate();
        \App\Project::truncate();
        \App\Bid::truncate();

        // For the sake of the exercise, making all seed users password the same
        $exercisePwd = Hash::make('intuit_exercise');

        \App\User::create(['name' => 'Administrator', 'email' => 'admin@intuit.com', 'password' => $exercisePwd]);
        for ($i = 0; $i < 10; $i++) {
            \App\User::create(['name' => $faker->name, 'email' => $faker->email, 'password' => $exercisePwd]);
        }

        for ($userId = 1; $userId <= 5; $userId++) {
            \App\Seller::create(['user_id' => $userId]);
        }

        for ($userId = 6; $userId <= 11; $userId++) {
            \App\Buyer::create(['user_id' => $userId]);
        }

        $projectList = [
            ['seller_id' => 4, 'created_at' => strtotime('-10 day'), 'deadline_at' => strtotime('-5 min'),  'lowest_bid_id' => 4, 'status' => 1, 'title' => 'Proj A', 'description' => $faker->paragraph],
            ['seller_id' => 1, 'created_at' => strtotime('-8 day'),  'deadline_at' => strtotime('+1 week'), 'lowest_bid_id' => 8, 'title' => 'Proj B', 'description' => $faker->paragraph],
            ['seller_id' => 2, 'created_at' => strtotime('-5 day'),  'deadline_at' => strtotime('+2 week'), 'title' => 'Proj C', 'description' => $faker->paragraph],
            ['seller_id' => 5, 'created_at' => strtotime('-2 day'),  'deadline_at' => strtotime('+1 week'), 'title' => 'Proj D', 'description' => $faker->paragraph],
            ['seller_id' => 1, 'created_at' => strtotime('-1 day'),  'deadline_at' => strtotime('+3 week'), 'title' => 'Proj E', 'description' => $faker->paragraph],
            ['seller_id' => 2, 'created_at' => strtotime('-5 min'),  'deadline_at' => strtotime('+8 day'),  'title' => 'Proj F', 'description' => $faker->paragraph],
        ];

        $bidList = [
            ['project_id' => 1, 'buyer_id' => 6,  'type' => 1, 'value' => '20.00', 'created_at' => strtotime('-9 day')],
            ['project_id' => 1, 'buyer_id' => 8,  'type' => 1, 'value' => '19.00', 'created_at' => strtotime('-8 day')],
            ['project_id' => 1, 'buyer_id' => 6,  'type' => 1, 'value' => '18.50', 'created_at' => strtotime('-7 day')],
            ['project_id' => 1, 'buyer_id' => 11, 'type' => 1, 'value' => '16.00', 'created_at' => strtotime('-6 day')],
            ['project_id' => 2, 'buyer_id' => 7,  'type' => 2, 'value' => '20.00', 'created_at' => strtotime('-8 day'), 'hourly_value' => '5.00', 'min_hours' => 4,],
            ['project_id' => 2, 'buyer_id' => 8,  'type' => 1, 'value' => '19.00', 'created_at' => strtotime('-7 day')],
            ['project_id' => 2, 'buyer_id' => 10, 'type' => 2, 'value' => '18.00', 'created_at' => strtotime('-6 day'), 'hourly_value' => '6.00', 'min_hours' => 3],
            ['project_id' => 2, 'buyer_id' => 7,  'type' => 1, 'value' => '16.00', 'created_at' => strtotime('-5 day')],
        ];


        foreach ($projectList as $project) {
            \App\Project::create($project);
        }
        foreach ($bidList as $bid) {
            \App\Bid::create($bid);
        }



    }
}
