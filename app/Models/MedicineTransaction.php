<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineTransaction extends Model
{
    use HasFactory;

    protected $table='medicines_transaction';

    public function ledger()
    {
        return $this->belongsTo(ledger::class, 'ledger_id');
    }
}
