<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($store) {
            $store->products->each(function ($product) {
                $product->delete();
            });
        });
    }
}
