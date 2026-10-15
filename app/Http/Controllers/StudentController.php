<?php

namespace App\Http\Controllers;


use App\Models\Faculty;
use App\Models\Students;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Logic to retrieve and display a list of students
        //return ('Hello from index controller ');
        // $students = Student::all(); // Fetch all students from the database
        $query = Students::with(['faculty', 'program.faculty'])
            ->orderBy('student_id', 'asc');

        if ($request->search) {
            $query->where('student_id', 'like', "%{$request->search}%")
                ->orWhere('student_name', 'like', "%{$request->search}%")
                // ->orWhere('program_id', 'like', "%{$request->search}%")
                ->orWhereHas('faculty', function ($q) use ($request) {
                    $q->where('faculty_name', 'like', "%{$request->search}%");
                })
                ->orWhereHas('program', function ($q) use ($request) {
                    $q->where('program_name', 'like', "%{$request->search}%");
                });
        }

        $students     = $query->paginate(10)->withQueryString();
        // $totalPrograms = Program::count();
        // $totalStudents = Student::count();
        $totalFaculties = DB::table('faculty')->count();
        $totalPrograms = DB::table('program')->count();
        $totalStudents = DB::table('students')->count();
        return view('students.index', compact(
            'students',
            'totalFaculties',
            'totalPrograms',
            'totalStudents'
        ));
        // $query->where('student_id', 'like', '%' . $request->input('search') . '%')
        //         ->orWhere('student_name', 'like', '%' . $request->input('search') . '%')
        //         ->orWhere('program_id', 'like', '%' . $request->input('search') . '%')
        //         ->orWhere('faculty_id', 'like', '%' . $request->input('search') . '%')
        //         ->orWhere('email', 'like', '%' . $request->input('search') . '%')
        //         ->orWhere('address', 'like', '%' . $request->input('search') . '%')
        //         ->orWhere('birth_date', 'like', '%' . $request->input('search') . '%');
        // }
        // ->paginate(10);    // Fetch all students from the database

        // return view('students.index', compact('students')); // Pass the students data to the view
    }

    public function add()
    {
        // ดึงข้อมูลคณะทั้งหมดจากตาราง faculty
        $faculties = Faculty::all();
        return view('students.add', compact('faculties'));
    }

    public function  createStudent(Request $request)
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
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Students::create($validated);

        return redirect('students')->with('success', 'บันทึกข้อมูลนักศึกษาเรียบร้อยแล้ว');
    }

    //edit student
    public function edit($student_id)
    {
        $student   = Students::findOrFail($student_id);
        $faculties = Faculty::orderBy('faculty_name')->get();

        return view('students.updateForm', compact('student', 'faculties'));
    }

    // Update student
    public function update(Request $request, $student_id)
    {
        $student = Students::findOrFail($student_id);

        $validated = $request->validate([
            'student_name' => 'required|string|max:100',
            'faculty_id'   => 'required|exists:faculty,faculty_id',
            'program_id'   => 'required|exists:program,program_id',
            'birth_date'   => 'required|date|before:today',
            'email'        => 'required|email|max:100|unique:students,email,' . $student->student_id . ',student_id',
            'address'      => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:students,username,' . $student->student_id . ',student_id',
            // ไม่มี password ในนี้ ดังนั้น $student->password จะไม่ถูกแตะต้อง
        ]);

        $student->update($validated);

        return redirect('students')->with('success', 'บันทึกการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }

    //delete student
    public function deleteStudent($student_id)
    {
        $student = Students::findOrFail($student_id);

        // เช็คก่อนว่านักศึกษาคนนี้มีประวัติการลงทะเบียนเรียนอยู่หรือไม่
        $hasRegistrations = DB::table('register')
            ->where('student_id', $student_id)
            ->exists();

        if ($hasRegistrations) {
            return redirect('students')
                ->with('error', "ไม่สามารถลบนักศึกษา {$student->student_name} ได้ เนื่องจากมีประวัติการลงทะเบียนเรียนอยู่ในระบบ");
        }

        try {
            $student->delete();
            return redirect('students')->with('success', 'ลบข้อมูลนักศึกษาเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect('students')
                ->with('error', 'ไม่สามารถลบข้อมูลนักศึกษาได้ เนื่องจากข้อมูลนี้ถูกอ้างอิงอยู่ในส่วนอื่นของระบบ');
        }
    }
    

}