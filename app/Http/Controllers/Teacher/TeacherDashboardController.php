<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterDetail;
use App\Models\SubjectTeacher;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();
        $semester = $this->currentSemester();

        // วิชาที่ตนเองสอน (ทุกวิชาที่ผูกไว้ใน subject_teacher)
        $mySubjects = SubjectTeacher::with('subject')
            ->where('teacher_id', $teacher->teacher_id)
            ->get()
            ->map(function ($st) use ($teacher, $semester) {
                $st->enrolled_count = RegisterDetail::where('subject_code', $st->subject_code)
                    ->where('teacher_id', $teacher->teacher_id)
                    ->whereHas('register', fn($q) => $q->where('semester', $semester))
                    ->count();
                return $st;
            });

        return view('teachers.dashboard', compact('teacher', 'mySubjects', 'semester'));
    }

    protected function currentSemester(): string
    {
        $month = now()->month;
        $buddhistYear = now()->year + 543;
        $term = ($month >= 6 && $month <= 10) ? '1' : (($month >= 11 || $month <= 3) ? '2' : '3');
        return "{$term}/{$buddhistYear}";
    }
}

