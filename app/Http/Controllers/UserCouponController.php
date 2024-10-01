<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCouponResource;
use App\Http\Resources\UserCouponStampResource;
use App\Models\Coupon;
use App\Models\UserCoupon;
use App\Models\UserCouponStamp;
use App\Models\UserPoints;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserCouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('page:my_coupon');
    }

    public function index()
    {
        $userCoupons = Auth::user()->user_coupons;
        $couponRewards = [];

        foreach ($userCoupons as $userCoupon) {
            $userCouponStamps = $userCoupon->user_coupon_stamps;

            // $rewards = [];

            foreach ($userCoupon->coupon->coupon_rewards as $couponReward) {
                $rewardId = $couponReward->id;

                $matchingCouponReward = $userCouponStamps->first(function ($userCouponStamp) use ($rewardId) {
                    return $userCouponStamp->coupon_reward_id === $rewardId;
                });

                $scan = $matchingCouponReward ? 'yes' : 'no';
                $couponReward->scan = $scan;
                // $rewards[] = $couponReward;
            }

            // $userCoupon->rewards = $rewards;
            $couponRewards[] = new UserCouponResource($userCoupon);
        }
        // dd($couponRewards);
        return $this->inertiaRender('UserCoupon/index', 'my_coupons', UserCouponResource::class, $couponRewards);
        // return $this->inertiaRender('UserCoupon/index', 'my_coupons', UserCouponResource::class, $userCoupons);

    }

    public function scan()
    {
        return $this->inertiaRender('UserCoupon/Scan');
    }

    public function store(Request $request, Authenticatable $user)
    {
        $authenticatedUser = $user->id;
        $couponId = $request->getContent();

        $coupon = Coupon::findOrFail($couponId);
        $existingUserCoupon = $coupon->user_coupons()->where('user_id', $authenticatedUser)->first();

        $dateToday = Carbon::now('Asia/Manila')->startOfDay();
        $startDate = Carbon::createFromFormat('Y-m-d', $coupon->date_start, 'Asia/Manila')->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $coupon->date_end, 'Asia/Manila')->startOfDay();

        if ($startDate->gt($dateToday)) {
            return to_route('my_coupon.index')->with(['message' => 'Coupon not yet started', 'status_code' => 400]);
        }
        if ($endDate->lt($dateToday)) {
            return to_route('my_coupon.index')->with(['message' => 'Coupon already ended', 'status_code' => 400]);
        }

        $rewards = $coupon->coupon_rewards;
        $userPoints = UserPoints::where('user_id', $authenticatedUser)->first();

        if (!$existingUserCoupon) {
            $userCoupon = UserCoupon::create([
                'id' => Str::uuid(),
                'user_id' => $authenticatedUser,
                'coupon_id' => $couponId
            ]);

            $firstStamp = collect($rewards)->firstWhere('sort', 0);
            UserCouponStamp::create([
                'id' => Str::uuid(),
                'user_coupon_id' => $userCoupon->id,
                'coupon_reward_id' => $firstStamp['id'],
            ]);

            if (!$userPoints) {
                UserPoints::create([
                    'id' => Str::uuid(),
                    'user_id' => $authenticatedUser,
                    'points' => 0.1
                ]);
            } else {
                $userPoints->update(['points' => $userPoints->points + 0.1]);
            }

            $reward = $firstStamp->reward != 'None' ? 'You recieved ' . $firstStamp->reward . ' from ' . $coupon->name : null;
            return to_route('my_coupon.index')->with(['message' => 'Coupon scanned and added successfully', 'reward' => $reward , 'status_code' => 200]);
        } else {
            $userCouponStamps = $existingUserCoupon->user_coupon_stamps;
            $couponsStamps = [];
            foreach ($userCouponStamps as $userCouponStamp) {
                $couponReward = collect($rewards)->firstWhere('id', $userCouponStamp->coupon_reward_id);
                $couponsStamps[] = $couponReward;
            }

            $lastSort = collect($couponsStamps)->max('sort');
            $nextStamp = collect($rewards)->firstWhere('sort', $lastSort + 1);
            
            if ($nextStamp) {
                UserCouponStamp::create([
                    'id' => Str::uuid(),
                    'user_coupon_id' => $existingUserCoupon->id,
                    'coupon_reward_id' => $nextStamp->id,
                ]);
                if ($existingUserCoupon->user_coupon_stamps()->count() == count($rewards)) {
                    $existingUserCoupon->update(['status' => true]);
                }

                $userPoints->update(['points' => $userPoints->points + 0.1]);
            } else {
                return to_route('my_coupon.index')->with(['message' => 'You have already received all the rewards from ' . $coupon->name, 'status_code' => 209]);
            }
            $reward = $nextStamp->reward != 'None' ? 'You recieved ' . $nextStamp->reward . ' from ' . $coupon->name : null;
            return to_route('my_coupon.index')->with(['message' => 'Coupon scanned successfully', 'reward' => $reward, 'status_code' => 200]);
        }
    }

    public function stamp($id)
    {
        $userCoupon = UserCoupon::findOrFail($id);
        $userCouponStamps = $userCoupon->user_coupon_stamps;

        $couponRewards = $userCoupon->coupon->coupon_rewards;

        $stampStatus = [];

        foreach ($couponRewards as $couponReward) {
            $rewardId = $couponReward->id;

            $matchingCouponReward = $userCouponStamps->first(function ($userCouponStamp) use ($rewardId) {
                return $userCouponStamp->coupon_reward_id === $rewardId;
            });

            $scan = $matchingCouponReward ? 'yes' : 'no';
            $couponReward->scan = $scan;
            $stampStatus[] = $couponReward;
        }

        return $this->inertiaRender('UserCoupon/Stamp', 'my_stamps', UserCouponStampResource::class, $stampStatus);
    }
}
