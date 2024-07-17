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
                'Name' => 'WEDDING PACKAGE 1',
                'Description' => "- 2 ON THE DAY PHOTOGRAPHER\n- RAW & ENHANCED COPY\n- ITEMS WILL BE SENT THROUGH EMAIL\n- (ADD 5K FOR PRENUP PHOTO SESSION)",
                'Price' => 10000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 2',
                'Description' => "- 2 ON THE DAY PHOTOGRAPHER\n- RAW & ENHANCED COPY\n- FULL VIDEO\n- ITEMS WILL BE SENT THROUGH EMAIL\n- (ADD 5K FOR PRENUP PHOTO SESSION)",
                'Price' => 15000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 3',
                'Description' => "- 2 ON THE DAY PHOTOGRAPHER\n- RAW & ENHANCED COPY\n- FULL VIDEO\n- VIDEO HIGHLIGHTS\n- ITEMS WILL BE SENT THROUGH EMAIL\n- (ADD 5K FOR PRENUP PHOTO SESSION)",
                'Price' => 20000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 4',
                'Description' => "- 2 ON THE DAY PHOTOGRAPHER\n- RAW & ENHANCED COPY\n- FULL VIDEO\n- SAME DAY EDIT VIDEO\n- FREE 32 GIG USB\n- (ADD 5K FOR PRENUP PHOTO SESSION)",
                'Price' => 30000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 5',
                'Description' => "- 2 ON THE DAY PHOTOGRAPHER\n- RAW & ENHANCED COPY\n- FULL VIDEO\n- SAME DAY EDIT VIDEO\n- PRENUP PHOTO SESSION\n- SAVE THE DATE VIDEO\n- FREE 32 GIG USB",
                'Price' => 35000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'WEDDING PACKAGE 6',
                'Description' => "- 2 ON THE DAY PHOTOGRAPHER\n- RAW & ENHANCED COPY\n- FULL VIDEO\n- SAME DAY EDIT VIDEO\n- PRENUP PHOTO SESSION\n- SAVE THE DATE VIDEO\n- ALBUM 20 PAGES WITH HARD CASE (80 PHOTOS)\n- 12x18 BLOW UP FRAME\n- FREE 32 GIG USB",
                'Price' => 45000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'DEBUT PACKAGE 1',
                'Description' => "- 5K PACKAGE\n- (ADD 5K FOR PRE BDAY SHOOT PHOTO)\n- 1 PHOTOGRAPHER WHOLE EVENT\n- ALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n- ALL ITEMS WILL BE SENT THROUGH GDRIVE",
                'Price' => 5000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'DEBUT PACKAGE 2',
                'Description' => "- 10K PACKAGE\n- (ADD 5K FOR PRE BDAY SHOOT PHOTO)\n- 1 PHOTOGRAPHER WHOLE EVENT\n- ALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n- FULL VIDEO\n- ALL ITEMS WILL BE SENT THROUGH GDRIVE",
                'Price' => 10000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'DEBUT PACKAGE 3',
                'Description' => "- 20K PACKAGE\n- (ADD 5K FOR PRE BDAY SHOOT PHOTO)\n- 1 PHOTOGRAPHER WHOLE EVENT\n- ALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n- SAME DAY EDIT VIDEO\n- FULL VIDEO\n- ALL ITEMS WILL BE SENT THROUGH GDRIVE",
                'Price' => 20000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'B/C PACKAGE 1',
                'Description' => "- 5K PACKAGE\n- (ADD 3500 FOR PRE BDAY SHOOT PHOTO)\n- 1 PHOTOGRAPHER WHOLE EVENT\n- ALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n- ALL ITEMS WILL BE SENT THROUGH GDRIVE",
                'Price' => 5000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'B/C PACKAGE 2',
                'Description' => "- 10K PACKAGE\n- (ADD 3500 FOR PRE BDAY SHOOT PHOTO)\n- 1 PHOTOGRAPHER WHOLE EVENT\n- FULL VIDEO\n- ALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n- ALL ITEMS WILL BE SENT THROUGH GDRIVE",
                'Price' => 10000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'B/C PACKAGE 3',
                'Description' => "- 15K PACKAGE\n- (ADD 3500 FOR PRE BDAY SHOOT PHOTO)\n- 1 PHOTOGRAPHER WHOLE EVENT\n- ALL RAW / SELECTED HIGHLIGHTS EDITED PHOTOS\n- FULL VIDEO AND HIGHLIGHTS VIDEO\n- ALL ITEMS WILL BE SENT THROUGH GDRIVE",
                'Price' => 15000,
                'isAddOn' => false,
            ],
            [
                'Name' => 'ADD PHOTOGRAPHER',
                'Description' => "Additional Photographer",
                'Price' => 5000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'SAME DAY EDIT VIDEO',
                'Description' => "Same Day Edit Video Service",
                'Price' => 20000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'SAVE THE DATE VIDEO',
                'Description' => "Save the Date Video",
                'Price' => 10000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'ALBUM',
                'Description' => "20 Pages Album",
                'Price' => 5000,
                'isAddOn' => true,
            ],
            [
                'Name' => 'FRAME',
                'Description' => "16x20 Blow Up Frame",
                'Price' => 1500,
                'isAddOn' => true,
            ],
        ]);
    }
}
