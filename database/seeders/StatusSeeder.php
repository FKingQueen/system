<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::truncate();

        $status =  [
          [
            'id' => '1',
            'name' => 'In Progress',
          ],
          [
            'id' => '2',
            'name' => 'Inactive',
          ],
        ];

        Status::insert($status);
    }
}
