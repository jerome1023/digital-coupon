<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCouponStamp extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [
        'id',
        'user_coupon_id',
        'coupon_reward_id'
    ];

    public function user_coupon()
    {
        return $this->belongsTo(UserCoupon::class, 'user_coupon_id');
    }

    public function coupon_reward()
    {
        return $this->belongsTo(CouponReward::class, 'coupon_reward_id');
    }
}
