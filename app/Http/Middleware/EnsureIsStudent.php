<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class EnsureIsStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('student')->check()) {
            return $next($request);
        }

        // ถ้ายังไม่ login ให้เด้งไปหน้า login student แทน 403 ตรงๆ
        if ($request->expectsJson()) {
            abort(401, 'กรุณาเข้าสู่ระบบ');
        }

        return redirect()->route('student.login')
            ->with('error', 'กรุณาเข้าสู่ระบบก่อนเข้าถึงส่วนนี้');
    }
}
