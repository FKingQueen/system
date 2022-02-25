<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;

class FarmerProfileController extends Controller
{
    public function farmerProfile($id)
    {
        $farmer = Farmer::all()->where("id", $id);
        return view('user/farmerProfile', array("farmers"=> $farmer));
    }

    public function composer(){
        
    }
}
