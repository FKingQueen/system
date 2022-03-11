<?php

namespace App\Imports;

use App\Models\Activity_file;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($farmer_id, $farming_data, $status_id)
    {
        $this->farming_data_id = $farming_data;
        $this->farmer_id = $farmer_id;
        $this->status_id = $status_id;
    }


    public function model(array $row)
    {

        return new Activity_file([
            "activity" => $row['activity'],
            "farming_data_id" =>  $this->farming_data_id,
            "farmer_id" =>  $this->farmer_id,
            "status_id" =>  $this->status_id,
        ]);

        

    }
}
