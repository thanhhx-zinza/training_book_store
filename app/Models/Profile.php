<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profile";
    protected $guarded  = "";

    public function scopeCurrent($query, $userId)
    {
        return $query->where('user_id', $userId)->first();
    }
}
