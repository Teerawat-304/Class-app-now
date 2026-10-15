@extends('layouts.app')

@section('title', 'เพิ่มข้อมูลนักศึกษาใหม่')

@section('breadcrumb')
    <a href="{{ url('students') }}">นักศึกษา</a>
    <i class="bi bi-chevron-right" style="font-size:11px"></i>
    <span>เพิ่มข้อมูลนักศึกษาใหม่</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card border-0 shadow-sm rounded-3">

            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3 text-primary"></i>
                    เพิ่มข้อมูลนักศึกษาใหม่
                </h6>
            </div>

            <div class="card-body p-4">

                {{-- Info Box --}}
                <div class="info-box mb-4">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        กรอกข้อมูลนักศึกษาให้ครบถ้วน และเลือกคณะและสาขาวิชาที่นักศึกษาสังกัดอยู่
                    </div>
                </div>

                <form action="{{ url('students/create') }}"
                      method="POST" id="studentForm">
                    @csrf

                    {{-- รหัสนักศึกษา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            รหัสนักศึกษา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="student_id"
                               id="student_id"
                               class="form-control @error('student_id') is-invalid @enderror"
                               value="{{ old('student_id') }}"
                               placeholder="เช่น 65011234, 66012345"
                               maxlength="20"
                               autofocus>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            รหัสนักศึกษาต้องไม่ซ้ำกัน ความยาวไม่เกิน 20 ตัวอักษร
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
                               value="{{ old('student_name') }}"
                               placeholder="เช่น นายสมชาย ใจดี"
                               maxlength="100">
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     {{-- Dropdown คณะ (ไม่แสดง preview) --}}
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
                                    {{ old('faculty_id') == $faculty->faculty_id
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
                                class="form-select @error('program_id') is-invalid @enderror"
                                disabled>
                            <option value="">-- กรุณาเลือกคณะก่อน --</option>
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
                               value="{{ old('birth_date') }}"
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
                               value="{{ old('email') }}"
                               placeholder="เช่น somchai@aru.ac.th หรือ student@email.com"
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
                               value="{{ old('address') }}"
                               placeholder="เช่น 123 หมู่ 1 ต.ประตูชัย อ.พระนครศรีอยุธยา จ.พระนครศรีอยุธยา"
                               maxlength="100">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-secondary mb-3" style="font-size: 14px;">
                        <i class="bi bi-shield-lock me-1"></i> บัญชีผู้ใช้งานสำหรับนักศึกษา
                    </h6>

                    {{-- ชื่อผู้ใช้งาน --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ชื่อผู้ใช้งาน (Username)
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="username"
                               id="username"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username') }}"
                               placeholder="เช่น 65011234"
                               maxlength="50"
                               autocomplete="off">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            ใช้สำหรับเข้าสู่ระบบ แนะนำให้ใช้รหัสนักศึกษาเป็นชื่อผู้ใช้
                        </div>
                    </div>

                    {{-- รหัสผ่าน --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            รหัสผ่าน
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="กำหนดรหัสผ่าน (อย่างน้อย 6-8 ตัวอักษร)"
                                   autocomplete="new-password">
                            <button class="btn btn-outline-secondary"
                                    type="button"
                                    id="togglePassword"
                                    tabindex="-1">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        {{-- แถบวัดความปลอดภัยของรหัสผ่าน --}}
                        <div class="strength-wrap mt-2" id="strengthWrap" style="display:none">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-label" id="strengthLabel"></div>
                        </div>

                        {{-- เช็คลิสต์เงื่อนไขความปลอดภัย --}}
                        <div class="card bg-light border-0 p-2 mt-2">
                            <ul class="password-checklist" id="passwordChecklist">
                                <li id="check-length">
                                    <i class="bi bi-circle"></i> ความยาวอย่างน้อย 6-8 ตัวอักษร
                                </li>
                                <li id="check-upper">
                                    <i class="bi bi-circle"></i> ตัวพิมพ์ใหญ่ (A-Z) อย่างน้อย 1 ตัว
                                </li>
                                <li id="check-lower">
                                    <i class="bi bi-circle"></i> ตัวพิมพ์เล็ก (a-z) อย่างน้อย 1 ตัว
                                </li>
                                <li id="check-number">
                                    <i class="bi bi-circle"></i> ตัวเลข (0-9) อย่างน้อย 1 ตัว
                                </li>
                                <li id="check-special">
                                    <i class="bi bi-circle"></i> อักขระพิเศษ (!@#$%^&* ฯลฯ)
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- ยืนยันรหัสผ่าน --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ยืนยันรหัสผ่าน
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               placeholder="กรอกรหัสผ่านอีกครั้ง"
                               autocomplete="new-password">
                        <div class="form-text mt-1" id="matchFeedback" style="font-size:12px; font-weight: 500;"></div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ url('students') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-1"></i> บันทึกข้อมูลนักศึกษา
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

    /* Password strength meter */
    .strength-bar {
        height: 6px; border-radius: 3px;
        background: #e9ecef; overflow: hidden;
    }
    .strength-fill {
        height: 100%; width: 0%;
        border-radius: 3px;
        transition: width .25s ease, background-color .25s ease;
    }
    .strength-label {
        font-size: 11.5px; font-weight: 600;
        margin-top: 4px;
    }

    /* Password checklist */
    .password-checklist {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4px 12px;
    }
    @media (max-width: 576px) {
        .password-checklist {
            grid-template-columns: 1fr;
        }
    }
    .password-checklist li {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color .2s;
    }
    .password-checklist li i {
        font-size: 13px;
    }
    .password-checklist li.valid {
        color: #16a34a;
        font-weight: 500;
    }
</style>
@endsection

@section('scripts')
<script>
    /* ---------- Dropdown สาขาวิชา (โหลดตามคณะที่เลือก) ---------- */
    const facultySelect = document.getElementById('faculty_id');
    const programSelect = document.getElementById('program_id');
    const oldProgramId  = "{{ old('program_id') }}";

    function loadPrograms(facultyId, selectedProgramId = null) {
        programSelect.innerHTML = '<option value="">กำลังโหลดสาขาวิชา...</option>';
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

    facultySelect.addEventListener('change', function () {
        loadPrograms(this.value);
    });

    window.addEventListener('DOMContentLoaded', function () {
        if (facultySelect.value) {
            loadPrograms(facultySelect.value, oldProgramId);
        }
    });

    /* ---------- เชื่อมโยงรหัสนักศึกษากับชื่อผู้ใช้ (Auto-fill username) ---------- */
    const studentIdInput = document.getElementById('student_id');
    const usernameInput  = document.getElementById('username');
    let usernameManuallyChanged = false;

    if (usernameInput && studentIdInput) {
        usernameInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                usernameManuallyChanged = true;
            }
        });

        studentIdInput.addEventListener('input', function() {
            if (!usernameManuallyChanged || usernameInput.value === '') {
                usernameInput.value = this.value;
            }
        });
    }

    /* ---------- ปุ่มแสดง/ซ่อนรหัสผ่าน ---------- */
    const passwordInput = document.getElementById('password');
    const toggleBtn     = document.getElementById('togglePassword');
    const toggleIcon    = document.getElementById('toggleIcon');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });
    }

    /* ---------- ตรวจสอบความปลอดภัยของรหัสผ่าน ---------- */
    const strengthWrap  = document.getElementById('strengthWrap');
    const strengthFill  = document.getElementById('strengthFill');
    const strengthLabel = document.getElementById('strengthLabel');

    const rules = {
        length : { el: document.getElementById('check-length'),  test: v => v.length >= 6 },
        upper  : { el: document.getElementById('check-upper'),   test: v => /[A-Z]/.test(v) },
        lower  : { el: document.getElementById('check-lower'),   test: v => /[a-z]/.test(v) },
        number : { el: document.getElementById('check-number'),  test: v => /[0-9]/.test(v) },
        special: { el: document.getElementById('check-special'), test: v => /[^A-Za-z0-9]/.test(v) },
    };

    function setCheck(item, passed) {
        if (!item || !item.el) return;
        const icon = item.el.querySelector('i');
        item.el.classList.toggle('valid', passed);
        if (icon) {
            icon.classList.toggle('bi-circle', !passed);
            icon.classList.toggle('bi-check-circle-fill', passed);
        }
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function () {
            const value = this.value;

            if (!value) {
                if (strengthWrap) strengthWrap.style.display = 'none';
            } else {
                if (strengthWrap) strengthWrap.style.display = 'block';
            }

            let passedCount = 0;
            Object.values(rules).forEach(rule => {
                const passed = rule.test(value);
                setCheck(rule, passed);
                if (passed) passedCount++;
            });

            const percent = (passedCount / 5) * 100;
            if (strengthFill) strengthFill.style.width = percent + '%';

            if (strengthLabel) {
                if (passedCount <= 2) {
                    if (strengthFill) strengthFill.style.backgroundColor = '#dc3545';
                    strengthLabel.textContent = 'ความปลอดภัย: ต่ำ';
                    strengthLabel.style.color = '#dc3545';
                } else if (passedCount <= 3) {
                    if (strengthFill) strengthFill.style.backgroundColor = '#fd7e14';
                    strengthLabel.textContent = 'ความปลอดภัย: ปานกลาง';
                    strengthLabel.style.color = '#fd7e14';
                } else {
                    if (strengthFill) strengthFill.style.backgroundColor = '#198754';
                    strengthLabel.textContent = 'ความปลอดภัย: สูง';
                    strengthLabel.style.color = '#198754';
                }
            }

            checkMatch();
        });
    }

    /* ---------- ตรวจสอบรหัสผ่านยืนยันให้ตรงกัน ---------- */
    const confirmInput  = document.getElementById('password_confirmation');
    const matchFeedback = document.getElementById('matchFeedback');

    function checkMatch() {
        if (!confirmInput || !matchFeedback) return;
        if (!confirmInput.value) {
            matchFeedback.textContent = '';
            return;
        }
        if (passwordInput.value === confirmInput.value) {
            matchFeedback.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> รหัสผ่านตรงกัน';
            matchFeedback.style.color = '#198754';
        } else {
            matchFeedback.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> รหัสผ่านไม่ตรงกัน';
            matchFeedback.style.color = '#dc3545';
        }
    }

    if (confirmInput) {
        confirmInput.addEventListener('input', checkMatch);
    }

    /* ---------- ตรวจสอบก่อนส่งฟอร์ม ---------- */
    const studentForm = document.getElementById('studentForm');
    if (studentForm) {
        studentForm.addEventListener('submit', function (e) {
            if (passwordInput && passwordInput.value.length < 6) {
                e.preventDefault();
                alert('กรุณากำหนดรหัสผ่านอย่างน้อย 6 ตัวอักษร');
                passwordInput.focus();
                return;
            }

            if (passwordInput && confirmInput && passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert('รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง');
                confirmInput.focus();
                return;
            }
        });
    }
</script>
@endsection