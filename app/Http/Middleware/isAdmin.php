<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check())
            return redirect('login');
        $user = Auth::user();

        if($user->isAdmin()) {
            return $next($request);
        }
        else {
            abort(403, "Anda tidak diizinkan untuk membuka halaman ini");
        }

        return $next($request);
    }
}
