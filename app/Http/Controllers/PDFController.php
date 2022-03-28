<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farming_data;
use App\Models\Activity_file;
use App\Models\Farmer;
use PDF;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
        $farmer_id= Farming_data::where('id', $id)->value('farmer_id'); 
        $farmer_data = Farmer::with('farming_datas', 'barangays')->where('id', $farmer_id)->get();
        $farming_data = Farming_data::with('crop', 'cropping_season')->where('id', $id)->get();

        $pdf = PDF::loadView('myPDF', array("farmer_data" => $farmer_data, "farming_data" => $farming_data));
    
        return $pdf->download('itsolutionstuff.pdf');
    }
}
