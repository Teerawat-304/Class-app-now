<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สรุปผลคะแนน {{ $subject->subject_code }} | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
        .topbar {
            background: linear-gradient(135deg, #d97706 0%, #92400e 100%);
            color: #fff; padding: 1.75rem 0;
        }
        .topbar-content {
            max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;
            display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;
        }
        .back-link { color: #fff; text-decoration: none; font-size: 0.9rem; opacity: 0.9; }
        .back-link:hover { opacity: 1; color: #fff; }
        .container-main { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }
        .card-panel {
            background: #fff; border-radius: 18px; padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); margin-bottom: 1.5rem;
        }
        .stat-mini {
            background: #f8fafc; border-radius: 14px; padding: 1rem; text-align: center; height: 100%;
        }
        .stat-mini .value { font-size: 1.5rem; font-weight: 800; color: #92400e; }
        .stat-mini .label { font-size: 0.78rem; color: #64748b; }

        .grade-dist-card {
            border-radius: 14px; padding: 0.9rem; text-align: center;
        }
        .grade-dist-card .grade-label { font-weight: 800; font-size: 1.1rem; }
        .grade-dist-card .grade-count { font-size: 1.6rem; font-weight: 800; }
        .grade-dist-card .grade-percent { font-size: 0.75rem; opacity: 0.75; }

        .g-A  { background: #dcfce7; color: #16a34a; }
        .g-Bp { background: #dbeafe; color: #2563eb; }
        .g-B  { background: #dbeafe; color: #2563eb; }
        .g-Cp { background: #fef3c7; color: #d97706; }
        .g-C  { background: #fef3c7; color: #d97706; }
        .g-Dp { background: #fee2e2; color: #dc2626; }
        .g-D  { background: #fee2e2; color: #dc2626; }
        .g-F  { background: #fee2e2; color: #991b1b; }
        .g-pending { background: #f1f5f9; color: #94a3b8; }

        .grade-pill {
            display: inline-block; min-width: 32px; text-align: center;
            border-radius: 50px; padding: 0.2rem 0.6rem; font-weight: 700; font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <div>
                <a href="{{ route('teacher.dashboard') }}" class="back-link mb-2 d-inline-block">
                    <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
                </a>
                <h5 class="mb-0 fw-bold mt-1">
                    <i class="bi bi-bar-chart-fill me-2"></i>สรุปผลคะแนน — {{ $subject->subject_code }} {{ $subject->subject_name }}
                </h5>
                <small class="opacity-85">ภาคเรียน {{ $semester }}</small>
            </div>
            <a href="{{ route('teacher.scores.edit', $subject->subject_code) }}"
               class="btn btn-light btn-sm rounded-pill px-3 align-self-center">
                <i class="bi bi-pencil-square me-1"></i> แก้ไขคะแนน
            </a>
        </div>
    </div>

    <div class="container-main">

        {{-- สถิติภาพรวม --}}
        <div class="row g-3 mb-1">
            <div class="col-6 col-md-3">
                <div class="stat-mini">
                    <div class="value">{{ $details->count() }}</div>
                    <div class="label">นักศึกษาทั้งหมด</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-mini">
                    <div class="value">{{ $avgScore }}</div>
                    <div class="label">คะแนนเฉลี่ย</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-mini">
                    <div class="value">{{ $maxScore ?? '-' }}</div>
                    <div class="label">คะแนนสูงสุด</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-mini">
                    <div class="value">{{ $minScore ?? '-' }}</div>
                    <div class="label">คะแนนต่ำสุด</div>
                </div>
            </div>
        </div>

        {{-- กระจายจำนวนนักศึกษาตามเกรด --}}
        <div class="card-panel">
            <h6 class="fw-bold mb-3"><i class="bi bi-pie-chart-fill me-2 text-warning"></i>สรุปจำนวนนักศึกษาตามเกรด</h6>
            <div class="row g-2">
                @php
                    $gradeClasses = [
                        'A' => 'g-A', 'B+' => 'g-Bp', 'B' => 'g-B', 'C+' => 'g-Cp',
                        'C' => 'g-C', 'D+' => 'g-Dp', 'D' => 'g-D', 'F' => 'g-F',
                    ];
                    $total = $details->count();
                @endphp
                @foreach($gradeCounts as $grade => $count)
                <div class="col-6 col-md-3 col-lg-auto flex-grow-1">
                    <div class="grade-dist-card {{ $gradeClasses[$grade] }}">
                        <div class="grade-label">{{ $grade }}</div>
                        <div class="grade-count">{{ $count }}</div>
                        <div class="grade-percent">{{ $total > 0 ? round($count / $total * 100) : 0 }}%</div>
                    </div>
                </div>
                @endforeach
                <div class="col-6 col-md-3 col-lg-auto flex-grow-1">
                    <div class="grade-dist-card g-pending">
                        <div class="grade-label">รอผล</div>
                        <div class="grade-count">{{ $pendingCount }}</div>
                        <div class="grade-percent">{{ $total > 0 ? round($pendingCount / $total * 100) : 0 }}%</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- กราฟแสดงจำนวนนักศึกษาตามเกรด --}}
        <div class="card-panel">
            <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-warning"></i>กราฟแสดงจำนวนนักศึกษาตามเกรด</h6>
            <div style="max-width: 100%; height: 320px;">
                <canvas id="gradeChart"></canvas>
            </div>
        </div>

        {{-- ตารางรายชื่อพร้อมคะแนน/เกรด --}}
        <div class="card-panel">
            <h6 class="fw-bold mb-3"><i class="bi bi-list-check me-2 text-warning"></i>รายชื่อนักศึกษาและผลคะแนน</h6>

            @if($details->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                    ยังไม่มีนักศึกษาลงทะเบียนวิชานี้ในภาคเรียนนี้
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-muted small">
                            <tr>
                                <th>รหัสนักศึกษา</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th class="text-center">คะแนนเก็บ</th>
                                <th class="text-center">กลางภาค</th>
                                <th class="text-center">ปลายภาค</th>
                                <th class="text-center">รวม</th>
                                <th class="text-center">เกรด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $d)
                            <tr>
                                <td>{{ $d->register->student->student_id ?? '-' }}</td>
                                <td>{{ $d->register->student->student_name ?? '-' }}</td>
                                <td class="text-center">{{ $d->subscore }}</td>
                                <td class="text-center">{{ $d->midterm_score }}</td>
                                <td class="text-center">{{ $d->final_score }}</td>
                                <td class="text-center fw-semibold">{{ $d->total_score }}</td>
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
            @endif
        </div>

    </div>
<script>
    const gradeChartCtx = document.getElementById('gradeChart').getContext('2d');

    const gradeLabels = [@foreach($gradeCounts as $grade => $count) '{{ $grade }}', @endforeach 'รอผล'];
    const gradeData = [@foreach($gradeCounts as $grade => $count) {{ $count }}, @endforeach {{ $pendingCount }}];
    const gradeColors = ['#16a34a', '#2563eb', '#2563eb', '#d97706', '#d97706', '#dc2626', '#dc2626', '#991b1b', '#94a3b8'];

    new Chart(gradeChartCtx, {
        type: 'bar',
        data: {
            labels: gradeLabels,
            datasets: [{
                label: 'จำนวนนักศึกษา',
                data: gradeData,
                backgroundColor: gradeColors,
                borderRadius: 8,
                maxBarThickness: 60,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const total = gradeData.reduce((a, b) => a + b, 0);
                            const val = context.parsed.y;
                            const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                            return `${val} คน (${pct}%)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });
</script>
</body>
</html>
