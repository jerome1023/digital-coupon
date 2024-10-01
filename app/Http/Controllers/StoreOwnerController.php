<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOwnerRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class StoreOwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('page:owner');
    }

    public function index()
    {
        // dd(User::find('store_owner')->role);
        // $role = Role::where('name', 'store_owner')->first();
        // $owners = User::where('role_id', $role->id)->get();
        $owners = User::whereHas('role', function ($query) {
            $query->where('name', 'store_owner');
        })->get();

        return $this->inertiaRender('StoreOwner/index', 'owners', UserResource::class, $owners);
    }

    public function create()
    {
        return $this->inertiaRender('StoreOwner/Add-StoreOwner');
    }

    public function store(StoreOwnerRequest $request)
    {
        $role = Role::where('name', $request->role)->first();

        User::create([
            'id' => Uuid::uuid4(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'role_id' => $role->id,
            'password' => Hash::make($request->password)
        ]);

        return to_route('owner.index');
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
            $owner = User::findOrFail($id);
            return $this->inertiaRender('StoreOwner/Edit-StoreOwner', 'owner', UserResource::class, $owner);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
    }

    public function update(StoreOwnerRequest $request, $id)
    {
        $owner = User::findOrFail($id);
        $owner->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => $request->filled('password') ? Hash::make($request->password) : $owner->password
        ]);

        return to_route('owner.index')->with('message', 'Store updated successfully!');
    }

    public function destroy(string $id)
    {
        try {
            $owner = User::findOrFail($id);
            $owner->stores->each(function ($store) {
                $store->coupons->each(function ($coupon) {
                    $coupon->coupon_rewards()->delete();
                    $coupon->user_coupons()->each(function ($userCoupon) {
                        $userCoupon->user_coupon_stamps()->delete();
                    });
                    $coupon->user_coupons()->delete();
                    $coupon->delete();
                });
                $store->delete();
            });
            return to_route('owner.index');
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
    }
}
