<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class LecturersCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            // dd(Auth::user()->role);
            if(Auth::user()->role === 1) {
                 return $next($request);
            } else {
                return response()->json([
                    "data" => 'Đường dẫn không tồn tại'
                ], 404);
            }
            // return $next($request);
        }
    }
}
