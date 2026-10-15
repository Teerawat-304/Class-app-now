<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterDetail;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class TeacherScoreController extends Controller
{
    public function edit(Request $request, string $subject_code)
    {
        $teacher = Auth::guard('teacher')->user();
        $semester = $request->query('semester', $this->currentSemester());

        $subject = Subject::where('subject_code', $subject_code)->firstOrFail();

        $details = RegisterDetail::with(['register.student'])
            ->where('subject_code', $subject_code)
            ->where('teacher_id', $teacher->teacher_id)
            ->whereHas('register', fn($q) => $q->where('semester', $semester))
            ->get();

        return view('teachers.scores.edit', compact('subject', 'details', 'semester'));
    }

    // บันทึกคะแนนทั้งชุด และตัดเกรดอัตโนมัติ
    public function update(Request $request, string $subject_code)
    {
        $teacher = Auth::guard('teacher')->user();

        $validated = $request->validate([
            'scores'                        => 'required|array',
            'scores.*.detail_id'            => 'required|integer',
            'scores.*.subscore'             => 'required|integer|min:0|max:100',
            'scores.*.midterm_score'        => 'required|integer|min:0|max:100',
            'scores.*.final_score'          => 'required|integer|min:0|max:100',
        ]);

        $updated = 0;

        foreach ($validated['scores'] as $row) {
            // เช็คสิทธิ์ทุกแถว: ต้องเป็น record ของวิชานี้ และเป็นของอาจารย์คนนี้เท่านั้น
            // ป้องกันการปลอมแปลง detail_id เพื่อแก้คะแนนวิชา/อาจารย์อื่น
            $detail = RegisterDetail::where('detail_id', $row['detail_id'])
                ->where('subject_code', $subject_code)
                ->where('teacher_id', $teacher->teacher_id)
                ->first();

            if (! $detail) {
                continue;
            }

            $total = $row['subscore'] + $row['midterm_score'] + $row['final_score'];

            $detail->update([
                'subscore'      => $row['subscore'],
                'midterm_score' => $row['midterm_score'],
                'final_score'   => $row['final_score'],
                'total_score'   => $total,
                'grade'         => $this->calculateGrade($total),
            ]);

            $updated++;
        }

        $semester = $request->input('semester', $this->currentSemester());

        return redirect()->route('teacher.scores.edit', ['subject_code' => $subject_code, 'semester' => $semester])
            ->with('success', "บันทึกคะแนนเรียบร้อยแล้ว ({$updated} รายการ)");
    }

    // ประวัติย้อนหลัง: วิชาที่เคยสอน + คะแนน/เกรดที่เคยกรอกในทุกภาคเรียนที่ผ่านมา
    public function history(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();
        $currentSemester = $this->currentSemester();

        $details = RegisterDetail::with(['subject', 'register.student'])
            ->where('teacher_id', $teacher->teacher_id)
            ->whereHas('register', fn($q) => $q->where('semester', '!=', $currentSemester))
            ->get()
            ->sortByDesc(fn($d) => $d->register->semester)
            ->groupBy(fn($d) => $d->register->semester)
            ->map(fn($items) => $items->groupBy('subject_code'));

        return view('teachers.scores.history', compact('details'));
    }

    private function calculateGrade(int $total): string
    {
        return match (true) {
            $total >= 80 => 'A',
            $total >= 75 => 'B+',
            $total >= 70 => 'B',
            $total >= 65 => 'C+',
            $total >= 60 => 'C',
            $total >= 55 => 'D+',
            $total >= 50 => 'D',
            default      => 'F',
        };
    }

    protected function currentSemester(): string
    {
        $month = now()->month;
        $buddhistYear = now()->year + 543;
        $term = ($month >= 6 && $month <= 10) ? '1' : (($month >= 11 || $month <= 3) ? '2' : '3');
        return "{$term}/{$buddhistYear}";
    }
    public function summary(Request $request, string $subject_code)
{
    $teacher = Auth::guard('teacher')->user();
    $semester = $request->query('semester', $this->currentSemester());

    $subject = Subject::where('subject_code', $subject_code)->firstOrFail();

    $details = RegisterDetail::with(['register.student'])
        ->where('subject_code', $subject_code)
        ->where('teacher_id', $teacher->teacher_id)
        ->whereHas('register', fn ($q) => $q->where('semester', $semester))
        ->get()
        ->sortBy(fn ($d) => $d->register->student->student_id ?? '');

    // นับจำนวนนักศึกษาต่อเกรด (เรียงจากดีสุดไปแย่สุด)
    $gradeOrder = ['A', 'B+', 'B', 'C+', 'C', 'D+', 'D', 'F'];
    $gradeCounts = collect($gradeOrder)
        ->mapWithKeys(fn ($g) => [$g => $details->where('grade', $g)->count()]);

    $pendingCount = $details->filter(fn ($d) => ! in_array($d->grade, $gradeOrder))->count();

    $avgScore = $details->count() > 0 ? round($details->avg('total_score'), 2) : 0;
    $maxScore = $details->max('total_score');
    $minScore = $details->count() > 0 ? $details->min('total_score') : null;

    return view('teachers.scores.summary', compact(
        'subject', 'details', 'gradeCounts', 'pendingCount',
        'avgScore', 'maxScore', 'minScore', 'semester'
    ));

}
}