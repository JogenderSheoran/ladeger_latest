<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\JournalVoucher;
use App\Models\ledger;
use App\Models\Medicine;
use App\Models\MedicineTransaction;
use App\Models\MedicineAmount;
use App\Models\LedgerAmount;
use App\Models\AdminAmount;
use Carbon\Carbon;
use Log;
use Auth;
Use View;

class VoucherController extends Controller
{
    //journal_voucher
    public function journal_voucher()
    {
        $title='Vocher';
        $current=date('Y-m-d');
        $previous= date('Y-m-d', strtotime($current .' -1 day'));
    
        $ledger=ledger::where('status',1)->where('archieve_status',1)->where('admin_id',Auth::user()->id)->get();
        $data=JournalVoucher::where('archieve_status',1)->where('status',1)->orderBy('id','DESC')->where('admin_id',Auth::user()->id)->limit(100)->get();
        
        
        foreach($data as $d){
            $d->party1=ledger::where('id',$d->party1)->value('name');
            $d->party2=ledger::where('id',$d->party2)->value('name');
        }
        return View::make('voucher.journal_voucher',compact('title','data','ledger'));
    }

    // public function medicine_transaction()
    // {
    //     $title='Medicine Transaction';
    //     $current=date('Y-m-d');
    //     $previous= date('Y-m-d', strtotime($current .' -1 day'));
    //     if(Auth::user()->is_admin == 'Admin'){
    //         $data=JournalVoucher::orderBy('id','DESC')->where('medicine_transaction',1)->limit(100)->get();
    //     }
    //     else{
    //         $data=JournalVoucher::orderBy('id','DESC')->where('medicine_transaction',1)->where('admin_id',Auth::user()->id)->limit(100)->get();
    //     }
    //     foreach($data as $d){
    //         $medicine = Medicine::where('id',$d->medicine_id)->first();
    //         if($medicine!=''){
    //             $d->medicine_name = $medicine->medicine_name;
    //         }
    //         else{
    //             $d->medicine_name = 'N/A';
    //         }
    //         $d->rate=$medicine->medicine_rate;
    //         $d->rebate=$medicine->medicine_rebate;
    //         $d->ledger_name=ledger::where('id',$d->ledger_id)->value('name');
    //     }
    //     $medicine=Medicine::where('admin_id',Auth::user()->id)->get();
    //     return View::make('voucher.medicine_transaction',compact('title','data','medicine'));
    // }

    public function medicine_transaction(){
        $title='Medicine Transaction';
        $medicine=Medicine::where('admin_id',Auth::user()->id)->get();
       
        $today = Carbon::today()->toDateString();

        // Get total plus transactions for today
        $total_plus = MedicineTransaction::where('admin_id', Auth::user()->id)
            ->where('date', $today)
            ->where('type', 'plus')
            ->sum('medicine_amount');

        // Get total minus transactions for today
        $total_minus = MedicineTransaction::where('admin_id', Auth::user()->id)
            ->where('date', $today)
            ->where('type', 'minus')
            ->sum('medicine_amount');

        $total = $total_plus - $total_minus;

        return View::make('voucher.medicine_transaction',compact('title','medicine','total_plus','total_minus','total'));
    }

    public function ledger_report($id)
    {
        $title='Vocher';
        $data=JournalVoucher::where('archieve_status',1)->where('ledger_id',$id)->where('status',1)->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->get();
        foreach($data as $d){
            $d->party1=ledger::where('id',$d->party1)->value('name');
            $d->party2=ledger::where('id',$d->party2)->value('name');
        }
        $ledger=ledger::where('status',1)->where('admin_id',Auth::user()->id)->where('archieve_status',1)->get();
        return View::make('voucher.user_journal_voucher',compact('title','data','ledger'));
    }

    public function archieve_transaction()
    {
        $title='archieve';
      
        $data=JournalVoucher::where('archieve_status',0)->where('admin_id',Auth::user()->id)->where('status',1)->orderBy('id','DESC')->get();
        
        foreach($data as $d){
            $d->party1=ledger::where('id',$d->party1)->value('name');
            $d->party2=ledger::where('id',$d->party2)->value('name');
        }
       
        $ledger=ledger::where('archieve_status',0)->where('admin_id',Auth::user()->id)->get();
        
       
        return View::make('voucher.archieve_transaction',compact('title','data','ledger'));
    }

