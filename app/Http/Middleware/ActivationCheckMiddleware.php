<?php

namespace App\Http\Middleware;

use App\CentralLogics\Helpers;
use App\Traits\ActivationClass;
use Closure;
use Illuminate\Support\Facades\Redirect;

class ActivationCheckMiddleware
{
    use ActivationClass;
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
