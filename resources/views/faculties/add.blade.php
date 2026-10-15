@extends('layouts.app')

@section('title', 'เพิ่มคณะใหม่')

@section('breadcrumb')
    {{-- <a href="{{ route('faculties.index') }}">รายการคณะ</a> --}}
    <i class="bi bi-chevron-right" style="font-size:11px"></i>
    <span>เพิ่มคณะใหม่</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card border-0 shadow-sm rounded-3">

            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-building-add text-primary"></i>
                    เพิ่มคณะใหม่
                </h6>
            </div>

            {{-- Form Body --}}
            <div class="card-body p-4">
                    <form action="{{ URL('faculties/create') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            รหัสคณะ
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="faculty_id"
                               class="form-control @error('faculty_id') is-invalid @enderror"
                               value="{{ old('faculty_id') }}"
                               placeholder="เช่น 1,2,3,4"
                               maxlength="100">
                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            กรอกรหัสคณะ 1 หลัก
                        </div>
                    </div>

                    {{-- ชื่อคณะภาษาไทย --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ชื่อคณะ (ภาษาไทย)
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="faculty_name"
                               class="form-control @error('faculty_name') is-invalid @enderror"
                               value="{{ old('faculty_name') }}"
                               placeholder="เช่น คณะวิทยาศาสตร์และเทคโนโลยี"
                               maxlength="100"
                               autofocus>
                        @error('faculty_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            กรอกชื่อคณะเต็มเป็นภาษาไทย
                        </div>
                    </div>


                   {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        {{-- <a href="{{ route('faculties.index') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a> --}}
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-1"></i> บันทึกคณะ
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
        background: #e6f1fb;
        border: 1px solid #b5d4f4;
        border-radius: 8px;
        padding: .65rem .9rem;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 12.5px;
        color: #0c447c;
    }
    .info-box i {
        font-size: 15px;
        color: #185fa5;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .preview-card {
        background: #f0f4f8;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: .75rem 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .preview-avatar {
        width: 38px; height: 38px;
        border-radius: 8px;
        background: #e6f1fb;
        color: #0c447c;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .preview-label {
        font-size: 10.5px;
        color: #6c757d;
        margin-bottom: 2px;
    }
    .preview-name {
        font-size: 13.5px;
        font-weight: 500;
        color: #1a1a19;
    }
</style>
@endsection

@section('scripts')
<script>
    // Live preview ชื่อคณะ
    const nameInput   = document.querySelector('input[name="faculty_name"]');
    const previewName = document.getElementById('preview-name');
    const previewAvatar = document.getElementById('preview-avatar');

    nameInput.addEventListener('input', function () {
        const val = this.value.trim();
        previewName.textContent   = val || 'ชื่อคณะที่กรอก';
        previewAvatar.textContent = val ? val.substring(0, 2) : 'คณะ';
    });
</script>
@endsection