    public function ledgerMedicineTransaction($id){
        $title='Medicine Transaction';
        $current=date('Y-m-d');
        $previous= date('Y-m-d', strtotime($current .' -1 day'));
      
        $data=MedicineTransaction::orderBy('id','DESC')->where('ledger_id',$id)->where('admin_id',Auth::user()->id)->limit(100)->get();
        

        $totalPlus = 0;
        $totalMinus = 0;
        $ledgerAmount = 0;

        foreach($data as $d){
            $medicine = Medicine::where('id',$d->medicine_id)->first();
            if($medicine!=''){
                $d->medicine_name = $medicine->medicine_name;
            }
            else{
                $d->medicine_name = 'N/A';
            }
            $d->rate=$medicine->medicine_rate;
            $d->rebate=$medicine->medicine_rebate;
            $d->ledger_name=ledger::where('id',$d->ledger_id)->value('name');

            if ($d->type === 'plus') {
                $totalPlus += $d->medicine_amount;
            } elseif ($d->type === 'minus') {
                $totalMinus += $d->medicine_amount;
            }
            $ledgerAmount=$d->ledger_amount;
        }
        $medicine=Medicine::where('admin_id',Auth::user()->id)->get();
        return View::make('voucher.user_medicine',compact('title','data','medicine','totalPlus','totalMinus','ledgerAmount'));
    }

    // public function ledgerMedicine(Request $request)
    // {
    //     $isAdmin = Auth::user()->is_admin == 'Admin';
    //     $query = JournalVoucher::where('medicine_transaction',1)->where('bill_status',0)->orderBy('id', 'DESC')
    //         ->where('ledger_id', $request->ledger_id);
    
    //     if (!$isAdmin) {
    //         $query->where('admin_id', Auth::user()->id);
    //     }
    
    //     $data = $query->get();
    
    //     $totalPlus = 0;
    //     $totalMinus = 0;
    
    //     foreach ($data as $d) {
    //         $medicine = Medicine::where('id', $d->medicine_id)->first();
    //         if($medicine!=''){
    //             $d->medicine_name = $medicine->medicine_name;
    //         }
    //         else{
    //             $d->medicine_name = 'N/A';
    //         }
            
    //         $d->medicine_amount = (int)$d->medicine_new_amount;
    //         $d->rate = $medicine->medicine_rate;
    //         $d->rebate = $medicine->medicine_rebate;
    //         $d->ledger_name = Ledger::where('id', $d->ledger_id)->value('name');
    
    //         if ($d->medicine_transaction_type === 'plus') {
    //             $totalPlus += $d->medicine_new_amount;
    //         } elseif ($d->medicine_transaction_type === 'minus') {
    //             $totalMinus += $d->medicine_new_amount;
    //         }
    //     }

        
    
    //     $totals = [
    //         'totalPlus' => $totalPlus,
    //         'totalMinus' => $totalMinus,
    //         'totalAmount' => $totalPlus - $totalMinus,
    //     ];
    
    //     return response()->json([
    //         'data' => $data,
    //         'totals' => $totals,
    //         'ledgerId'=>$request->ledger_id
    //     ]);
    // }

