<?php

namespace App\Imports;

use App\Models\Activity_file;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($farming_data)
    {
        $this->farming_data_id = $farming_data;
    }


    public function model(array $row)
    {
        return new Activity_file([
            "activity" => $row[0],
            "farming_data_id" =>  $this->farming_data_id,
        ]);

    }
}
