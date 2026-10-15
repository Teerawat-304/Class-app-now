<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>กรอกคะแนน {{ $subject->subject_code }} | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
        .topbar {
            background: linear-gradient(135deg, #d97706 0%, #92400e 100%);
            color: #fff; padding: 1.75rem 0;
        }
        .topbar-content { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
        .back-link { color: #fff; text-decoration: none; font-size: 0.9rem; opacity: 0.9; }
        .back-link:hover { opacity: 1; color: #fff; }
        .container-main { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }
        .card-panel {
            background: #fff; border-radius: 18px; padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .form-control-score { border-radius: 10px; text-align: center; max-width: 90px; }
        .grade-pill {
            display: inline-block; min-width: 32px; text-align: center;
            border-radius: 50px; padding: 0.2rem 0.6rem; font-weight: 700; font-size: 0.8rem;
            background: #f1f5f9; color: #94a3b8;
        }
        .btn-save {
            background: #d97706; border: none; border-radius: 50px;
            padding: 0.65rem 2rem; font-weight: 600; color: #fff;
        }
        .btn-save:hover { background: #92400e; color: #fff; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <a href="{{ route('teacher.dashboard', ['semester' => $semester]) }}" class="back-link mb-2 d-inline-block">
                    <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
                </a>
                <h5 class="mb-0 fw-bold mt-1">
                    <i class="bi bi-journal-check me-2"></i>{{ $subject->subject_code }} — {{ $subject->subject_name }}
                </h5>
                <small class="opacity-85">หน่วยกิต {{ $subject->credit }}</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="opacity-85 small text-white">ภาคเรียน:</span>
                <form method="GET" action="{{ route('teacher.scores.edit', $subject->subject_code) }}" id="editSemForm">
                    <select name="semester" class="form-select form-select-sm rounded-pill border-0 shadow-sm px-3" 
                            style="background:#fff; color:#92400e; font-weight:600; cursor:pointer;"
                            onchange="document.getElementById('editSemForm').submit()">
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
                <a href="{{ route('teacher.scores.summary', ['subject_code' => $subject->subject_code, 'semester' => $semester]) }}" 
                   class="btn btn-light btn-sm rounded-pill px-3 ms-2">
                    <i class="bi bi-bar-chart-fill me-1"></i> สรุปผล
                </a>
            </div>
        </div>
    </div>

    <div class="container-main">
        @if(session('success'))
            <div class="alert alert-success rounded-4">{{ session('success') }}</div>
        @endif

        <div class="card-panel">
            @if($details->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                    ยังไม่มีนักศึกษาลงทะเบียนวิชานี้ในภาคเรียนนี้
                </div>
            @else
                <form method="POST" action="{{ route('teacher.scores.update', $subject->subject_code) }}">
                    @csrf
                    <input type="hidden" name="semester" value="{{ $semester }}">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small">
                                <tr>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th class="text-center">คะแนนเก็บ<br><small>(0-100)</small></th>
                                    <th class="text-center">กลางภาค<br><small>(0-100)</small></th>
                                    <th class="text-center">ปลายภาค<br><small>(0-100)</small></th>
                                    <th class="text-center">รวม</th>
                                    <th class="text-center">เกรด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($details as $i => $d)
                                <tr>
                                    <td>{{ $d->register->student->student_id ?? '-' }}</td>
                                    <td>{{ $d->register->student->student_name ?? '-' }}</td>
                                    <td class="text-center">
                                        <input type="hidden" name="scores[{{ $i }}][detail_id]" value="{{ $d->detail_id }}">
                                        <input type="number" min="0" max="100"
                                               name="scores[{{ $i }}][subscore]"
                                               value="{{ $d->subscore }}"
                                               class="form-control form-control-sm form-control-score mx-auto" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" min="0" max="100"
                                               name="scores[{{ $i }}][midterm_score]"
                                               value="{{ $d->midterm_score }}"
                                               class="form-control form-control-sm form-control-score mx-auto" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" min="0" max="100"
                                               name="scores[{{ $i }}][final_score]"
                                               value="{{ $d->final_score }}"
                                               class="form-control form-control-sm form-control-score mx-auto" required>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $d->total_score }}</td>
                                    <td class="text-center">
                                        <span class="grade-pill">{{ $d->grade ?: 'รอกรอก' }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-save">
                            <i class="bi bi-save2 me-1"></i> บันทึกคะแนนและตัดเกรด
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</body>
</html>