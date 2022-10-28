<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;


class MasterAdminCheck
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
            // echo(Auth::user());
            $user = Auth::user();

            if($user->role == 2) {
                $admin = Admin::where('id_user', $user->id)->first();
                    if($admin->role == 1) {
                        return $next($request);
                    }
                    return response()->json([
                        'data' => 'Đường dẫn không tồn tại',
                    ], 404);
            }


            // if(Auth::user()->role === 2) {
            //      return $next($request);
            // } else {
            //     return response()->json([
            //         "data" => 'Đường dẫn không tồn tại'
            //     ], 404);
            // }
            // return $next($request);
        }
    }
}
