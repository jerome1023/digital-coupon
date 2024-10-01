<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;
use App\Http\Resources\StoreResource;
use App\Models\Coupon;
use App\Models\CouponReward;
use App\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('page:coupon')->except('index');
    }

    public function index()
    {
        $user = Auth::user();
        $coupons = $user->role->name === 'store_owner' ? $user->stores->flatMap->coupons : Coupon::all();
        return $this->inertiaRender('Coupon/index', 'coupons', CouponResource::class, $coupons);
    }

    public function create()
    {
        $stores = $this->getAuthenticatedStore();
        return $this->inertiaRender('Coupon/Add-Coupon', 'stores', StoreResource::class, $stores);
    }

    public function store(CouponRequest $request)
    {
        $store = Store::findOrFail($request->store_id);
// dd($request);
        $coupon = Coupon::create([
            'id' => Str::uuid(),
            'store_id' => $store->id,
            'name' => $request->name,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end
        ]);

        foreach ($request->coupon_rewards as $reward) {
            CouponReward::create([
                'id' => Str::uuid(),
                'coupon_id' => $coupon->id,
                'reward' => $reward['reward'],
                'details' => $reward['details'],
                'sort' => $reward['sort']
            ]);
        }

        return to_route('coupon.index');
    }

    public function edit(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return abort(404);
        }

        try {
            $coupon = Coupon::findOrFail($id);
            $stores = $this->getAuthenticatedStore();

            return Inertia::render('Coupon/Edit-Coupon', [
                'stores' => StoreResource::collection($stores),
                'coupon' => new CouponResource($coupon),
            ]);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
    }

    public function update(CouponRequest $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $store = Store::findOrFail($request->store_id);

        $existingCouponRewardIds = collect($request->coupon_rewards)->pluck('id')->filter();
        $rewardToDelete = $coupon->coupon_rewards()->whereNotIn('id', $existingCouponRewardIds)->get();
        foreach ($rewardToDelete as $reward) {
            $reward->user_coupon_stamp()->delete();
            $reward->delete();
        }

        $coupon->update([
            'store_id' => $store->id,
            'name' => $request->name,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end
        ]);

        foreach ($request->coupon_rewards as $reward) {
            if (isset($reward['id'])) {
                $couponReward = CouponReward::findOrFail($reward['id']);
                $couponReward->update([
                    'reward' => $reward['reward'],
                    'details' => $reward['details'],
                    'sort' => $reward['sort']
                ]);
            } else {
                CouponReward::create([
                    'id' => Str::uuid(),
                    'coupon_id' => $coupon->id,
                    'reward' => $reward['reward'],
                    'details' => $reward['details'],
                    'sort' => $reward['sort']
                ]);
            }
        }

        return to_route('coupon.index');
    }

    public function destroy(string $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->user_coupons()->each(function ($userCoupon) {
                $userCoupon->user_coupon_stamps()->delete();
            });
            $coupon->coupon_rewards()->delete();
            $coupon->user_coupons()->delete();
            $coupon->delete();
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
    }

    private function getAuthenticatedStore()
    {
        $user = Auth::user();
        return $user->stores;
    }
}
