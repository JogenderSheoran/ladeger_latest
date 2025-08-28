<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'instruction_text',
        'is_active',
        'admin_id'
    ];
    
    // Relationship with User (Admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    // Get active instruction
    public static function getActiveInstruction()
    {
        return self::where('is_active', true)->latest()->first();
    }
}
