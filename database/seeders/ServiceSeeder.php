<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->insert([
            [
                'Name' => 'WEDDING PHOTO PACKAGE 1',
                'Description' => '2 ON THE DAY PHOTOGRAPHER\nRAW & ENHANCE COPY\nITEMS WILL BE SENT THROUGH EMAIL\n(ADD 5K FOR PRENUP PHOTO SESSION)',
                'Price' => 10000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 2',
                'Description' => '2 ON THE DAY PHOTOGRAPHER\nRAW & ENHANCE COPY\nFULL VIDEO\nITEMS WILL BE SENT THROUGH EMAIL\n(ADD 5K FOR PRENUP PHOTO SESSION)',
                'Price' => 15000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 3',
                'Description' => '2 ON THE DAY PHOTOGRAPHER\nRAW & ENHANCE COPY\nFULL VIDEO\nVIDEO HIGHLIGHTS\nITEMS WILL BE SENT THROUGH EMAIL\n(ADD 5K FOR PRENUP PHOTO SESSION)',
                'Price' => 20000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 4',
                'Description' => '2 ON THE DAY PHOTOGRAPHER\nRAW & ENHANCE COPY\nFULL VIDEO\nSAME DAY EDIT VIDEO\nFREE 32 GIG USB\n(ADD 5K FOR PRENUP PHOTO SESSION)',
                'Price' => 30000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 5',
                'Description' => '2 ON THE DAY PHOTOGRAPHER\nRAW & ENHANCE COPY\nFULL VIDEO\nSAME DAY EDIT VIDEO\nPRENUP PHOTO SESSION\nSAVE THE DATE VIDEO\nFREE 32 GIG USB',
                'Price' => 35000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 6',
                'Description' => '2 ON THE DAY PHOTOGRAPHER\nRAW & ENHANCE COPY\nFULL VIDEO\nSAME DAY EDIT VIDEO\nPRENUP PHOTO SESSION\nSAVE THE DATE VIDEO\nALBUM 20 PAGES WITH HARD CASE (80 PHOTOS)\n12x18 BLOW UP FRAME\nFREE 32 GIG USB',
                'Price' => 45000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'DEBUT PACKAGE - PACKAGE 1',
                'Description' => '5k PACKAGE\n( ADD 5K FOR PRE BDAY SHOOT PHOTO)\n\n1 PHOTOGRAPHER WHOLE EVENT\n\nALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n\nALL ITEMS WILL BE SENT THROUGH GDRIVE',
                'Price' => 5000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'DEBUT PACKAGE - PACKAGE 2',
                'Description' => '10k PACKAGE\n( ADD 5K FOR PRE BDAY SHOOT PHOTO)\n\n1 PHOTOGRAPHER WHOLE EVENT\n\nALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\nFULL VIDEO\n\nALL ITEMS WILL BE SENT THROUGH GDRIVE',
                'Price' => 10000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'DEBUT PACKAGE - PACKAGE 3',
                'Description' => '20k PACKAGE\n( ADD 5K FOR PRE BDAY SHOOT PHOTO)\n\n1 PHOTOGRAPHER WHOLE EVENT\n\nALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n\nALL ITEMS WILL BE SENT THROUGH GDRIVE\nSAME DAY EDIT VIDEO\nFULL VIDEO',
                'Price' => 20000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'BIRTHDAY & CHRISTENING PACKAGE - PACKAGE 1',
                'Description' => '5k PACKAGE\n( ADD 3500 FOR PRE BDAY SHOOT PHOTO)\n\n1 PHOTOGRAPHER WHOLE EVENT\n\nALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n\nALL ITEMS WILL BE SENT THROUGH GDRIVE',
                'Price' => 5000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'BIRTHDAY & CHRISTENING PACKAGE - PACKAGE 2',
                'Description' => '10k PACKAGE\n( ADD 3500 FOR PRE BDAY SHOOT PHOTO)\n\n1 PHOTOGRAPHER WHOLE EVENT\nFULL VIDEO\n\nALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n\nALL ITEMS WILL BE SENT THROUGH GDRIVE',
                'Price' => 10000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'BIRTHDAY & CHRISTENING PACKAGE - PACKAGE 3',
                'Description' => '15k PACKAGE\n( ADD 3500 FOR PRE BDAY SHOOT PHOTO)\n\n1 PHOTOGRAPHER WHOLE EVENT\n\nALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\nFULL VIDEO AND HIGHLIGHTS VIDEO\n\nALL ITEMS WILL BE SENT THROUGH GDRIVE',
                'Price' => 15000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'ADD PHOTOGRAPHER',
                'Description' => '',
                'Price' => 5000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'SAME DAY EDIT VIDEO',
                'Description' => '',
                'Price' => 20000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'SAVE THE DATE VIDEO',
                'Description' => '',
                'Price' => 10000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'ALBUM 20 PAGES',
                'Description' => '',
                'Price' => 5000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'FRAME 16X20 BLOW UP',
                'Description' => '',
                'Price' => 1500,
                'isAddOn' => true,
            ],
        ]);
    }
}
