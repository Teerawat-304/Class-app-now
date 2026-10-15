<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการสอน | ARU Student System</title>
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
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); margin-bottom: 1.5rem;
        }
        .semester-badge {
            background: #fef3c7; color: #92400e; border-radius: 50px;
            padding: 0.35rem 0.9rem; font-size: 0.85rem; font-weight: 600;
        }
        .subject-code-badge {
            background: #f1f5f9; color: #475569; border-radius: 8px;
            padding: 0.25rem 0.6rem; font-size: 0.82rem; font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <a href="{{ route('teacher.dashboard') }}" class="back-link mb-2 d-inline-block">
                <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
            </a>
            <h5 class="mb-0 fw-bold mt-1"><i class="bi bi-clock-history me-2"></i>ประวัติการสอนย้อนหลัง</h5>
        </div>
    </div>

    <div class="container-main">
        @forelse($details as $semester => $bySubject)
        <div class="card-panel">
            <span class="semester-badge mb-3 d-inline-block">
                <i class="bi bi-calendar3 me-1"></i>ภาคเรียน {{ $semester }}
            </span>

            @foreach($bySubject as $subject_code => $rows)
            <h6 class="mt-3 mb-2">
                <span class="subject-code-badge">{{ $subject_code }}</span>
                <span class="ms-2 fw-semibold">{{ $rows->first()->subject->subject_name ?? '-' }}</span>
            </h6>
            <div class="table-responsive mb-3">
                <table class="table table-sm align-middle">
                    <thead class="text-muted small">
                        <tr><th>รหัสนักศึกษา</th><th>ชื่อ-นามสกุล</th><th class="text-center">รวม</th><th class="text-center">เกรด</th></tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $d)
                        <tr>
                            <td>{{ $d->register->student->student_id ?? '-' }}</td>
                            <td>{{ $d->register->student->student_name ?? '-' }}</td>
                            <td class="text-center">{{ $d->total_score }}</td>
                            <td class="text-center"><span class="badge bg-secondary">{{ $d->grade ?: '-' }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
        @empty
        <div class="card-panel text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
            ยังไม่มีประวัติการสอนในภาคเรียนก่อนหน้า
        </div>
        @endforelse
    </div>
</body>
</html>