<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        //dd($request, $next, $role);
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            if ($userRole === $role) {
                return $next($request);
            }

            if ($userRole === 'admin') {
                return redirect()->route('posts.index');
            } elseif ($userRole === 'user') {
                return redirect()->route('userPosts.index');
            }
        }

        return redirect('/login');
    }
}
