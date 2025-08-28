<?php

namespace App\Http\Controllers;

use View;
use DB;
use App\Models\Note;
use App\Models\ledger;
use Illuminate\Http\Request;
use App\Models\shift;
use App\Models\transaction;
use App\Models\User;
use App\Models\Prediction;
use App\Models\LedgerAmount;
use DateTime;
use Auth;

class TransactionController extends Controller
{

    public function notes(){
        $title='notes';
      
        $data=Note::where('admin_id',Auth::user()->id)->get();
        
        return view::make('notes.notes',compact('title','data'));
    }

    public function createNote(Request $request){
        $title='notes';
        if($request->id!=''){
            $insert=Note::where('id',$request->id)->first();
        }
        else{
            $insert=new Note();
        }
        $insert->title=$request->title;
        $insert->admin_id=Auth::user()->id;
        $insert->remark=$request->remark;
        $save=$insert->save();
        if($save){
            return response()->json(['message'=>'success','status'=>'success']);
        }
            return response()->json(['message'=>'success','status'=>'error']);
        
    }

    public function edit_notes($id){
        $title='notes';
        $data=Note::where('id',decrypt($id))->first();
        return view::make('notes.edit_notes',compact('title','data'));
    }

    public function updateNotes(Request $request){
        $title='notes';
        $data=Note::where('id',$request->id)->first();
        $data->title=$request->title;
        $data->remark=$request->remark;
        $data->admin_id=Auth::user()->id;
        $save=$data->save();
        if($save){
            return response()->json(['message'=>'success','status'=>'success']);
        }
            return response()->json(['message'=>'success','status'=>'error']);
    }

    public function deleteNotes(Request $request){
        $delete=Note::where('id',$request->id)->delete();
        if($delete){
            return response()->json(['message'=>'Notes delete successfully','status'=>'success']);
        }
            return response()->json(['message'=>'Error in notes deleting','status'=>'error']);

    }

    public function deleteAdmin(Request $request){
        $delete=User::where('id',$request->id)->delete();
        if($delete){
            return response()->json(['message'=>'Admin delete successfully','status'=>'success']);
        }
            return response()->json(['message'=>'Error in admin deleting','status'=>'error']);

    }

    public function get_ledger(Request $request){
     
        $data=ledger::where('id','!=',$request->id)->where('status',1)->where('admin_id',Auth::user()->id)->get();
        
        return response()->json(['message'=>'success','status'=>true,'data'=>$data]);
    }

    public function user_transaction(){
        $title='transaction';
        $ledger=ledger::where('status',1)->get();
        return View::make('transaction.transaction_user_list',compact('title','ledger')); 
    }

    public function transaction(){
        $title='transaction';
        $ledger=ledger::where('status',1)->get();
        $admin_amount=LedgerAmount::where('ledger_id',1)->value('total_amount');
        return View::make('transaction.profile_transaction',compact('title','ledger','admin_amount'));
    }
    public function fetch_mainjantri_transaction(Request $r)
    {
        try {
            $data=transaction::select('amount','number');
            if(Auth::user()->is_admin=='data_entry'){
                $data->where('added_by',Auth::user()->id);
            }
            if ($r->shift) {
                $data->where('shift',$r->shift);
            }
            if ($r->date) {
                $data->where('date',date('d-m-Y', strtotime($r->date)));
            }
            $data->where('status',0);
            $data=$data->get();
            if ($this->check_count($data)>0) {
                return response()->json(['status'=>'success','data'=>$data]);
            } else {
                return response()->json(['message'=>'No transaction found !!','status'=>'fail']);
            }            
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
            if(Auth::user()->is_admin=='data_entry'){
                $data->where('transactions.added_by',Auth::user()->id);
            }
           
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
            if($r->user){
                $data->where('transactions.added_by',$r->user);
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

    public function edit_transaction($id)
    {
        $title='transaction';
        $data=transaction::find($id);
        $shift=shift::where('id',$data->shift)->first();

        // if($shift->date==date('Y-m-d') || ($shift->next_day=="Yes" && date('Y-m-d')==date('Y-m-d',strtotime('+1 day', strtotime(date('Y-m-d',strtotime($shift->date))))))){
            if (Auth::User()->is_admin=='KING') {
                $get_time=$shift->time;
            }
            else {
                $get_time=$shift->Auth::User()->is_admin;
            }
            $time=date('D M d Y H:i:s O',strtotime($shift->date.' '.$get_time));
            $ledgers=ledger::select('id','name','dara','dara_commission','akhar','akhar_commission','limit','limit_status')->where('status',1)->get();
            return View::make('transaction.edit_transaction',compact('title','ledgers','shift','time','data'));
        // }
        // else{
        //     return redirect()->route('transaction_list');
        // }
    }

    public function add_transaction($shift)
    {
        $title='transaction';
        $shift=shift::where('id',$shift)->first();

        if($shift->date==date('Y-m-d') || ($shift->next_day=="Yes" && date('Y-m-d')==date('Y-m-d',strtotime('+1 day', strtotime(date('Y-m-d',strtotime($shift->date))))))){
            if (Auth::User()->is_admin=='KING') {
                $get_time=$shift->time;
            }
            else {
                $role=Auth::User()->is_admin.'_time';
                $get_time=$shift->$role;
            }
            $time=date('D M d Y H:i:s O',strtotime($shift->date.' '.$get_time));
            $ledgers=ledger::select('id','name','dara','dara_commission','akhar','akhar_commission')->where('status',1)->get();
            return View::make('transaction.add_transaction',compact('title','ledgers','shift','time'));
        }
        else{
            return redirect()->route('transaction_list');
        }
    }
    
    public function declared_transaction()
    {
        $title='del_transaction';
        $shifts=shift::where('active','on')->get();
        $staff=User::where('is_admin','data_entry')->select('id','name')->get();
        return View::make('transaction.declared_transaction',compact('title','shifts','staff'));
    }

    public function transaction_list()
    {
        $title='transaction';
        $shifts=shift::where('active','on')->select('id','name','date','next_day','time')->get();
        foreach ($shifts as $shift) {
            $shift->active_status=0;

            $check=Prediction::where('shift_id',$shift->id)->where('date',date('Y-m-d'))->count();
            if ($check<1) {
                if ($shift->date==date('Y-m-d')) {
                    $shift->active_status=1;
                }
                else{
                    $date=date('Y-m-d',strtotime('+1 day', strtotime(date('Y-m-d',strtotime($shift->date)))));
                    if($shift->next_day=="Yes" && date('Y-m-d')==$date && strtotime(date("G:i"))<strtotime($shift->time)) {
                        $shift->active_status=1;
                    }
                } 
            }
        }
        $staff=User::where('is_admin','data_entry')->select('id','name')->get();
        return View::make('transaction.transaction_list',compact('title','shifts','staff'));
    }

    public function transaction_popup()
    {
        $title='transaction';
        $data=shift::where('active','on')->get();
        return View::make('transaction.transaction_pop',compact('title','data'));
    }
}
