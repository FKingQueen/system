<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barangay;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barangay::truncate();

        $barangays =  [
            [
                'name' => 'Pob 1',
                'municipality_id' => '1'
            ],
            [
                'name' => 'Pob 2',
                'municipality_id' => '1'
            ],
            [
                'name' => 'Colo 1',
                'municipality_id' => '2'
            ],
            [
                'name' => 'Colo 2',
                'municipality_id' => '2'
            ],
          ];

        Barangay::insert( $barangays);
    }
}
