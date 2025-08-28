<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\shift;
use App\Models\User;
use App\Models\agent;
use App\Models\Medicine;
use App\Models\ledger;
use App\Models\MedicineTransaction;
use App\Models\LedgerAmount;
use App\Models\JournalVoucher;
use App\Models\MedicineAmount;
use Carbon\Carbon;
use App\Models\AdminAmount;
use DB;
use Auth;
use Hash;

class shiftController extends Controller
{   

    public function add_medicine_transaction(Request $request){
        // dd($request->all());
        if($request->medicine_id == ''){
            return response()->json(['message'=>'Please select medicine','status'=>false]);
        }
        $medicine = Medicine::where('id',$request->medicine_id)->first();
        if($medicine==''){
            return response()->json(['message'=>'Error in getting record','status'=>false]);
        }
        $ledger_id = $medicine->ledger_id;

        $rebate = $medicine->medicine_rebate;
        $rate   = $medicine->medicine_rate;
       

        $ledgerAmount = MedicineAmount::where('ledger_id',$ledger_id)->select('id','ledger_amount')->first();
        $insert = new MedicineTransaction ();
        $insert->medicine_id = $request->medicine_id;
        $insert->ledger_id = $ledger_id;
        $insert->admin_id = $request->admin_id;
        $insert->type = $request->type;
        $insert->remark= $request->remark;
        $insert->amount = $request->amount;
        $rate_amount  =  $request->amount * $rate /100;
        $rebate_amount = $rate_amount * $rebate /100;
        $final_amount = $rate_amount - $rebate_amount;
        $currentdate = date('Y-m-d');
        $insert->date = $request->date;
        if($request->type=='plus'){
            $insert->medicine_amount = $rate_amount;
        }
        else{
            $insert->medicine_amount = $final_amount;
        }
       
        $ledgerAmount = MedicineAmount::where('ledger_id',$ledger_id)->select('id','ledger_amount')->first();
        if($request->type=='plus'){
            $new_ledger_amount = $ledgerAmount->ledger_amount + $rate_amount;
            $ledgerAmount->ledger_amount = $new_ledger_amount;
            $insert->ledger_amount = $ledgerAmount->ledger_amount;
            $ledgerAmount->date = $request->date;
            $ledgerAmount->type = 'plus';
            $ledgerAmount->deduct_amount = $rate_amount;
            $ledgerAmount->save();
        }
        else{
            $new_ledger_amount = $ledgerAmount->ledger_amount - $final_amount;
            $ledgerAmount->ledger_amount = $new_ledger_amount;
            $insert->ledger_amount = $ledgerAmount->ledger_amount;
            $ledgerAmount->date = $request->date;
            $ledgerAmount->type = 'minus';
            $ledgerAmount->deduct_amount = $final_amount;
            $ledgerAmount->save();
        }
        $insert->total_amount = $new_ledger_amount;
        $save = $insert->save();
        if($save){
            return response()->json(['message'=>'success','status'=>true]);
        }
        return response()->json(['message'=>'Error','status'=>false]);
    }

    // public function add_medicine_transaction(Request $request){
    //     if($request->medicine_id == ''){
    //         return response()->json(['message'=>'Please select medicine','status'=>false]);
    //     }
    
    //     $medicine = Medicine::where('id',$request->medicine_id)->first();
    //     if($medicine==''){
    //         return response()->json(['message'=>'Error in getting record','status'=>false]);
    //     }

    //     $ledger_id = $medicine->ledger_id;

    //     $ledger=ledger::where('id',$medicine->ledger_id)->where('status',1)->first();

    //     $rebate = $medicine->medicine_rebate;
    //     $rate   = $medicine->medicine_rate;
    //     $medicine_name   = $medicine->medicine_name;

    //     $insert = new JournalVoucher ();
    //     $insert->medicine_transaction = 1;
    //     $insert->ledger_id = $ledger_id;
    //     $insert->ledger_name = $ledger->name;
    //     $insert->admin_id = $request->admin_id;
    //     $insert->medicine_transaction_type = $request->type;
    //     $insert->remark= $request->remark;
    //     $insert->medicine_amount = $request->amount;
    //     $rate_amount  =  $request->amount * $rate /100;
    //     $rebate_amount = $rate_amount * $rebate /100;
    //     $final_amount = $rate_amount - $rebate_amount;
    //     if($request->type=='plus'){
    //         $insert->medicine_new_amount = $rate_amount;
    //     }
    //     else{
    //         $insert->medicine_new_amount = $final_amount;
    //     }

    //     $insert->medicine_rate = $rate;
    //     $insert->medicine_rebate=$rebate;
    //     $insert->medicine_name=$medicine_name;
    //     $insert->medicine_id=$medicine->id;
    //     $currentdate = date('Y-m-d');
    //     $insert->date = $currentdate;

    //     $opening=JournalVoucher::where('ledger_id',$ledger->id)->orderBy('id','DESC')->where('status',1)->first();
    //     if($opening==''){
    //         $lm=LedgerAmount::where('ledger_id',$ledger->id)->select('total_amount')->first();
    //         $opening_balance=0;
    //         $closing_balance=$lm->total_amount;
    //     }
    //     else{
    //         $opening_balance=$opening->closing_balance;
    //         $closing_balance=$opening->closing_balance;
    //     }
    //     if($request->type=='plus'){
    //         $insert->opening_balance=$opening_balance;
    //         $insert->closing_balance=$closing_balance + $rate_amount;
    //     }
    //     else{
    //         $insert->opening_balance=$opening_balance;
    //         $insert->closing_balance=$closing_balance - $final_amount;
    //     }
    //     $save=$insert->save();
    //     if($save){
    //         $this->updateMedicineLedgerAmount($ledger_id,$request->type,$rate_amount,$final_amount);
    //         return response()->json(['message'=>'success','status'=>true]);
    //     }
    //     else{
    //         return response()->json(['message'=>'Error','status'=>false]);
    //     }
       
