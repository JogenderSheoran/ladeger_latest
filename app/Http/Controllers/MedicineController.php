<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\MedicineTransaction;
use View;
use Auth;
use App\Models\ledger;

class MedicineController extends Controller
{
    //
    public function medicineList (){
        $data=ledger::where('admin_id',Auth::user()->id)->select('id','name','username')->get();
        return view::make('medicine.index',compact('data'));
    }


    public function addMedicine(){
        return view::make('medicine.add');
    }

    public function insertMedicineTransaction(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'medicine_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'ledger_id' => 'required',
        ]);

        $ledger_price=0;
        $ledgerId = MedicineTransaction::where('ledger_id',$request->ledger_id)->orderBy('id','DESC')->first();
        if($ledgerId!=''){
            $ledger_price=$ledgerId->ledger_amount;
        }
        $medicineTransaction = new MedicineTransaction();
        $medicineTransaction->medicine_id = $request->medicine_id;
        $medicineTransaction->price = $request->price;
        $medicineTransaction->quantity = $request->quantity;
        $medicineTransaction->ledger_id = $request->ledger_id;
        $medicineTransaction->save();

        // Return a success response
        return response()->json(['message' => 'Medicine added successfully'], 201);
    }
}
