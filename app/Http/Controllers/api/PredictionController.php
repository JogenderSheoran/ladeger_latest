<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Models\transaction;
use App\Models\ledger;
use App\Models\shift;
use DB;

class PredictionController extends Controller
{
      public function prediction_list(Request $r){
        $data=shift::where('active','on')->select('id','name')->get();
        foreach ($data as $value) {
            $value->predictions=Prediction::where('shift_id',$value->id)->orderBy('id','DESC')->limit(30)->select('number','date')->get();
        }
        if($this->check_count($data)>0){
          return response()->json(['data'=>$data,'status'=>true]);
        }
        return response()->json(['message'=>'No prediction found!!','status'=>false]);
      }

      //remove number
      public function remove_number(Request $r){
        $delete=Prediction::where('id',$r->id)->update(['status'=>0]);
        if($delete){
          transaction::where('shift',$delete->shift_id)->where('date',date('d-m-Y',strtotime($delete->date)))->update(["draw_number"=>null,"winn_type"=>null,"winn_number"=>null,"winn_amount"=>null,"winn_comm"=>null,"opening_balance"=>null,"closing_balance"=>null]);

          return response()->json(['message'=>'Number delete successfully','status'=>true]);
        }
        return response()->json(['message'=>'Error','status'=>false]);
      }

      //redeclare number
      public function redeclare_number(Request $r){

        if ($r->id) {
            $update=Prediction::where('id',$r->id)->first();
            $update->number=$r->number;
            $update->save();
        } else {
            $update=Prediction::where('shift_id',$r->shift_id)->where('date',date('Y-m-d',strtotime($r->date)))->first();
        }
        if($update){

          transaction::where('shift',$r->shift_id)->where('date',date('d-m-Y',strtotime($update->date)))->update(["redeclare_status"=>0,"draw_number"=>null,"winn_type"=>null,"winn_number"=>null,"winn_amount"=>null,"winn_comm"=>null,"opening_balance"=>null,"closing_balance"=>null]);

          $this->update_transaction($update->number,$r->shift_id,$update->date);
          return response()->json(['message'=>'Number redeclare successfully','number'=>$update->number,'status'=>true]);
        }
        return response()->json(['message'=>'Error','status'=>false]);
      }


      //prediction data
      public function prediction_data(Request $r){
        $today_count=0;
        $data=Prediction::where('shift_id',$r->shift)->where('status',1)->orderBy('date','DESC')->get();
        $check_today_data=Prediction::where('shift_id',$r->shift)->whereDate('date',date('Y-m-d'))->where('status',1)->orderBy('id','DESC')->count();
        if($check_today_data > 0){
          $today_count=1;
        }
        if($this->check_count($data)>0){
          return response()->json(['message'=>'success','data'=>$data,'status'=>true,'today_count'=>$today_count]);
        }
        return response()->json(['message'=>'No data found','status'=>false]);
        
      }

      public function declare_number(Request $r){
          $date=date('Y-m-d');
          $check=Prediction::whereDate('date',$date)->where('shift_id',$r->shift)->count();
          if($check > 0){
              return response()->json(['message'=>'Number already declared','status'=>false]);
          }
          $insert=new Prediction();
          $insert->shift_id=$r->shift;
          $insert->number=$r->number;
          $insert->date=$date;
          $insert->save();
          if($insert){
            $this->update_transaction($r->number,$r->shift,$insert->date);
          }
        return response()->json(['message'=>'success','status'=>true]);
      }

      function update_transaction($number,$shift,$date)
      {
        $stri = (string)$number;
        $b = $stri[0]*111;
        $a = $stri[1]*1111;
        // $draw_numbers=[$number,$a,$b];
        // $transaction=transaction::where('shift',$shift)->where(function ($q) use($draw_numbers) {
        //     foreach($draw_numbers as $key => $draw_number)
        //     {
        //         if($key == 0)
        //         {
        //             $q->whereRaw('json_contains(number, \'["'.$draw_number.'"]\')');    
        //         }
        //         else 
        //         {
        //             $q->orWhereRaw('json_contains(number, \'["'.$draw_number.'"]\')');    
        //         }
        //     }
        // })->where('date',date('d-m-Y'))->select('id','number','amount','party','total')->get();

        $transaction=transaction::where('shift',$shift)->where('date',date('d-m-Y',strtotime($date)))->select('id','number','amount','party','total')->get();

        // get draw data
        if ($this->check_count($transaction)>0) {
            foreach($transaction as $tran){
                $last_balance=transaction::where('party',$tran->party)->where('id','<',$tran->id)->select('closing_balance')->orderBy('id','DESC')->first();
                if ($this->check_count($last_balance)>0) {
                    $tran->opening_balance=$last_balance->closing_balance;
                } else {
                    $tran->opening_balance=0;
                }
              
                $numbers=json_decode($tran->number);
                $amounts=json_decode($tran->amount);

                if(in_array($number,$numbers)){
                    $draw_index = array_search($number, $numbers);
                    $tran->winn_type='dara';
                    $tran->winn_number=$number;
                    $tran->winn_amount=$amounts[$draw_index];
                    $tran->draw_number=$number;
                }
                if(in_array($b,$numbers)){
                    $draw_index = array_search($b, $numbers);
                    $tran->winn_type='akhar';
                    $tran->winn_number=$b;
                    $tran->winn_amount=$amounts[$draw_index];
                    $tran->draw_number=$number;
                }
                if(in_array($a,$numbers)){
                    $draw_index = array_search($a, $numbers);
                    $tran->winn_type='akhar';
                    $tran->winn_number=$a;
                    $tran->winn_amount=$amounts[$draw_index];
                    $tran->draw_number=$number;
                }

                $ledger=ledger::where('id',$tran->party)->select('dara','akhar','dara_commission')->first();
                $commission=$tran->total*$ledger->dara_commission/100;
                $tran->commission=(int)$commission;

                $win_total=0;
                if ($tran->draw_number) {
                    if ($tran->winn_type=='dara') {
                      $tran->winn_comm=$ledger->dara;
                    } else {
                      $tran->winn_comm=$ledger->akhar;
                    }
                  $win_total=$tran->winn_amount*$tran->winn_comm;
                }

                $tran->closing_balance=$tran->total-$win_total-$tran->commission+$tran->opening_balance;                
                $tran->save();
            }
        }        
      }
}
