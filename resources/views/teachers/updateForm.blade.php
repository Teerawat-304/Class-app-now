@extends('layouts.app')

@section('hero')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

        <a href="{{ URL('teachers') }}" class="btn btn-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i>กลับ
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger rounded-4">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>
                    กรุณาตรวจสอบข้อมูลที่กรอก
                    <ul class="mb-0 mt-2 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ URL('teachers/update/'.$teacher->teacher_id) }}">
                @csrf
                @method('POST')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">
                            ชื่อ-นามสกุลอาจารย์ <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="teacher_name"
                               class="form-control rounded-pill px-3 @error('teacher_name') is-invalid @enderror"
                               value="{{ old('teacher_name', $teacher->teacher_name) }}" required>
                        @error('teacher_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">
                            อีเมล <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="t_email"
                               class="form-control rounded-pill px-3 @error('t_email') is-invalid @enderror"
                               value="{{ old('t_email', $teacher->t_email) }}" required>
                        @error('t_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">
                            คณะ <span class="text-danger">*</span>
                        </label>
                        <select name="t_faculty_id" id="facultySelect"
                                class="form-select rounded-pill px-3 @error('t_faculty_id') is-invalid @enderror" required>
                            <option value="">-- เลือกคณะ --</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->faculty_id }}"
                                    {{ old('t_faculty_id', $teacher->t_faculty_id) == $faculty->faculty_id ? 'selected' : '' }}>
                                    {{ $faculty->faculty_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('t_faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">
                            สาขา/หลักสูตร <span class="text-danger">*</span>
                        </label>
                        <select name="t_program_id" id="programSelect"
                                class="form-select rounded-pill px-3 @error('t_program_id') is-invalid @enderror" required>
                            <option value="">-- เลือกสาขา/หลักสูตร --</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->program_id }}"
                                    data-faculty="{{ $program->faculty_id }}"
                                    {{ old('t_program_id', $teacher->t_program_id) == $program->program_id ? 'selected' : '' }}>
                                    {{ $program->program_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('t_program_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">
                            ที่อยู่
                        </label>
                        <input type="text" name="t_address"
                               class="form-control rounded-pill px-3 @error('t_address') is-invalid @enderror"
                               value="{{ old('t_address', $teacher->t_address) }}">
                        @error('t_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">
                            ชื่อผู้ใช้ (Username) <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="t_username"
                               class="form-control rounded-pill px-3 @error('t_username') is-invalid @enderror"
                               value="{{ old('t_username', $teacher->t_username) }}" required>
                        @error('t_username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">
                            สิทธิ์การใช้งาน <span class="text-danger">*</span>
                        </label>
                        <select name="t_role"
                                class="form-select rounded-pill px-3 @error('t_role') is-invalid @enderror" required>
                            <option value="1" {{ old('t_role', $teacher->t_role) == 1 ? 'selected' : '' }}>
                                อาจารย์ทั่วไป
                            </option>
                            <option value="0" {{ old('t_role', $teacher->t_role) == 0 ? 'selected' : '' }}>
                                ผู้ดูแลระบบ (Admin)
                            </option>
                        </select>
                        @error('t_role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ URL('teachers') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        ยกเลิก
                    </a>
                    <button type="submit" class="btn text-white rounded-pill px-4" style="background:#1e3a5f;">
                        <i class="bi bi-save me-1"></i>บันทึกการแก้ไข
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // กรองรายการสาขาตามคณะที่เลือก (client-side, ไม่ต้องยิง AJAX)
    document.addEventListener('DOMContentLoaded', function () {
        const facultySelect = document.getElementById('facultySelect');
        const programSelect = document.getElementById('programSelect');
        const allProgramOptions = Array.from(programSelect.options).slice(1); // เก็บ option ทั้งหมดไว้ (ยกเว้นตัวแรก)

        function filterPrograms(keepSelected = false) {
            const selectedFaculty = facultySelect.value;
            const currentSelected = programSelect.value;

            programSelect.innerHTML = '<option value="">-- เลือกสาขา/หลักสูตร --</option>';

            allProgramOptions.forEach(option => {
                if (!selectedFaculty || option.dataset.faculty === selectedFaculty) {
                    const cloned = option.cloneNode(true);
                    if (keepSelected && cloned.value === currentSelected) {
                        cloned.selected = true;
                    }
                    programSelect.appendChild(cloned);
                }
            });
        }

        facultySelect.addEventListener('change', () => filterPrograms(false));

        // โหลดหน้าแรก: กรองตามคณะที่เลือกไว้เดิม พร้อมคงค่าสาขาที่เคยเลือกไว้
        if (facultySelect.value) {
            filterPrograms(true);
        }
    });
</script>
@endsection