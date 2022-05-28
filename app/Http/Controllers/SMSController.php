<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\mpDetail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;
Session_start();

class SMSController extends Controller
{
    public function mp(){
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

    public function word(){
        $word_details =  DB::table('word_rps')
                            ->join('parlament_seat','word_rps.p_id','=','parlament_seat.id')
                            ->join('police_stations','word_rps.ps_id','=','police_stations.id')
                            ->join('words','word_rps.w_id','=','words.id')
                            ->join('designation','word_rps.d_id','=','designation.id')
                            ->select('word_rps.*','police_stations.PS_name','parlament_seat.name','parlament_seat.no','designation.d_name','words.w_number')
                            ->get();

        return view('sms.word_sms', compact('word_details'));
    }

    public function thana(){
        $thana_details =  DB::table('police_station_responsible_parsons')
                            ->join('parlament_seat','police_station_responsible_parsons.p_id','=','parlament_seat.id')
                            ->join('police_stations','police_station_responsible_parsons.ps_id','=','police_stations.id')
                            ->join('designation','police_station_responsible_parsons.d_id','=','designation.id')
                            ->select('police_station_responsible_parsons.*','police_stations.PS_name','parlament_seat.name','parlament_seat.no','designation.d_name')
                            ->get();

        return view('sms.thana_sms', compact('thana_details'));
    }

    public function birthday(){
        $key = 0;
        $today = Carbon::now()->format('Y-m-d');
        $mp_details = mpDetail::whereDate('mp_dob', '=', $today)->get();
        $thana_details =  DB::table('police_station_responsible_parsons')->whereDate('rp_dob', '=', $today)->get();
        $word_details =  DB::table('word_rps')->whereDate('rp_dob', '=', $today)->get();
        $unit_details =  DB::table('unit_r_p_s')->whereDate('rp_dob', '=', $today)->get();

        foreach($mp_details as $key =>$md){
            $data[$key]['name'] = $md->mp_name;
            $data[$key]['designation'] = 'এম.পি ';
            $data[$key]['phone'] = $md->mp_phone;
            $data[$key]['birthdate'] = $md->mp_dob;
        }
        foreach($thana_details as $td){
            $key++;
            $data[$key]['name'] = $td->rp_name;
            $data[$key]['designation'] = 'থানার দায়িত্বভার প্রাপ্ত ব্যক্তি';
            $data[$key]['phone'] = $td->rp_phone;
            $data[$key]['birthdate'] = $td->rp_dob;
        }
        foreach($word_details as $wd){
            $key++;
            $data[$key]['name'] = $wd->rp_name;
            $data[$key]['designation'] = 'ওয়ার্ডের দায়িত্বভার প্রাপ্ত ব্যক্তি';
            $data[$key]['phone'] = $wd->rp_phone;
            $data[$key]['birthdate'] = $wd->rp_dob;
        }
        foreach($unit_details as $ud){
            $key++;
            $data[$key]['name'] = $ud->rp_name;
            $data[$key]['designation'] = 'ওয়ার্ডের দায়িত্বভার প্রাপ্ত ব্যক্তি';
            $data[$key]['phone'] = $ud->rp_phone;
            $data[$key]['birthdate'] = $ud->rp_dob;
        }

        if(!isset($data)){
            $data = [];
        }

        return view('sms.birthday_sms', compact('data'));
    }

    public function individual(){
        $key = 0;
        $mp_details = mpDetail::get();
        $thana_details =  DB::table('police_station_responsible_parsons')->get();
        $word_details =  DB::table('word_rps')->get();
        $unit_details =  DB::table('unit_r_p_s')->get();

        foreach($mp_details as $key =>$md){
            $data[$key]['name'] = $md->mp_name;
            $data[$key]['designation'] = 'এম.পি ';
            $data[$key]['phone'] = $md->mp_phone;
        }
        foreach($thana_details as $td){
            $key++;
            $data[$key]['name'] = $td->rp_name;
            $data[$key]['designation'] = 'থানার দায়িত্বভার প্রাপ্ত ব্যক্তি';
            $data[$key]['phone'] = $td->rp_phone;
        }
        foreach($word_details as $wd){
            $key++;
            $data[$key]['name'] = $wd->rp_name;
            $data[$key]['designation'] = 'ওয়ার্ডের দায়িত্বভার প্রাপ্ত ব্যক্তি';
            $data[$key]['phone'] = $wd->rp_phone;
        }
        foreach($unit_details as $ud){
            $key++;
            $data[$key]['name'] = $ud->rp_name;
            $data[$key]['designation'] = 'ওয়ার্ডের দায়িত্বভার প্রাপ্ত ব্যক্তি';
            $data[$key]['phone'] = $ud->rp_phone;
        }

        // dd ($data);
        return view('sms.individual_sms', compact('data'));
    }

    public function test(){
        return view('test');
    }

}
