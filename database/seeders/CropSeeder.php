<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Crop::truncate();

        $crops =  [
          [
            'id' => '1',
            'name' => 'Bitter Gourd (Ampalya)',
          ],
          [
            'id' => '2',
            'name' => 'Corn',
          ],
          [
            'id' => '3',
            'name' => 'Ladys Finger (Okra)',
          ],
          [
            'id' => '4',
            'name' => 'Rice',
          ],
          [
            'id' => '5',
            'name' => 'String Beans (Sitaw)',
          ],
        ];

        Crop::insert( $crops);
    }
}
