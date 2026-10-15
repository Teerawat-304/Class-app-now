<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Students;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentRegisterController extends Controller
{
    public function showRegisterForm()
    {
        $faculties = Faculty::orderBy('faculty_name')->get();
        return view('auth.student-register', compact('faculties'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'student_id'   => 'required|string|max:10|unique:students,student_id',
            'student_name' => 'required|string|max:100',
            'faculty_id'   => 'required|exists:faculty,faculty_id',
            'program_id'   => 'required|exists:program,program_id',
            'birth_date'   => 'required|date|before:today',
            'email'        => 'required|email|max:100|unique:students,email',
            'address'      => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:students,username',
            'password'     => ['required', 'confirmed', Password::min(8)
                ->mixedCase()->numbers()->symbols()],
        ], [
            'student_id.unique' => 'รหัสนักศึกษานี้มีในระบบแล้ว',
            'email.unique'      => 'อีเมลนี้ถูกใช้สมัครแล้ว',
            'username.unique'   => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $student = Students::create($validated);

        Auth::guard('student')->login($student);

        return redirect()->route('student.dashboard')
            ->with('success', 'สมัครสมาชิกสำเร็จ ยินดีต้อนรับเข้าสู่ระบบ');
    }
}
