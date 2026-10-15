@extends('layouts.app')

@section('title', 'แก้ไขการกำหนดอาจารย์ผู้สอน')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">

        {{-- Navigation Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('subject-teachers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-2">
                    <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
                </a>
                <h4 class="fw-bold text-dark mb-0">แก้ไขการกำหนดอาจารย์ผู้สอน</h4>
                <p class="text-muted small mb-0">ปรับปรุงข้อมูลอาจารย์ผู้สอนประจำรายวิชา</p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="header-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <div class="fw-semibold text-dark">แก้ไขข้อมูลการมอบหมาย</div>
                        <div class="text-muted" style="font-size:12px;">รหัสรายการ #{{ $assignment->id }}</div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('subject-teachers.update', $assignment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- รายวิชา --}}
                    <div class="mb-4">
                        <label for="subject_code" class="form-label fw-semibold text-dark">
                            รายวิชา <span class="text-danger">*</span>
                        </label>
                        <select name="subject_code" id="subject_code" class="form-select select-custom @error('subject_code') is-invalid @enderror" required>
                            <option value="">-- เลือกรายวิชา --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->subject_code }}"
                                    {{ (old('subject_code', $assignment->subject_code) == $subject->subject_code) ? 'selected' : '' }}>
                                    [{{ $subject->subject_code }}] {{ $subject->subject_name }} ({{ $subject->credit }} หน่วยกิต)
                                </option>
                            @endforeach
                        </select>
                        @error('subject_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- อาจารย์ผู้สอน --}}
                    <div class="mb-4">
                        <label for="teacher_id" class="form-label fw-semibold text-dark">
                            อาจารย์ผู้สอน <span class="text-danger">*</span>
                        </label>
                        <select name="teacher_id" id="teacher_id" class="form-select select-custom @error('teacher_id') is-invalid @enderror" required>
                            <option value="">-- เลือกอาจารย์ผู้สอน --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->teacher_id }}"
                                    {{ (old('teacher_id', $assignment->teacher_id) == $teacher->teacher_id) ? 'selected' : '' }}>
                                    {{ $teacher->teacher_name }}
                                    @if($teacher->faculty)
                                        — คณะ{{ $teacher->faculty->faculty_name }}
                                    @endif
                                    @if($teacher->program)
                                        ({{ $teacher->program->program_name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 pt-2">
                        <a href="{{ route('subject-teachers.index') }}" class="btn btn-light px-4 rounded-pill">
                            ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold">
                            <i class="bi bi-check-lg me-1"></i> บันทึกการแก้ไข
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
    .header-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: #fef3c7; color: #b45309;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .select-custom {
        padding: 0.65rem 1rem;
        border-radius: 10px;
        border-color: #cbd5e1;
        font-size: 14px;
    }
    .select-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
    }
</style>
@endsection

