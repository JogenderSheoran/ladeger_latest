<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Models\shift;
use View;

class PredictionController extends Controller
{
    //
      //prediction
      public function prediction(){
        $title='Pridiction';
        $shift=shift::select('id','name')->where('active','on')->get();
        $data=Prediction::orderBy('id','DESC')->get();
        return View::make('prediction.prediction',compact('title','data','shift'));
    }

  
}
