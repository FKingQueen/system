<?php

namespace App\Imports;

use App\Models\Activity_file;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($farmer_id, $farming_data, $status, $crop_id)
    {
        $this->farming_data_id = $farming_data;
        $this->farmer_id = $farmer_id;
        $this->status = $status;
        $this->crop_id = $crop_id;
    }


    public function model(array $row)
    {

        return new Activity_file([
            "activity" => $row['activity'],
            "date" => Carbon::createFromFormat('d/m/Y',  $row['date']),
            "farming_data_id" =>  $this->farming_data_id,
            "farmer_id" =>  $this->farmer_id,
            "crop_id" =>  $this->crop_id,
            "status" =>  $this->status,
        ]);

    }
}
