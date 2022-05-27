<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\mpDetail;
use Illuminate\Support\Facades\Auth;
use Session;
Session_start();

class SMSController extends Controller
{
    public function index(){
        $mp_details = mpDetail::with('parlament_seat')->get();
        return view('sms.mp_sms', compact('mp_details'));
    }

    public function send_sms(Request $request){
        $request->validate([
            'number' => 'required',
            'message' =>'required|string'
        ]);

        $message = $request->message;
        $masking = false;

        foreach($request->number as $numbers){
            $result = $this->sendSms($numbers, $message, $masking);
        }

        return redirect()->back();
    }

    public function unit(){
        $unit_details =  DB::table('unit_r_p_s')
                            ->join('parlament_seat','unit_r_p_s.p_id','=','parlament_seat.id')
                            ->join('police_stations','unit_r_p_s.ps_id','=','police_stations.id')
                            ->join('words','unit_r_p_s.w_id','=','words.id')
                            ->join('units','unit_r_p_s.u_id','=','units.id')
                            ->join('designation','unit_r_p_s.d_id','=','designation.id')
                            ->select('unit_r_p_s.*','police_stations.PS_name','parlament_seat.name','parlament_seat.no','designation.d_name','words.w_number','units.union_name')
                            ->orderBy('units.union_name')
                            ->get();
        return view('sms.unit_sms', compact('unit_details'));
    }


}
