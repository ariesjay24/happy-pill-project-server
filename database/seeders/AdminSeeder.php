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
            'Email' => 'jhunleowin@gmail.com', 
            'PhoneNumber' => '09569703817',
            'Password' => Hash::make('Admin123!'), 
            'Role' => 'Admin',
            'Address' => 'Blk 15 Lot 4 Capitol Parkland Subd. Brgy 177 Camarin 1424 Caloocan City NCR',
        ]);
    }
}
