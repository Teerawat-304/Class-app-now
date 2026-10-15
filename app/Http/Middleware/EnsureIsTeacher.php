<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('teacher')->check()) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            abort(401, 'กรุณาเข้าสู่ระบบ');
        }

        return redirect()->route('teacher.login')
            ->with('error', 'กรุณาเข้าสู่ระบบก่อนเข้าถึงส่วนนี้');
    }
}

