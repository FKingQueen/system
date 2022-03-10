<?php

namespace App\Imports;

use App\Models\Activity_file;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersUpdate implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($id)
    {
        $this->id = $id;
    }

    public function model(array $row)
    {
        return new Activity_file([
            "activity" => $row['activity'],
            "farming_data_id" =>  $this->id,
        ]);
    }
}
