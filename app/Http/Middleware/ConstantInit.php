<?php

namespace App\Http\Middleware;

use Closure;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Log;

class ConstantInit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        define('LOGIN_UID',Admin::user()->id);
        return $next($request);
    }
}
