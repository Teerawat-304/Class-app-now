<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class TeacherLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.teacher-login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('teacher')->attempt(
            ['t_username' => $credentials['username'], 'password' => $credentials['password']],
            $remember
        )) {
            $request->session()->regenerate();

            $teacher = Auth::guard('teacher')->user();

            return redirect()->intended($this->redirectByRole($teacher)->getTargetUrl());
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('teacher.login')->with('status', 'ออกจากระบบเรียบร้อยแล้ว');
    }

    /**
     * แสดงคนละหน้าจอตาม t_role:
     * 0= isAdmin() = true  → หน้าจัดการข้อมูล (admin panel)
     * 1= isAdmin() = false → หน้า dashboard อาจารย์ผู้สอนปกติ
     */
    private function redirectByRole($teacher)
    {
        if ($teacher->isAdmin()) {
            return redirect('teachers');
        }

        return redirect()->route('teacher.dashboard');
    }
    
}