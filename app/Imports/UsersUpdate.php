<?php

namespace App\Imports;

use App\Models\Activity_file;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class UsersUpdate implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($id, $status_id, $farmer_id)
    {
        $this->id = $id;
        $this->status_id = $status_id;
        $this->farmer_id = $farmer_id;
    }

    public function model(array $row)
    {

        $activity_file = new Activity_file([
            "activity" => $row['activity'],
            $date =  strtotime( $row['activity']),
            $new_date = date('Y-m-d',$date),
            "activity_date" => Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'),
            "farming_data_id" =>  $this->id,
            "status_id" =>  $this->status_id,
            "farmer_id" =>  $this->farmer_id,
        ]);

        DB::table('activity_files')
        ->where('farming_data_id', $this->id)
        ->update([
        'status_id' => $this->status_id,
        ]);

        return $activity_file;
    }
}
