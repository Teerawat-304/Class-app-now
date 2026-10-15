<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class StudentLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $loginInput = $request->input('student_id') ?? $request->input('username');

        $credentials = $request->validate([
            'student_id' => 'nullable|string',
            'username'   => 'nullable|string',
            'password'   => 'required|string',
        ], [
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        if (empty($loginInput)) {
            return back()
                ->withErrors(['student_id' => 'กรุณากรอกรหัสนักศึกษา'])
                ->withInput();
        }

        $remember = $request->boolean('remember');

        // ค้นหานักศึกษาด้วย student_id หรือ username
        $student = \App\Models\Students::where('student_id', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        if ($student) {
            $passwordMatches = \Illuminate\Support\Facades\Hash::check($credentials['password'], $student->password);

            // รองรับกรณีรหัสผ่านใน DB เป็นข้อความธรรมดา (plaintext)
            if (!$passwordMatches && $student->password === $credentials['password']) {
                $passwordMatches = true;
                $student->password = \Illuminate\Support\Facades\Hash::make($credentials['password']);
                $student->save();
            }

            if ($passwordMatches) {
                Auth::guard('student')->login($student, $remember);
                $request->session()->regenerate();

                return redirect()->intended(route('student.dashboard'))
                    ->with('success', 'เข้าสู่ระบบสำเร็จ ยินดีต้อนรับ ' . $student->student_name);
            }
        }

        return back()
            ->withErrors(['student_id' => 'รหัสนักศึกษาหรือรหัสผ่านไม่ถูกต้อง'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return redirect()->route('student.login');
        return redirect()->route('home');
    }
}
