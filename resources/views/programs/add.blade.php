@extends('layouts.app')

@section('title', 'เพิ่มสาขาวิชาใหม่')

@section('breadcrumb')
    <a href="{{ url('programs') }}">สาขาวิชา</a>
    <i class="bi bi-chevron-right" style="font-size:11px"></i>
    <span>เพิ่มสาขาวิชาใหม่</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card border-0 shadow-sm rounded-3">

            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3 text-primary"></i>
                    เพิ่มสาขาวิชาใหม่
                </h6>
            </div>

            <div class="card-body p-4">

                {{-- Info Box --}}
                <div class="info-box mb-4">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        กรอกข้อมูลสาขาวิชาให้ครบถ้วน
                        และเลือกคณะที่สาขาวิชานี้สังกัดอยู่
                    </div>
                </div>

                <form action="{{ url('programs/create') }}"
                      method="POST" id="programForm">
                    @csrf

                    {{-- รหัสสาขาวิชา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            รหัสสาขาวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="program_id"
                               id="program_id"
                               class="form-control @error('program_id') is-invalid @enderror"
                               value="{{ old('program_id') }}"
                               placeholder="เช่น CS001, IT002, ACC003"
                               maxlength="10"
                               autofocus>
                        @error('program_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            รหัสสาขาวิชาต้องไม่ซ้ำกัน ความยาวไม่เกิน 10 ตัวอักษร
                        </div>
                    </div>

                    {{-- ชื่อสาขาวิชา --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            ชื่อสาขาวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="program_name"
                               id="program_name"
                               class="form-control @error('program_name') is-invalid @enderror"
                               value="{{ old('program_name') }}"
                               placeholder="เช่น วิทยาการคอมพิวเตอร์"
                               maxlength="100">
                        @error('program_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-3">

                    {{-- Dropdown คณะ --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            คณะที่สังกัด
                            <span class="text-danger ms-1">*</span>
                        </label>

                        <select name="faculty_id"
                                id="faculty_id"
                                class="form-select @error('faculty_id') is-invalid @enderror">
                            <option value="">-- เลือกคณะ --</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->faculty_id }}"
                                    data-name="{{ $faculty->faculty_name }}"
                                    {{ old('faculty_id') == $faculty->faculty_id
                                        ? 'selected' : '' }}>
                                    {{ $faculty->faculty_name }}
                                    ({{ $faculty->faculty_id }})
                                </option>
                            @endforeach
                        </select>

                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            เลือกคณะที่สาขาวิชานี้สังกัดอยู่
                        </div>

                        {{-- Faculty Preview --}}
                        <div class="faculty-preview mt-2" id="facultyPreview">
                            <div class="fac-preview-icon" id="previewIcon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <div class="fac-preview-label">คณะที่เลือก</div>
                                <div class="fac-preview-val"
                                     id="previewFacultyName">
                                    ยังไม่ได้เลือกคณะ
                                </div>
                            </div>
                            <div class="ms-auto">
                                <span class="badge-fac-id"
                                      id="previewFacultyId"
                                      style="display:none">
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- Preview ข้อมูลที่จะบันทึก
                    <div class="preview-section">
                        <div class="preview-title">
                            <i class="bi bi-eye"></i>
                            ตัวอย่างข้อมูลที่จะบันทึก
                        </div>
                        <div class="preview-row">
                            <div class="preview-dot"></div>
                            <span class="preview-key">รหัสสาขา</span>
                            <span class="preview-val" id="prev-id">—</span>
                        </div>
                        <div class="preview-row">
                            <div class="preview-dot"></div>
                            <span class="preview-key">ชื่อสาขา</span>
                            <span class="preview-val" id="prev-name">—</span>
                        </div>
                        <div class="preview-row">
                            <div class="preview-dot"></div>
                            <span class="preview-key">สังกัดคณะ</span>
                            <span class="preview-val" id="prev-faculty">—</span>
                        </div>
                    </div> --}}

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ url('programs') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-1"></i> บันทึกสาขาวิชา
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('styles')
<style>
    .info-box {
        background: #e6f1fb; border: 1px solid #b5d4f4;
        border-radius: 8px; padding: .65rem .9rem;
        display: flex; align-items: flex-start;
        gap: 8px; font-size: 12.5px; color: #0c447c;
    }
    .info-box i { font-size: 15px; color: #185fa5;
                  flex-shrink: 0; margin-top: 1px; }

    .faculty-preview {
        background: #f0f4f8; border: 1px solid #e9ecef;
        border-radius: 8px; padding: .7rem 1rem;
        display: flex; align-items: center; gap: 10px;
        transition: all .2s;
    }
    .faculty-preview.selected {
        background: #e6f1fb; border-color: #b5d4f4;
    }
    .fac-preview-icon {
        width: 36px; height: 36px; border-radius: 8px;
        background: #dee2e6; color: #6c757d;
        font-size: 14px; font-weight: 500;
        display: flex; align-items: center;
        justify-content: center; flex-shrink: 0;
        transition: all .2s;
    }
    .fac-preview-icon.active {
        background: #185fa5; color: #fff;
    }
    .fac-preview-label { font-size: 10.5px; color: #6c757d; margin-bottom: 2px; }
    .fac-preview-val   { font-size: 13px; font-weight: 500; }

    .badge-fac-id {
        background: #185fa5; color: #fff;
        padding: 2px 9px; border-radius: 10px;
        font-size: 11px; font-weight: 500;
    }

    .preview-section {
        background: #f0f4f8; border: 1px solid #e9ecef;
        border-radius: 8px; padding: .9rem 1rem;
    }
    .preview-title {
        font-size: 11px; font-weight: 500; color: #6c757d;
        text-transform: uppercase; letter-spacing: .05em;
        margin-bottom: .6rem;
        display: flex; align-items: center; gap: 5px;
    }
    .preview-row {
        display: flex; align-items: center; gap: 8px;
        font-size: 12.5px; margin-bottom: .35rem;
    }
    .preview-row:last-child { margin-bottom: 0; }
    .preview-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: #185fa5; flex-shrink: 0;
    }
    .preview-key  { color: #6c757d; min-width: 90px; }
    .preview-val  { color: #1a1a19; font-weight: 500; }
</style>
@endsection

@section('scripts')
<script>
    const programIdInput   = document.getElementById('program_id');
    const programNameInput = document.getElementById('program_name');
    const facultySelect    = document.getElementById('faculty_id');
    const facultyPreview   = document.getElementById('facultyPreview');
    const previewIcon      = document.getElementById('previewIcon');
    const previewFacName   = document.getElementById('previewFacultyName');
    const previewFacId     = document.getElementById('previewFacultyId');
    const prevId           = document.getElementById('prev-id');
    const prevName         = document.getElementById('prev-name');
    const prevFaculty      = document.getElementById('prev-faculty');

    // อัปเดต preview รหัสสาขา
    programIdInput.addEventListener('input', function () {
        prevId.textContent = this.value.trim() || '—';
    });

    // อัปเดต preview ชื่อสาขา
    programNameInput.addEventListener('input', function () {
        prevName.textContent = this.value.trim() || '—';
    });

    // อัปเดต preview คณะ เมื่อเปลี่ยน dropdown
    facultySelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const facName  = selected.getAttribute('data-name');
        const facId    = this.value;

        if (facId) {
            // แสดง faculty preview
            facultyPreview.classList.add('selected');
            previewIcon.classList.add('active');
            previewIcon.textContent = facName
                ? facName.substring(0, 2)
                : facId.substring(0, 2);

            previewFacName.textContent  = facName || facId;
            previewFacId.textContent    = facId;
            previewFacId.style.display  = 'inline-block';
            prevFaculty.textContent     = facName || facId;
        } else {
            // รีเซ็ต
            facultyPreview.classList.remove('selected');
            previewIcon.classList.remove('active');
            previewIcon.innerHTML       = '<i class="bi bi-building"></i>';
            previewFacName.textContent  = 'ยังไม่ได้เลือกคณะ';
            previewFacId.style.display  = 'none';
            prevFaculty.textContent     = '—';
        }
    });

    // โหลดค่าเดิมกรณี validation error (old values)
    window.addEventListener('DOMContentLoaded', function () {
        if (facultySelect.value) {
            facultySelect.dispatchEvent(new Event('change'));
        }
        if (programIdInput.value)   prevId.textContent   = programIdInput.value;
        if (programNameInput.value) prevName.textContent = programNameInput.value;
    });
</script>
@endsection