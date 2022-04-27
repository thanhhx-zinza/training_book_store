<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    protected $table = "users";

    /**
     * Get the profile associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function totalProductCount()
    {
        $storeList = [];
        $stores = $this->stores->toArray();
        $storeList = array_map(function ($stores) {
            return $this->stores->find($stores['id'])->products;
        }, $stores);
        return array_sum(array_map(function ($storeList) {
            return count($storeList);
        }, $storeList));
    }
}
