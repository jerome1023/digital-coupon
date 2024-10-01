<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'store_id',
        'name',
        'date_start',
        'date_end',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function coupon_rewards()
    {
        return $this->hasMany(CouponReward::class, 'coupon_id');
    }

    public function user_coupons()
    {
        return $this->hasMany(UserCoupon::class, 'coupon_id');
    }
}
