<?php

namespace App\Models;

use App\Jobs\updateTotalProductCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    public static function boot()
    {
        parent::boot();
        self::created(function () {
            $totalProduct = Auth::user()->total_product_count + 1;
            updateTotalProductCount::dispatch($totalProduct);
        });
        self::deleted(function () {
            $totalProduct = Auth::user()->total_product_count - 1;
            updateTotalProductCount::dispatch($totalProduct);
        });
    }
}
