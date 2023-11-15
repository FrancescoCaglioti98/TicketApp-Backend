<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            "name" => "Francesco",
            "last_name" => "Caglioti",
            "email" => "dummy@mail.it",
            "password" => Hash::make('Password01!'),
            "is_admin" => 1,
            "is_active" => 1,
        ]);

        \App\Models\GroupModel::factory()->create([
            "name" => "Default Group",
            "description" => "First group to be created",
            "user_admin_id" => 1
        ]);


        
        /**
         * The Group Admin should also need to be a group member?
         */

        \App\Models\GroupToUserModel::factory()->create([
            "user_id" => 1,
            "group_id" => 1
        ]);

    }
}
