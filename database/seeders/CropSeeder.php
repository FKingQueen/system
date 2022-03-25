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
            'name' => 'Bitter Gourd',
          ],
          [
            'id' => '2',
            'name' => 'Cabbage',
          ],
          [
            'id' => '3',
            'name' => 'Corn',
          ],
          [
            'id' => '4',
            'name' => 'Eggplant',
          ],
          [
            'id' => '5',
            'name' => 'Garlic',
          ],
          [
            'id' => '6',
            'name' => 'Ladys Finger',
          ],
          [
            'id' => '7',
            'name' => 'Rice',
          ],
          [
            'id' => '8',
            'name' => 'Onion',
          ],
          [
            'id' => '9',
            'name' => 'Peanut',
          ],
          [
            'id' => '10',
            'name' => 'String Beans',
          ],
          [
            'id' => '11',
            'name' => 'Tobacco',
          ],
          [
            'id' => '12',
            'name' => 'Tomato',
          ],
          [
            'id' => '13',
            'name' => 'Water Melon',
          ],
        ];

        Crop::insert( $crops);
    }
}
