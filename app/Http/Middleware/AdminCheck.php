<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheck
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
        if ($request->user()->role == '0') {
            return $next($request);
        } else {
            request()->session()->flash('error', 'Bạn không có quyền truy cập vào page này.');
            return redirect()->route('user-login');
        }
    }
}
