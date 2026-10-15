<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ผลการเรียน | ARU Student System</title>
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
        .semester-header {
            background: #f8fafc; border-radius: 12px; padding: 0.75rem 1rem;
            margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;
        }
        .subject-code-badge {
            background: #dbeafe; color: #1e40af; border-radius: 50px;
            padding: 0.25rem 0.7rem; font-weight: 700; font-size: 0.8rem;
        }
        .grade-pill {
            display: inline-block; min-width: 38px; text-align: center;
            border-radius: 50px; padding: 0.25rem 0.65rem; font-weight: 700; font-size: 0.85rem;
        }
        .g-A  { background: #dcfce7; color: #16a34a; }
        .g-Bp { background: #dbeafe; color: #2563eb; }
        .g-B  { background: #dbeafe; color: #2563eb; }
        .g-Cp { background: #fef3c7; color: #d97706; }
        .g-C  { background: #fef3c7; color: #d97706; }
        .g-Dp { background: #fee2e2; color: #dc2626; }
        .g-D  { background: #fee2e2; color: #dc2626; }
        .g-F  { background: #fee2e2; color: #991b1b; }
        .g-pending { background: #f1f5f9; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <div>
                <a href="{{ route('student.dashboard') }}" class="text-white text-decoration-none small opacity-75">
                    <i class="bi bi-arrow-left me-1"></i> กลับหน้าหลัก
                </a>
                <h4 class="mb-0 fw-bold mt-1"><i class="bi bi-journal-check me-2"></i>ผลการเรียน</h4>
                <small class="opacity-85">ARU Student System</small>
            </div>
            <a href="{{ route('student.gpa') }}" class="btn btn-light btn-sm rounded-pill px-3">
                <i class="bi bi-bar-chart-line me-1"></i> ดูเกรดเฉลี่ยสะสม (GPA)
            </a>
        </div>
    </div>

    <div class="container-main">

        @if($details->isEmpty())
            <div class="card-panel text-center py-5">
                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50 text-muted"></i>
                <h6 class="fw-bold">ยังไม่มีข้อมูลผลการเรียน</h6>
                <p class="small text-muted mb-3">ยังไม่มีวิชาที่บันทึกเกรดในระบบ</p>
                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    กลับหน้าหลัก
                </a>
            </div>
        @else
            @foreach($details as $semester => $items)
                <div class="card-panel">
                    <div class="semester-header">
                        <span class="fw-bold text-dark fs-6">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>ภาคเรียนที่ {{ $semester }}
                        </span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">
                            {{ $items->count() }} วิชา ({{ $items->sum(fn($d) => $d->subject->credit ?? 0) }} หน่วยกิต)
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อรายวิชา</th>
                                    <th class="text-center">หน่วยกิต</th>
                                    <th class="text-center">คะแนนรวม</th>
                                    <th class="text-center">เกรด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $gradeClasses = [
                                        'A' => 'g-A', 'B+' => 'g-Bp', 'B' => 'g-B', 'C+' => 'g-Cp',
                                        'C' => 'g-C', 'D+' => 'g-Dp', 'D' => 'g-D', 'F' => 'g-F',
                                    ];
                                @endphp
                                @foreach($items as $d)
                                    <tr>
                                        <td>
                                            <span class="subject-code-badge">{{ $d->subject_code }}</span>
                                        </td>
                                        <td class="fw-semibold text-dark">
                                            {{ $d->subject->subject_name ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $d->subject->credit ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $d->total_score !== null ? $d->total_score : '-' }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $grade = $d->grade;
                                                $gClass = $gradeClasses[$grade] ?? 'g-pending';
                                            @endphp
                                            <span class="grade-pill {{ $gClass }}">{{ $grade ?: 'รอผล' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

