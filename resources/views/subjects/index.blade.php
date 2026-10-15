@extends('layouts.app')

@section('title', 'จัดการรายวิชา')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-icon-blue"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div>
                <div class="stat-label">รายวิชาทั้งหมด</div>
                <div class="stat-value">{{ $totalSubjects }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-icon-tan"><i class="bi bi-award-fill"></i></div>
            <div>
                <div class="stat-label">หน่วยกิตรวมทั้งหมด</div>
                <div class="stat-value">{{ $totalCredits }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Toolbar --}}
<div class="toolbar-card mb-4">
    <form method="GET" action="{{ URL('subjects') }}" class="d-flex flex-wrap gap-2 align-items-center">
        <div class="search-box flex-grow-1">
            <i class="bi bi-search"></i>
            <input type="text"
                   name="search"
                   class="search-input"
                   placeholder="ค้นหารหัสวิชา หรือชื่อวิชา..."
                   value="{{ $search }}">
        </div>
        <button type="submit" class="btn btn-search">
            <i class="bi bi-funnel-fill me-1"></i> ค้นหา
        </button>
        <a href="{{ route('subject-teachers.index') }}" class="btn btn-outline-primary rounded-pill px-3" style="font-size:13.5px; font-weight:600;">
            <i class="bi bi-person-video3 me-1"></i> จัดการผู้สอนทั้งหมด
        </a>
        <a href="{{ URL('subjects/add') }}" class="btn btn-add ms-auto">
            <i class="bi bi-plus-lg me-1"></i> เพิ่มรายวิชาใหม่
        </a>
    </form>
</div>

