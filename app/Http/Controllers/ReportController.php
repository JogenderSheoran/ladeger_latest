<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;
use Auth;
use App\Models\ledger;
use App\Models\JournalVoucher;
use App\Models\shift;
use App\Models\transaction;
use App\Models\User;
use DateTime;

class ReportController extends Controller
{
    public function settling_report()
    {
        $title='settling_report';
        $ledgers=ledger::where('status',1)->get();
        return View::make('report.settling_report',compact('title','ledgers'));
    }

    public function profit_loss_report()
    {
        $title='profit_loss_report';
        return View::make('report.profit_loss_report',compact('title'));
    }

    public function limit_balance_report()
    {
        $title='limit_balance_report';
        return View::make('report.limit_balance_report',compact('title'));
    }

    public function all_shift_report()
    {
        $title='all_report';
        return View::make('report.all_shift_report',compact('title'));
    }
    
    public function daily_report()
    {
        $title='report';
       
        $ledger=ledger::where('status',1)->where('admin_id',Auth::user()->id)->select('id','name')->get();
        $data=JournalVoucher::where('status',1)->where('admin_id',Auth::user()->id)->limit(100)->get();
        
        foreach($data as $d){
            $d->party1=ledger::where('id',$d->party1)->value('name');
            $d->party2=ledger::where('id',$d->party2)->value('name');
        }
        return View::make('report.daily_report',compact('title','data','ledger'));
    }

    public function filter_report()
    {
        $title='report';
       
            $ledger=ledger::where('status',1)->where('admin_id',Auth::user()->id)->select('id','name')->get();
            $data=JournalVoucher::where('status',1)->where('admin_id',Auth::user()->id)->get();
        
        
        foreach($data as $d){
            $d->party1=ledger::where('id',$d->party1)->value('name');
            $d->party2=ledger::where('id',$d->party2)->value('name');
        }
        return View::make('report.filter_report',compact('title','data','ledger'));
    }
}
