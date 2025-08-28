<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\ledger;
use App\Models\MedicineTransaction;

class MedicineController extends Controller
{
    //

    public function insertMedicine(Request $request)
    {
        $request->validate([
            'medicine_name' => 'required',
        ]);
        $medicine = Medicine::where('medicine_name', $request->medicine_name)->first();

        if (!$medicine) {
            $medicine = new Medicine();
            $medicine->medicine_name = $request->medicine_name;
            $medicine->save();
        }

        return response()->json(['message' => 'Medicine inserted successfully', 'medicine_id' => $medicine->id,'status'=>true], 201);
    }

    public function addTransaction(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required',
            'quantity' => 'required',
            'ledger_id' => 'required',
            'admin_id' => 'required',
            'ledger_amount' => 'required',
        ]);
        $medicineTransaction = new MedicineTransaction();
    
        $ledger_price=0;
        $ledgerId = MedicineTransaction::where('ledger_id',$request->ledger_id)->orderBy('id','DESC')->first();
        if($ledgerId!=''){
            $ledger_price=$ledgerId->ledger_amount;
        }
        

        if($request->has('price')){
            $price = $request->price;
        }
        else{
            $medicine = MedicineTransaction::where('medicine_id',$request->medicine_id)->orderBy('id','DESC')->first();
            $price = $medicine->unit_price;
        }

        

        $medicineTransaction->medicine_id = $request->medicine_id;
        $medicineTransaction->unit_price = $price;
        $medicineTransaction->price = $price;
        $medicineTransaction->quantity = $request->quantity;
        $medicineTransaction->ledger_id = $request->ledger_id;
        $medicineTransaction->admin_id = $request->admin_id;
        $totalPrice = $price * $request->quantity;
        $medicineTransaction->total_price = $totalPrice;
        $medicineTransaction->ledger_amount = $ledger_price + $totalPrice;

        $medicineTransaction->save();

        return response()->json(['message' => 'Medicine transaction added successfully','status'=>true], 201);
    }

    public function getMedicineList()
    {
        $medicines = Medicine::all();
        return response()->json(['medicines' => $medicines,'status'=>true]);
    }

    public function getLedgerList()
    {
        $ledger = ledger::all();
        return response()->json(['ledger' => $ledger,'status'=>true]);
    }

    public function getLastPrice(Request $request){
        $data = MedicineTransaction::where('ledger_id',$request->ledger_id)->where('medicine_id',$request->medicine_id)->select('unit_price')->where('admin_id',$request->admin_id)->orderBy('id','DESC')->first();
        if($data!=''){
            return response()->json(['message'=>'Success','status'=>true,'data'=>$data->unit_price]);
        }
        return response()->json(['message'=>'No medicine found','status'=>false]);
    }

    public function getLedgerData(Request $request){
        $uniqueLedgerIds = MedicineTransaction::where('admin_id', $request->admin_id)->pluck('ledger_id')->unique();
        
        $ledgerNames = [];
        foreach ($uniqueLedgerIds as $ledgerId) {
            $ledger = Ledger::find($ledgerId);
            if ($ledger) {
                $ledgerData[] = [
                    'ledger_id' => $ledgerId,
                    'ledger_name' => $ledger->name
                ];
                $ledgerNames[$ledgerId] = $ledger->name;

            }
        }
        
        return response()->json(['message' => 'success', 'status' => true, 'data' => $ledgerNames]);
    }

    public function getLedgerMedicine(Request $request){
        $data = JournalVoucher::where('admin_id', $request->admin_id)->where('medicine_transaction',1)->where('ledger_id',$request->ledger_id)->get();

        foreach($data as $d){
            $medicine = Medicine::find($d->medicine_id);
            if ($medicine) {
                $d->medicine_name = $medicine->medicine_name;
            }
            
            $ledger = Ledger::find($d->ledger_id);
            if ($ledger) {
                $d->ledger_name = $ledger->name;
            }
        }
        return response()->json(['message' => 'success', 'status' => true, 'data' => $data]);
    }

    public function getMedicineTransaction(Request $request){
       $transactions = MedicineTransaction::where('admin_id',$request->admin_id)->where('ledger_id',$request->ledger_id)->get();
       $totalAmount = 0;
       foreach($transactions as $d){
        $medicine= Medicine::where('id',$d->medicine_id)->first();
        $d->medicine_name = $medicine->medicine_name;
        $totalAmount += $d->total_price;
       }
       $ledger = ledger::where('id',$request->ledger_id)->value('name');

       $data = [
            'ledgerName' => $ledger,
            'totalAmount' => $totalAmount,
            'medicines' => $transactions->map(function ($transaction) {
                return [
                    'name' => $transaction->medicine_name,
                    'unitPrice' => $transaction->unit_price,
                    'quantity' => $transaction->quantity,
                    'totalPrice' => $transaction->unit_price * $transaction->quantity,
                ];
            }),
        ];

        return response()->json($data);
    }
    
    


}
