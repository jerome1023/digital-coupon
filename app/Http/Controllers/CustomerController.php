<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class CustomerController extends Controller
{
    public function index(Authenticatable $user)
    {
        // dd($user->stores->get());
        $storeIds = $user->stores->pluck('id')->toArray(); // Get an array of store ids
        $customers = User::whereHas('user_coupons', function ($query) use ($storeIds) {
            $query->whereHas('coupon', function ($query) use ($storeIds) {
                $query->whereIn('store_id', $storeIds);
            });
        })->whereHas('role', function ($query) {
            $query->where('name', 'customer');
        })->get();
        return $this->inertiaRender('Customer/index', 'customers', UserResource::class, $customers);
    }
}
