<?php

namespace App\Imports;

use App\Models\Farmer;
use App\Models\Barangay;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use auth;

class FarmersImport implements ToModel, WithHeadingRow
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
        $brgy_id = Barangay::where("name", $row['barangay'])->value('id');
        if(Farmer::where('name', $row['name'])->where('barangay_id', $brgy_id)->where('municipality_Id', Auth::user()->muni_address)->count() == 0 )
        {
            return new Farmer([
                "name"  => $row['name'],
                "municipality_id"   => DB::table("municipalities")->where("id", Auth::user()->muni_address)->value('id'),
                "barangay_id"   => Barangay::where("name", $row['barangay'])->value('id'),
                "status"    => 2,
                "user_id"   => $this->user_id,
            ]);
        }
        
    }
}
