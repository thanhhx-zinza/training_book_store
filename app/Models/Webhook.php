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
        'name',
        'payload',
        'exception',
    ];
}
