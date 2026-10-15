<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SubjectTeacher;
use App\Models\RegisterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectTeacherController extends Controller
{
    /**
     * แสดงรายการการกำหนดอาจารย์ผู้สอนทั้งหมด
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $assignments = SubjectTeacher::with(['subject', 'teacher.faculty', 'teacher.program'])
            ->when($search, function ($query, $search) {
                $query->whereHas('subject', function ($q) use ($search) {
                    $q->where('subject_code', 'like', "%{$search}%")
                      ->orWhere('subject_name', 'like', "%{$search}%");
                })
                ->orWhereHas('teacher', function ($q) use ($search) {
                    $q->where('teacher_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('subject_code')
            ->paginate(15)
            ->withQueryString();

        $totalAssignments = SubjectTeacher::count();
        $totalSubjectsAssigned = SubjectTeacher::distinct('subject_code')->count('subject_code');
        $totalTeachersAssigned = SubjectTeacher::distinct('teacher_id')->count('teacher_id');

        return view('subject_teachers.index', compact(
            'assignments',
            'search',
            'totalAssignments',
            'totalSubjectsAssigned',
            'totalTeachersAssigned'
        ));
    }

    /**
     * แสดงฟอร์มกำหนดอาจารย์ผู้สอน
     */
    public function add(Request $request)
    {
        $selectedSubjectCode = $request->query('subject_code');

        $subjects = Subject::orderBy('subject_code')->get();
        $teachers = Teacher::with(['faculty', 'program'])->orderBy('teacher_name')->get();

        return view('subject_teachers.add', compact('subjects', 'teachers', 'selectedSubjectCode'));
    }

    /**
     * บันทึกการกำหนดอาจารย์ผู้สอน
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|exists:subject,subject_code',
            'teacher_id'   => 'required|exists:teacher,teacher_id',
        ], [
            'subject_code.required' => 'กรุณาเลือกรายวิชา',
            'subject_code.exists'   => 'ไม่พบรายวิชาที่เลือก',
            'teacher_id.required'   => 'กรุณาเลือกอาจารย์ผู้สอน',
            'teacher_id.exists'     => 'ไม่พบอาจารย์ที่เลือก',
        ]);

        // ตรวจสอบว่ามีการกำหนดอาจารย์ท่านนี้กับวิชานี้แล้วหรือยัง
        $exists = SubjectTeacher::where('subject_code', $validated['subject_code'])
            ->where('teacher_id', $validated['teacher_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'อาจารย์ท่านนี้ได้รับการกำหนดให้สอนในรายวิชานี้อยู่แล้ว');
        }

        SubjectTeacher::create($validated);

        // ถ้ามาจากหน้ารายวิชา ให้กลับไปหน้ารายวิชาพร้อมแจ้งเตือน
        if ($request->input('from_subjects')) {
            return redirect('subjects')
                ->with('success', 'กำหนดอาจารย์ผู้สอนให้กับรายวิชาเรียบร้อยแล้ว');
        }

        return redirect()->route('subject-teachers.index')
            ->with('success', 'กำหนดอาจารย์ผู้สอนประจำรายวิชาเรียบร้อยแล้ว');
    }

    /**
     * แสดงฟอร์มแก้ไขการกำหนดอาจารย์ผู้สอน
     */
    public function edit($id)
    {
        $assignment = SubjectTeacher::with(['subject', 'teacher'])->findOrFail($id);
        $subjects = Subject::orderBy('subject_code')->get();
        $teachers = Teacher::with(['faculty', 'program'])->orderBy('teacher_name')->get();

        return view('subject_teachers.edit', compact('assignment', 'subjects', 'teachers'));
    }

    /**
     * อัปเดตข้อมูลการกำหนดอาจารย์ผู้สอน
     */
    public function update(Request $request, $id)
    {
        $assignment = SubjectTeacher::findOrFail($id);

        $validated = $request->validate([
            'subject_code' => 'required|exists:subject,subject_code',
            'teacher_id'   => 'required|exists:teacher,teacher_id',
        ], [
            'subject_code.required' => 'กรุณาเลือกรายวิชา',
            'subject_code.exists'   => 'ไม่พบรายวิชาที่เลือก',
            'teacher_id.required'   => 'กรุณาเลือกอาจารย์ผู้สอน',
            'teacher_id.exists'     => 'ไม่พบอาจารย์ที่เลือก',
        ]);

        // ตรวจสอบว่าซ้ำกับรายการอื่นหรือไม่
        $duplicate = SubjectTeacher::where('subject_code', $validated['subject_code'])
            ->where('teacher_id', $validated['teacher_id'])
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'มีข้อมูลการกำหนดอาจารย์ท่านนี้กับวิชานี้อยู่แล้วในระบบ');
        }

        $assignment->update($validated);

        return redirect()->route('subject-teachers.index')
            ->with('success', 'แก้ไขข้อมูลการกำหนดผู้สอนเรียบร้อยแล้ว');
    }

    /**
     * ยกเลิกการกำหนดอาจารย์ผู้สอน
     */
    public function destroy($id)
    {
        $assignment = SubjectTeacher::findOrFail($id);

        // ตรวจสอบว่ามีการลงทะเบียนเรียนกับอาจารย์ท่านนี้ในวิชานี้หรือไม่
        $hasRegistrations = false;
        try {
            $hasRegistrations = RegisterDetail::where('subject_code', $assignment->subject_code)
                ->where('teacher_id', $assignment->teacher_id)
                ->exists();
        } catch (\Exception $e) {
        }

        if ($hasRegistrations) {
            return redirect()->back()
                ->with('error', 'ไม่สามารถยกเลิกได้ เนื่องจากมีนักศึกษาลงทะเบียนเรียนกับอาจารย์ท่านนี้แล้ว');
        }

        $assignment->delete();

        return redirect()->back()
            ->with('success', 'ยกเลิกการกำหนดผู้สอนเรียบร้อยแล้ว');
    }
}

