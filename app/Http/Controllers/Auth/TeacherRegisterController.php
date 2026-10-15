<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherRegisterController extends Controller
{
    public function showRegisterForm()
    {
        $faculties = Faculty::orderBy('faculty_name')->get();
        $faculty = $faculties;
        return view('auth.teacher-register', compact('faculties', 'faculty'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'teacher_name'          => 'required|string|max:100',
            't_faculty_id'          => 'required|exists:faculty,faculty_id',
            't_program_id'          => 'required|exists:program,program_id',
            't_email'               => 'required|email|max:100|unique:teacher,t_email',
            't_address'             => 'nullable|string|max:100',
            't_username'            => 'required|string|max:50|unique:teacher,t_username',
            't_password'            => ['required', 'confirmed', Password::min(8)
                ->mixedCase()->numbers()->symbols()],
        ], [
            'teacher_name.required' => 'กรุณากรอกชื่อ-นามสกุล',
            't_faculty_id.required' => 'กรุณาเลือกคณะ',
            't_program_id.required' => 'กรุณาเลือกสาขาวิชา',
            't_email.required'      => 'กรุณากรอกอีเมล',
            't_email.unique'        => 'อีเมลนี้ถูกใช้สมัครแล้ว',
            't_username.required'   => 'กรุณากรอกชื่อผู้ใช้',
            't_username.unique'     => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',
            't_password.required'   => 'กรุณากรอกรหัสผ่าน',
            't_password.confirmed'  => 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน',
        ]);

        $teacher = Teacher::create([
            'teacher_name' => $validated['teacher_name'],
            't_faculty_id' => $validated['t_faculty_id'],
            't_program_id' => $validated['t_program_id'],
            't_email'      => $validated['t_email'],
            't_address'    => $validated['t_address'] ?? null,
            't_username'   => $validated['t_username'],
            't_password'   => Hash::make($validated['t_password']),
            't_role'       => 1, // 1 = อาจารย์ทั่วไป, ไม่ใช่แอดมิน
        ]);

        Auth::guard('teacher')->login($teacher);

        return redirect()->route('teacher.dashboard')
            ->with('success', 'สมัครสมาชิกสำเร็จ ยินดีต้อนรับเข้าสู่ระบบ');
    }
}
