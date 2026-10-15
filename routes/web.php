<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Models\Faculty;
use App\Models\Students;
use App\Models\Program;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\SubjectTeacherController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\Auth\StudentRegisterController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherScoreController;


Route::get('/', [HomeController::class, 'index'])->name('home');


use App\Http\Controllers\Auth\TeacherRegisterController;

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/register', [TeacherRegisterController::class, 'showRegisterForm'])->name('register.show');
    Route::post('/register', [TeacherRegisterController::class, 'register'])->name('register.submit');
});


// --- ข้อมูลระบบจัดการ (เฉพาะผู้ดูแลระบบ t_role = 0) ---
Route::middleware('is.admin')->group(function () {

    Route::prefix('students')->controller(StudentController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('add', 'add');
        Route::post('create', 'createStudent');
        Route::get('edit/{id}', 'edit');
        Route::post('update/{id}', 'update');
        Route::post('delete/{id}', 'deleteStudent');
    });

    Route::prefix('faculties')->controller(FacultyController::class)->group(function () {
        Route::get('/', 'index');
        Route::view('add', 'faculties.add');
        Route::post('create', 'createFaculty');
        Route::get('edit/{id}', 'editFaculty');
        Route::post('update/{id}', 'updateFaculty');
        Route::post('delete/{id}', 'deleteFaculty');
    });

    Route::prefix('programs')->controller(ProgramController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('add', 'add');
        Route::post('create', 'createProgram');
        Route::get('edit/{id}', 'editProgram');
        Route::post('update/{id}', 'updateProgram');
        Route::post('delete/{id}', 'deleteProgram');
    });

    Route::prefix('subjects')->controller(SubjectController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('add', 'add');
        Route::post('create', 'createSubject');
        Route::post('store', 'createSubject');
        Route::get('edit/{id}', 'editSubject');
        Route::get('{id}/edit', 'editSubject');
        Route::post('update/{id}', 'updateSubject');
        Route::put('update/{id}', 'updateSubject');
        Route::match(['post', 'delete'], 'delete/{id}', 'deleteSubject');
        Route::match(['post', 'delete'], 'destroy/{id}', 'deleteSubject');
    });

    // Teacher CRUD
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/add', [TeacherController::class, 'add'])->name('teachers.add');
    Route::post('/teachers/store', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // กำหนดอาจารย์ผู้สอนประจำรายวิชา (Subject-Teacher Assignment)
    Route::prefix('subject-teachers')->name('subject-teachers.')->group(function () {
        Route::get('/', [SubjectTeacherController::class, 'index'])->name('index');
        Route::get('/add', [SubjectTeacherController::class, 'add'])->name('add');
        Route::post('/store', [SubjectTeacherController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SubjectTeacherController::class, 'edit'])->name('edit');
        Route::match(['post', 'put'], '/{id}', [SubjectTeacherController::class, 'update'])->name('update');
        Route::match(['post', 'delete'], '/{id}/delete', [SubjectTeacherController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/programs/by-faculty/{faculty_id}', [ProgramController::class, 'getByFaculty'])
    ->name('programs.byFaculty');


// --- Admin Login ---
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::post('/admin/logout', [AdminLoginController::class, 'logout']);


// --- Teacher Login ---
Route::get('/teacher/login', [TeacherLoginController::class, 'showLoginForm'])->name('teacher.login');
Route::post('/teacher/login', [TeacherLoginController::class, 'login'])->name('teacher.login.submit');
Route::get('/teacher/logout', [TeacherLoginController::class, 'logout'])->name('teacher.logout');


Route::middleware('is.teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    Route::get('/subjects/{subject_code}/students', [TeacherScoreController::class, 'edit'])
        ->name('scores.edit');
    Route::post('/subjects/{subject_code}/students', [TeacherScoreController::class, 'update'])
        ->name('scores.update');
    Route::get('/subjects/{subject_code}/summary', [TeacherScoreController::class, 'summary'])
        ->name('scores.summary');
    Route::get('/history', [TeacherScoreController::class, 'history'])->name('history');
});



// Student Registration Routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/register', [StudentRegisterController::class, 'showRegisterForm'])->name('register.show');
    Route::post('/register', [StudentRegisterController::class, 'register'])->name('register.submit');
});
// --- Student Login ---


// Login/Logout ไม่ต้องครอบ middleware (ยังไม่ได้ login)
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/login', [StudentLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StudentLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [StudentLoginController::class, 'logout'])->name('logout');
});

// Route ที่ต้อง login แล้วเท่านั้น
Route::middleware('is.student')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::get('/course_register', [CourseRegistrationController::class, 'create'])->name('course_register.create');

    Route::post('/course_register', [CourseRegistrationController::class, 'store'])->name('course_register.store');
    Route::get('/course_register/history', [CourseRegistrationController::class, 'history'])->name('course_register.history');

    Route::get('/grades', [CourseRegistrationController::class, 'grades'])->name('grades');
    Route::get('/gpa', [CourseRegistrationController::class, 'gpa'])->name('gpa');
});