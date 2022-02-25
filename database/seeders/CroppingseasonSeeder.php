<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cropping_season;

class CroppingseasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cropping_season::truncate();

        $croppingseasons =  [
          [
            'id' => '1',
            'name' => 'Dry Season',
          ],
          [
            'id' => '2',
            'name' => 'Wet Season',
          ],
        ];

        Cropping_season::insert($croppingseasons);
    }
}
