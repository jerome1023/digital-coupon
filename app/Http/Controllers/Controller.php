<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function inertiaRender(string $componentPage, ?string $resourceKey = null, $resource = null, $name = null)
    {
        $props = [];

        if ($resourceKey !== null && $resource !== null && $name !== null) {
            $props[$resourceKey] = is_iterable($name) ? $resource::collection($name)
                :  $resource::make($name);
        }

        return Inertia::render($componentPage, $props);
    }
}
