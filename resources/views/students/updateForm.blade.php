@extends('layouts.app')

@section('title', 'แก้ไขข้อมูลนักศึกษา')

@section('breadcrumb')
    <a href="{{ url('students') }}">นักศึกษา</a>
    <i class="bi bi-chevron-right" style="font-size:11px"></i>
    <span>แก้ไขข้อมูลนักศึกษา</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card border-0 shadow-sm rounded-3">

            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square text-primary"></i>
                    แก้ไขข้อมูลนักศึกษา
                </h6>
            </div>

            <div class="card-body p-4">

                {{-- Info Box --}}
                <div class="info-box mb-4">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        แก้ไขข้อมูลนักศึกษาแล้วกด "บันทึกการแก้ไข"
                        (รหัสผ่านจะไม่ถูกเปลี่ยนแปลงจากหน้านี้)
                    </div>
                </div>

                <form action="{{ url('students/update/'.$student->student_id) }}" method="POST" id="studentForm">
                    @csrf
                    @method('POST')

                    {{-- รหัสนักศึกษา (แก้ไขไม่ได้) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            รหัสนักศึกษา
                        </label>
                        <input type="text"
                               name="student_id"
                               id="student_id"
                               class="form-control"
                               value="{{ old('student_id', $student->student_id) }}"
                               readonly
                               style="background:#f0f4f8;">
                        <div class="form-text" style="font-size:11.5px">
                            รหัสนักศึกษาเป็นคีย์หลัก ไม่สามารถแก้ไขได้
                        </div>
                    </div>

                    {{-- ชื่อนักศึกษา --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            ชื่อ-นามสกุล นักศึกษา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="student_name"
                               id="student_name"
                               class="form-control @error('student_name') is-invalid @enderror"
                               value="{{ old('student_name', $student->student_name) }}"
                               placeholder="เช่น นายสมชาย ใจดี"
                               maxlength="100"
                               autofocus>
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     {{-- Dropdown คณะ --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            คณะที่สังกัด
                            <span class="text-danger ms-1">*</span>
                        </label>

                        <select name="faculty_id"
                                id="faculty_id"
                                class="form-select @error('faculty_id') is-invalid @enderror">
                            <option value="">-- เลือกคณะ --</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->faculty_id }}"
                                    data-name="{{ $faculty->faculty_name }}"
                                    {{ old('faculty_id', $student->faculty_id) == $faculty->faculty_id
                                        ? 'selected' : '' }}>
                                    {{ $faculty->faculty_name }}
                                    ({{ $faculty->faculty_id }})
                                </option>
                            @endforeach
                        </select>

                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            เลือกคณะที่นักศึกษาสังกัดอยู่
                        </div>
                    </div>

                    {{-- Dropdown สาขาวิชา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            สาขาวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>

                        <select name="program_id"
                                id="program_id"
                                class="form-select @error('program_id') is-invalid @enderror">
                            <option value="">-- กำลังโหลดสาขาวิชา... --</option>
                        </select>

                        @error('program_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            เลือกสาขาวิชาที่นักศึกษาสังกัด
                        </div>
                    </div>

                    {{-- วันเกิด --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            วันเกิด
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="date"
                               name="birth_date"
                               id="birth_date"
                               class="form-control @error('birth_date') is-invalid @enderror"
                                value="{{ old('birth_date', $student->birth_date ? substr($student->birth_date, 0, 10) : '') }}"
                               max="{{ date('Y-m-d') }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- อีเมล --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            อีเมล
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $student->email) }}"
                               placeholder="เช่น example@email.com"
                               maxlength="100">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            ที่อยู่
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="address"
                               id="address"
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address', $student->address) }}"
                               placeholder="เช่น 123 ถนน example"
                               maxlength="100">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-3">

                    {{-- ชื่อผู้ใช้งาน --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ชื่อผู้ใช้งาน (Username)
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="username"
                               id="username"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username', $student->username) }}"
                               placeholder="เช่น 6512345001"
                               maxlength="50"
                               autocomplete="off">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            ใช้สำหรับเข้าสู่ระบบ ต้องไม่ซ้ำกับผู้ใช้งานอื่น
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ url('students') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-1"></i> บันทึกการแก้ไข
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
    .info-box {
        background: #e6f1fb; border: 1px solid #b5d4f4;
        border-radius: 8px; padding: .65rem .9rem;
        display: flex; align-items: flex-start;
        gap: 8px; font-size: 12.5px; color: #0c447c;
    }
    .info-box i { font-size: 15px; color: #185fa5;
                  flex-shrink: 0; margin-top: 1px; }
</style>
@endsection

@section('scripts')
<script>
    /* ---------- Dropdown สาขาวิชา (โหลดตามคณะที่เลือก + pre-select ค่าเดิม) ---------- */
    const facultySelect = document.getElementById('faculty_id');
    const programSelect = document.getElementById('program_id');

    // ลำดับความสำคัญ: old('program_id') ตอน validation fail > ค่าที่บันทึกไว้เดิมของ student
    const targetProgramId = "{{ old('program_id', $student->program_id) }}";

    function loadPrograms(facultyId, selectedProgramId = null) {
        programSelect.innerHTML = '<option value="">กำลังโหลด...</option>';
        programSelect.disabled = true;

        if (!facultyId) {
            programSelect.innerHTML = '<option value="">-- กรุณาเลือกคณะก่อน --</option>';
            return;
        }

        fetch(`/programs/by-faculty/${facultyId}`)
            .then(res => res.json())
            .then(programs => {
                programSelect.innerHTML = '<option value="">-- เลือกสาขาวิชา --</option>';

                if (programs.length === 0) {
                    programSelect.innerHTML = '<option value="">-- คณะนี้ยังไม่มีสาขาวิชา --</option>';
                    return;
                }

                programs.forEach(program => {
                    const opt = document.createElement('option');
                    opt.value = program.program_id;
                    opt.textContent = `${program.program_name} (${program.program_id})`;
                    if (selectedProgramId && String(selectedProgramId) === String(program.program_id)) {
                        opt.selected = true;
                    }
                    programSelect.appendChild(opt);
                });

                programSelect.disabled = false;
            })
            .catch(err => {
                console.error(err);
                programSelect.innerHTML = '<option value="">เกิดข้อผิดพลาดในการโหลดข้อมูล</option>';
            });
    }

    // เมื่อ user เปลี่ยนคณะเอง (ไม่ pre-select สาขาเดิมอีกต่อไป
    // เพราะสาขาเดิมอาจไม่อยู่ในคณะใหม่)
    facultySelect.addEventListener('change', function () {
        loadPrograms(this.value);
    });

    // ตอนเปิดหน้า edit: โหลดสาขาวิชาของคณะเดิมทันที พร้อม select ค่าที่มีอยู่แล้ว
    window.addEventListener('DOMContentLoaded', function () {
        if (facultySelect.value) {
            loadPrograms(facultySelect.value, targetProgramId);
        } else {
            programSelect.innerHTML = '<option value="">-- กรุณาเลือกคณะก่อน --</option>';
        }
    });
</script>
@endsection