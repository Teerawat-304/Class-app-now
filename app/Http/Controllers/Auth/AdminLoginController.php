<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    /**
     * แสดงหน้าฟอร์มเข้าสู่ระบบของผู้ดูแลระบบ
     */
    public function showLoginForm()
    {
        // หากเข้าสู่ระบบแล้วและเป็น admin ให้ส่งไปหน้าจัดการข้อมูลเลย
        if (Auth::guard('teacher')->check() && Auth::guard('teacher')->user()->isAdmin()) {
            return redirect('/students');
        }

        return view('auth.admin-login');
    }

    /**
     * ดำเนินการเข้าสู่ระบบสำหรับผู้ดูแลระบบ (ใช้บัญชีอาจารย์ที่ t_role = 0)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        $remember = $request->boolean('remember');

        // ค้นหาบัญชีอาจารย์ตาม t_username
        $teacher = Teacher::where('t_username', $credentials['username'])->first();

        if ($teacher) {
            $passwordMatches = Hash::check($credentials['password'], $teacher->t_password);

            // รองรับกรณีข้อมูลเดิมในตารางเก็บเป็น plain text
            if (!$passwordMatches && $teacher->t_password === $credentials['password']) {
                $passwordMatches = true;
                $teacher->t_password = Hash::make($credentials['password']);
                $teacher->save();
            }

            if ($passwordMatches) {
                // ตรวจสอบสิทธิ์ผู้ดูแลระบบ (t_role == 0)
                if ($teacher->isAdmin()) {
                    Auth::guard('teacher')->login($teacher, $remember);
                    $request->session()->regenerate();

                    return redirect()->intended(url('/students'))
                        ->with('success', 'ยินดีต้อนรับ ผู้ดูแลระบบ: ' . $teacher->teacher_name);
                }

                // หากไม่ใช่ผู้ดูแลระบบ (t_role != 0)
                return back()
                    ->withInput($request->only('username'))
                    ->with('error', 'บัญชีนี้ไม่มีสิทธิ์ผู้ดูแลระบบ (เฉพาะอาจารย์ที่มีสิทธิ์ระดับ Admin หรือ t_role = 0 เท่านั้น)');
            }
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
    }

    /**
     * ออกจากระบบ
     */
    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'ออกจากระบบเรียบร้อยแล้ว');
    }
}

