<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลักนักศึกษา | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; }

.topbar {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: #fff;
    padding: 2rem 0 5.5rem;   /* เพิ่ม padding ล่างให้มากพอ ไม่ให้การ์ดชนขอบ */
    position: relative;
}

.topbar-content {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.topbar-content h5 { margin-bottom: 0.35rem; }
.topbar-content small { display: block; opacity: 0.85; }

.container-main {
    max-width: 1100px;
    margin: -3.5rem auto 2rem;   /* ดึงขึ้นพอดีกับ padding-bottom ของ topbar ไม่ล้น */
    padding: 0 1.5rem;
    position: relative;
    z-index: 2;
}

.stat-card {
    background: #fff; border-radius: 18px; padding: 1.25rem;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06); height: 100%;
}
.stat-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
}
.bg-blue-soft { background: #dbeafe; color: #2563eb; }
.bg-green-soft { background: #dcfce7; color: #16a34a; }
.bg-amber-soft { background: #fef3c7; color: #d97706; }
.bg-pink-soft { background: #fce7f3; color: #db2777; }

.card-panel {
    background: #fff; border-radius: 18px; padding: 1.5rem;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}
.quick-link {
    display: block; text-decoration: none; color: #1e293b;
    background: #f8fafc; border-radius: 14px; padding: 1rem;
    transition: all .2s; border: 1px solid #e2e8f0;
}
.quick-link:hover { background: #eff6ff; border-color: #2563eb; color: #2563eb; }
.badge-pill-soft {
    background: #dbeafe; color: #1e40af; border-radius: 50px;
    padding: 0.4rem 0.9rem; font-size: 0.8rem; font-weight: 600;
    white-space: nowrap;
}
    </style>
</head>
<body>
    <div class="topbar">
    <div class="topbar-content">
        <div>
            <h5 class="mb-0 fw-bold"><i class="bi bi-mortarboard-fill me-2"></i>ARU Student System</h5>
            <small>ระบบสารสนเทศนักศึกษา</small>
        </div>
        <form method="POST" action="{{ route('student.logout') }}">
            @csrf
            <button class="btn btn-light btn-sm rounded-pill px-3">
                <i class="bi bi-box-arrow-right me-1"></i> ออกจากระบบ
            </button>
        </form>
    </div>
</div>

    <div class="container-main">

        @if(session('success'))
            <div class="alert alert-success rounded-4">{{ session('success') }}</div>
        @endif

        {{-- โปรไฟล์ --}}
        <div class="card-panel mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-blue-soft" style="width:64px;height:64px;font-size:1.8rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">{{ $student->student_name }}</h5>
                    <div class="text-muted small">
                        รหัสนักศึกษา {{ $student->student_id }} &nbsp;•&nbsp;
                        {{ $student->faculty->faculty_name ?? '-' }} &nbsp;•&nbsp;
                        {{ $student->program->program_name ?? '-' }}
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form method="GET" action="{{ route('student.dashboard') }}" id="dashboardSemForm">
                    <select name="semester" class="form-select form-select-sm rounded-pill border shadow-sm px-3" 
                            style="background:#f8fafc; color:#1e40af; font-weight:600; cursor:pointer;"
                            onchange="document.getElementById('dashboardSemForm').submit()">
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
                            <option value="{{ $semOption }}" {{ $currentSemester == $semOption ? 'selected' : '' }}>
                                ภาคเรียนที่ {{ $semOption }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-blue-soft mb-2"><i class="bi bi-journal-check"></i></div>
                    <div class="text-muted small">วิชาที่ลงทะเบียนภาคนี้</div>
                    <div class="fs-4 fw-bold">{{ $currentSubjects->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-green-soft mb-2"><i class="bi bi-award"></i></div>
                    <div class="text-muted small">เกรดเฉลี่ยสะสม</div>
                    <div class="fs-4 fw-bold">{{ $overallGpa !== null ? number_format($overallGpa, 2) : '-' }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-amber-soft mb-2"><i class="bi bi-stack"></i></div>
                    <div class="text-muted small">หน่วยกิตสะสม</div>
                    <div class="fs-4 fw-bold">{{ $earnedCredits }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-pink-soft mb-2"><i class="bi bi-clock-history"></i></div>
                    <div class="text-muted small">ภาคเรียนที่ลงทะเบียน</div>
                    <div class="fs-4 fw-bold">{{ $totalSemesters }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- วิชาที่ลงทะเบียนภาคนี้ --}}
            <div class="col-lg-7">
                <div class="card-panel">
                    <h6 class="fw-bold mb-3"><i class="bi bi-journal-text me-2 text-primary"></i>วิชาที่ลงทะเบียนภาคเรียนนี้</h6>

                    @if($currentSubjects->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                            ยังไม่มีการลงทะเบียนในภาคเรียนนี้
                            <div class="mt-3">
                                <a href="{{ route('student.course_register.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                                    ลงทะเบียนเรียนตอนนี้
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="text-muted small">
                                    <tr><th>รหัสวิชา</th><th>ชื่อวิชา</th><th>ผู้สอน</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($currentSubjects as $d)
                                    <tr>
                                        <td>{{ $d->subject_code }}</td>
                                        <td>{{ $d->subject->subject_name ?? '-' }}</td>
                                        <td>{{ $d->teacher->teacher_name ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick links --}}
            <div class="col-lg-5">
                <div class="card-panel">
                    <h6 class="fw-bold mb-3"><i class="bi bi-grid me-2 text-primary"></i>เมนูลัด</h6>
                    <div class="d-grid gap-2">
                        @if (Route::has('student.course_register.create'))
                            <a href="{{ route('student.course_register.create') }}" class="quick-link">
                                <i class="bi bi-plus-circle me-2"></i>ลงทะเบียนเรียน
                            </a>
                        @endif
                        @if (Route::has('student.course_register.history'))
                            <a href="{{ route('student.course_register.history') }}" class="quick-link">
                                <i class="bi bi-clock-history me-2"></i>ประวัติการลงทะเบียน
                            </a>
                        @endif
                        @if (Route::has('student.grades'))
                            <a href="{{ route('student.grades') }}" class="quick-link">
                                <i class="bi bi-journal-check me-2"></i>ผลการเรียน
                            </a>
                        @endif
                        @if (Route::has('student.gpa'))
                            <a href="{{ route('student.gpa') }}" class="quick-link">
                                <i class="bi bi-bar-chart-line me-2"></i>เกรดเฉลี่ยสะสม
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- กราฟแสดงสถิติเกรดที่ได้รับ --}}
        <div class="card-panel mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bar-chart-fill me-2 text-primary"></i>กราฟแสดงสถิติเกรดที่ได้รับสะสม
                </h6>
                <span class="text-muted small">รวมทั้งหมด {{ array_sum($gradeCounts) }} รายวิชา</span>
            </div>
            <div style="max-width: 100%; height: 280px;">
                <canvas id="studentGradeChart"></canvas>
            </div>
        </div>

    </div>

    <script>
        const studentGradeCtx = document.getElementById('studentGradeChart').getContext('2d');
        const gradeLabels = [@foreach($gradeCounts as $grade => $count) '{{ $grade }}', @endforeach];
        const gradeData = [@foreach($gradeCounts as $grade => $count) {{ $count }}, @endforeach];
        const gradeColors = ['#16a34a', '#2563eb', '#3b82f6', '#d97706', '#f59e0b', '#dc2626', '#ef4444', '#991b1b'];

        new Chart(studentGradeCtx, {
            type: 'bar',
            data: {
                labels: gradeLabels,
                datasets: [{
                    label: 'จำนวนวิชา',
                    data: gradeData,
                    backgroundColor: gradeColors,
                    borderRadius: 8,
                    maxBarThickness: 50,
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
                                return `${val} วิชา (${pct}%)`;
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