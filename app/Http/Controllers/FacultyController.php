<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        // // Logic to retrieve and display a list of faculties
        // // Fetch all faculties from the database
        // $faculties = Faculty::all();

        // // Pass the faculties data to the view
        // return view('faculties.index', compact('faculties'));
        $query = Faculty::with(['programs', 'students']);

        if ($request->search) {
            $query->where('faculty_name', 'like', "%{$request->search}%")
                ->orWhere('faculty_id', 'like', "%{$request->search}%");
        }

        $faculties     = $query->paginate(10)->withQueryString();
        // $totalPrograms = Program::count();
        // $totalStudents = Student::count();
        $totalPrograms = DB::table('program')->count();
        $totalStudents = DB::table('students')->count();
        return view('faculties.index', compact(
            'faculties',
            'totalPrograms',
            'totalStudents'
        ));
    }

    public function createFaculty(Request $request)
    {

        $faculty = new Faculty();
        $faculty->faculty_id = $request->input('faculty_id');
        $faculty->faculty_name = $request->input('faculty_name');
        $faculty->save();

        return redirect('faculties')->with('success', 'Faculty created successfully!');
    }

    public function deleteFaculty($id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();

        return redirect('faculties')->with('success', 'Faculty deleted successfully!');
    }

    public function editFaculty($id)
    {
        $faculty = Faculty::findOrFail($id);
        return view('faculties.updateForm', compact('faculty'));
    }
    // {
    //     $subject = Subjects::findOrFail($id);
    //     $subject->delete();

    //     return redirect('subject')->with('success', 'Subject deleted successfully!');
    // }


    public function updateFaculty(Request $request, $id)
    {
        $faculty = Faculty::findOrFail($id);

        $faculty->faculty_name = $request->input('faculty_name');
        $faculty->update();

        return redirect('faculties')->with('success', 'Faculty updated successfully!');
    }

    // public function getFaculty($id)
    // {
    //     $faculty = Faculty::where('faculty_id', $id)->first();
    //     // or use faculty_id if that’s your PK
    //     return response()->json($faculty);
    // }


    // public function add()
    // {
    //     $faculty = new Faculty();
    //     $faculty->faculty_id = '5';
    //     $faculty->faculty_name = 'Engineering';
    //     $faculty->save();
    //     return ('Faculty added successfully');
    // }

    // public function show($id)
    // {
    //     $faculty =  Faculty::findOrFail($id);
    //     return $faculty;
    // }

    // public function update($id)
    // {
    //     $faculty =  Faculty::findOrFail($id);
    //     $faculty->faculty_name = 'Science and Technology';
    //     $faculty->update();
    //     return ('Faculty updated successfully');
    // }

    // public function deleteFaculty($id)
    // {
    //     $faculty =  Faculty::findOrFail($id);
    //     $faculty->delete();
    //     return ('Faculty deleted successfully');
    // }
}
