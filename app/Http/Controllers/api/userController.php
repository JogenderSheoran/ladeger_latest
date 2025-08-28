<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\shift;
use App\Models\Prediction;
use App\Models\ledger;
use App\Models\transaction;
use App\Models\JournalVoucher;
use DB;

use Auth;
use Hash;

class userController extends Controller
{

    public function update_detail(){
        $data=ledger::where('status',1)->pluck('id')->toArray();
        // return response()->json(['data'=>$data]);
        $amount=DB::table('ledger_amount')->whereIn('ledger_id',$data)->select('total_amount','ledger_id')->get();
        foreach($amount as $a){
            $latest=JournalVoucher::where('ledger_id',$a->ledger_id)->orderBy('id','DESC')->first();
            if($latest){
                $latest->closing_balance=$a->total_amount;
                $latest->save();
            }
            
        }
    }

    public function update_info(Request $r){
        try {
            $update=User::find($r->user_id);
            $update->player_id = $r->player_id;	
            $update->device_id = $r->device_id;	
            $update->save();

            if ($update) {
                return response()->json(['data'=>$update,'status'=>'success']);
            } else {
                return response()->json(['message'=>'Fail to update info!!','status'=>'fail']);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function party_info(Request $r){
        try {
            $data=ledger::where('id',$r->party)->select('id','name','dara','dara_commission','akhar','akhar_commission','limit','limit_status')->get();
            return response()->json(['data'=>$data,'status'=>'success']);

        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function user_info(Request $r){
        try {
            $user=User::where('id',$r->user_id)->first();
            return response()->json(['data'=>$user,'status'=>'success']);

        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }


    //Login
    public function login(Request $r){
        try {
            $check_email=User::where('email',$r->email)->first();
            if($this->check_count($check_email)<1)
            {
                return response()->json(['message'=>'Invalid email','status'=>'fail']);
            }



            if($check_email->is_admin!='KING'){
                if($check_email->type!='mobile')
                {
                    return response()->json(['message'=>'This account is not for app access','status'=>'fail']);
                }
            }
            
            $pass=$check_email->password;
            $password=$r->password;	
            if (Hash::check($password,$pass))
            {
                if($r->player_id){
                    $check_email->player_id = $r->player_id;	
                    $check_email->device_id = $r->device_id;	
                    $check_email->save();
                }

                $ledger='';
                if ($check_email->ledger_id) {
                    $ledger=ledger::where('id',$check_email->ledger_id)->first();
                }
                return response()->json(['data'=>$check_email,'ledger'=>$ledger,'message'=>'Successfully loggin','status'=>'success']);
            }
            else 
            {
                return response()->json(['message'=>'Invalid password','status'=>'fail']);
            } 

        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }


    //Change Password
    public function changePassword(Request $r){

        try{
            $update=User::find($r->id);
            if($this->check_count($update)>0){

                $pass=$update->password;
                $password=$r->old_password;	
                if (Hash::check($password,$pass)){

                    $update->password=bcrypt($r->new_password);
                    $save=$update->save();
                    if($save){
                        return response()->json(['message'=>'Successfully password Chnage','status'=>'success']);
                    }
                    else{
                        return response()->json(['message'=>'Server not response,please try again later!','status'=>'fail']);
                    }
                }
                else {
                    return response()->json(['message'=>'Password not match','status'=>'fail']);
                }
            }   
            else {
                return response()->json(['message'=>'User ID not exist','status'=>'fail']);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }

    }


    //Update Player & device_id
    public function updatePlayer(Request $r){

        try{
            $update=User::find($r->id);
            if($this->check_count($update)>0){

                $update->player_id = $r->player_id;	
                $update->device_id = $r->device_id;	
                $save=$update->save();

                return response()->json(['data'=>$update,'message'=>'PlayerID has been updated successfully.','status'=>'success']);                
            }   
            else {
                return response()->json(['message'=>'User ID not exist','status'=>'fail']);
            }
        
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }

    }

    //Your shift
    public function yourShift(Request $r){

        try{
           
        
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }

    }

    //Cutting shift
    public function cuttingShift(Request $r){

        date_default_timezone_set('Asia/Kolkata');

        try{

            $getKing=User::where('is_admin','KING')->first();
            if($this->check_count($getKing)>0){
                $shift=shift::where('updatedBy',$getKing->company)->get();
                if($this->check_count($shift)>0){
                    foreach($shift as $s){
                        $check=Prediction::where('shift_id',$s->id)->where('date',date('Y-m-d'))->select('number')->first();
                        if($this->check_count($check)>0){
                            $s->number=$check->number;
                        }
                        else{
                            $c_sale=0;
                            $sale=0;
                            if($r->role=='king' && !empty($r->ledger)){
                                $transactions=transaction::where('shift',$s->id)->where('date',date('d-m-Y'))->where('party',$r->ledger)->select('party','total')->get();
                            }
                            else{
                                $transactions=transaction::where('shift',$s->id)->where('date',date('d-m-Y'))->select('party','total')->get(); 
                            }
                            foreach ($transactions as $value) {
                                $c_sale=$c_sale+$value->total;
                                $party=ledger::where('id',$value->party)->select('dara_commission','akhar_commission')->first();
                                $sale=$sale+$value->total*$party->dara_commission/100;
                            }
                            $s->c_sale=$c_sale;
                            $s->sale=$sale;
                        }
                    }
                    return response()->json(['data'=>$shift,'message'=>'Shift data fetch successfully.','status'=>'success']);              
                }else{
                    return response()->json(['message'=>'Sorry,Shift not found.','status'=>'fail']);
                }

            }else{
                return response()->json(['message'=>'Sorry,King id not found.','status'=>'fail']);
            }
        
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }

    }




}
