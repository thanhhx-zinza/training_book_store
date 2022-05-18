<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    protected $table = "webhook_calls";
    protected $fillable =
    [
        'event',
        'payload_id',
        'exception',
        'user_id',
        'amount_cent',
    ];
}
