<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FarmerListController extends Controller
{
    public function farmerList()
    {
        return view('user/farmerList');
    }
}
