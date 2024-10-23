<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed the user table
        $user = \App\Models\User::create([
            'name' => 'Admin User', // Replace with the admin name
            'email' => 'admin@example.com', // Replace with admin email
            'password' => Hash::make('password'), // Replace with a secure password
        ]);

        // Seed the profile table
        \App\Models\Profile::create([
            'user_id' => $user->id, // Link to the user
            'first_name' => 'Admin',
            'last_name' => 'User',
            'mobile_number' => '1234567890',
            'work_number' => '0987654321',
            'organisation_name' => 'Admin Org',
            'search_address' => '123 Admin Street',
            'suburb' => 'Adminville',
            'region' => 'Region 1',
            'postcode' => '12345',
            'state' => 'Admin State',
            'is_indigenous_organisation' => false, // Set as false or true depending on the case
        ]);
    }
}
