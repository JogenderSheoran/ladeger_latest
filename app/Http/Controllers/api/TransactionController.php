<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transaction;
use App\Models\User;
use App\Models\Prediction;
use DB;

class TransactionController extends Controller
{
    public function delete_transaction(Request $r)
    {
        try {
            $update=transaction::find($r->id);
            $update->status=1;
            $update->save();
            if ($update) {
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['message'=>'Try again, Please try again!!','status'=>'fail']);
            }            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function copy_transaction(Request $r)
    {
        date_default_timezone_set('Asia/Kolkata');
        try {
            $transaction=transaction::where('id',$r->id)->first();
            $shifts=$r->shifts;
            foreach($shifts as $shift){
                $insert = $transaction->replicate();
                $insert->added_by=$r->user;
                $insert->updated_by=$r->user;
                $insert->date=date('d-m-Y');
                $insert->addedAt=date('d-m-Y h:i A');
                $insert->updatedAt=date('d-m-Y h:i A');
                $insert->shift=$shift;
                $insert->save();
            }
            return response()->json(['status'=>'success']);
           
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function fetch_transaction(Request $r)
    {
        try {
            $data=DB::table('transactions')
                    ->join('ledgers','transactions.party','ledgers.id')
                    ->join('users','transactions.added_by','users.id')
                    ->select('ledgers.name','ledgers.dara','ledgers.dara_commission','ledgers.akhar','ledgers.akhar_commission','transactions.*','users.name as added_name')
                    ->orderBy('transactions.id','DESC');
            if ($r->shift) {
                $data->where('transactions.shift',$r->shift);
            }
            if ($r->ledger) {
                $data->where('ledgers.id',$r->ledger);
            }
            if ($r->keyword) {
                $data->where('ledgers.name','like','%'. $r->keyword .'%');
            }
            if ($r->date_from) {
                $data->where('transactions.date','>=',date('d-m-Y', strtotime($r->date_from)));
                $data->where('transactions.date','<=',date('d-m-Y', strtotime($r->date_to)));
            }
            if ($r->date) {
                $data->where('transactions.date',date('d-m-Y', strtotime($r->date)));
            }
            if ($r->staff) {
                $data->where('transactions.added_by',$r->staff);
            }
            if($r->status){
                $data->where('transactions.status',1);
            }
            else{
                $data->where('transactions.status',0);
            }
            $data=$data->get();
            foreach ($data as $value) {
                $updated_by=User::where('id',$value->updated_by)->select('name as updated_name')->first();
                $value->updated_name=$updated_by->updated_name;
            }
            if ($this->check_count($data)>0) {
                return response()->json(['status'=>'success','data'=>$data]);
            } else {
                return response()->json(['message'=>'No transaction found !!','status'=>'fail']);
            }            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function transaction_detail(Request $r){
        try {
            $data=transaction::where('id',$r->id)->select('amount','number')->first();
            return response()->json(['status'=>'success','data'=>$data]);
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function update_transaction(Request $r){

        date_default_timezone_set('Asia/Kolkata');
        
        try {
            if($r->id){
                $insert=transaction::find($r->id);

                // check no is already declared and we need to redeclare it or not
                $check=Prediction::whereDate('date',date('Y-m-d',strtotime($insert->date)))->where('shift_id',$insert->shift)->count();
                if($check > 0){
                    $insert->redeclare_status=1;
                }

            }else{
                $insert=new transaction();
                $insert->added_by=$r->user;
                $insert->date=date('d-m-Y');
                $insert->addedAt=date('d-m-Y h:i A');
                $insert->shift=$r->shift;
            }
       
            $insert->updated_by=$r->user;
            $insert->updatedAt=date('d-m-Y H:i A');
            $insert->total=$r->total;
            $insert->dara_total=$r->DaraTotal;
            $insert->akhar_total=$r->AkharTotal;

            if (is_array($r->amount)) {
                $insert->amount=json_encode($r->amount);
                $insert->number=json_encode($r->number);
            }
            else{
                $insert->amount=json_encode(explode(",",$r->amount));
                $insert->number=json_encode(explode(",",$r->number));
            }
            $insert->party=$r->party;

            // // check if no is already declared
            // $check=Prediction::whereDate('date',date('Y-m-d'))->where('shift_id',$insert->shift)->count();
            // if($check > 0){
            //     return response()->json(['message'=>'Can not add or edit transaction, Number has been already declared in this shift!!','status'=>'fail']);
            // }

            $insert->save();
            if($insert){
                return response()->json(['message'=>'Transaction has beed updated successfully.','status'=>'success','data'=>$insert]);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }
}
