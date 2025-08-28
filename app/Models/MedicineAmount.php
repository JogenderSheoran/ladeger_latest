<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineAmount extends Model
{
    use HasFactory;

    protected $table = 'medicine_ledger_amount';
}
