<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิกอาจารย์ | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #d97706 0%, #92400e 100%);
            font-family: 'Segoe UI', sans-serif; padding: 2rem 1rem;
        }
        .register-card {
            background: #fff; border-radius: 24px; padding: 2.5rem 2rem;
            width: 100%; max-width: 640px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        .register-icon {
            width: 70px; height: 70px; border-radius: 50%;
            background: #fef3c7; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
        }
        .register-icon i { font-size: 1.8rem; color: #d97706; }
        .form-control, .form-select { border-radius: 16px; padding: 0.6rem 1rem; }
        .form-control:focus, .form-select:focus {
            border-color: #d97706; box-shadow: 0 0 0 0.2rem rgba(217,119,6,0.15);
        }
        .input-group .form-control { border-radius: 16px 0 0 16px; }
        .btn-toggle {
            border-radius: 0 16px 16px 0; border: 1px solid #ced4da; border-left: none; background: #fff;
        }
        .btn-register {
            background: #d97706; border: none; border-radius: 50px;
            padding: 0.65rem; font-weight: 600; color: #fff;
        }
        .btn-register:hover { background: #92400e; color: #fff; }
        .strength-bar { height: 6px; border-radius: 4px; background: #e9ecef; overflow: hidden; margin-top: 6px; }
        .strength-fill { height: 100%; width: 0%; transition: all .3s; background: #dc3545; }
        .pw-checklist { font-size: 0.78rem; margin-top: 6px; }
        .pw-checklist li { color: #adb5bd; transition: color .2s; }
        .pw-checklist li.valid { color: #198754; }
        .pw-checklist li.valid i.bi-circle::before { content: "\f26a"; }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="text-center">
            <div class="register-icon"><i class="bi bi-person-workspace"></i></div>
            <h4 class="fw-bold mb-1" style="color:#d97706;">สมัครสมาชิกอาจารย์</h4>
            <p class="text-muted small mb-4">ARU Student System</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('teacher.register.submit') }}" id="registerForm">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">ชื่อ-นามสกุล</label>
                    <input type="text" name="teacher_name" value="{{ old('teacher_name') }}"
                           class="form-control" placeholder="ชื่อ-นามสกุล" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">อีเมล</label>
                    <input type="email" name="t_email" value="{{ old('t_email') }}"
                           class="form-control" placeholder="example@email.com" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">คณะ</label>
                    <select name="t_faculty_id" id="t_faculty_id" class="form-select" required>
                        <option value="">-- เลือกคณะ --</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->faculty_id }}" {{ old('t_faculty_id') == $f->faculty_id ? 'selected' : '' }}>
                                {{ $f->faculty_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">สาขาวิชา</label>
                    <select name="t_program_id" id="t_program_id" class="form-select" required>
                        <option value="">-- เลือกคณะก่อน --</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">ที่อยู่</label>
                    <input type="text" name="t_address" value="{{ old('t_address') }}"
                           class="form-control" placeholder="ที่อยู่ปัจจุบัน" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">ชื่อผู้ใช้ (Username)</label>
                    <input type="text" name="t_username" value="{{ old('t_username') }}"
                           class="form-control" placeholder="ใช้สำหรับเข้าสู่ระบบ" required>
                </div>
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">รหัสผ่าน</label>
                    <div class="input-group">
                        <input type="password" name="t_password" id="password" class="form-control"
                               placeholder="กรอกรหัสผ่าน" required>
                        <button type="button" class="btn btn-toggle" onclick="toggle('password','icon1')">
                            <i class="bi bi-eye" id="icon1"></i>
                        </button>
                    </div>
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                    <ul class="pw-checklist list-unstyled">
                        <li id="chk-length"><i class="bi bi-circle"></i> อย่างน้อย 8 ตัวอักษร</li>
                        <li id="chk-upper"><i class="bi bi-circle"></i> ตัวพิมพ์ใหญ่</li>
                        <li id="chk-lower"><i class="bi bi-circle"></i> ตัวพิมพ์เล็ก</li>
                        <li id="chk-number"><i class="bi bi-circle"></i> ตัวเลข</li>
                        <li id="chk-symbol"><i class="bi bi-circle"></i> อักขระพิเศษ</li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">ยืนยันรหัสผ่าน</label>
                    <div class="input-group">
                        <input type="password" name="t_password_confirmation" id="password_confirmation"
                               class="form-control" placeholder="ยืนยันรหัสผ่าน" required>
                        <button type="button" class="btn btn-toggle" onclick="toggle('password_confirmation','icon2')">
                            <i class="bi bi-eye" id="icon2"></i>
                        </button>
                    </div>
                    <small id="matchMsg" class="d-block mt-1"></small>
                </div>
            </div>

            <button type="submit" class="btn btn-register w-100 mt-4">
                <i class="bi bi-person-check me-1"></i> สมัครสมาชิก
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('teacher.login') }}" class="small text-muted text-decoration-none">
                มีบัญชีอยู่แล้ว? <span class="fw-semibold" style="color:#d97706;">เข้าสู่ระบบ</span>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggle(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        // cascading dropdown faculty -> program
        function loadPrograms(facultyId, selectedProgramId) {
            const programSelect = document.getElementById('t_program_id');
            programSelect.innerHTML = '<option value="">กำลังโหลด...</option>';

            if (!facultyId) {
                programSelect.innerHTML = '<option value="">-- เลือกคณะก่อน --</option>';
                return;
            }

            fetch(`/programs/by-faculty/${facultyId}`)
                .then(res => res.json())
                .then(data => {
                    programSelect.innerHTML = '<option value="">-- เลือกสาขาวิชา --</option>';
                    data.forEach(p => {
                        const isSelected = selectedProgramId && selectedProgramId == p.program_id ? 'selected' : '';
                        programSelect.innerHTML += `<option value="${p.program_id}" ${isSelected}>${p.program_name}</option>`;
                    });
                })
                .catch(() => {
                    programSelect.innerHTML = '<option value="">โหลดข้อมูลไม่สำเร็จ</option>';
                });
        }

        document.getElementById('t_faculty_id').addEventListener('change', function () {
            loadPrograms(this.value, null);
        });

        // เมื่อหน้าโหลดแล้วมีค่าเก่าอยู่ (กรณี validation ไม่ผ่าน)
        const oldFaculty = document.getElementById('t_faculty_id').value;
        const oldProgram = "{{ old('t_program_id') }}";
        if (oldFaculty) {
            loadPrograms(oldFaculty, oldProgram);
        }

        // password strength + checklist
        const pwInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthFill = document.getElementById('strengthFill');
        const matchMsg = document.getElementById('matchMsg');

        pwInput.addEventListener('input', function () {
            const val = this.value;
            let score = 0;
            const checks = {
                length: val.length >= 8,
                upper: /[A-Z]/.test(val),
                lower: /[a-z]/.test(val),
                number: /[0-9]/.test(val),
                symbol: /[^A-Za-z0-9]/.test(val),
            };
            Object.entries(checks).forEach(([key, valid]) => {
                const el = document.getElementById('chk-' + key);
                el.classList.toggle('valid', valid);
                if (valid) score++;
            });
            const pct = (score / 5) * 100;
            strengthFill.style.width = pct + '%';
            strengthFill.style.background = score <= 2 ? '#dc3545' : score <= 4 ? '#ffc107' : '#198754';
            checkMatch();
        });

        confirmInput.addEventListener('input', checkMatch);

        function checkMatch() {
            if (!confirmInput.value) { matchMsg.textContent = ''; return; }
            if (pwInput.value === confirmInput.value) {
                matchMsg.textContent = 'รหัสผ่านตรงกัน';
                matchMsg.className = 'd-block mt-1 text-success';
            } else {
                matchMsg.textContent = 'รหัสผ่านไม่ตรงกัน';
                matchMsg.className = 'd-block mt-1 text-danger';
            }
        }
    </script>
</body>
</html>