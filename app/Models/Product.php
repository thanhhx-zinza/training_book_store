<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products";
    protected $fillable =
    [
        "name",
        "images",
        "sale",
        "description",
        "price",
        'slug',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
