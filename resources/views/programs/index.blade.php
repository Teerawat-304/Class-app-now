@extends('layouts.app')
@section('title','รายการสาขาวิชา')
@section('breadcrumb')<span>รายการสาขาวิชา</span>@endsection

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="bi bi-diagram-3"></i></div>
            <div>
                <div class="stat-label">สาขาวิชาทั้งหมด</div>
                <div class="stat-val">{{ $programs->total() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon si-amber"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-label">นักศึกษาทั้งหมด</div>
                {{-- <div class="stat-val">{{ $totalStudents }}</div> --}}
            </div>
        </div>
    </div>
</div>

{{-- Toolbar --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ URL('programs') }}">
            <div class="d-flex gap-3 align-items-center">
                <div class="input-group" style="max-width:360px">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search"
                           class="form-control border-start-0 bg-light"
                           placeholder="ค้นหาชื่อสาขา หรือรหัสสาขา..."
                           value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i> ค้นหา
                </button>
                @if(request('search'))
                    <a href="{{ url('programs') }}"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> ล้าง
                    </a>
                @endif
                <a href="{{ URL('programs/add') }}"
                   class="btn btn-success ms-auto px-4">
                    <i class="bi bi-plus-lg me-1"></i> เพิ่มสาขาวิชาใหม่
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3
                d-flex align-items-center justify-content-between">
        <h6 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-diagram-3 text-primary"></i>
            รายการสาขาวิชา
        </h6>
        <span class="badge bg-primary rounded-pill">
            {{ $programs->total() }} สาขาวิชา
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width:50px">#</th>
                        <th>ชื่อสาขาวิชา</th>
                        <th style="width:130px">รหัสสาขาวิชา</th>
                        <th class="text-center" style="width:110px">นักศึกษา</th>
                        <th class="text-center" style="width:150px">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $i => $p)
                    @php
                        $colors = [
                            0 => ['bg'=>'#e6f1fb','color'=>'#0c447c'],
                            1 => ['bg'=>'#e1f5ee','color'=>'#085041'],
                            2 => ['bg'=>'#faeeda','color'=>'#633806'],
                            3 => ['bg'=>'#eeedfe','color'=>'#3c3489'],
                        ];
                        $c = $colors[$i % 4];
                        $initials = mb_strtoupper(mb_substr($p->program_name, 0, 2));
                    @endphp
                    <tr>
                        <td class="ps-4 text-muted" style="font-size:13px">
                            {{ $programs->firstItem() + $i }}
                        </td>

                        {{-- ชื่อสาขา --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="prog-avatar"
                                     style="background:{{ $c['bg'] }};color:{{ $c['color'] }}">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:14px">
                                        {{ $p->program_name }}
                                    </div>
                                    <div class="text-muted" style="font-size:11px">
                                        ID: {{ $p->program_id }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- รหัสสาขา --}}
                        <td>
                            <span class="badge-program-id">
                                {{ $p->program_id }}
                            </span>
                        </td>

                        {{-- จำนวนนักศึกษา --}}
                        <td class="text-center fw-semibold" style="color:#185fa5">
                            {{-- {{ $p->students->count() }} --}}
                        </td>

                        {{-- ปุ่มจัดการ --}}
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                {{-- <a href="{{ route('program.show', $p->program_id) }}"
                                   class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> ดู
                                </a> --}}
                                <a href="{{ URL('programs/edit', $p->program_id) }}"
                                   class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> แก้ไข
                                </a>
                                <form action="{{ url('programs/delete/' . $p->program_id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('ลบสาขาวิชา {{ $p->program_name }}?')">
                                    @csrf
                                    <button type="submit" class="btn-action btn-action-del">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-diagram-3 fs-1 text-muted d-block mb-2"></i>
                            <span class="text-muted">ไม่พบข้อมูลสาขาวิชา</span>
                            <div class="mt-2">
                               <a href="{{ URL('programs/add') }}"
                                 class="btn btn-sm btn-primary">
                                 + เพิ่มสาขาวิชาแรก
                              </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($programs->hasPages())
    <div class="card-footer bg-white border-top d-flex
                align-items-center justify-content-between py-3">
        <span class="text-muted" style="font-size:13px">
            แสดง {{ $programs->firstItem() }}–{{ $programs->lastItem() }}
            จาก {{ $programs->total() }} รายการ
        </span>
        {{ $programs->appends(request()->query())->links() }}
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

    .prog-avatar {
        width: 36px; height: 36px; border-radius: 8px;
        display: inline-flex; align-items: center;
        justify-content: center; font-size: 13px;
        font-weight: 500; flex-shrink: 0;
    }
    .badge-program-id {
        background: #e6f1fb; color: #0c447c;
        padding: 3px 10px; border-radius: 20px;
        font-size: 12px; font-weight: 500;
    }
    .btn-action {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 4px 10px; border-radius: 5px;
        font-size: 12px; font-weight: 500;
        border: none; cursor: pointer; text-decoration: none;
    }
    .btn-action-view { background: #e6f1fb; color: #0c447c; }
    .btn-action-edit { background: #faeeda; color: #633806; }
    .btn-action-del  { background: #fcebeb; color: #791f1f; }
    .btn-action:hover { opacity: .85; }
</style>
@endsection