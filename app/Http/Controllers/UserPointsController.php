<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserPointsController extends Controller
{
    public function index(Authenticatable $user)
    {
        $userPoints = $user->user_points->first();
        return Inertia::render('UserPoints/index',[
            'points' => $userPoints->points ?? 0
        ]);
    }
}
