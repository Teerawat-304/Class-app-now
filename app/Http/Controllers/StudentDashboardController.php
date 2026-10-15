<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\RegisterDetail;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    protected array $gradePoints = [
        'A' => 4.0,
        'B+' => 3.5,
        'B' => 3.0,
        'C+' => 2.5,
        'C' => 2.0,
        'D+' => 1.5,
        'D' => 1.0,
        'F' => 0.0,
    ];
    public function index(Request $request)
    {
        $student = Auth::guard('student')->user();
        $currentSemester = $request->query('semester', $this->currentSemester());

        // วิชาที่ลงทะเบียนในภาคเรียนที่เลือก
        $currentRegister = Register::with(['details.subject', 'details.teacher'])
            ->where('student_id', $student->student_id)
            ->where('semester', $currentSemester)
            ->first();

        $currentSubjects = $currentRegister ? $currentRegister->details : collect();

        // ข้อมูลสำหรับคำนวณ GPA สะสม (เฉพาะวิชาที่มีเกรดแล้ว)
        $gradedDetails = RegisterDetail::with(['subject', 'register'])
            ->whereHas('register', fn($q) => $q->where('student_id', $student->student_id))
            ->whereNotNull('grade')
            ->where('grade', '!=', '')
            ->whereIn('grade', array_keys($this->gradePoints))
            ->get();

        $totalCredit = 0;
        $totalPoint = 0;
        foreach ($gradedDetails as $d) {
            $credit = $d->subject->credit ?? 0;
            $point  = $this->gradePoints[$d->grade] ?? 0;
            $totalCredit += $credit;
            $totalPoint  += $credit * $point;
        }
        $overallGpa = $totalCredit > 0 ? round($totalPoint / $totalCredit, 2) : null;

        // จำนวนภาคเรียนที่เคยลงทะเบียนทั้งหมด
        $totalSemesters = Register::where('student_id', $student->student_id)
            ->distinct('semester')->count('semester');

        // หน่วยกิตสะสมที่ผ่านแล้ว (เกรดไม่ใช่ F)
        $earnedCredits = $gradedDetails->filter(fn($d) => $d->grade !== 'F')
            ->sum(fn($d) => $d->subject->credit ?? 0);

        // นับจำนวนเกรดแต่ละตัวสำหรับแสดงกราฟใน Dashboard
        $gradeCounts = [
            'A' => 0, 'B+' => 0, 'B' => 0, 'C+' => 0,
            'C' => 0, 'D+' => 0, 'D' => 0, 'F' => 0,
        ];
        foreach ($gradedDetails as $d) {
            if (isset($gradeCounts[$d->grade])) {
                $gradeCounts[$d->grade]++;
            }
        }

        return view('students.dashboard', compact(
            'student',
            'currentSemester',
            'currentSubjects',
            'overallGpa',
            'totalSemesters',
            'earnedCredits',
            'totalCredit',
            'gradeCounts'
        ));
    }

    protected function currentSemester(): string
    {
        $month = now()->month;
        $buddhistYear = now()->year + 543;
        $term = ($month >= 6 && $month <= 10) ? '1' : (($month >= 11 || $month <= 3) ? '2' : '3');
        return "{$term}/{$buddhistYear}";
    }
}

