<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use View;
use App\Models\ledger;
use App\Models\transaction;
use App\Models\shift;
use App\Models\User;
use App\Models\AdminAmount;
use App\Models\Prediction;
use App\Models\JournalVoucher;
use App\Models\LedgerAmount;
use Carbon\Carbon;
use Hash;
use Auth;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title="Dashboard";
        $am=DB::table('amount')->select('amount')->first();
        $amount=$am->amount;

        // if(Auth::user()->is_admin == 'Admin'){
        //     $lene=JournalVoucher::where('status',1)->where('cr_dr','lene')->orderBy('id','DESC')->limit(10)->get();
        //     $dene=JournalVoucher::where('status',1)->where('cr_dr','dene')->orderBy('id','DESC')->limit(10)->get();
          
        // }
        // else{
        $lene=JournalVoucher::where('status',1)->where('cr_dr','lene')->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->limit(10)->get();
        $dene=JournalVoucher::where('status',1)->where('cr_dr','dene')->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->limit(10)->get();
        // }
         
       
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        $days_value=date('t');
        

    
        $amount_total=array();
        for($i=0; $i<7; $i++){
            $start_date = $weekStartDate;  
            $date = strtotime($start_date);
            if($i!=0){
                $date = strtotime('+ '.$i .'days', $date);
            }
            $date=date('Y-m-d', $date);
            
          
            $loss=JournalVoucher::where('date',$date)->where('cr_dr','dene')->where('admin_id',Auth::user()->id)->sum('amount');
            $profit=JournalVoucher::where('date',$date)->where('cr_dr','lene')->where('admin_id',Auth::user()->id)->sum('amount');
             
            
             $j=$i+1;
            $amount_total[$i]['day']='Day'.$j;
            $amount_total[$i]['profit']=(int)$profit;
            $amount_total[$i]['loss']=(int)$loss;
        }

       
        foreach($lene as $l){
                $l->ledger_name=ledger::where('id',$l->ledger_id)->value('name');
        }

        foreach($dene as $d){
               $d->ledger_name=ledger::where('id',$d->ledger_id)->value('name');
        }

      
        $ledger=ledger::select('id','name','created_at')->where('status',1)->where('admin_id',Auth::user()->id)->orderBy('name','ASC')->get();
        
       
        foreach($ledger as $l){
            $l->net_balance=LedgerAmount::where('ledger_id',$l->id)->value('total_amount');
        }
        if(Auth::user()){
            $admin_amount=AdminAmount::where('admin_id',Auth::user()->id)->select('total_amount')->first();
        }
        else{
            $admin_amount='';
        }
       
        return View::make('home',compact('ledger','lene','dene','admin_amount','amount_total','amount'));
    }

    public function new()
    {
        return view('new');
    }

    public function profile(){
        return view::make('profile');
    }

    public function change_password(Request $request){
       $data=User::where('id',Auth::user()->id)->first();
       $data->password=Hash::make($request->password);
       $save=$data->save();
       if($save){
           return redirect()->back()->with('success','Password update successfully');
       }
       else{
        return redirect()->back()->with('error','Error in password update');
       }
    }
}
