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
            'Email' => 'jhunleowin@gmail123.com', 
            'PhoneNumber' => '09474863546',
            'Password' => Hash::make('Qwerty123!'), 
            'Role' => 'Admin',
            'Address' => 'Cielito Homes',
        ]);
    }
}
