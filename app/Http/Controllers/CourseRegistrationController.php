<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\SubjectTeacher;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseRegistrationController extends Controller
{
    // เกรดแต้ม (สเกล 4.00 แบบไทย)
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

    public function create(Request $request)
    {
        $student = Auth::guard('student')->user();
        $semester = $request->query('semester', $this->currentSemester());

        // วิชาที่ลงแล้วใน semester นี้ (กันแสดงซ้ำ)
        $registeredCodes = RegisterDetail::whereHas('register', function ($q) use ($student, $semester) {
            $q->where('student_id', $student->student_id)->where('semester', $semester);
        })->pluck('subject_code')->toArray();

        $subjectTeachers = SubjectTeacher::with(['subject', 'teacher'])
            ->whereNotIn('subject_code', $registeredCodes)
            ->get();

        return view('students.register.create', compact('subjectTeachers', 'semester', 'registeredCodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|max:6',
            'subject_teacher_ids' => 'required|array|min:1',
            'subject_teacher_ids.*' => 'exists:subject_teacher,id',
        ]);

        $student = Auth::guard('student')->user();
        $semester = $request->semester;

        DB::beginTransaction();
        try {
            $register = Register::firstOrCreate(
                ['student_id' => $student->student_id, 'semester' => $semester],
                ['register_date' => now()]
            );

            $chosen = SubjectTeacher::whereIn('id', $request->subject_teacher_ids)->get();

            $skipped = [];
            foreach ($chosen as $st) {
                $exists = RegisterDetail::where('register_id', $register->register_id)
                    ->where('subject_code', $st->subject_code)
                    ->exists();

                if ($exists) {
                    $skipped[] = $st->subject_code;
                    continue;
                }

                RegisterDetail::create([
                    'register_id'   => $register->register_id,
                    'subject_code'  => $st->subject_code,
                    'teacher_id'    => $st->teacher_id,
                    'subscore'      => 0,
                    'midterm_score' => 0,
                    'final_score'   => 0,
                    'total_score'   => 0,
                    'grade'         => '',
                ]);
            }

            DB::commit();

            $msg = 'ลงทะเบียนสำเร็จ';
            if (!empty($skipped)) {
                $msg .= ' (ข้ามวิชาที่ลงซ้ำ: ' . implode(', ', $skipped) . ')';
            }

            return redirect()->route('student.course_register.history')->with('success', $msg);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            // เผื่อ race condition ชน unique key ที่เพิ่มไว้ใน DB
            return back()->with('error', 'ไม่สามารถลงทะเบียนได้ อาจมีวิชาที่ลงซ้ำในภาคเรียนนี้แล้ว');
        }
    }

    // public function history()
    // {
    //     $student = Auth::guard('student')->user();

    //     $registers = Register::with(['details.subject', 'details.teacher'])
    //         ->where('student_id', $student->student_id)
    //         ->orderByDesc('semester')
    //         ->paginate(10);

    //     return view('students.register.history', compact('registers'));
    // }

    public function history()
    {
        $student = Auth::guard('student')->user();

        $registers = Register::with(['details.subject', 'details.teacher'])
            ->where('student_id', $student->student_id)
            ->orderByDesc('semester')
            ->orderByDesc('register_date')
            ->paginate(5);

        return view('students.register.history', compact('registers'));
    }
    public function grades()
    {
        $student = Auth::guard('student')->user();

        $details = RegisterDetail::with(['subject', 'register'])
            ->whereHas('register', fn($q) => $q->where('student_id', $student->student_id))
            ->where('grade', '!=', '')
            ->get()
            ->groupBy(fn($d) => $d->register->semester);

        return view('students.grades.index', compact('details'));
    }

    public function gpa()
    {
        $student = Auth::guard('student')->user();

        $details = RegisterDetail::with(['subject', 'register'])
            ->whereHas('register', fn($q) => $q->where('student_id', $student->student_id))
            ->where('grade', '!=', '')
            ->whereIn('grade', array_keys($this->gradePoints)) // ตัด W/I ออกจากการคิด GPA
            ->get();

        $bySemester = $details->groupBy(fn($d) => $d->register->semester);

        $semesterGpa = [];
        $totalCredit = 0;
        $totalPoint = 0;

        foreach ($bySemester as $semester => $items) {
            $credit = 0;
            $point = 0;
            foreach ($items as $d) {
                $c = $d->subject->credit ?? 0;
                $p = $this->gradePoints[$d->grade] ?? 0;
                $credit += $c;
                $point += $c * $p;
            }
            $semesterGpa[$semester] = $credit > 0 ? round($point / $credit, 2) : 0;
            $totalCredit += $credit;
            $totalPoint += $point;
        }

        $overallGpa = $totalCredit > 0 ? round($totalPoint / $totalCredit, 2) : 0;

        return view('students.gpa.index', compact('semesterGpa', 'overallGpa'));
    }

    protected function currentSemester(): string
    {
        // ปรับ format ให้ตรงกับที่ระบบคุณใช้จริง เช่น "1/2568"
        $month = now()->month;
        $buddhistYear = now()->year + 543;
        $term = $month >= 6 && $month <= 10 ? '1' : ($month >= 11 || $month <= 3 ? '2' : '3');
        return "{$term}/{$buddhistYear}";
    }
}