    public function ledgerMedicine(Request $request)
    {
        $isAdmin = Auth::user()->is_admin == 'Admin';
        $query = MedicineTransaction::where('bill_status',0)->orderBy('id', 'DESC')
            ->where('ledger_id', $request->ledger_id);
    
        $query->where('admin_id', Auth::user()->id);
        

        $data = $query->get();
   

    $totalPlus = 0;
    $totalMinus = 0;

    foreach ($data as $d) {
        $medicine = Medicine::withTrashed()->where('id', $d->medicine_id)->first();
        // dd($medicine);
        if($medicine!=''){
            $d->medicine_name = $medicine->medicine_name;
        }
        else{
            $d->medicine_name = 'N/A';
        }
        
        $d->medicine_amount = (int)$d->medicine_amount;
        $d->rate = $medicine->medicine_rate;
        $d->rebate = $medicine->medicine_rebate;
        $d->ledger_name = Ledger::where('id', $d->ledger_id)->value('name');
        
        // Format the date for display
        $d->formatted_date = $d->created_at ? $d->created_at->format('d/m/Y') : '';
    
            if ($d->type == 'plus') {
                $totalPlus += $d->medicine_amount;
            } elseif ($d->type == 'minus') {
                $totalMinus += $d->medicine_amount;
            }
        }

        $totals = [
            'totalPlus' => $totalPlus,
            'totalMinus' => $totalMinus,
            'totalAmount' => $totalPlus - $totalMinus,
        ];
    
        return response()->json([
            'data' => $data,
            'totals' => $totals,
            'ledgerId'=>$request->ledger_id
        ]);
    }