    // }


    public function update_ledger(){
        $data=ledger::get();
        
        foreach($data as $d){
            $update=ledger::where('id',$d->id)->first();
            $name=ucwords($update->name);
            $update->name=$name;
            $save=$update->save();
        }
        return response()->json(['message'=>'sueccess']);
    }

    public function autocompelete_punter_id(Request $r)
    {
        $data=DB::table('users')->where('name','LIKE','%'.$r->name.'%')->where('is_admin','id_cutter')
        ->get();
        if($this->check_count($data) > 0){
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row)
            {
            $output .= '
            <li><a href="#">'.$row->name.'</a></li>
            ';
            }
            $output .= '</ul>';
            return response()->json(['data'=>$output,'status'=>200]);
        }
        else{
            return response()->json(['status'=>500]);
        }
    }

    public function autocompelete_ledger(Request $r)
    {
        $data=DB::table('ledgers')->where('name','LIKE','%'.$r->name.'%')->where('admin_id',$r->admin_id)
        ->get();
        if($this->check_count($data) > 0){
            $output = '<ul class="dropdown-menu" tabindex="0" style="display:block; position:relative">';
            foreach($data as $row)
            {
            $output .= '
            <li><a href="#">'.$row->name.'</a></li>
            ';
            }
            $output .= '</ul>';
            return response()->json(['data'=>$output,'status'=>200]);
        }
        else{
            return response()->json(['status'=>500]);
        }
    }

    //auto complete search ledger
    public function autocompelete_transaction_ledger(Request $r)
    {
        $data=DB::table('ledgers')->where('status',1)->where('name','LIKE','%'.$r->name.'%')
        ->get();
        if($this->check_count($data) > 0){
            $output = '<ul class="dropdown-menu" tabindex="1" style="display:block; position:relative; height:200px;overflow:hidden; overflow-y:scroll;"><li><a href="#">All</a></li>';
            foreach($data as $row)
            {
            $output .= '
            <li><a href="#">'.$row->name.'</a></li>
            ';
            }
            $output .= '</ul>';
            return response()->json(['data'=>$output,'status'=>200]);
        }
        else{
            return response()->json(['status'=>500]);
        }
    }
      //get ledgers
    public function get_ledgers()
      {
          $data=ledger::select('id','name')->where('status',1)->get();
          if($this->check_count($data)>0){
            return response()->json(['message'=>'Success','status'=>true,'data'=>$data]);
          }
          return response()->json(['message'=>'Success','status'=>false]);

      }

    //Delete shift
    public function delete_shift(Request $r){
        $delete=shift::where('id',$r->id)->update(['status'=>0]);
        if($delete){
            return response()->json(['message'=>'Shift Delete Successfully','status'=>'success']);   
        }
        return response()->json(['message'=>'Error!','status'=>'fail']);
    }

     //Delete ledger
     public function delete_ledger(Request $r){
        $delete=ledger::where('id',$r->id)->update(['status'=>0]);
        if($delete){
            return response()->json(['message'=>'Ledger delete Successfully','status'=>'success']);   
        }
        return response()->json(['message'=>'Error!','status'=>'fail']);
    }

     //archieve ledger
     public function archieve_ledger(Request $r){
        $delete=ledger::where('id',$r->id)->update(['archieve_status'=>0]);
        if($delete){
            return response()->json(['message'=>'Ledger Unarchieve Successfully','status'=>'success']);   
        }
        return response()->json(['message'=>'Error!','status'=>'fail']);
    }

      //Delete ledger
      public function unarchieve_ledger(Request $r){
        $delete=ledger::where('id',$r->id)->update(['archieve_status'=>1]);
        if($delete){
            return response()->json(['message'=>'Ledger Unarchieve Successfully','status'=>'success']);   
        }
        return response()->json(['message'=>'Error!','status'=>'fail']);
    }

       //Delete ledger
    //    public function delete_voucher(Request $r){

    //     $update=JournalVoucher::where('id',$r->id)->first();
       
    //     if($update->type==1){
    //         $data=JournalVoucher::where('transaction_id',$update->transaction_id)->get();
    //         $ledger=array();
    //         foreach($data as $key=>$d){
    //             $ledger[$key]=$d->ledger_id;
    //             $ledger[$key]=$d->ledger_id;
    //             if($d->cr_dr=='lene'){
    //                 $latest=JournalVoucher::where('ledger_id',$d->ledger_id)->latest()->first();
    //                 if($latest->id != $update->id){
    //                     $latest->closing_balance=$latest->closing_balance + $update->amount;
    //                     $latest->opening_balance=$latest->opening_balance + $update->amount;
    //                     $latest->save();
    //                 }
                   

    //                 $update_ledger=LedgerAmount::where('ledger_id',$d->ledger_id)->first();
    //                 $update_ledger->total_amount=$update_ledger->total_amount + $update->amount;
    //                 $update_ledger->save();
    //             }
    //             else{
    //                 $latest=JournalVoucher::where('ledger_id',$d->ledger_id)->latest()->first();
    //                  if($latest->id != $update->id){
    //                     $latest->closing_balance=$latest->closing_balance - $update->amount;
    //                     $latest->opening_balance=$latest->opening_balance - $update->amount;
    //                     $latest->save();
    //                 }

    //                 $update_ledger=LedgerAmount::where('ledger_id',$d->ledger_id)->first();
    //                 $update_ledger->total_amount=$update_ledger->total_amount - $update->amount;
    //                 $update_ledger->save();
    //             }
    //             $update_data=DB::table('journal_vouchers')->where('transaction_id',$d->transaction_id)->update(['status'=>0]);


    //         }
    //         // $ledger1=$ledger[0];
    //         // $ledger2=$ledger[1];
           
    //         // $this->updateLegerAmount($ledger1,$update->amount,$update->cr_dr,$update->type,$ledger2);
    //         return response()->json(['message'=>'Journal voucher has been delete successfully.','status'=>'success','type'=>1]);    
    //     }
    //     else{
    //         if($update->cr_dr=='lene'){
    //             $latest=JournalVoucher::where('ledger_id',$update->ledger_id)->latest()->first();
    //             if($latest->id != $update->id){
    //                 $latest=JournalVoucher::where('ledger_id',$update->ledger_id)->latest()->first();
    //                 $latest->closing_balance=$latest->closing_balance + $update->amount;
    //                 $latest->opening_balance=$latest->opening_balance + $update->amount;
    //                 $latest->save();
    //             }
            

    //             $update_ledger=LedgerAmount::where('ledger_id',$update->ledger_id)->first();
    //             $update_ledger->total_amount=$update_ledger->total_amount + $update->amount;
    //             $update_ledger->save();

    //             $update_admin=LedgerAmount::where('ledger_id',0)->first();
    //             $update_admin->total_amount=$update_admin->total_amount - $update->amount;
    //             $update_admin->save();
    //         }
    //         else{
    //             $latest=JournalVoucher::where('ledger_id',$update->ledger_id)->latest()->first();
    //             if($latest->id != $update->id){
    //                 $latest->closing_balance=$latest->closing_balance - $update->amount;
    //                 $latest->opening_balance=$latest->opening_balance - $update->amount;
    //                 $latest->save();
    //             }

    //             $update_ledger=LedgerAmount::where('ledger_id',$update->ledger_id)->first();
    //             $update_ledger->total_amount=$update_ledger->total_amount - $update->amount;
    //             $update_ledger->save();

    //             $update_admin=LedgerAmount::where('ledger_id',0)->first();
    //             $update_admin->total_amount=$update_admin->total_amount + $update->amount;
    //             $update_admin->save();
    //         }
    //         $update->status=0;
    //         $delete=$update->save();
    //         if($delete){  
    //             // $this->deleteLegerAmount($update->ledger_id,$update->amount,$update->cr_dr,0,'');
    //             return response()->json(['message'=>'Transaction has been delete successfully.','status'=>'success']);
    //         }else{
    //             return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
    //         }
    //     }
    // }

    public function delete_voucher(Request $r){
        $update=JournalVoucher::where('id',$r->id)->first();
        if($update->type==1){
            $data=JournalVoucher::where('transaction_id',$update->transaction_id)->get();
            $ledger=array();
            foreach($data as $key=>$d){
                $ledger[$key]=$d->ledger_id;
                $ledger[$key]=$d->ledger_id;
                if($d->cr_dr=='lene'){
                    $latest=JournalVoucher::where('ledger_id',$d->ledger_id)->latest()->first();
                    if($latest->id != $update->id){
                        $latest->closing_balance=$latest->closing_balance + $update->amount;
                        $latest->opening_balance=$latest->opening_balance + $update->amount;
                        $latest->save();
                    }
                    $update_ledger=LedgerAmount::where('ledger_id',$d->ledger_id)->first();
                    $update_ledger->total_amount=$update_ledger->total_amount + $update->amount;
                    $update_ledger->save();
                }
                else{
                    $latest=JournalVoucher::where('ledger_id',$d->ledger_id)->latest()->first();
                     if($latest->id != $update->id){
                        $latest->closing_balance=$latest->closing_balance - $update->amount;
                        $latest->opening_balance=$latest->opening_balance - $update->amount;
                        $latest->save();
                    }

                    $update_ledger=LedgerAmount::where('ledger_id',$d->ledger_id)->first();
                    $update_ledger->total_amount=$update_ledger->total_amount - $update->amount;
                    $update_ledger->save();
                }
                $update_data=DB::table('journal_vouchers')->where('transaction_id',$d->transaction_id)->update(['status'=>0]);


            }
            return response()->json(['message'=>'Journal voucher has been delete successfully.','status'=>'success','type'=>1]);    
        }
        else{
            if($update->cr_dr=='lene'){
                 $latest=JournalVoucher::where('ledger_id',$update->ledger_id)->latest()->first();
                if($latest->id != $update->id){
                    $latest=JournalVoucher::where('id','>',$r->id)->where('ledger_id',$update->ledger_id)->get();
                    
                    foreach($latest as $l){
                        $update_latest_amount=JournalVoucher::where('id',$l->id)->first();
                        $update_latest_amount->closing_balance=$update_latest_amount->closing_balance + $update->amount;
                        $update_latest_amount->opening_balance=$update_latest_amount->opening_balance + $update->amount;
                        $update_latest_amount->save();

                    }
                  
                }
            

                $update_ledger=LedgerAmount::where('ledger_id',$update->ledger_id)->first();
                $update_ledger->total_amount=$update_ledger->total_amount + $update->amount;
                $update_ledger->save();



                $update_admin=AdminAmount::where('admin_id',$request->admin_id)->first();
                $update_admin->total_amount=$update_admin->total_amount - $update->amount;
                $update_admin->save();
            }
            else{
                $latest=JournalVoucher::where('ledger_id',$update->ledger_id)->latest()->first();
                if($latest->id != $update->id){
                    $latest=JournalVoucher::where('id','>',$r->id)->where('ledger_id',$update->ledger_id)->get();
                    
                    foreach($latest as $l){
                        $update_latest_amount=JournalVoucher::where('id',$l->id)->first();
                        $update_latest_amount->closing_balance=$update_latest_amount->closing_balance - $update->amount;
                        $update_latest_amount->opening_balance=$update_latest_amount->opening_balance - $update->amount;
                        $update_latest_amount->save();
                    }
                }

                $update_ledger=LedgerAmount::where('ledger_id',$update->ledger_id)->first();
                $update_ledger->total_amount=$update_ledger->total_amount - $update->amount;
                $update_ledger->save();

                $update_admin=AdminAmount::where('admin_id',$request->admin_id)->first();
                $update_admin->total_amount=$update_admin->total_amount + $update->amount;
                $update_admin->save();
            }
            $update->status=0;
            $delete=$update->save();
            if($delete){  
                return response()->json(['message'=>'Transaction has been delete successfully.','status'=>'success']);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }
        }
    }

    //change status
    public function change_status(Request $r){

        $update=JournalVoucher::where('id',$r->id)->first();
        $update->transaction_status=$r->status;
        $save=$update->save();
        if($save){
            return response()->json(['message'=>'Transaction update successfully','status'=>'success','t_status'=>$r->status]);
        }
        else{
            return response()->json(['message'=>'Error!','status'=>'fail']);
        }
       
    }

    //archieve voucher
    public function archieve_voucher(Request $r){
        $update=JournalVoucher::where('id',$r->id)->first();
        if($update->type==1){
            $update_data=DB::table('journal_vouchers')->where('transaction_id',$update->transaction_id)->update(['archieve_status'=>0]);
            return response()->json(['message'=>'Transaction archieve Successfully','status'=>'success']); 
        }
        else{
            $update->archieve_status=0;
            $update->save();
            return response()->json(['message'=>'Transaction archieve Successfully','status'=>'success']); 
        }
        
    }

      //archieve voucher
      public function unarchieve_voucher(Request $r){
        $update=JournalVoucher::where('id',$r->id)->first();
        if($update->type==1){
            $update_data=DB::table('journal_vouchers')->where('transaction_id',$update->transaction_id)->update(['archieve_status'=>1]);
            return response()->json(['message'=>'Transaction unarchieve Successfully','status'=>'success']); 
        }
        else{
            $update->archieve_status=1;
            $update->save();
            return response()->json(['message'=>'Transaction unarchieve Successfully','status'=>'success']); 
        }
       
    }

    //Delete staff
    public function delete_staff(Request $r){
        $delete=user::where('id',$r->id)->update(['status'=>0]);
        if($delete){
            return response()->json(['message'=>'Staff Delete Successfully','status'=>'success']);   
        }
        return response()->json(['message'=>'Error!','status'=>'fail']);
    }

    //Add Edit Shift
    public function addShift(Request $r){
        
        try {

            $check=shift::where('name',$r->name);
            if($r->id !=''){
                $check=$check->whereNotIn('id',[$r->id]);
            }
            $check=$check->first();

            if($check){
                return response()->json(['message'=>'Error! Shift name already exists,Please enter unique name.','status'=>'fail']);
            }

            if($r->id !=''){
                $insert=shift::find($r->id);
            }else{
                $insert=new shift();
            }
       
            $insert->name=$r->name;
            $insert->date=$r->joined_date;
            $insert->next_day=$r->next_day;
            $insert->time=$r->time;
            $insert->super_admin_time=$r->super_admin_time;
            $insert->admin_time=$r->admin_time;
            $insert->all_data_entry_time=$r->all_data_entry_time;
            $insert->data_entry_time=$r->data_entry_time;
            $insert->active=$r->active;             
            $insert->updatedBy=$r->updatedBy;
            $save=$insert->save();
            if($save){
                return response()->json(['message'=>'Shift has beed added successfully.','status'=>'success','data'=>$insert]);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }


    //Add Edit staff
    public function addShaff(Request $r){

        try {

            $check=User::where('email',$r->email);
            if($r->id !=''){
                $check=$check->whereNotIn('id',[$r->id]);
            }
            $check=$check->first();

            if($check){
                return response()->json(['message'=>'Error! Staff email address already exists,Please enter unique email.','status'=>'fail']);
            }

            if($r->id !=''){
                $insert=User::find($r->id);

                if($r->password != ''){
                    $insert->password=Hash::make($r->password);
                }
                
            }else{
                $insert=new User();
                $insert->email=$r->email; 
                $insert->password=Hash::make($r->password); 
            }

            $insert->name=$r->name;                     
            $insert->mobile=$r->mobile; 
            $insert->is_admin=$r->role;
            
            $insert->agent=$r->agent;
            $insert->user_id=$r->user_id;             
            $insert->active=$r->active; 
            $insert->address=$r->address;             
            $insert->updatedBy=$r->updatedBy;
            $save=$insert->save();

            if($save){
                return response()->json(['message'=>'Staff has beed added successfully.','status'=>'success','data'=>$insert]);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    // Add Agent
    public function addAgent(Request $r){

        try {

            if($r->id !=''){
                $insert=agent::find($r->id);
            }else{
                $insert=new agent(); 
            }

            $insert->group=$r->agent;                     
            $insert->agent=$r->maine_agent; 
            $insert->parent_agent=$r->parent_agent;
            $insert->updated_by=$r->updated_by;
            $save=$insert->save();

            if($save){
                return response()->json(['message'=>'Agent has beed added successfully.','status'=>'success','data'=>$insert]);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }

    }

    public function ledger(Request $r){
        // dd($r->all());
        try {

            $check=ledger::where('name',$r->name)->where('status',1);
            if($r->id !=''){
                $check=$check->whereNotIn('id',[$r->id]);
            }
            $check=$check->first();

            if($check){
                return response()->json(['message'=>'Error! Ledger name already exists,Please enter unique name.','status'=>'fail']);
            }

            if($r->id !=''){
                $insert=ledger::find($r->id);
            }else{
                $insert=new ledger();
            }
            if($r->limit="Yes"){
                $insert->limit_status=$r->limit;
                $insert->limit=$r->limit_value;
            }
       
            $insert->name=$r->name;
            $insert->admin_id=$r->admin_id;
            $insert->username=$r->username;
            $insert->group=$r->group;
            $insert->dara=$r->dara;
            $insert->dara_commission=$r->dara_commission;
            $insert->akhar=$r->akhar;
            $insert->akhar_commission=$r->akhar_commission;
            $insert->tp=$r->tp;
            $insert->rebate=$r->rebate;
            $insert->tp_r=$r->tp_r;
            $insert->hissa=$r->hissa;             
            $insert->grantor=$r->grantor;
            $insert->mobile=$r->mobile;             
            $insert->address=$r->address;
            $insert->user_id=$r->user_id;
            $save=$insert->save();
            if($save){
                return response()->json(['message'=>'Ledger has beed added successfully.','status'=>'success','data'=>$insert]);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }

    }


    public function addidCutter(Request $r){
    //   dd($r->all());
    //  die;
        try {
            $check=User::where('email',$r->email)->where('type',$r->type);
            if($r->id !=''){
                $check=$check->whereNotIn('id',[$r->id]);
            }

            $check=$check->first();

            if($check){
                return response()->json(['message'=>'Error! Id Cutter email address already exists,Please enter unique email.','status'=>'fail']);
            }

            if($r->id !=''){
                $insert=User::find($r->id);

                if($r->password != ''){
                    $insert->password=Hash::make($r->password);
                }
                
            }else{
                $insert=new User();
                $insert->email=$r->email; 
                $insert->password=Hash::make($r->password); 
            }

            $insert->name=$r->name;                     
            $insert->mobile=$r->mobile; 
            $insert->is_admin="id_cutter";
            $insert->type=$r->type;
            $insert->ledger_id=$r->ledger;
            $insert->guarantor=$r->guarantor;  
            $insert->active=$r->active; 
            $insert->address=$r->address;      
            $insert->group_id=$r->group;
            $insert->user_id=$r->user_id;   
            $insert->updatedBy=$r->updatedBy;
            $insert->save();

            if($insert){
             
                return response()->json(['message'=>'Id Cutter has beed added successfully.','status'=>'success','data'=>$insert]);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }


        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        }
    }

    // public function add_journal_voucher(Request $request){

    //     if($request->ledger_name){
    //         $check=ledger::where('name',$request->ledger_name)->where('status',1)->count();
    //         if($check==0){
    //             return response()->json(['message'=>'Ledger account not found','status'=>'error']);
    //         }
    //     }

    //     if($request->ledger_name_2){
    //         $check=ledger::where('name',$request->ledger_name)->where('status',1)->count();
    //         if($check==0){
    //             return response()->json(['message'=>'Ledger account not found','status'=>'error']);
    //         }
    //     }
       
    
    //     if($request->type==1){
    //         $transaction_id=mt_rand(1000000, 9999999);
    //         $message="added";
    //         $insert=new JournalVoucher();
    //         $insert->ledger_id=$request->ledger_id;
    //         $insert->ledger_name=$request->ledger_name;
    //         $insert->date=$request->date;
    //         $insert->type=$request->type;
    //         $insert->transaction_id=$transaction_id;
    //         $insert->cr_dr=$request->cr_dr;
    //         $insert->amount=$request->amount;
    //         if($request->cr_dr=='lene'){
    //             $cr_dr='lene';
    //         }
    //         else{
    //             $cr_dr='dene';
    //         }
    //         $insert->remark=$request->ledger_name.' ' . 'ne'. ' '. $cr_dr .' '. $request->ledger_name_2;
    //         $save=$insert->save();
    //         // $this->updateLegerAmount($request->ledger_id,$request->amount,$request->cr_dr,$request->type,$request->ledger_id_2);

    //         $message="added";
    //         $insert=new JournalVoucher();
    //         $insert->ledger_id=$request->ledger_id_2;
    //         $insert->ledger_name=$request->ledger_name_2;
    //         $insert->type=$request->type;
    //         $insert->transaction_id=$transaction_id;
    //         $insert->date=$request->date;
    //         if($request->cr_dr=='lene'){
    //             $cr_dr='dene';
    //         }
    //         else{
    //             $cr_dr='lene';
    //         }
    //         $insert->cr_dr=$cr_dr;
    //         $insert->amount=$request->amount;
    //         if($request->cr_dr=='lene'){
    //             $cr_dr='dene';
    //         }
    //         else{
    //             $cr_dr='lene';
    //         }
    //         $insert->remark=$request->ledger_name_2.' ' . 'ne'. ' '. $cr_dr .' '. $request->ledger_name;
    //         $save=$insert->save();
    //         $this->updateLegerAmount($request->ledger_id_2,$request->amount,$request->cr_dr,$request->type,$request->ledger_id);
    //         return response()->json(['message'=>'Journal voucher has been '. $message . ' successfully.','status'=>'success','type'=>1]);
    //     }

    //     else{
    //         $message="added";
    //         $insert=new JournalVoucher();
    //         $insert->ledger_id=$request->ledger_id;
    //         $insert->ledger_name=$request->ledger_name;
    //         $insert->date=$request->date;
    //         $insert->type=$request->type;
    //         $insert->cr_dr=$request->cr_dr;
    //         $insert->amount=$request->amount;
    //         $insert->remark=$request->remark;
    //         $save=$insert->save();
    //         // $save=1;
    //         if($save){
    //             $latest=JournalVoucher::orderBy('created_at', 'desc')->where('id',$insert->id)->get();
    //             foreach($latest as $l){
    //                 $l->date=date('d-m-Y',strtotime($l->date));
    //             }
    //             $this->updateLegerAmount($request->ledger_id,$request->amount,$request->cr_dr,0,'');
    //             return response()->json(['message'=>'Journal voucher has been '. $message . ' successfully.','status'=>'success','data'=>$latest,'type'=>0]);
    //         }else{
    //             return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
    //         }

    //     }
    // }

    public function add_journal_voucher(Request $request){

        if($request->has('ledger_id')){
            $check=ledger::where('id',$request->ledger_id)->where('status',1)->count();
            if($check==0){
                return response()->json(['message'=>'Ledger account not found','status'=>'error']);
            }
        }
       


        if($request->ledger_name){
            $check=ledger::where('name',$request->ledger_name)->where('status',1)->count();
            if($check==0){
                return response()->json(['message'=>'Ledger account not found','status'=>'error']);
            }
        }

        if($request->ledger_name_2){
            $check=ledger::where('name',$request->ledger_name_2)->where('status',1)->count();
            if($check==0){
                return response()->json(['message'=>'Ledger account not found','status'=>'error']);
            }
        }
       
    
        if($request->type==1){
            $currentdate = date('Y-m-d');
            $transaction_id=mt_rand(1000000, 9999999);
            $message="added";
            $insert=new JournalVoucher();
            $insert->ledger_id=$request->ledger_id;
            $insert->ledger_name=$request->ledger_name;
            $insert->date=$request->date;
            $insert->type=$request->type;
            $insert->transaction_id=$transaction_id;
            $insert->cr_dr=$request->cr_dr;
            $insert->amount=$request->amount;
            $insert->admin_id = $request->admin_id;
            if($request->cr_dr=='lene'){
                $cr_dr='lene';
            }
            else{
                $cr_dr='dene';
            }
            $insert->remark=$request->ledger_name.' ' . 'ne'. ' '. $cr_dr .' '. $request->ledger_name_2;
            $insert->remark1=$request->remark;



            //first ledger opening balance and closing blance
             //first ledger opening balance and closing blance
             $opening=JournalVoucher::where('ledger_id',$request->ledger_id)->orderBy('id','DESC')->where('status',1)->first();
             if($opening==''){
                 $lm=LedgerAmount::where('ledger_id',$request->ledger_id)->select('total_amount')->first();
                 $opening_balance=0;
                 $closing_balance=$lm->total_amount;
             }
             else{
                 $opening_balance=$opening->closing_balance;
                 $closing_balance=$opening->closing_balance;
             }
             if($request->cr_dr=='lene'){
                 $cr_dr='lene';
                 $insert->opening_balance=$opening_balance;
                 $insert->closing_balance=$closing_balance - $request->amount;
             }
             else{
                 $cr_dr='dene';
                 $insert->opening_balance=$opening_balance;
                 $insert->closing_balance=$closing_balance + $request->amount;
             }
             $save=$insert->save();
            // $this->updateLegerAmount($request->ledger_id,$request->amount,$request->cr_dr,$request->type,$request->ledger_id_2);



            $message="added";
            $insert=new JournalVoucher();
            $insert->ledger_id=$request->ledger_id_2;
            $insert->ledger_name=$request->ledger_name_2;
            $insert->type=$request->type;
            $insert->transaction_id=$transaction_id;
            $insert->date=$request->date;
            $insert->admin_id = $request->admin_id;
            if($request->cr_dr=='lene'){
                $cr_dr='dene';
            }
            else{
                $cr_dr='lene';
            }
            $insert->cr_dr=$cr_dr;
            $insert->amount=$request->amount;
            if($request->cr_dr=='lene'){
                $cr_dr='dene';
            }
            else{
                $cr_dr='lene';
            }
            $insert->remark=$request->ledger_name_2.' ' . 'ne'. ' '. $cr_dr .' '. $request->ledger_name;
            $insert->remark1=$request->remark;

            //ledger_id_2
            $opening=JournalVoucher::where('ledger_id',$request->ledger_id_2)->orderBy('id','DESC')->where('status',1)->first();
            // dd($opening);
            if($opening==''){
                $lm=LedgerAmount::where('ledger_id',$request->ledger_id_2)->select('total_amount')->first();
                $opening_balance=0;
                $closing_balance=$lm->total_amount;
            }
            else{
                $opening_balance=$opening->closing_balance;
                $closing_balance=$opening->closing_balance;
            }
            if($request->cr_dr=='dene'){
                $insert->opening_balance=$opening_balance;
                $insert->closing_balance=$closing_balance - $request->amount;
            }
            else{
                $insert->opening_balance=$opening_balance;
                $insert->closing_balance=$closing_balance + $request->amount;
            }

            $save=$insert->save();
          
            $this->updateLegerAmount($request->ledger_id_2,$request->amount,$request->cr_dr,$request->type,$request->ledger_id,$request->admin_id);
            return response()->json(['message'=>'Journal voucher has been '. $message . ' successfully.','status'=>'success','type'=>1]);
        }

        else{
            $message="added";
            $insert=new JournalVoucher();
            $insert->ledger_id=$request->ledger_id;
            $insert->ledger_name=$request->ledger_name;
            $insert->date=$request->date;
            $insert->type=$request->type;
            $insert->cr_dr=$request->cr_dr;
            $insert->amount=$request->amount;
            $insert->remark=$request->remark;
            $insert->admin_id = $request->admin_id;

            //date
            $currentdate = date('Y-m-d');


            $opening=JournalVoucher::where('ledger_id',$request->ledger_id)->orderBy('id','DESC')->where('status',1)->first();
            // dd($opening);
            if($opening==''){
                $lm=LedgerAmount::where('ledger_id',$request->ledger_id)->select('total_amount')->first();
                $opening_balance=0;
                $closing_balance=$lm->total_amount;
            }
            else{
                $opening_balance=$opening->closing_balance;
                $closing_balance=$opening->closing_balance;
            }
            if($request->cr_dr=='lene'){
                $cr_dr='lene';
                $insert->opening_balance=$opening_balance;
                $insert->closing_balance=$closing_balance - $request->amount;
            }
            else{
                $cr_dr='dene';
                $insert->opening_balance=$opening_balance;
                $insert->closing_balance=$closing_balance + $request->amount;
            }
            $save=$insert->save();
            // $save=1;
            if($save){
                $latest=JournalVoucher::orderBy('created_at', 'desc')->where('id',$insert->id)->get();
                foreach($latest as $l){
                    $l->date=date('d-m-Y',strtotime($l->date));
                    $l->amount=substr_replace($l->amount,'.',-2,0);
                }
                $this->updateLegerAmount($request->ledger_id,$request->amount,$request->cr_dr,0,'',$request->admin_id);
                return response()->json(['message'=>'Journal voucher has been '. $message . ' successfully.','status'=>'success','data'=>$latest,'type'=>0]);
            }else{
                return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
            }

        }
    }

    public function edit_journal_voucher(Request $request){
         
        //  try {
    
            $update=JournalVoucher::find($request->id);  
            $type=$update->cr_dr;
            if($update->type==1){
                $data=JournalVoucher::where('transaction_id',$update->transaction_id)->get();
                $ledger=array();
                foreach($data as $key=>$d){
                    $ledger[$key]=$d->ledger_id;
                    $ledger[$key]=$d->ledger_id;
                    if($d->cr_dr=='lene'){
                        $update_ledger=LedgerAmount::where('ledger_id',$d->ledger_id)->first();
                        $update_ledger->total_amount=$update_ledger->total_amount + $update->amount;
                        $update_ledger->save();
                    }
                    else{
                        $update_ledger=LedgerAmount::where('ledger_id',$d->ledger_id)->first();
                        $update_ledger->total_amount=$update_ledger->total_amount - $update->amount;
                        $update_ledger->save();
                    }
                    $update_data=DB::table('journal_vouchers')->where('transaction_id',$d->transaction_id)->update(['amount'=>$request->edit_amount]);
                }
                $ledger1=$ledger[0];
                $ledger2=$ledger[1];
                $update->date=$request->edit_date;
                $update->amount=$request->edit_amount;
                $save=$update->save();
                $this->updateLegerAmount($ledger1,$request->edit_amount,$update->cr_dr,$update->type,$ledger2,$request->admin_id);
                return response()->json(['message'=>'Journal voucher has been update successfully.','status'=>'success','type'=>1]);    
            }
            else{
                if($update->cr_dr=='lene'){
                    $update_ledger=LedgerAmount::where('ledger_id',$update->ledger_id)->first();
                    $update_ledger->total_amount=$update_ledger->total_amount + $update->amount;
                    $update_ledger->save();
    
                    $update_admin=AdminAmount::where('admin_id',$request->admin_id)->first();
                    $update_admin->total_amount=$update_admin->total_amount - $update->amount;
                    $update_admin->save();
                }
                else{
                    $update_ledger=LedgerAmount::where('ledger_id',$update->ledger_id)->first();
                    $update_ledger->total_amount=$update_ledger->total_amount - $update->amount;
                    $update_ledger->save();
    
                    $update_admin=AdminAmount::where('admin_id',$request->admin_id)->first();
                    $update_admin->total_amount=$update_admin->total_amount + $update->amount;
                    $update_admin->save();
                }
            
                $update->date=$request->edit_date;
                $update->amount=$request->edit_amount;
                $update->remark=$request->edit_remark;
                $save=$update->save();
                if($save){
                    $latest=JournalVoucher::orderBy('created_at', 'desc')->where('id',$update->id)->get();
                    foreach($latest as $l){
                        $l->date=date('d-m-Y',strtotime($l->date));
                    }
                    // dd($latest);
                    $this->updateLegerAmount($update->ledger_id,$request->edit_amount,$update->cr_dr,0,'',$request->admin_id);
                    return response()->json(['message'=>'Transaction has been update successfully.','status'=>'success','data'=>$latest]);
                }else{
                    return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
                }
            }
        // }catch (\Exception $e) {
        //     return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        // }
    
    
        }

    public function updateLegerAmount($ledger_id,$amount,$type,$transaction_type,$ledger_id_2,$admin_id){
        if($transaction_type==1){

            $ledger=LedgerAmount::where('ledger_id',$ledger_id)->first();
            if($type=='dene'){
                $ledger->total_amount=$ledger->total_amount - $amount;
            }
            else if($type=='lene'){
                $ledger->total_amount=$ledger->total_amount + $amount;
            }
            $ledger->save();
            

            $admin=LedgerAmount::where('ledger_id',$ledger_id_2)->first();
            if($type=='dene'){
                $admin->total_amount=$admin->total_amount + $amount;
            }
            else if($type=='lene'){
                $admin->total_amount=$admin->total_amount - $amount;
            }
            $admin->save();

        }
        else{
           
        $ledger=LedgerAmount::where('ledger_id',$ledger_id)->first();
        if($type=='dene'){
            $ledger->total_amount=$ledger->total_amount + $amount;
        }
        else if($type=='lene'){
            
            $ledger->total_amount=$ledger->total_amount - $amount;
        }
        $ledger->save();

        $admin=AdminAmount::where('admin_id',$admin_id)->first();
        if($type=='dene'){
            $admin->total_amount=$admin->total_amount - $amount;
        }
        else if($type=='lene'){
            $admin->total_amount=$admin->total_amount + $amount;
        }
        $admin->save();

        }
        
    }

    public function deleteLegerAmount($ledger_id,$amount,$type,$transaction_type,$ledger_id_2){
        
        if($transaction_type==1){

            $ledger=LedgerAmount::where('ledger_id',$ledger_id)->first();
            if($type=='dene'){
                $ledger->total_amount=$ledger->total_amount + $amount;
            }
            else if($type=='lene'){
                $ledger->total_amount=$ledger->total_amount - $amount;
            }
            $ledger->save();
            

            $admin=LedgerAmount::where('ledger_id',$ledger_id_2)->first();
            if($type=='dene'){
                $admin->total_amount=$admin->total_amount - $amount;
            }
            else if($type=='lene'){
                $admin->total_amount=$admin->total_amount + $amount;
            }
            $admin->save();

        }

        else{
            $ledger=LedgerAmount::where('ledger_id',$ledger_id)->first();
        if($type=='dene'){
            $ledger->total_amount=$ledger->total_amount - $amount;
        }
        else if($type=='lene'){
            $ledger->total_amount=$ledger->total_amount + $amount;
        }
        $ledger->save();

        $admin=LedgerAmount::where('ledger_id',0)->first();
        if($type=='dene'){
            $admin->total_amount=$admin->total_amount + $amount;
        }
        else if($type=='lene'){
            $admin->total_amount=$admin->total_amount - $amount;
        }
        $admin->save();

        }
        
    }
  

    public function search_ledger(Request $request){
        try {
            $data=ledger::select('id','name')->where('status',1)->where('name',$request->keyword)->count();
            return response()->json(['message'=>'success','data'=>$data,'status'=>200]);
       }catch (\Exception $e) {
           return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
       }
   
   
       }

    public function update_basic_ledger(Request $request){
        // dd($request->all());
        $data=ledger::where('id',$request->ledger_id)->first();
        $data->name=$request->ledger;
        $data->mobile=$request->mobile;
        $data->username=$request->realname;
        $save=$data->save();
        if($save){
            return response()->json(['message'=>'Update successfully','status'=>200]);
        }
        return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);
       
    }


    public function update_reconfig_rate(Request $request){
        // dd($request->all());
        $data=ledger::where('id',$request->ledger_id)->first();
        $data->dara=$request->dara;
        $data->dara_commission=$request->dara_commission;
        $data->akhar=$request->akhar;
        $data->akhar_commission=$request->akhar_commission;
        $data->rebate=$request->rebate;
        $save=$data->save();
        if($save){
            return response()->json(['message'=>'Update successfully','status'=>200]);
        }
        return response()->json(['message'=>'Error! Please try again.','status'=>'fail']);

    }

    public function search_shift(Request $request){
        $data=shift::where('name', 'like', '%' . $request->shift_name . '%')->where('status',1)->get();
        foreach($data as $d){
            $new_updated_at=date('d-m-Y h:i a',strtotime($d->updated_at));
            $d->new_updated_at=$new_updated_at;
        }
        if($this->check_count($data) > 0){
            return response()->json(['message'=>'success','status'=>'success','data'=>$data]);   
        }
        return response()->json(['message'=>'No data found','status'=>'fail']);
    }

    public function updateMedicineLedgerAmount($ledger_id,$type,$rate_amount,$final_amount){
        $ledger=LedgerAmount::where('ledger_id',$ledger_id)->first();
        if($type=='plus'){
            $ledger->total_amount=$ledger->total_amount + $rate_amount;
        }
        else if($type=='minus'){
            $ledger->total_amount=$ledger->total_amount - $final_amount;
        }
        $ledger->save();
    }

   

    

}
