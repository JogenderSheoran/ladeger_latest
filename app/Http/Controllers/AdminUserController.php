<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminAmount;
use App\Models\Instruction;
use Hash;
use View;
use Auth;

class AdminUserController extends Controller
{
    //

    public function admins(){
        $data=User::where('is_admin','!=','Admin')->get();
        $title='admin';
        return view::make('admin.index',compact('title','data'));
    }

    public function createAdmin(Request $request){
        $hashedPassword = Hash::make($request->input('password'));
        // Create the admin user
        if($request->id!=''){
            $user=User::where('id',$request->id)->first();
        }
        else{
            $user= new User();
        }
        $user->name = strtolower(str_replace(' ', '_', $request->name));
        $user->mobile = $request->mobile;
        if($request->has('password')){
            $user->password = $hashedPassword;
        }
        $user->email = $request->name.'ledger@gmail.com'; 
        $user->is_admin = strtolower(str_replace(' ', '_', $request->name));;
        $save = $user->save();
        if($save){
            
            $admin_amount = new AdminAmount();
            $admin_amount->admin_id = $user->id;
            $save = $admin_amount->save();

           return response()->json(['message'=>'success','status'=>'success']);
        }
        else{
            return response()->json(['message'=>'Error','status'=>'error']);
        }

    }

    public function instructionSettings(){
        $title = 'Instruction Settings';
        $activeInstruction = Instruction::getActiveInstruction();
        $current_instruction = $activeInstruction ? $activeInstruction->instruction_text : 'Welcome to the Ledger Management System! Please follow the guidelines for accurate transaction recording.';
        return view('admin.instruction_settings', compact('title', 'current_instruction'));
    }

    public function updateInstruction(Request $request){
        try {
            // Validate the request
            $request->validate([
                'instruction_text' => 'required|string|max:500'
            ]);
            
            $instruction_text = $request->input('instruction_text');
            
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated'
                ]);
            }
            
            // Deactivate all previous instructions
            Instruction::where('is_active', true)->update(['is_active' => false]);
            
            // Create new active instruction
            $instruction = Instruction::create([
                'instruction_text' => $instruction_text,
                'is_active' => true,
                'admin_id' => Auth::user()->id
            ]);
            
            if ($instruction) {
                return redirect()->route('instructionSettings')->with('success', 'Instruction updated successfully!');
            } else {
                return redirect()->route('instructionSettings')->with('error', 'Failed to create instruction record');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessage = 'Validation error: ' . implode(', ', $e->errors()['instruction_text'] ?? ['Invalid input']);
            return redirect()->route('instructionSettings')->with('error', $errorMessage);
        } catch (\Exception $e) {
            return redirect()->route('instructionSettings')->with('error', 'Error updating instruction: ' . $e->getMessage());
        }
    }

   
}
