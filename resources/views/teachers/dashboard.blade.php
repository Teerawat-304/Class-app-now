<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลักอาจารย์ | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
        .topbar {
            background: linear-gradient(135deg, #d97706 0%, #92400e 100%);
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
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .subject-row {
            border: 1px solid #e2e8f0; border-radius: 14px; padding: 1rem 1.25rem;
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.75rem;
        }
        .subject-code-badge {
            background: #fef3c7; color: #92400e; border-radius: 50px;
            padding: 0.3rem 0.8rem; font-weight: 700; font-size: 0.85rem;
        }
        .count-badge {
            background: #f1f5f9; color: #475569; border-radius: 50px;
            padding: 0.3rem 0.8rem; font-size: 0.82rem;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <div>
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-workspace me-2"></i>{{ $teacher->teacher_name }}</h5>
                <small class="opacity-85">ภาคเรียนปัจจุบัน {{ $semester }}</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('teacher.history') }}" class="btn btn-light btn-sm rounded-pill px-3">
                    <i class="bi bi-clock-history me-1"></i> ประวัติย้อนหลัง
                </a>
                <form method="GET" action="{{ route('teacher.logout') }}">
                    @csrf
                    <button class="btn btn-light btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> ออกจากระบบ
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-main">
        @if(session('success'))
            <div class="alert alert-success rounded-4">{{ session('success') }}</div>
        @endif

        <div class="card-panel">
            <h6 class="fw-bold mb-3"><i class="bi bi-journal-bookmark-fill me-2 text-warning"></i>รายวิชาที่สอนภาคเรียนนี้</h6>

            @forelse($mySubjects as $st)
            <div class="subject-row">
                <div>
                    <span class="subject-code-badge">{{ $st->subject_code }}</span>
                    <span class="ms-2 fw-semibold">{{ $st->subject->subject_name ?? '-' }}</span>
                    <span class="count-badge ms-2">
                        <i class="bi bi-people-fill me-1"></i>{{ $st->enrolled_count }} คนลงทะเบียน
                    </span>
                </div>
                <div>
                    <a href="{{ route('teacher.scores.summary', $st->subject_code) }}"
                       class="btn btn-sm rounded-pill px-3 btn-outline-secondary"
                       style="background:#d97706;color:#fff;">
                        <i class="bi bi-bar-chart-fill me-1"></i> สรุปผล
                    </a>

                    <a href="{{ route('teacher.scores.edit', $st->subject_code) }}"
                       class="btn btn-sm rounded-pill px-3" style="background:#d97706;color:#fff;">
                        <i class="bi bi-pencil-square me-1"></i> ดูรายชื่อ / กรอกคะแนน
                    </a>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-4 mb-0">ยังไม่มีวิชาที่รับผิดชอบสอน</p>
            @endforelse
        </div>
    </div>
</body>
</html>