{{-- Table Card --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-journal-bookmark-fill"></i>
            <span class="fw-semibold" style="color:#1e3a5f">รายการรายวิชา</span>
        </div>
        <span class="count-pill">{{ $subjects->total() }} วิชา</span>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0 custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>รหัสวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>หน่วยกิต</th>
                    <th>อาจารย์ผู้สอน</th>
                    <th class="text-end">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $index => $subject)
                <tr>
                    <td>{{ $subjects->firstItem() + $index }}</td>
                    <td class="fw-bold">{{ $subject->subject_code }}</td>
                    <td><span class="pill-badge">{{ $subject->subject_name }}</span></td>
                    <td>{{ $subject->credit }}</td>
                    <td>
                        @if($subject->subjectTeachers && $subject->subjectTeachers->count() > 0)
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                @foreach($subject->subjectTeachers as $st)
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle d-inline-flex align-items-center gap-1 py-1 px-2" style="font-size:12px; font-weight:500;">
                                        <i class="bi bi-person-fill"></i>
                                        {{ $st->teacher->teacher_name ?? 'ไม่พบชื่อ' }}
                                    </span>
                                @endforeach
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary rounded-circle p-0 d-inline-flex align-items-center justify-content-center"
                                        style="width:22px; height:22px;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#assignTeacherModal"
                                        data-code="{{ $subject->subject_code }}"
                                        data-name="{{ $subject->subject_name }}"
                                        title="เพิ่มผู้สอนวิชานี้">
                                    <i class="bi bi-plus" style="font-size:14px;"></i>
                                </button>
                            </div>
                        @else
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-muted border" style="font-size:11.5px; font-weight: normal;">
                                    <i class="bi bi-dash-circle me-1"></i>ยังไม่กำหนด
                                </span>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill"
                                        style="font-size:11.5px;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#assignTeacherModal"
                                        data-code="{{ $subject->subject_code }}"
                                        data-name="{{ $subject->subject_name }}">
                                    <i class="bi bi-person-plus-fill me-1"></i>กำหนด
                                </button>
                            </div>
                        @endif
                    </td>
                    <td class="text-end">
                        <button type="button"
                                class="btn btn-assign-pill me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#assignTeacherModal"
                                data-code="{{ $subject->subject_code }}"
                                data-name="{{ $subject->subject_name }}"
                                title="กำหนดอาจารย์ผู้สอน">
                            <i class="bi bi-person-plus-fill me-1"></i> กำหนดผู้สอน
                        </button>
                        <a href="{{ URL('subjects/edit/' . $subject->subject_code) }}" class="btn btn-edit-pill">
                            <i class="bi bi-pencil-fill me-1"></i> แก้ไข
                        </a>
                        <button type="button"
                                class="btn btn-delete-circle"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="{{ $subject->subject_code }}"
                                data-name="{{ $subject->subject_name }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        @if($search)
                            ไม่พบรายวิชาที่ตรงกับ "{{ $search }}"
                        @else
                            ยังไม่มีข้อมูลรายวิชาในระบบ
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center py-3">
        {{ $subjects->links() }}
    </div>
</div>

{{-- Modal กำหนดอาจารย์ผู้สอน --}}
<div class="modal fade" id="assignTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="stat-icon bg-icon-blue" style="width:36px; height:36px; font-size:16px;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold mb-0">กำหนดอาจารย์ผู้สอน</h6>
                        <small class="text-muted" id="assignSubjectDisplay"></small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('subject-teachers.store') }}">
                @csrf
                <input type="hidden" name="from_subjects" value="1">
                <input type="hidden" name="subject_code" id="assignSubjectCode" value="">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">วิชาที่เลือก</label>
                        <input type="text" id="assignSubjectName" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalTeacherSelect" class="form-label fw-semibold text-dark">
                            เลือกอาจารย์ผู้สอน <span class="text-danger">*</span>
                        </label>
                        <select name="teacher_id" id="modalTeacherSelect" class="form-select select-custom" required>
                            <option value="">-- เลือกอาจารย์ผู้สอน --</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->teacher_id }}">
                                    {{ $t->teacher_name }}
                                    @if($t->faculty)
                                        — คณะ{{ $t->faculty->faculty_name }}
                                    @endif
                                    @if($t->program)
                                        ({{ $t->program->program_name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i> รายวิชานี้สามารถกำหนดอาจารย์ผู้สอนได้มากกว่า 1 ท่าน
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> บันทึกการกำหนดผู้สอน
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal ยืนยันการลบ --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2.5rem"></i>
                </div>
                <h6 class="fw-semibold mb-2">ยืนยันการลบรายวิชา</h6>
                <p class="text-muted mb-0" style="font-size:13.5px">
                    ต้องการลบรายวิชา
                    <span class="fw-semibold" id="deleteSubjectName"></span>
                    ใช่หรือไม่? การลบนี้ไม่สามารถย้อนกลับได้
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
                        <i class="bi bi-trash me-1"></i> ลบข้อมูล
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
    .bg-icon-blue { background: #dbeafe; color: #2563eb; }
    .bg-icon-tan  { background: #fde9c8; color: #b8860b; }
    .stat-label { font-size: 13.5px; color: #495057; margin-bottom: 2px; }
    .stat-value { font-size: 28px; font-weight: 700; color: #1e293b; line-height: 1.1; }

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
        border-bottom: 1px solid #eef0f2; padding: .9rem 1.5rem;
        background: #fff;
    }
    .custom-table tbody td {
        padding: .9rem 1.5rem; font-size: 13.5px; color: #212529;
        border-bottom: 1px solid #f4f5f6;
    }

    .pill-badge {
        background: #e5f0fc; color: #1e5fd9; font-size: 12.5px; font-weight: 500;
        padding: 4px 12px; border-radius: 999px; display: inline-block;
    }

    .btn-assign-pill {
        background: #e0f2fe; color: #0284c7; border: none;
        border-radius: 999px; padding: .38rem .9rem;
        font-size: 12.5px; font-weight: 600;
    }
    .btn-assign-pill:hover { background: #bae6fd; color: #0369a1; }

    .btn-edit-pill {
        background: #fdf1d9; color: #b8860b; border: none;
        border-radius: 999px; padding: .38rem 1rem;
        font-size: 12.5px; font-weight: 600;
    }
    .btn-edit-pill:hover { background: #f9e4b7; color: #8a660a; }

    .btn-delete-circle {
        background: #fde3e1; color: #d9534f; border: none;
        width: 34px; height: 34px; border-radius: 999px;
        display: inline-flex; align-items: center; justify-content: center;
        margin-left: 6px;
    }
    .btn-delete-circle:hover { background: #f8c9c5; color: #b52d2a; }
</style>
@endsection

@section('scripts')
<script>
    const assignModal = document.getElementById('assignTeacherModal');
    if (assignModal) {
        assignModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const code = button.getAttribute('data-code');
            const name = button.getAttribute('data-name');

            document.getElementById('assignSubjectCode').value = code;
            document.getElementById('assignSubjectName').value = `[${code}] ${name}`;
            document.getElementById('assignSubjectDisplay').textContent = `รหัสวิชา ${code}`;
        });
    }

    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id   = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');

            document.getElementById('deleteSubjectName').textContent = name;
            document.getElementById('deleteForm').action = `/subjects/destroy/${id}`;
        });
    }
</script>
@endsection