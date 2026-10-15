@extends('layouts.app')

@section('title', 'เพิ่มรายวิชาใหม่')

@section('breadcrumb')
    <a href="{{URL('subjects') }}">รายวิชา</a>
    <i class="bi bi-chevron-right" style="font-size:11px"></i>
    <span>เพิ่มรายวิชาใหม่</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card border-0 shadow-sm rounded-3">

            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-journal-plus text-primary"></i>
                    เพิ่มรายวิชาใหม่
                </h6>
            </div>

            <div class="card-body p-4">

                <div class="info-box mb-4">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>กรอกรหัสวิชา ชื่อวิชา และหน่วยกิตให้ครบถ้วน</div>
                </div>

                <form action="{{ URL('subjects/store') }}" method="POST">
                    @csrf

                    {{-- รหัสวิชา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            รหัสวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="subject_code"
                               class="form-control @error('subject_code') is-invalid @enderror"
                               value="{{ old('subject_code') }}"
                               placeholder="เช่น CS1010"
                               maxlength="7"
                               autofocus>
                        @error('subject_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            ไม่เกิน 7 ตัวอักษร และต้องไม่ซ้ำกับรายวิชาอื่น
                        </div>
                    </div>

                    {{-- ชื่อวิชา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ชื่อวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="subject_name"
                               class="form-control @error('subject_name') is-invalid @enderror"
                               value="{{ old('subject_name') }}"
                               placeholder="เช่น การเขียนโปรแกรมเบื้องต้น"
                               maxlength="255">
                        @error('subject_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- หน่วยกิต --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            หน่วยกิต
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="number"
                               name="credit"
                               class="form-control @error('credit') is-invalid @enderror"
                               value="{{ old('credit') }}"
                               placeholder="เช่น 3"
                               min="1" max="9">
                        @error('credit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ URL('subjects') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-1"></i> บันทึกรายวิชา
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
</style>
@endsection