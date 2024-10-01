<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponReward extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'coupon_id',
        'reward',
        'details',
        'sort'
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function user_coupon_stamp()
    {
        return $this->hasMany(UserCouponStamp::class, 'coupon_reward_id');
    }
}
