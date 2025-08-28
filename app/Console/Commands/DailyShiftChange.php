<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\shift;
use Log;
use DB;

class DailyShiftChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shift:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("hi");
        $newdate = date('Y-m-d');
        $shift=shift::where('status',1)->get();
        foreach($shift as $s){
            Log::info("in loop");
           $update=DB::table('shifts')->where('id',$s->id)->update(['date'=>$newdate]);
        }
    }
}
