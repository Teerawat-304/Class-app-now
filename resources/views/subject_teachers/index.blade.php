@extends('layouts.app')

@section('title', 'กำหนดอาจารย์ผู้สอนประจำรายวิชา')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-icon-blue"><i class="bi bi-person-video3"></i></div>
            <div>
                <div class="stat-label">การมอบหมายผู้สอนทั้งหมด</div>
                <div class="stat-value">{{ $totalAssignments }} รายการ</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-icon-green"><i class="bi bi-journal-check"></i></div>
            <div>
                <div class="stat-label">วิชาที่มีผู้สอนแล้ว</div>
                <div class="stat-value">{{ $totalSubjectsAssigned }} วิชา</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-icon-purple"><i class="bi bi-person-badge"></i></div>
            <div>
                <div class="stat-label">อาจารย์ที่ได้รับมอบหมาย</div>
                <div class="stat-value">{{ $totalTeachersAssigned }} ท่าน</div>
            </div>
        </div>
    </div>
</div>

{{-- Toolbar --}}
<div class="toolbar-card mb-4">
    <form method="GET" action="{{ route('subject-teachers.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
        <div class="search-box flex-grow-1">
            <i class="bi bi-search"></i>
            <input type="text"
                   name="search"
                   class="search-input"
                   placeholder="ค้นหารหัสวิชา, ชื่อวิชา, หรือชื่ออาจารย์..."
                   value="{{ $search }}">
        </div>
        <button type="submit" class="btn btn-search">
            <i class="bi bi-funnel-fill me-1"></i> ค้นหา
        </button>
        <a href="{{ url('/subjects') }}" class="btn btn-outline-secondary rounded-pill px-3" style="font-size:13.5px;">
            <i class="bi bi-journal-bookmark me-1"></i> หน้ารายวิชา
        </a>
        <a href="{{ route('subject-teachers.add') }}" class="btn btn-add ms-auto">
            <i class="bi bi-plus-lg me-1"></i> กำหนดผู้สอนใหม่
        </a>
    </form>
</div>

{{-- Table Card --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-lines-fill"></i>
            <span class="fw-semibold" style="color:#1e3a5f">รายการการกำหนดอาจารย์ผู้สอน</span>
        </div>
        <span class="count-pill">{{ $assignments->total() }} รายการ</span>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0 custom-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>รหัสวิชา</th>
                    <th>ชื่อรายวิชา</th>
                    <th>อาจารย์ผู้สอน</th>
                    <th>คณะ / สาขาวิชา</th>
                    <th class="text-end" style="width: 150px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignments as $index => $item)
                <tr>
                    <td>{{ $assignments->firstItem() + $index }}</td>
                    <td>
                        <span class="badge bg-light text-dark border px-2 py-1 font-monospace fw-bold">
                            {{ $item->subject_code }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $item->subject->subject_name ?? '-' }}</div>
                        <small class="text-muted">{{ $item->subject->credit ?? 0 }} หน่วยกิต</small>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <span class="fw-semibold text-primary">
                                    {{ $item->teacher->teacher_name ?? 'ไม่พบข้อมูลอาจารย์' }}
                                </span>
                                @if($item->teacher && $item->teacher->t_email)
                                    <div class="small text-muted" style="font-size:11.5px;">
                                        {{ $item->teacher->t_email }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="badge bg-secondary-subtle text-secondary-emphasis" style="font-size:11.5px;">
                                {{ $item->teacher->faculty->faculty_name ?? 'ไม่ระบุคณะ' }}
                            </span>
                        </div>
                        @if($item->teacher && $item->teacher->program)
                        <div class="small text-muted mt-1" style="font-size:11.5px;">
                            {{ $item->teacher->program->program_name }}
                        </div>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('subject-teachers.edit', $item->id) }}" class="btn btn-edit-pill me-1" title="แก้ไขการกำหนด">
                            <i class="bi bi-pencil-fill me-1"></i> แก้ไข
                        </a>
                        <button type="button"
                                class="btn btn-delete-circle"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="{{ $item->id }}"
                                data-subject="{{ $item->subject_code }} {{ $item->subject->subject_name ?? '' }}"
                                data-teacher="{{ $item->teacher->teacher_name ?? '' }}"
                                title="ยกเลิกการกำหนดผู้สอน">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-inbox text-muted fs-1 d-block mb-2"></i>
                        @if($search)
                            ไม่พบข้อมูลที่ตรงกับคำค้นหา "{{ $search }}"
                        @else
                            ยังไม่มีข้อมูลการกำหนดอาจารย์ผู้สอนประจำวิชา
                        @endif
                        <div class="mt-3">
                            <a href="{{ route('subject-teachers.add') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-lg me-1"></i> กำหนดอาจารย์ผู้สอนคนแรก
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($assignments->hasPages())
    <div class="d-flex justify-content-center py-3 border-top">
        {{ $assignments->links() }}
    </div>
    @endif
