<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $fillable = [
        'amount',
        'currency',
        'user_id',
        'charge_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
