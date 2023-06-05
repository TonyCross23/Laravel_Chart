<?php

namespace App\Http\Controllers;

use App\Models\Inout;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index () {
        
        $currency = Inout::orderBy('id','desc')->get();

        $total_income = 0;
        $total_outcome = 0;

        $today_date = date('Y-m-d');

        $inoutdata = Inout::whereDate('date',$today_date)->get();

        foreach($inoutdata as $sInoutdata) {
            if($sInoutdata->type == 'in') {
                $total_income += $sInoutdata->amount;
            }

             if($sInoutdata->type == 'out') {
                $total_outcome += $sInoutdata->amount;
            }
        }

        // day loop for chart
        $day_arr = [date('D')];

        $date_arr = [
            [
                'year' => date('Y'),
                'month' => date('m'),
                'day' => date('d'),
            ]
            ];

        for($i=1; $i<=6;$i++){
            $day_arr[] = date('D',strtotime("-$i day"));

            $new_date = [
                'year' => date('Y',strtotime("-$i day")),
                'month' => date('m',strtotime("-$i day")),
                'day' => date('d',strtotime("-$i day"))
            ];

            $date_arr[] = $new_date;
        }


        $income_amount = [];
        $outcome_amount = [];

        foreach($date_arr as $a) {
            $income_amount[] = Inout::where('date',$a['year'])
                                                    ->whereMonth('date',$a['month'])
                                                    ->whereDate('date',$a['day'])
                                                    ->where('type','in')
                                                    ->sum('amount');
                                  
              $outcome_amount[] = Inout::whereYear('date',$a['year'])
                                                    ->whereMonth('date',$a['month'])
                                                    ->whereDate('date',$a['day'])
                                                    ->where('type','out')
                                                    ->sum('amount');
        }    

        return view('welcome',compact('currency','total_income','total_outcome','day_arr','income_amount','outcome_amount'));
    }

    public function store (Request $request){
        
        $chart = new Inout();
        $chart->about = $request->about;
        $chart->amount = $request->amount;
        $chart->type = $request->type;
        $chart->date = $request->date;
        $chart->save();

      return redirect()->back()->with('success','Successfully Data Store');
    }
}