</div>

{{-- Modal ยืนยันการลบ / ยกเลิก --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2.5rem"></i>
                </div>
                <h6 class="fw-semibold mb-2">ยืนยันการยกเลิกการกำหนดผู้สอน</h6>
                <p class="text-muted mb-1" style="font-size:13.5px">
                    ต้องการยกเลิกอาจารย์ <span class="fw-bold text-dark" id="modalTeacherName"></span>
                </p>
                <p class="text-muted mb-0" style="font-size:13px">
                    จากวิชา: <span class="fw-semibold text-primary" id="modalSubjectName"></span>
                </p>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    ยกเลิก
                </button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash me-1"></i> ยืนยันยกเลิก
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    /* ---------- Stat Cards ---------- */
    .stat-card {
        background: #fff; border: 1px solid #e9ecef; border-radius: 14px;
        padding: 1.3rem 1.5rem; display: flex; align-items: center; gap: 16px;
    }
    .stat-icon {
        width: 52px; height: 52px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; flex-shrink: 0;
    }
    .bg-icon-blue   { background: #dbeafe; color: #2563eb; }
    .bg-icon-green  { background: #dcfce7; color: #16a34a; }
    .bg-icon-purple { background: #f3e8ff; color: #9333ea; }
    .stat-label { font-size: 13px; color: #64748b; margin-bottom: 2px; }
    .stat-value { font-size: 24px; font-weight: 700; color: #1e293b; line-height: 1.1; }

    /* ---------- Toolbar ---------- */
    .toolbar-card {
        background: #fff; border: 1px solid #e9ecef; border-radius: 14px;
        padding: 1.1rem 1.3rem;
    }
    .search-box {
        position: relative; max-width: 480px;
    }
    .search-box i {
        position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
        color: #9aa5b1; font-size: 15px;
    }
    .search-input {
        width: 100%; border: 1px solid #e2e6ea; background: #f8f9fb;
        border-radius: 999px; padding: .6rem 1rem .6rem 2.6rem;
        font-size: 13.5px; outline: none;
    }
    .search-input:focus { border-color: #1e3a5f; background: #fff; }

    .btn-search {
        background: #1e5fd9; color: #fff; border: none;
        border-radius: 999px; padding: .55rem 1.4rem;
        font-size: 13.5px; font-weight: 600;
    }
    .btn-search:hover { background: #174bb0; color: #fff; }

    .btn-add {
        background: #1e8e5a; color: #fff; border: none;
        border-radius: 999px; padding: .55rem 1.4rem;
        font-size: 13.5px; font-weight: 600; white-space: nowrap;
    }
    .btn-add:hover { background: #17714a; color: #fff; }

    /* ---------- Table Card ---------- */
    .table-card {
        background: #fff; border: 1px solid #e9ecef; border-radius: 14px;
        overflow: hidden;
    }
    .table-card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.5rem; border-bottom: 1px solid #eef0f2;
    }
    .table-card-header i { color: #1e3a5f; font-size: 17px; }
    .count-pill {
        background: #1e5fd9; color: #fff; font-size: 12px; font-weight: 600;
        padding: 3px 12px; border-radius: 999px;
    }

    .custom-table thead th {
        font-size: 13px; color: #495057; font-weight: 700;
        border-bottom: 1px solid #eef0f2; padding: .9rem 1.2rem;
        background: #fafbfc;
    }
    .custom-table tbody td {
        padding: .9rem 1.2rem; font-size: 13.5px; color: #212529;
        border-bottom: 1px solid #f4f5f6;
    }

    .avatar-sm {
        width: 34px; height: 34px; border-radius: 50%;
        background: #e0e7ff; color: #4338ca;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }

    .btn-edit-pill {
        background: #fdf1d9; color: #b8860b; border: none;
        border-radius: 999px; padding: .38rem .9rem;
        font-size: 12.5px; font-weight: 600; text-decoration: none;
    }
    .btn-edit-pill:hover { background: #f9e4b7; color: #8a660a; }

    .btn-delete-circle {
        background: #fde3e1; color: #d9534f; border: none;
        width: 32px; height: 32px; border-radius: 999px;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .btn-delete-circle:hover { background: #f8c9c5; color: #b52d2a; }
</style>
@endsection

@section('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const teacher = button.getAttribute('data-teacher');
            const subject = button.getAttribute('data-subject');

            document.getElementById('modalTeacherName').textContent = teacher;
            document.getElementById('modalSubjectName').textContent = subject;
            document.getElementById('deleteForm').action = `/subject-teachers/${id}/delete`;
        });
    }
</script>
@endsection