    public function ledgerMedicineList(Request $request){
        $data = Medicine::where('ledger_id',$request->ledger_id)->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function ledgerBillUpdate (Request $request)
    {
        $ledgerId = $request->input('ledger_id');

        $transactionCount = MedicineTransaction::where('ledger_id', $ledgerId)
        ->where('bill_status',0)
        ->count();

        if ($transactionCount == 0) {
            return response()->json(['message' => 'Bill cannot be generated. No transactions found.', 'status' => false]);
        }

        $ledger =  ledger::where('id',$ledgerId)->first();
       

        if (!$ledger) {
            return response()->json(['error' => 'Error','status'=>false], 404);
        }

        $medicineTransaction =  MedicineTransaction::where('ledger_id',$ledgerId)->where('bill_status',0)->get();

      
        foreach($medicineTransaction as $transaction){
            // $medicine = Medicine::where('id',$transaction->medicine_id)->first();
            $medicine = Medicine::withTrashed()->where('id', $transaction->medicine_id)->first();
            if($medicine==''){
                exit;
            }
            else{
                $ledger=ledger::where('id',$transaction->ledger_id)->first();
                $ledger_id = $ledger->id;
                $rebate = $medicine->medicine_rebate;
                $rate   = $medicine->medicine_rate;
                $medicine_name   = $medicine->medicine_name;

                $insert = new JournalVoucher ();
                $insert->medicine_transaction = 1;
                $insert->ledger_id = $transaction->ledger_id;
                $insert->ledger_name = $ledger->name;
                $insert->admin_id = Auth::user()->id;
                $insert->medicine_transaction_type = $transaction->type;
                $insert->remark= $transaction->remark;
                $insert->medicine_amount = $transaction->amount;
                $rate_amount  =  $transaction->amount * $rate /100;
                $rebate_amount = $rate_amount * $rebate /100;
                $final_amount = $rate_amount - $rebate_amount;
                $insert->amount = $transaction->amount;
                if($transaction->type=='plus'){
                    $insert->medicine_new_amount = $rate_amount;
                }
                else{
                    $insert->medicine_new_amount = $final_amount;
                }
        
                $insert->medicine_rate = $rate;
                $insert->medicine_rebate=$rebate;
                $insert->medicine_name=$medicine_name;
                $insert->medicine_id=$medicine->id;
                $currentdate = date('Y-m-d');
                $insert->date = $currentdate;
                $insert->bill_status=1;
        
                $opening=JournalVoucher::where('ledger_id',$ledger->id)->orderBy('id','DESC')->where('status',1)->first();
                if($opening==''){
                    $lm=LedgerAmount::where('ledger_id',$ledger->id)->select('total_amount')->first();
                    $opening_balance=0;
                    $closing_balance=$lm->total_amount;
                }
                else{
                    $opening_balance=$opening->closing_balance;
                    $closing_balance=$opening->closing_balance;
                }
                if($transaction->type=='plus'){
                    $insert->opening_balance=$opening_balance;
                    $insert->closing_balance=$closing_balance + $rate_amount;
                }
                else{
                    $insert->opening_balance=$opening_balance;
                    $insert->closing_balance=$closing_balance - $final_amount;
                }
                $save=$insert->save();
                if($save){
                    MedicineTransaction::where('ledger_id',$ledgerId)->update(['bill_status'=>1]);
                    $this->updateMedicineLedgerAmount($ledger_id,$transaction->type,$rate_amount,$final_amount);
                }
            }
        }

        return response()->json(['message' => 'Bill status updated successfully','status'=>true], 200);
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

        
        $admin=AdminAmount::where('admin_id',Auth::user()->id)->first();
        if($type=='plus'){
            $admin->total_amount=$admin->total_amount - $final_amount;
        }
        else if($type=='minus'){
            $admin->total_amount=$admin->total_amount + $final_amount;
        }
        $admin->save();

    }

    public function getMedicineTransactionsAjax(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search')['value'];

        // Base query
        $query = MedicineTransaction::orderBy('id', 'DESC')
            ->where('admin_id', Auth::user()->id);

        // Apply search if provided
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('remark', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Get total records count
        $totalRecords = MedicineTransaction::where('admin_id', Auth::user()->id)->count();
        $filteredRecords = $query->count();

        // Apply pagination
        $data = $query->skip($start)->take($length)->get();

        // Process data for display
        $result = [];
        foreach ($data as $key => $value) {
            $medicine = Medicine::withTrashed()->where('id', $value->medicine_id)->first();
            $ledger_name = ledger::where('id', $value->ledger_id)->value('name');
            
            $medicine_name = $medicine ? $medicine->medicine_name : 'N/A';
            $rate = $medicine ? $medicine->medicine_rate : 0;
            $rebate = $medicine ? $medicine->medicine_rebate : 0;

            $typeLabel = $value->type == 'minus' 
                ? '<span class="label label-sm label-danger label-mini btn cr_dr  sbold" style="background-color:red">
                                                    lene
                                                </span>'
                : '<span class="label label-sm label-success label-mini btn cr_dr  sbold" style="background-color:green">
                                                    dene
                                                </span>';

            // // Bill status with proper colored buttons
            // $billLabel = $value->bill_status == 0 
            //     ? '<span class="btn btn-xs btn-danger" style="background-color: #dc3545; color: white; border: none; font-size: 10px; padding: 2px 6px;">
            //         <i class="fa fa-clock-o"></i> PENDING
            //        </span>'
            //     : '<span class="btn btn-xs btn-success" style="background-color: #28a745; color: white; border: none; font-size: 10px; padding: 2px 6px;">
            //         <i class="fa fa-check-circle"></i> GENERATED
            //        </span>';

            $style="";
            if($value->bill_status==0){
                $style="background-color:red";
            }
            else{
                $style="background-color:green";
            }

            $val = "";
            if($value->bill_status==0){
                $val="Generate Bill";
            }
            else{
                $val="Bill Generated";
            }
            
            $billLabel='<span class="label label-sm label-success label-mini btn cr_dr  sbold" style="'.$style.'">
                  '.$val.'
               </span>';

            // Check if transaction is deleted
            $isDeleted = isset($value->is_deleted) && $value->is_deleted == 1;
            
            // Show amounts as 0 if deleted, otherwise show actual amounts
            $amount = $isDeleted ? '0' : (($value->type == 'minus' ? '- ' : '+ ') . $value->medicine_amount);
            $medicineAmount = $isDeleted ? '0' : (($value->type == 'minus' ? '- ' : '+ ') . $value->amount);

            $actionButton = '<div style="display: grid; gap:2px; justify-content: center; align-items: center;">
            <a href="javascript:void(0)" onclick="showTransactionDetails(' . $value->ledger_id . ')" class="btn btn-sm" title="View Details">
                <i class="fa fa-eye" style="font-size: 12px;"></i>
            </a>';
        
        // Add delete button only if not already deleted AND bill is not generated
        if (!$isDeleted && $value->bill_status == 0) {
            $actionButton .= '<a href="javascript:void(0)" onclick="deleteTransaction(' . $value->id . ')" class="btn btn-sm" title="Delete Transaction">
                <i class="fa fa-times" style="font-size: 12px; color: #e74c3c;"></i>
            </a>';
        } elseif ($value->bill_status == 1) {
            // Show green tick if bill is generated
            $actionButton .= '';
        } elseif ($isDeleted) {
            // Show "DELETED" status if deleted
            $actionButton .= '<span class="btn btn-sm" title="Transaction Deleted">
                <i class="fa fa-ban" style="font-size: 10px; color: #95a5a6;"></i>
            </span>';
        }
            
        $actionButton .= '</div>';

        // Set row style - deleted transactions get gray background, others keep original logic
        $rowStyle = '';
        if ($isDeleted) {
            $rowStyle = 'background-color: #f8f9fa; opacity: 0.7; text-decoration: line-through;';
        } elseif ($value->transaction_status == 1) {
            $rowStyle = 'background-color:rgb(150 221 150)';
        }

            $result[] = [
                'id' => $value->id,
                'sr_no' => $start + $key + 1,
                'date' => date('d-m-Y', strtotime($value->date)),
                'medicine_name' => $medicine_name,
                'ledger_name' => $ledger_name,
                'type' => $typeLabel,
                'amount' => $amount,
                'medicine_amount' => $medicineAmount,
                'rate' => $rate,
                'rebate' => $rebate,
                'remark' => $value->remark,
                'bill' => $billLabel,
                'action' => $actionButton,
                'row_style' => $rowStyle
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $result
        ]);
    }

    public function deleteTransaction(Request $request)
    {
        try {
            $transactionId = $request->input('id');
            
            // Find the transaction
            $transaction = MedicineTransaction::find($transactionId);
            
            if (!$transaction) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaction not found'
                ]);
            }
            
            // Check if user owns this transaction
            if ($transaction->admin_id != Auth::user()->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ]);
            }
            
            // Mark as deleted and set amounts to 0
            $transaction->is_deleted = 1;
            $transaction->medicine_amount = 0;
            $transaction->amount = 0;
            $transaction->deleted_at = now();
            $transaction->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Transaction deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting transaction: ' . $e->getMessage()
            ]);
        }
    }

    // public function getMedicineTotals(Request $request)
    // {
    //     try {
    //         $today = Carbon::today()->toDateString();
    //         $total_plus = MedicineTransaction::where('admin_id', Auth::user()->id)
    //             ->where('date', $today)
    //             ->where('type', 'plus')
    //             ->where(function($query) {
    //                 $query->where('is_deleted', '!=', 1)->orWhereNull('is_deleted');
    //             })
    //             ->sum('medicine_amount');
                
    //         $total_minus = MedicineTransaction::where('admin_id', Auth::user()->id)
    //             ->where('date', $today)
    //             ->where('type', 'minus')
    //             ->where(function($query) {
    //                 $query->where('is_deleted', '!=', 1)->orWhereNull('is_deleted');
    //             })
    //             ->sum('medicine_amount');
                
    //         $total = $total_plus - $total_minus;

    //         return response()->json([
    //             'status' => 'success',
    //             'total_plus' => $total_plus,
    //             'total_minus' => $total_minus,
    //             'total' => $total
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Error getting totals: ' . $e->getMessage()
    //         ]);
    //     }
    // }

    public function getMedicineTotals(Request $request)
{
    try {
        $today = Carbon::today()->toDateString();

        // Use the same logic as medicine_transaction method for consistency
        // Get total plus transactions for today
        $total_plus = MedicineTransaction::where('admin_id', Auth::user()->id)
            ->where('date', $today)
            ->where('type', 'plus')
            ->sum('medicine_amount');

        // Get total minus transactions for today
        $total_minus = MedicineTransaction::where('admin_id', Auth::user()->id)
            ->where('date', $today)
            ->where('type', 'minus')
            ->sum('medicine_amount');

        $total = $total_plus - $total_minus;

        return response()->json([
            'status'       => 'success',
            'date'         => $today, // info: which date is covered
            'total_plus'   => (float) $total_plus,
            'total_minus'  => (float) $total_minus,
            'total'        => (float) $total,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Error getting totals: ' . $e->getMessage()
        ], 500);
    }
}

  
}
