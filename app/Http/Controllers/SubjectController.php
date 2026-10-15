<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * แสดงรายการรายวิชาทั้งหมด พร้อมค้นหาและแบ่งหน้า
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $subjects = Subject::with(['subjectTeachers.teacher.faculty', 'subjectTeachers.teacher.program'])
            ->when($search, function ($query, $search) {
                $query->where('subject_name', 'like', "%{$search}%")
                    ->orWhere('subject_code', 'like', "%{$search}%");
            })
            ->orderBy('subject_code')
            ->paginate(10)
            ->withQueryString();

        $totalSubjects = Subject::count();
        $totalCredits  = Subject::sum('credit');
        $teachers      = Teacher::with(['faculty', 'program'])->orderBy('teacher_name')->get();

        return view('subjects.index', compact(
            'subjects',
            'search',
            'totalSubjects',
            'totalCredits',
            'teachers'
        ));
    }

    /**
     * แสดงฟอร์มเพิ่มรายวิชาใหม่
     */
    public function add()
    {
        return view('subjects.add');
    }

    /**
     * บันทึกรายวิชาใหม่ลงฐานข้อมูล
     */
    public function createSubject(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:7|unique:subject,subject_code',
            'subject_name' => 'required|string|max:255',
            'credit'       => 'required|integer|min:1|max:9',
        ], [
            'subject_code.required' => 'กรุณากรอกรหัสวิชา',
            'subject_code.max'      => 'รหัสวิชาต้องไม่เกิน 7 ตัวอักษร',
            'subject_code.unique'   => 'รหัสวิชานี้มีอยู่ในระบบแล้ว',
            'subject_name.required' => 'กรุณากรอกชื่อรายวิชา',
            'credit.required'       => 'กรุณากรอกจำนวนหน่วยกิต',
            'credit.integer'        => 'หน่วยกิตต้องเป็นตัวเลขจำนวนเต็ม',
            'credit.min'            => 'หน่วยกิตต้องมีอย่างน้อย 1',
            'credit.max'            => 'หน่วยกิตต้องไม่เกิน 9',
        ]);

        Subject::create($validated);

        return redirect('subjects')
            ->with('success', 'เพิ่มรายวิชาเรียบร้อยแล้ว');
    }

    /**
     * ค้นหารายวิชาโดย subject_code หรือ id
     */
    private function findSubject($id)
    {
        $subject = Subject::where('subject_code', $id)->first();

        if (! $subject) {
            try {
                $subject = Subject::where('id', $id)->first();
            } catch (\Exception $e) {
                // เผื่อกรณีตารางไม่มีคอลัมน์ id
            }
        }

        if (! $subject) {
            abort(404, 'ไม่พบรายวิชาที่ระบุ');
        }

        return $subject;
    }

    /**
     * แสดงฟอร์มแก้ไขรายวิชา
     */
    public function editSubject($id)
    {
        $subject = $this->findSubject($id);

        return view('subjects.updateForm', compact('subject'));
    }

    /**
     * อัปเดตข้อมูลรายวิชา
     */
    public function updateSubject(Request $request, $id)
    {
        $subject = $this->findSubject($id);

        $validated = $request->validate([
            'subject_code' => 'required|string|max:7|unique:subject,subject_code,' . $subject->subject_code . ',subject_code',
            'subject_name' => 'required|string|max:255',
            'credit'       => 'required|integer|min:1|max:9',
        ], [
            'subject_code.required' => 'กรุณากรอกรหัสวิชา',
            'subject_code.max'      => 'รหัสวิชาต้องไม่เกิน 7 ตัวอักษร',
            'subject_code.unique'   => 'รหัสวิชานี้มีอยู่ในระบบแล้ว',
            'subject_name.required' => 'กรุณากรอกชื่อรายวิชา',
            'credit.required'       => 'กรุณากรอกจำนวนหน่วยกิต',
            'credit.integer'        => 'หน่วยกิตต้องเป็นตัวเลขจำนวนเต็ม',
            'credit.min'            => 'หน่วยกิตต้องมีอย่างน้อย 1',
            'credit.max'            => 'หน่วยกิตต้องไม่เกิน 9',
        ]);

        $subject->update($validated);

        return redirect('subjects')
            ->with('success', 'แก้ไขข้อมูลรายวิชาเรียบร้อยแล้ว');
    }

    /**
     * ลบรายวิชา (เช็คก่อนว่ามีการลงทะเบียนเรียนวิชานี้อยู่หรือไม่)
     */
    public function deleteSubject($id)
    {
        $subject = $this->findSubject($id);

        $hasRegistrations = false;
        try {
            $hasRegistrations = DB::table('registerr_detail')
                ->where('subject_code', $subject->subject_code)
                ->exists();
        } catch (\Exception $e) {
            try {
                $hasRegistrations = DB::table('register_detail')
                    ->where('subject_code', $subject->subject_code)
                    ->exists();
            } catch (\Exception $e2) {
            }
        }

        if ($hasRegistrations) {
            return redirect('subjects')
                ->with('error', 'ไม่สามารถลบได้ เนื่องจากรายวิชานี้มีการลงทะเบียนเรียนอยู่แล้ว');
        }

        // ลบข้อมูลที่ผูกกับอาจารย์ผู้สอนใน subject_teacher (ถ้ามี)
        try {
            DB::table('subject_teacher')->where('subject_code', $subject->subject_code)->delete();
        } catch (\Exception $e) {
        }

        $subject->delete();

        return redirect('subjects')
            ->with('success', 'ลบรายวิชาเรียบร้อยแล้ว');
    }
}