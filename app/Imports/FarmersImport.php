<?php

namespace App\Imports;

use App\Models\Farmer;
use Maatwebsite\Excel\Concerns\ToModel;
use auth;

class FarmersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($user_id)
    {
        $this->user_id = $user_id;
    }


    public function model(array $row)
    {
        return new Farmer([
            'name'  => $row['name'],
            'municipality_id'   => DB::table("municipalities")->where("id", Auth::user()->muni_address)->value('id'),
            'barangay_id'   => DB::table("barangays")->where("name", $row['barangay'])->value('id'),
            'status'    => 2,
            'user_id'   => $this->user_id,
        ]);
    }
}
