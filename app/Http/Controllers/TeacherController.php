<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = Teacher::with(['faculty', 'program'])
            ->when($search, function ($query, $search) {
                $query->where('teacher_name', 'like', "%{$search}%")
                    ->orWhereHas('faculty', function ($q) use ($search) {
                        $q->where('faculty_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('program', function ($q) use ($search) {
                        $q->where('program_name', 'like', "%{$search}%");
                    })
                ;
            })
            ->orderBy('teacher_name')
            ->paginate(10)
            ->withQueryString();

        // $students     = $query->paginate(10)->withQueryString();
        // $totalPrograms = Program::count();
        // $totalStudents = Student::count();

        $totalFaculties = DB::table('faculty')->count();
        $totalPrograms = DB::table('program')->count();
        $totalStudents = DB::table('students')->count();
        $totalTeachers = DB::table('teacher')->count();

        return view('teachers.index', compact('teachers', 'search', 'totalFaculties', 'totalPrograms', 'totalStudents', 'totalTeachers'));
    }

    public function add()
    {
        $faculties = Faculty::orderBy('faculty_name')->get();
        $programs  = Program::orderBy('program_name')->get();

        return view('teachers.add', compact('faculties', 'programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_name'  => 'required|string|max:255',
            't_faculty_id'  => 'required|exists:faculty,faculty_id',
            't_program_id'  => 'required|exists:program,program_id',
            't_email'       => 'required|email|max:255|unique:teacher,t_email',
            't_address'     => 'nullable|string|max:255',
            't_username'    => 'required|string|max:255|unique:teacher,t_username',
            't_password'    => ['required', 'confirmed', Password::min(8)],
            't_role'        => 'required|in:0,1',
        ]);

        $validated['t_password'] = Hash::make($validated['t_password']);

        Teacher::create($validated);

        // Student::create($validated);

        return redirect('teachers')->with('success', 'บันทึกข้อมูลอาจารย์เรียบร้อยแล้ว');

        //     return redirect()
        //         ->('teachers')
        //         ->with('success', 'เพิ่มข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['faculty', 'program']);
        return view('teachers.show', compact('teacher'));
    }

    public function edit($teacher_id)
    {
        // $student   = Student::findOrFail($student_id);
        // $faculties = Faculty::orderBy('faculty_name')->get();
        $teacher   = Teacher::findOrFail($teacher_id);
        $faculties = Faculty::orderBy('faculty_name')->get();
        $programs  = Program::orderBy('program_name')->get();

        return view('teachers.edit', compact('teacher', 'faculties', 'programs'));
        return view('teachers.updateForm', compact('teacher', 'faculties', 'programs'));
    }

    public function update(Request $request, $teacher_id)
    {
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',
            't_faculty_id' => 'required|exists:faculty,faculty_id',
            't_program_id' => 'required|exists:program,program_id',
            't_email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('teacher', 't_email')->ignore($teacher_id, 'teacher_id'),
            ],
            't_address'    => 'nullable|string|max:255',
            't_username'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('teacher', 't_username')->ignore($teacher_id, 'teacher_id'),
            ],
            // 't_password'   => ['nullable', 'confirmed', Password::min(8)],
            // 't_role'       => 'required|in:0,1',
        ]);

        // if (!empty($validated['t_password'])) {
        //     $validated['t_password'] = Hash::make($validated['t_password']);
        // } else {
        //     unset($validated['t_password']);
        // }

        $teacher = Teacher::findOrFail($teacher_id);
        $teacher->update($validated);
        return redirect('teachers')->with('success', 'แก้ไขข้อมูลอาจารย์เรียบร้อยแล้ว');

        // return redirect()
        //     ->route('teachers')
        //     ->with('success', 'แก้ไขข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function destroy($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);

        $hasAssignments = DB::table('subject_teacher')->where('teacher_id', $teacher_id)->exists();
        $hasScores = DB::table('register_detail')->where('teacher_id', $teacher_id)->exists();

        if ($hasAssignments || $hasScores) {
            return redirect('teachers')->with('error', "ไม่สามารถลบอาจารย์ {$teacher->teacher_name} ได้ เนื่องจากมีรายวิชาที่สอนหรือมีประวัติการให้คะแนนนักศึกษาอยู่ในระบบ");
        }

        try {
            $teacher->delete();
            return redirect('teachers')->with('success', 'ลบข้อมูลอาจารย์เรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect('teachers')->with('error', 'ไม่สามารถลบข้อมูลอาจารย์ได้ เนื่องจากมีข้อมูลที่เกี่ยวข้องอยู่ในระบบ');
        }
    }
}