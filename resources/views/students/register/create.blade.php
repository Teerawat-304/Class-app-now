<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนเรียน | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
        .topbar {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: #fff; padding: 2rem 0 3.5rem;
        }
        .topbar-content {
            max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;
            display: flex; justify-content: space-between; align-items: flex-start;
        }
        .container-main {
            max-width: 1100px; margin: -2rem auto 2rem; padding: 0 1.5rem;
            position: relative; z-index: 2;
        }
        .card-panel {
            background: #fff; border-radius: 18px; padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); margin-bottom: 1.5rem;
        }
        .subject-row {
            border: 1px solid #e2e8f0; border-radius: 14px; padding: 1rem 1.25rem;
            margin-bottom: 0.75rem; transition: all .2s;
            display: flex; justify-content: space-between; align-items: center;
        }
        .subject-row:hover {
            border-color: #2563eb; background: #f8faff;
        }
        .subject-row.selected {
            border-color: #2563eb; background: #eff6ff;
        }
        .subject-code-badge {
            background: #dbeafe; color: #1e40af; border-radius: 50px;
            padding: 0.3rem 0.8rem; font-weight: 700; font-size: 0.85rem;
        }
        .credit-badge {
            background: #f1f5f9; color: #475569; border-radius: 50px;
            padding: 0.3rem 0.75rem; font-size: 0.82rem; font-weight: 600;
        }
        .form-check-input {
            width: 1.3rem; height: 1.3rem; cursor: pointer;
        }
        .form-check-input:checked {
            background-color: #2563eb; border-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <div>
                <a href="{{ route('student.dashboard') }}" class="text-white text-decoration-none small opacity-75">
                    <i class="bi bi-arrow-left me-1"></i> กลับหน้าหลัก
                </a>
                <h4 class="mb-0 fw-bold mt-1"><i class="bi bi-pencil-square me-2"></i>ลงทะเบียนเรียน</h4>
                <div class="d-flex align-items-center gap-2 mt-2">
                    <span class="opacity-85 small">เลือกภาคเรียน:</span>
                    <form method="GET" action="{{ route('student.course_register.create') }}" id="semesterForm">
                        <select name="semester" class="form-select form-select-sm rounded-pill border-0 shadow-sm px-3" 
                                style="background:#fff; color:#1e40af; font-weight:600; cursor:pointer;"
                                onchange="document.getElementById('semesterForm').submit()">
                            @php
                                $bYear = now()->year + 543;
                                $availableSemesters = [
                                    "1/{$bYear}",
                                    "2/{$bYear}",
                                    "3/{$bYear}",
                                    "1/" . ($bYear - 1),
                                    "2/" . ($bYear - 1),
                                ];
                            @endphp
                            @foreach($availableSemesters as $semOption)
                                <option value="{{ $semOption }}" {{ $semester == $semOption ? 'selected' : '' }}>
                                    ภาคเรียนที่ {{ $semOption }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <a href="{{ route('student.course_register.history') }}" class="btn btn-light btn-sm rounded-pill px-3">
                <i class="bi bi-clock-history me-1"></i> ประวัติการลงทะเบียน
            </a>
        </div>
    </div>

    <div class="container-main">

        @if(session('error'))
            <div class="alert alert-danger rounded-4 mb-3">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 mb-3 py-2 small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('student.course_register.store') }}" id="registerForm">
            @csrf
            <input type="hidden" name="semester" value="{{ $semester }}">

            <div class="card-panel">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>รายวิชาที่เปิดให้ลงทะเบียน
                        </h6>
                        <small class="text-muted">เลือกรายวิชาที่ต้องการลงทะเบียนในภาคเรียนนี้</small>
                    </div>
                    @if($subjectTeachers->isNotEmpty())
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6" id="summaryBadge">
                                เลือกแล้ว: <span id="selectedCount">0</span> วิชา (<span id="selectedCredits">0</span> หน่วยกิต)
                            </span>
                        </div>
                    @endif
                </div>

                @if($subjectTeachers->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                        <h6 class="fw-bold">ไม่มีรายวิชาที่เปิดให้ลงทะเบียน</h6>
                        <p class="small text-muted mb-3">คุณอาจได้ลงทะเบียนครบทุกวิชาแล้ว หรือยังไม่มีวิชาเปิดสอนในภาคเรียนนี้</p>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                            กลับหน้าหลัก
                        </a>
                    </div>
                @else
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label small fw-semibold" for="selectAll">
                                เลือกทั้งหมด
                            </label>
                        </div>
                        <small class="text-muted">คลิกที่แถววิชาเพื่อเลือก/ยกเลิก</small>
                    </div>

                    <div class="subject-list">
                        @foreach($subjectTeachers as $st)
                            @php
                                $credit = $st->subject->credit ?? 0;
                            @endphp
                            <div class="subject-row" onclick="toggleRow(this, event)">
                                <div class="d-flex align-items-center gap-3">
                                    <input class="form-check-input subject-checkbox" type="checkbox"
                                           name="subject_teacher_ids[]" value="{{ $st->id }}"
                                           data-credit="{{ $credit }}">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="subject-code-badge">{{ $st->subject_code }}</span>
                                            <span class="fw-bold text-dark">{{ $st->subject->subject_name ?? '-' }}</span>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>ผู้สอน: {{ $st->teacher->teacher_name ?? '-' }}
                                        </small>
                                    </div>
                                </div>
                                <div>
                                    <span class="credit-badge">{{ $credit }} หน่วยกิต</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="{{ route('student.dashboard') }}" class="btn btn-light rounded-pill px-4">
                            ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSubmit">
                            <i class="bi bi-check-circle me-1"></i> ยืนยันการลงทะเบียน
                        </button>
                    </div>
                @endif
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const checkboxes = document.querySelectorAll('.subject-checkbox');
        const selectAll = document.getElementById('selectAll');
        const countSpan = document.getElementById('selectedCount');
        const creditSpan = document.getElementById('selectedCredits');
        const form = document.getElementById('registerForm');

        function updateSummary() {
            let count = 0;
            let totalCredits = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    count++;
                    totalCredits += parseInt(cb.getAttribute('data-credit') || 0);
                    cb.closest('.subject-row').classList.add('selected');
                } else {
                    cb.closest('.subject-row').classList.remove('selected');
                }
            });
            if (countSpan) countSpan.textContent = count;
            if (creditSpan) creditSpan.textContent = totalCredits;

            if (selectAll) {
                selectAll.checked = (count === checkboxes.length && checkboxes.length > 0);
            }
        }

        function toggleRow(row, event) {
            if (event.target.tagName.toLowerCase() === 'input') return;
            const cb = row.querySelector('.subject-checkbox');
            if (cb) {
                cb.checked = !cb.checked;
                updateSummary();
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateSummary);
        });

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                });
                updateSummary();
            });
        }

        if (form) {
            form.addEventListener('submit', function (e) {
                let anyChecked = false;
                checkboxes.forEach(cb => {
                    if (cb.checked) anyChecked = true;
                });
                if (!anyChecked) {
                    e.preventDefault();
                    alert('กรุณาเลือกวิชาที่ต้องการลงทะเบียนอย่างน้อย 1 วิชา');
                }
            });
        }
    </script>
</body>
</html>

