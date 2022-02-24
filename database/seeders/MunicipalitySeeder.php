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
            'id' => '1',
            'name' => 'Badoc',
          ],
          [
            'id' => '2',
            'name' => 'Banna',
          ],
          [
            'id' => '3',
            'name' => 'Batac City',
          ],
          [
            'id' => '4',
            'name' => 'Currimao',
          ],
          [
            'id' => '5',
            'name' => 'Dingras',
          ],
          [
            'id' => '6',
            'name' => 'Marcos',
          ],
          [
            'id' => '7',
            'name' => 'Nueva Era',
          ],
          [
            'id' => '8',
            'name' => 'Paoay',
          ],
          [
            'id' => '9',
            'name' => 'Pinili',
          ],
          [
            'id' => '10',
            'name' => 'San Nicolas',
          ],
          [
            'id' => '11',
            'name' => 'Solsona',
          ],
        ];

        Municipality::insert( $municipalities);
    }
}
