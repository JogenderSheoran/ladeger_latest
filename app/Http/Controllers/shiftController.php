<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use View;
use App\Models\shift;
use App\Models\User;
use App\Models\LedgerAmount;
use App\Models\agent;
use App\Models\ledger;
use App\Models\Medicine;
use App\Models\LedgerCommission;
use App\Models\MedicineAmount;
use Auth;
use Carbon\Carbon;

class shiftController extends Controller
{  

    //Search ledger data
    public function search_ledger_data(Request $request){
       
        $data=ledger::where('name',$request->ledger_name)->where('status',1)->where('admin_id',Auth::user()->id)->get();
        
        foreach($data as $d){
            $new_updated_at=date('d-m-Y h:i a',strtotime($d->updated_at));
            $d->new_updated_at=$new_updated_at;
            $d->updated_by=Auth::user()->name;
            $d->edit=route('edit_ledger',['id'=>encrypt($d->id)]);
        }
        if($this->check_count($data) > 0){
            return response()->json(['message'=>'success','status'=>'success','data'=>$data]);   
        }
        return response()->json(['message'=>'No data found','status'=>'fail']);
    }

    public function search_admin_data(Request $request){
            $data=User::where('name',$request->ledger_name)->where('status',1)->get();
        foreach($data as $d){
            $new_updated_at=date('d-m-Y h:i a',strtotime($d->updated_at));
            $d->new_updated_at=$new_updated_at;
            $d->updated_by=Auth::user()->name;
            $d->edit=route('edit_ledger',['id'=>encrypt($d->id)]);
        }
        if($this->check_count($data) > 0){
            return response()->json(['message'=>'success','status'=>'success','data'=>$data]);   
        }
        return response()->json(['message'=>'No data found','status'=>'fail']);
    }


    //ledgers
    public function ledgers(){
        $title='Ledgers';
       
        $ledger=ledger::orderBy('id','DESC')->where('status',1)->where('admin_id',Auth::user()->id)->get();
        

        foreach($ledger as $d){
            $admin = User::where('id',$d->admin_id)->value('name');
            $d->admin = $admin;
        }
       
        return View::make('ledgers.ledger',compact('title','ledger'));
    }

    public function check_ledger_name(Request $request){
        $name = $request->name;
        $id = $request->id; // For edit mode
        
        if($id && $id != ''){
            // For edit mode, exclude current record
            $check = ledger::where('name', $name)
                          ->where('admin_id', Auth::user()->id)
                          ->where('status', 1)
                          ->where('id', '!=', $id)
                          ->first();
        } else {
            // For new record
            $check = ledger::where('name', $name)
                          ->where('admin_id', Auth::user()->id)
                          ->where('status', 1)
                          ->first();
        }
        
        if($check){
            return response()->json([
                'status' => 'error',
                'message' => 'This ledger name already exists. Please enter a unique name.'
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Ledger name is available.'
            ]);
        }
    }

    public function submit_ledger(Request $r){
            if($r->id!=''){
                $insert=ledger::where('admin_id',Auth::user()->id)->find($r->id);
            }else{
                $check=ledger::where('name',$r->name)->where('admin_id',Auth::user()->id)->where('status',1)->first();
                if($check){
                    return redirect()->back()->with('error','Error! Ledger name already exists,Please enter unique name');
                }
                $insert=new ledger();
            }
          
       
            $insert->name=ucwords($r->name);
            $insert->username=$r->username;
            $insert->admin_id=Auth::user()->id;
            $insert->mobile=$r->mobile;  
            $insert->grantor=$r->grantor_name;   
            $save=$insert->save();
            if($save){  

                //Create medicine amount here 
                $existingRecord = MedicineAmount::where('ledger_id', $insert->id)->first();
                if (!$existingRecord) {
                    // Create a new MedicineAmount record
                    $insertMedicienLedger = new MedicineAmount();
                    $insertMedicienLedger->ledger_id = $insert->id;
                    $insertMedicienLedger->admin_id = Auth::user()->id;
                    $insertMedicienLedger->ledger_amount = 0;
                    $insertMedicienLedger->date = Carbon::now(); // Add current date
                    $insertMedicienLedger->save();
                }

                if($r->id==''){
                    $ledger_amount=new LedgerAmount();
                    $ledger_amount->ledger_id=$insert->id;
                    $ledger_amount->save();
                }
                  // Retrieve current medicines for the given ledger
                    $currentMedicines = Medicine::where('ledger_id', $r->id)->get();
                    $currentMedicineNames = $currentMedicines->pluck('medicine_name')->toArray();
                    $newMedicineNames = $r->medicine_name;

                    // Find medicines to delete
                    $medicinesToDelete = array_diff($currentMedicineNames, $newMedicineNames);
                    if (!empty($medicinesToDelete)) {
                        Medicine::where('ledger_id', $r->id)
                                ->whereIn('medicine_name', $medicinesToDelete)
                                ->delete();
                    }
               
                    for ($i = 0; $i < sizeof($r->medicine_name); $i++) {
                        $medicineName = $r->medicine_name[$i];
                        $medicineRate = $r->medicine_rate[$i];
                        $medicineRebate = $r->medicine_rebate[$i];

                        if($medicineRebate == ''){
                            $medicineRebate = 0;
                        }
                    
                        // Check if all variables are not null
                        if (!is_null($medicineName) && !is_null($medicineRate) && !is_null($medicineRebate)) {
                            $medicine = Medicine::where('medicine_name', $medicineName)->where('admin_id',Auth::user()->id)->first();
                            
                            if (is_null($medicine)) {
                                $medicine = new Medicine();
                            }
                    
                            $medicine->medicine_name = $medicineName;
                            $medicine->medicine_rate = $medicineRate;
                            $medicine->medicine_rebate = $medicineRebate;
                            $medicine->ledger_id = $insert->id;
                            $medicine->admin_id = Auth::user()->id;
                            $medicine->save();
                        }
                    }
                    
                return redirect()->back()->with('success','Ledger has beed added successfully.');
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }
        // }catch (\Exception $e) {
        //     return response()->json(['message'=>$e->getMessage(),'status'=>'fail']);
        // }

    }

    public function edit_ledger($id){
       $data=ledger::where('id',decrypt($id))->first();
       return view::make('ledgers.edit_ledger',compact('data'));
    } 

    public function getLedgerMedicine(Request $request){
        $data = Medicine::where('ledger_id', $request->id)->get();

        if($data->isEmpty()) {
            return response()->json(['status' => 'success', 'message' => 'No medicine found for the given ledger ID','data'=>$data]);
        } else {
            return response()->json(['status' => 'success', 'data' => $data]);
        }
    }
    
}
