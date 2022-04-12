<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = "stores";
    protected $fillable =
    [
        "name",
        "description",
        "images",
        "rates",
        "followers",
        "follow",
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->hasMany(Product::class);
    }
}