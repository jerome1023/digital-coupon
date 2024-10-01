<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'owner_id',
        'name',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'store_id');
    }
}
