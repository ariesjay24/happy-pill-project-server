<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'FirstName' => 'Jhun',
            'LastName' => 'Leowin',
            'Email' => 'jhunleowin@gmail.com', // Use a unique email address
            'PhoneNumber' => '1234567890',
            'Password' => Hash::make('qwerty123'), // Use a secure password
            'Role' => 'Admin',
            'Address' => 'Cielito Homes',
        ]);
    }
}
