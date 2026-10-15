<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการลงทะเบียน | ARU Student System</title>
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
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <div>
                <a href="{{ route('student.dashboard') }}" class="text-white text-decoration-none small opacity-75">
                    <i class="bi bi-arrow-left me-1"></i> กลับหน้าหลัก
                </a>
                <h4 class="mb-0 fw-bold mt-1"><i class="bi bi-clock-history me-2"></i>ประวัติการลงทะเบียนเรียน</h4>
                <small class="opacity-85">ARU Student System</small>
            </div>
            <a href="{{ route('student.course_register.create') }}" class="btn btn-light btn-sm rounded-pill px-3">
                <i class="bi bi-plus-circle me-1"></i> ลงทะเบียนเพิ่ม
            </a>
        </div>
    </div>

    <div class="container-main">

        @if(session('success'))
            <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger rounded-4 mb-3">{{ session('error') }}</div>
        @endif

        @if($registers->isEmpty())
            <div class="card-panel text-center py-5">
                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50 text-muted"></i>
                <h6 class="fw-bold">ยังไม่มีประวัติการลงทะเบียนเรียน</h6>
                <p class="small text-muted mb-3">คุณยังไม่ได้ลงทะเบียนรายวิชาใดๆ ในระบบ</p>
                <a href="{{ route('student.course_register.create') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                    ลงทะเบียนเรียนตอนนี้
                </a>
            </div>
        @else
            @foreach($registers as $reg)
                <div class="card-panel">
                    <div class="semester-header">
                        <div>
                            <span class="fw-bold text-dark fs-6">
                                <i class="bi bi-calendar3 me-2 text-primary"></i>ภาคเรียนที่ {{ $reg->semester }}
                            </span>
                            @if($reg->register_date)
                                <small class="text-muted ms-2">
                                    (วันที่ลงทะเบียน: {{ \Carbon\Carbon::parse($reg->register_date)->format('d/m/Y') }})
                                </small>
                            @endif
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">
                            {{ $reg->details->count() }} รายวิชา
                            ({{ $reg->details->sum(fn($d) => $d->subject->credit ?? 0) }} หน่วยกิต)
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อรายวิชา</th>
                                    <th class="text-center">หน่วยกิต</th>
                                    <th>อาจารย์ผู้สอน</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reg->details as $d)
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
                                        <td class="text-muted small">
                                            <i class="bi bi-person me-1"></i>{{ $d->teacher->teacher_name ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">ไม่มีข้อมูลวิชาในภาคเรียนนี้</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center mt-3">
                {{ $registers->links() }}
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

