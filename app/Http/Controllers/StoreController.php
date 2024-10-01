<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use App\Http\Resources\UserResource;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('page:store')->except('index');
    }

    public function index()
    {
        $user = Auth::user();
        $stores = $user->role->name === 'store_owner' ? $user->stores : Store::all();
        return $this->inertiaRender('Store/index', 'stores', StoreResource::class, $stores);
    }

    public function create()
    {
        $owners = User::whereHas('role', function ($query) {
            $query->where('name', 'store_owner');
        })->get();

        return $this->inertiaRender('Store/Add-Store', 'owners', UserResource::class, $owners);
    }

    public function store(StoreRequest $request)
    {
        Store::create([
            'id' => Str::uuid(),
            'owner_id' => $request->owner_id,
            'name' => $request->name,
            'address' => $request->address
        ]);

        return to_route('store.index');
    }

    public function edit($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return abort(404);
        }

        try {
            $store = Store::findOrFail($id);
            $owners = User::whereHas('role', function ($query) {
                $query->where('name', 'store_owner');
            })->get();

            return Inertia::render('Store/Edit-Store', [
                'owners' => UserResource::collection($owners),
                'store' => new StoreResource($store),
            ]);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
    }

    public function update(StoreRequest $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update([
            'owner_id' => $request->owner_id,
            'name' => $request->name,
            'address' => $request->address
        ]);

        return to_route('store.index');
    }

    public function destroy(string $id)
    {
        try {
            $store = Store::findOrFail($id);
            $store->coupons->each(function ($coupon) {
                $coupon->coupon_rewards()->delete();
                
                $coupon->user_coupons->each(function ($userCoupon) {
                    $userCoupon->user_coupon_stamps()->delete();
                    $userCoupon->delete();
                });
                $coupon->delete();
            });
            $store->delete();
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
    }
}
