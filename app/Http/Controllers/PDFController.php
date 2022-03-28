<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farming_data;
use App\Models\Activity_file;
use App\Models\Farmer;
use DateTime;
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

        $act_total_count = Activity_file::where('farming_data_id', $id)->count();

        for($i = 0; $i <= 2; $i++)
            {
                if($i == 0)
                {
                    $activity_percent[$i] =  number_format((Activity_file::where('farming_data_id', $id)->where('activity', 'water')->count() / $act_total_count) *100);
                    $activity_count[$i] = Activity_file::where('farming_data_id', $id)->where('activity', 'water')->count();
                } else if($i == 1)
                {
                    $activity_percent[$i] = number_format((Activity_file::where('farming_data_id', $id)->where('activity', 'fertilizer')->count() / $act_total_count) *100);
                    $activity_count[$i] = Activity_file::where('farming_data_id', $id)->where('activity', 'fertilizer')->count();
                } else if($i == 2)
                {
                    $activity_percent[$i] = number_format((Activity_file::where('farming_data_id', $id)->where('activity', 'pesticide')->count() / $act_total_count) *100);
                    $activity_count[$i] = Activity_file::where('farming_data_id', $id)->where('activity', 'pesticide')->count();
                }
               
            }


            $firstdate = Activity_file::where('farming_data_id', $id)->first();
            $latestdate = Activity_file::where('farming_data_id', $id)->latest('date')->first();
            
            $firstdate = $firstdate->date;            
            $latestdate = $latestdate->date;            
            
            $firstdate = new DateTime($firstdate);
            $latestdate = new DateTime($latestdate);
            
            
            $interval = $firstdate->diff($latestdate);
            $d = $interval->format('%a');//now do whatever you like with $days

            $days = $d;

            $firstmonth = Activity_file::where('farming_data_id', $id)->first();
            $latestmonth = Activity_file::where('farming_data_id', $id)->latest('date')->first();
            
            $firstmonth = $firstmonth->date;            
            $latestmonth = $latestmonth->date;  

            $firstmonth = new DateTime($firstmonth);
            $latestmonth = new DateTime($latestmonth);

            $fmonth = $firstmonth->format('F');
            $lmonth = $latestmonth->format('F');

            $pluck_date = Activity_file::where('farming_data_id', $id)->pluck('date');
            $unique_date = $pluck_date->unique();
            $unique_date_count = $unique_date->count();
            

            foreach($unique_date as $key => $unique_dates)
            {
                for($i = 0; $i <= 2; $i++)
                {
                    if($i == 0)
                    {
                        $activity_date_percent[$key][0] = number_format((Activity_file::whereDate('date', '=', $unique_dates)->where('farming_data_id', $id)->where('activity', 'water')->count() / $act_total_count) *100);
                        
                    } else if($i == 1)
                    {
                        $activity_date_percent[$key][1] = number_format((Activity_file::whereDate('date', '=', $unique_dates)->where('farming_data_id', $id)->where('activity', 'fertilizer')->count() / $act_total_count) *100);
                        
                    } else if($i == 2)
                    {
                        $activity_date_percent[$key][2] = number_format((Activity_file::whereDate('date', '=', $unique_dates)->where('farming_data_id', $id)->where('activity', 'pesticide')->count() / $act_total_count) *100);
                        //dd(Activity_file::whereDate('date', '=', $unique_dates)->where('farming_data_id', $id)->where('activity', 'pesticide')->count());
                    }
                   
                }
                
            }

            

            


        $pdf = PDF::loadView('myPDF', array("farmer_data" => $farmer_data,
                                            "farming_data" => $farming_data,
                                            "activity_percent" => $activity_percent,
                                            "activity_count" => $activity_count,
                                            "days" => $days,
                                            "fmonth" => $fmonth,
                                            "lmonth" => $lmonth,
                                            "activity_date_percents" => $activity_date_percent,
                                            "unique_date" => $unique_date,
                                            "act_total_count" => $act_total_count,
                                        ));
    
        return $pdf->download('itsolutionstuff.pdf');
    }
}
