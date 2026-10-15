<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เกรดเฉลี่ยสะสม (GPA) | ARU Student System</title>
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
        .stat-overall {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff; border-radius: 18px; padding: 2rem; text-align: center;
        }
        .gpa-number {
            font-size: 3.5rem; font-weight: 800; line-height: 1;
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
                <h4 class="mb-0 fw-bold mt-1"><i class="bi bi-bar-chart-line me-2"></i>เกรดเฉลี่ยสะสม (GPA)</h4>
                <small class="opacity-85">ARU Student System</small>
            </div>
            <a href="{{ route('student.grades') }}" class="btn btn-light btn-sm rounded-pill px-3">
                <i class="bi bi-journal-check me-1"></i> ดูผลการเรียนรายวิชา
            </a>
        </div>
    </div>

    <div class="container-main">

        {{-- เกรดเฉลี่ยรวม --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-6 col-lg-5">
                <div class="stat-overall shadow-sm">
                    <div class="small text-white-50 mb-1">เกรดเฉลี่ยสะสมทั้งหมด (GPAX)</div>
                    <div class="gpa-number my-2">{{ number_format($overallGpa, 2) }}</div>
                    <div class="small opacity-75">จากทุกภาคเรียนที่ผ่านการตัดเกรดแล้ว</div>
                </div>
            </div>
        </div>

        {{-- สรุปแต่ละภาคเรียน --}}
        <div class="card-panel">
            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>เกรดเฉลี่ยรายภาคเรียน (GPA)</h6>

            @if(empty($semesterGpa))
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                    ยังไม่มีข้อมูลผลการเรียนที่นำมาคำนวณ GPA ได้
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="text-muted small">
                            <tr>
                                <th>ภาคเรียน</th>
                                <th class="text-end">เกรดเฉลี่ยประจำภาค (GPA)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semesterGpa as $sem => $gpa)
                                <tr>
                                    <td class="fw-semibold text-dark">
                                        <i class="bi bi-calendar3 me-2 text-muted"></i>ภาคเรียนที่ {{ $sem }}
                                    </td>
                                    <td class="text-end fw-bold fs-6 text-primary">
                                        {{ number_format($gpa, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

