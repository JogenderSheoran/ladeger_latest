<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\ledger;
use App\Models\shift;
use App\Models\transaction;
use App\Models\User;
use App\Models\Prediction;
use App\Models\JournalVoucher;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\LedgerCommission;


class ReportController extends Controller
{
    public function ledger_daily_report(Request $r)
    {
        try {
            $transactions=transaction::where('party',$r->ledger)
                            ->where('date',date('d-m-Y', strtotime($r->date)))
                            ->where('shift',$r->shift)
                            ->select('number','amount')
                            ->get();
            $new_numbers=[];
            $new_amounts=[];
            foreach ($transactions as $transaction) {
                $numbers=json_decode($transaction->number);
                $amounts=json_decode($transaction->amount);

                for ($i=0; $i < sizeof($numbers); $i++) { 
                    if (in_array($numbers[$i],$new_numbers)) {
                    $existing_index = array_search($numbers[$i], $new_numbers);
                    $new_amounts[$existing_index]=$new_amounts[$existing_index]+$amounts[$i];
                    } else {
                        $new_numbers[]=$numbers[$i];
                        $new_amounts[]=$amounts[$i];
                    }
                    
                }
            }
            return response()->json(['status'=>'success','numbers'=>$new_numbers,'amounts'=>$new_amounts]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function settling_report(Request $r)
    {
        try {

            $ledger=ledger::where('id',$r->party)->select('id','dara_commission','dara','akhar','akhar_commission','name','mobile','limit')->first();
            
            $begin = new DateTime(date('Y-m-d',strtotime($r->date_from)));
            $end = new DateTime(date('Y-m-d',strtotime('+1 day', strtotime(date('Y-m-d',strtotime($r->date_to))))));
    
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);
    
            $data=[];
            foreach ($period as $dt) 
            {
                $tras_data=[];
                $transaction=transaction::where('party',$r->party)->where('date',$dt->format("d-m-Y"));

                $tras_data['date']=$dt->format("d-m-Y");
                $tras_data['total']=$transaction->sum('total');
                $tras_data['commission']=$transaction->sum('commission');
                $tras_data['dara_total']=$transaction->sum('dara_total');
                $tras_data['akhar_total']=$transaction->sum('akhar_total');
                $tras_data['o_dara']=0;
                $tras_data['o_akhar']=0;
                $tras_data['profit']=0;

                $tras_data['opening']=$transaction->value('opening_balance');
                if (!$tras_data['opening']) {
                    $tras_data['opening']=0;
                }
                $tras_data['closing']=0;

                // get draw data
                $win_total=0;
                if($tras_data['total'])
                {
                    $transaction=$transaction->whereNotNull('draw_number')->select('id','winn_type','winn_amount','winn_comm','closing_balance')->get();
                    if ($this->check_count($transaction)>0) {
                        foreach($transaction as $tran){
                            if($tran->winn_type=='dara'){
                                $tras_data['o_dara']=$tran->winn_amount;
                            }
                            else{
                                $tras_data['o_akhar']=$tran->winn_amount;
                            }
                            $win_total=$win_total+$tran->winn_amount*$tran->winn_comm;

                            if ($tran->closing_balance) {
                                $tras_data['closing']=$tran->closing_balance;
                            }
                        }
                    }
                }

                $tras_data['profit']=$tras_data['total']-$win_total-$tras_data['commission'];

                // Get TPC and Hissa 
                $tpc_hissa=$this->get_tpc($ledger->id,$dt->format("d-m-Y"),'','');
                $tras_data['tpc']=$tpc_hissa['tpc'];
                $tras_data['hissa']=$tpc_hissa['hissa'];
                
                $data[]=$tras_data;
            }

            if ($this->check_count($data)>0) {
                return response()->json(['status'=>'success','data'=>$data,'party'=>$ledger]);
            } else {
                return response()->json(['message'=>'No record found !!','status'=>'fail']);
            }            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function all_shift_report(Request $r)
    {
        try {

            $data=ledger::select('id','dara_commission','dara','akhar','akhar_commission','name','mobile','limit')->where('status',1)->get();
            $filter_data=[];
            foreach($data as $ledger){
                $transaction=transaction::where('party',$ledger->id)
                                ->where('date','>=',date('d-m-Y', strtotime($r->date_from)))
                                ->where('date','<=',date('d-m-Y', strtotime($r->date_to)));
                $ledger->total=$transaction->sum('total');
                // $ledger->commission=$transaction->sum('total')*$ledger->dara_commission/100;
                $ledger->commission=$transaction->sum('commission');
                $ledger->dara_total=$transaction->sum('dara_total');
                $ledger->akhar_total=$transaction->sum('akhar_total');

                $ledger->o_dara=0;
                $ledger->o_akhar=0;
                $ledger->profit=0;
                $ledger->opening=$transaction->value('opening_balance');
                if (!$ledger->opening) {
                    $ledger->opening=0;
                }
                $ledger->closing=0;

                // get draw data
                $win_total=0;
                if($ledger->total)
                {
                    $transaction=$transaction->whereNotNull('draw_number')->select('id','winn_type','winn_amount','closing_balance','winn_comm')->get();
                    if ($this->check_count($transaction)>0) {
                        foreach($transaction as $tran){
                            if($tran->winn_type=='dara'){
                                $ledger->o_dara=$tran->winn_amount;
                            }
                            else{
                                $ledger->o_akhar=$tran->winn_amount;
                            }

                            $win_total=$win_total+$tran->winn_amount*$tran->winn_comm;

                            if ($tran->closing_balance) {
                                $ledger->closing=$tran->closing_balance;
                            }
                        }
                    }
                }

                $ledger->profit=$ledger->total-$win_total-$ledger->commission;


                // Get TPC and Hissa
                $tpc_hissa=$this->get_tpc($ledger->id,$r->date,'','');
                $ledger->tpc=$tpc_hissa['tpc'];
                $ledger->hissa=$tpc_hissa['hissa'];

                if (!$ledger->limit) {
                    $ledger->limit=0;
                }

                if ($ledger->total>1 || $ledger->opening!=0 || $ledger->closing!=0 || $ledger->tpc!=0 || $ledger->tpc!=0 || $ledger->hissa!=0 || $ledger->profit!=0) {
                    $filter_data[]=$ledger;
                }
            }
            if ($this->check_count($filter_data)>0) {
                return response()->json(['status'=>'success','data'=>$filter_data]);
            } else {
                return response()->json(['message'=>'No record found !!','status'=>'fail']);
            }            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function limit_balance_report(Request $r)
    {
        try {
            $ledgers=ledger::select('id','name','limit','limit_status')->where('status',1)->get();
            foreach($ledgers as $ledger){
                $transaction=transaction::where('party',$ledger->id)->sum('total');
                $ledger->TransConsum=$transaction;
                $ledger->balance=$ledger->limit-$transaction;

                if (!$ledger->limit) {
                    $ledger->limit=0;
                }
            }
            
            if ($this->check_count($ledgers)>0) {
                return response()->json(['status'=>'success','data'=>$ledgers]);
            } else {
                return response()->json(['message'=>'No record found !!','status'=>'fail']);
            }            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function profit_loss_data(Request $r)
    {
        try {
            $shifts=shift::where('active','on')->select('id','name')->get();
            foreach($shifts as $shift)
            {            
                $begin = new DateTime(date('Y-m-d',strtotime($r->date_from)));
                $end = new DateTime(date('Y-m-d',strtotime('+1 day', strtotime(date('Y-m-d',strtotime($r->date_to))))));
        
                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);

                $shift->total=0;
                $shift->commission=0;
                $shift->dara_total=0;
                $shift->akhar_total=0;
                $shift->o_dara=0;
                $shift->o_akhar=0;
                $shift->tpc=0;
                $shift->profit=0;
                $shift->credit=0;
                $shift->debit=0;
                $shift->hissa=0;
        
                foreach ($period as $dt) 
                {
                    $transaction=transaction::where('shift',$shift->id)->where('date',$dt->format("d-m-Y"));
                    if ($r->ledger_id) {
                        $transaction->where('party',$r->ledger_id);
                    }
                    $transaction=$transaction->select('id','party','total','dara_total','akhar_total','winn_type','winn_amount','winn_comm','commission')->get();
                    if ($this->check_count($transaction)>0) {
                        foreach($transaction as $tran){

                            $shift->total=$shift->total+$tran->total;
                            $shift->dara_total=$shift->dara_total+$tran->dara_total;
                            $shift->akhar_total=$shift->akhar_total+$tran->akhar_total;
                            $shift->commission=$shift->commission+$tran->commission;

                            // get withdrow data
                            if($tran->winn_type='dara'){
                                $shift->o_dara=$shift->o_dara+$tran->winn_amount;
                            }
                            else{
                                $shift->o_akhar=$shift->o_akhar+$tran->winn_amount;
                            }

                            if ($tran->winn_type) {
                                $shift->profit=$shift->profit+$tran->total-$tran->winn_amount*$tran->winn_comm-$tran->commission;
                            }
                        }
                    }
                }

                if($shift->profit>0){
                    $shift->debit=$shift->profit;
                }
                else{
                    $shift->credit=$shift->profit;
                }
            }
            
            $ledger='';
            if ($r->ledger_id) {
                $ledger=ledger::select('dara','dara_commission')->where('id',$r->ledger_id)->first();
            }
            if ($this->check_count($shifts)>0) {
                return response()->json(['status'=>'success','data'=>$shifts,'ledger'=>$ledger]);
            } else {
                return response()->json(['message'=>'No record found !!','status'=>'fail']);
            }            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    public function daily_report(Request $r)
    {
        // try {

            if($r->search!=='All'){
                $ledger=ledger::where('name',$r->search)->select('id')->first();
                if($r->from_date && $r->to_date){
                    $from_date=date('Y-m-d',strtotime($r->from_date));
                    $to_date=date('Y-m-d',strtotime($r->to_date));
                    $data = JournalVoucher::where('status',1)->where('date','>=',$from_date)->where('date','<=',$to_date);
                    if($ledger->id){
                        $data=$data->where('admin_id',$r->admin_id)->where('ledger_id',$ledger->id)->orderBy('id','DESC')->get();
                    }
                    else{
                        $data=$data->where('admin_id',$r->admin_id)->orderBy('id','DESC')->get();
                    }
                }
                elseif($r->date){
                    $date=date('Y-m-d',strtotime($r->date));    
                    $data = JournalVoucher::where('status',1)->where('date',$date)->where('admin_id',$r->admin_id);
                    if($ledger->id){
                        $data=$data->where('admin_id',$r->admin_id)->where('ledger_id',$ledger->id);
                    }
                    $data=$data->orderBy('id','DESC')->get();
                    
                }
            }
            else{
                if($r->date){
                    $data = JournalVoucher::where('status',1)->where('date',$r->date)->where('admin_id',$r->admin_id)->get();
                }
                else{
                    $from_date=date('Y-m-d',strtotime($r->from_date));
                    $to_date=date('Y-m-d',strtotime($r->to_date));
                    $data = JournalVoucher::where('status',1)->where('admin_id',$r->admin_id)->where('date','>=',$from_date)->where('date','<=',$to_date)->where('admin_id',$r->admin_id)->orderBy('id','DESC')->get();
                }
    
            }
            // dd($data);
            

            $lene=0;
            $dene=0;
            $profit=0;
            $loss=0;
            foreach($data as $d){
               $d->date= date('d-m-Y', strtotime($d->date));
                    if($d->cr_dr=='lene'){
                        $lene=$lene+$d->amount;
                    }
                    elseif($d->cr_dr=='dene'){
                        $dene=$dene+$d->amount;
                    }
                    $d->ledger_name=ledger::where('id',$d->ledger_id)->value('name');
                    $d->amount=substr_replace($d->amount,'.',-2,0);
            }
            if($lene > $dene){
                $profit=$lene - $dene;
            }
            elseif($dene > $lene){
                $loss=$dene - $lene;
            }
            elseif($lene==$dene){
                $profit=0;
                $loss=0;
            }
            if ($this->check_count($data)>0) {
                return response()->json(['status'=>'success','data'=>$data,'plus'=>$profit,'minus'=>$loss]);
            } else {
                return response()->json(['message'=>'No record found !!','status'=>'fail']);
            }            
        // }catch (\Exception $e) {
        //     return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        // }
    }


    // Get TPC 
    public function get_tpc($party,$date,$date_from,$date_to)
    {
        $tpc=0;
        $hissa=0;
        $tpc_ledgers=LedgerCommission::where('party_id',$party)->get();
        if ($this->check_count($tpc_ledgers)>0) {
            foreach ($tpc_ledgers as $tpc_ledger) {
                $tpc_trans=transaction::where('party',$tpc_ledger->ledger_id);
                            if ($date) {
                                $tpc_trans->where('date',date('d-m-Y', strtotime($date)));
                            }
                            if ($date_from) {
                                $tpc_trans->where('date','>=',date('d-m-Y', strtotime($date_from)));
                                $tpc_trans->where('date','<=',date('d-m-Y', strtotime($date_to)));
                            }
                $tpc_trans=$tpc_trans->whereNotNull('draw_number')->select('winn_type','winn_amount','winn_comm','total')->get();
                foreach ($tpc_trans as $tpc_tran) {

                    // TPC
                    if ($tpc_tran->winn_type=='dara' && $tpc_ledger->dara!='') {
                        $tpc=$tpc+(($tpc_tran->winn_amount*$tpc_tran->winn_comm)*$tpc_ledger->dara/100);
                    }
                    if ($tpc_tran->winn_type=='akhar' && $tpc_ledger->akhar!='') {
                        $tpc=$tpc+(($tpc_tran->winn_amount*$tpc_tran->winn_comm)*$tpc_ledger->akhar/100);
                    }

                    // Hissa
                    if ($tpc_ledger->hissa!='') {
                        $hissa=$hissa+$tpc_tran->total-(($tpc_tran->winn_amount*$tpc_tran->winn_comm)*$tpc_ledger->hissa/100);
                    }
                }
            }
        }
        return array('tpc'=>$tpc,'hissa'=>$hissa);
    }
}
