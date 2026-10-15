<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // กรณีที่ 1: บัญชีอาจารย์ที่มีสิทธิ์ admin (t_role == 0)
        if (Auth::guard('teacher')->check()) {
            $teacher = Auth::guard('teacher')->user();
            if ($teacher && $teacher->isAdmin()) {
                return $next($request);
            }
        }

        // กรณีที่ 2: บัญชีจาก guard web
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            abort(401, 'กรุณาเข้าสู่ระบบ');
        }

        return redirect()->route('admin.login')
            ->with('error', 'กรุณาเข้าสู่ระบบด้วยบัญชีผู้ดูแลระบบ (Admin) ก่อนเข้าถึงส่วนนี้');
    }
}