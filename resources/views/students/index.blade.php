@extends('layouts.app')
@section('title', 'รายการนักศึกษา')
@section('breadcrumb') <span>รายการนักศึกษา</span> @endsection

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="bi bi-building"></i></div>
            <div>
                <div class="stat-label">คณะทั้งหมด</div>
                {{-- ปลดคอมเมนต์และเปลี่ยนชื่อตัวแปรตามที่ส่งมาจาก Controller (เช่น $totalFaculties) --}}
                <div class="stat-val">{{ $totalFaculties ?? 0 }}</div> 
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon si-teal"><i class="bi bi-diagram-3"></i></div>
            <div>
                <div class="stat-label">สาขาวิชาทั้งหมด</div>
                <div class="stat-val">{{ $totalPrograms }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon si-amber"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-label">นักศึกษาทั้งหมด</div>
                <div class="stat-val">{{ $totalStudents }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Toolbar --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ url('students') }}">
            <div class="d-flex gap-3 align-items-center">
                <div class="input-group" style="max-width:360px">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search"
                           class="form-control border-start-0 bg-light"
                           placeholder="ค้นหาชื่อนักศึกษา หรือรหัสนักศึกษา..."
                           value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i> ค้นหา
                </button>
                @if(request('search'))
                    <a href="{{ url('students') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> ล้าง
                    </a>
                @endif
                <a href="{{ url('students/add') }}" class="btn btn-success ms-auto px-4">
                    <i class="bi bi-plus-lg me-1"></i> เพิ่มนักศึกษาใหม่
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table of Students --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-people text-primary"></i>
            รายการนักศึกษา
        </h6>
        <span class="badge bg-primary rounded-pill">
            {{ $students->total() }} คน
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width:50px">#</th>
                        <th style="width:120px">รหัสนักศึกษา</th>
                        <th style="width:200px">ชื่อนักศึกษา</th>
                        <th style="width:200px">สาขาวิชา</th>
                        <th style="width:200px">คณะ</th>
                        <th>ที่อยู่</th>
                        <th class="text-center" style="width:150px">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $i => $s)
                    @php
                        $colors = [
                            0 => ["bg" => "#e6f1fb", "color" => "#0c447c"],
                            1 => ["bg" => "#e1f5ee", "color" => "#085041"],
                            2 => ["bg" => "#faeeda", "color" => "#633806"],
                            3 => ["bg" => "#eeedfe", "color" => "#3c3489"],
                        ];
                        $c = $colors[$i % 4];
                        $programName = $s->program ? $s->program->program_name : 'N/A';
                        $initials = mb_strtoupper(mb_substr($programName, 0, 2));
                    @endphp
                    <tr>
                        <td class="ps-4 text-muted" style="font-size:13px">
                            {{ $students->firstItem() + $i }}
                        </td>
                        <td class="fw-semibold" style="font-size:14px">
                            {{ $s->student_id }}
                        </td>
                        <td>{{ $s->student_name }}</td>
                        <td>
                            <span class="badge-program text-truncate d-inline-block" style="max-width: 180px;" title="{{ $programName }}">
                                {{ $programName }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-faculty-id">
                                {{ $s->program && $s->program->faculty ? $s->program->faculty->faculty_name : 'N/A' }}
                            </span>
                        </td>
                        <td class="text-muted" style="font-size:13px;">
                            {{ Str::limit($s->address, 40) }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ url('students/edit/'.$s->student_id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> แก้ไข
                                </a>

                                <form action="{{ url('students/delete/' . $s->student_id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('คุณต้องการลบนักศึกษา {{ $s->student_name }} ใช่หรือไม่?')">
                                    @csrf
                                    <button type="submit" class="btn-action btn-action-del">
                                        <i class="bi bi-trash"></i> ลบ
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-people-fill fs-1 text-muted d-block mb-2"></i>
                            <span class="text-muted">ไม่พบข้อมูลนักศึกษา</span>
                            <div class="mt-2">
                                <a href="{{ url('students/add') }}" class="btn btn-sm btn-primary">
                                    + เพิ่มนักศึกษาคนแรก
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($students->hasPages())
    <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between py-3">
        <span class="text-muted" style="font-size:13px">
            แสดง {{ $students->firstItem() }}–{{ $students->lastItem() }} จาก {{ $students->total() }} รายการ
        </span>
        {{ $students->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection

@section('styles')
<style>
    .stat-card {
        background: #fff; border: 1px solid #e9ecef;
        border-radius: 10px; padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: 14px;
    }
    .stat-icon {
        width: 42px; height: 42px; border-radius: 10px;
        display: flex; align-items: center;
        justify-content: center; font-size: 20px; flex-shrink: 0;
    }
    .si-blue  { background: #e6f1fb; color: #185fa5; }
    .si-teal  { background: #e1f5ee; color: #0f6e56; }
    .si-amber { background: #faeeda; color: #854f0b; }
    .stat-label { font-size: 12px; color: #6c757d; margin-bottom: 3px; }
    .stat-val   { font-size: 22px; font-weight: 500; }

    .badge-faculty-id {
        background: #eeedfe; color: #3c3489;
        padding: 4px 10px; border-radius: 20px;
        font-size: 12px; font-weight: 500;
    }
    .badge-program {
        background: #e6f1fb; color: #0c447c;
        padding: 4px 10px; border-radius: 6px;
        font-size: 12px; font-weight: 500;
    }
    .btn-action {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 5px 10px; border-radius: 5px;
        font-size: 12px; font-weight: 500;
        border: none; cursor: pointer; text-decoration: none;
    }
    .btn-action-edit { background: #faeeda; color: #633806; }
    .btn-action-del  { background: #fcebeb; color: #791f1f; }
    .btn-action:hover { opacity: .85; }
</style>
@endsection