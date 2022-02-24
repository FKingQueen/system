<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipality;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Municipality::truncate();

        $municipalities =  [
            [
              'name' => 'Currimao',
            ],
            [
              'name' => 'Batac',
            ],
          ];

        Municipality::insert( $municipalities);
    }
}
