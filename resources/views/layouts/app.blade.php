<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ARU Student System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; font-family: 'Sarabun', sans-serif; }

        /* Navbar */
        .navbar-main { background: #1e3a5f; height: 60px; padding: 0 1.5rem; }
        .nav-logo { width: 36px; height: 36px; background: rgba(255,255,255,0.15);
                    border-radius: 8px; display: flex; align-items: center;
                    justify-content: center; font-size: 18px; color: #fff; }
        .nav-brand-title { font-size: 15px; font-weight: 500; color: #fff; line-height: 1.2; }
        .nav-brand-sub   { font-size: 11px; color: #aac4e0; }
        .nav-link-main { display: flex; align-items: center; gap: 6px;
                          padding: 6px 14px; border-radius: 6px; font-size: 13px;
                          color: #cde4f7; text-decoration: none; transition: background .15s; }
        .nav-link-main:hover,
        .nav-link-main.active { background: rgba(255,255,255,0.15); color: #fff; }
        .btn-login-nav { display: flex; align-items: center; gap: 5px; padding: 6px 14px;
                          background: #e8f4ff; color: #1e3a5f; border: none;
                          border-radius: 6px; font-size: 13px; font-weight: 500;
                          text-decoration: none; }
        .btn-login-nav:hover { background: #c5dff5; color: #1e3a5f; }

        /* Hero */
        .hero-section { background: #1e3a5f; padding: 2.5rem 1.5rem 3rem;
                         position: relative; overflow: hidden; }
        .hero-deco { position: absolute; right: -40px; top: -40px; width: 220px;
                      height: 220px; border-radius: 50%;
                      background: rgba(255,255,255,0.04); pointer-events: none; }
        .hero-deco2 { position: absolute; right: 60px; bottom: -60px; width: 140px;
                       height: 140px; border-radius: 50%;
                       background: rgba(255,255,255,0.04); pointer-events: none; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px;
                       background: rgba(255,255,255,0.12); color: #aac4e0;
                       font-size: 12px; padding: 4px 12px; border-radius: 20px;
                       margin-bottom: 1rem; }
        .hero-title { font-size: 24px; font-weight: 500; color: #fff;
                       margin-bottom: .5rem; line-height: 1.3; }
        .hero-sub { font-size: 14px; color: #8fb8d8; margin-bottom: 1.5rem; }
        .btn-hero-primary { display: inline-flex; align-items: center; gap: 6px;
                             padding: 9px 20px; background: #fff; color: #1e3a5f;
                             border: none; border-radius: 8px; font-size: 14px;
                             font-weight: 500; text-decoration: none; }
        .btn-hero-secondary { display: inline-flex; align-items: center; gap: 6px;
                               padding: 9px 20px;
                               background: rgba(255,255,255,0.12);
                               color: #fff;
                               border: 0.5px solid rgba(255,255,255,0.25);
                               border-radius: 8px; font-size: 14px;
                               text-decoration: none; }

        /* Stats bar */
        .stats-bar { background: #fff; border-bottom: 1px solid #e9ecef; }
        .stat-item { display: flex; align-items: center; gap: 10px;
                      padding: 1rem 1.5rem; border-right: 1px solid #e9ecef; }
        .stat-item:first-child { padding-left: 1.5rem; }
        .stat-icon { width: 38px; height: 38px; border-radius: 8px;
                      display: flex; align-items: center; justify-content: center;
                      font-size: 18px; flex-shrink: 0; }
        .si-blue   { background: #e6f1fb; color: #185fa5; }
        .si-teal   { background: #e1f5ee; color: #0f6e56; }
        .si-amber  { background: #faeeda; color: #854f0b; }
        .si-purple { background: #eeedfe; color: #534ab7; }
        .si-red    { background: #fcebeb; color: #791f1f; }
        .si-gray   { background: #f1efe8; color: #5f5e5a; }
        .stat-label { font-size: 11px; color: #6c757d; margin-bottom: 2px; }
        .stat-val   { font-size: 18px; font-weight: 500; }

        /* Semester card */
        .sem-card { background: #1e3a5f; border-radius: 12px;
                     padding: 1.1rem 1.25rem; color: #fff; }
        .sem-item-label { font-size: 11px; color: #8fb8d8; margin-bottom: 3px; }
        .sem-item-val   { font-size: 16px; font-weight: 500; color: #fff; }
        .sem-badge { background: rgba(255,255,255,0.15); color: #aac4e0;
                      font-size: 11px; padding: 2px 10px; border-radius: 10px; }

        /* Menu cards */
        .menu-card { background: #fff; border: 1px solid #e9ecef;
                      border-radius: 12px; padding: 1.1rem 1rem;
                      cursor: pointer; transition: border-color .15s;
                      text-decoration: none; display: block; }
        .menu-card:hover { border-color: #185fa5; }
        .mc-icon { width: 42px; height: 42px; border-radius: 10px;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 20px; margin-bottom: 10px; }
        .mc-title { font-size: 13.5px; font-weight: 500; color: #1a1a19;
                     margin-bottom: 3px; }
        .mc-desc  { font-size: 11px; color: #6c757d; }
        .mc-badge { display: inline-block; font-size: 10px; padding: 2px 8px;
                     border-radius: 10px; margin-top: 6px; font-weight: 500; }

        /* Activity & Quick access cards */
        .info-card { background: #fff; border: 1px solid #e9ecef;
                      border-radius: 12px; padding: 1rem 1.1rem; }
        .ic-head { font-size: 13px; font-weight: 500; display: flex;
                    align-items: center; gap: 6px; padding-bottom: .6rem;
                    border-bottom: 1px solid #e9ecef; margin-bottom: .6rem; }
        .ic-head i { font-size: 15px; color: #185fa5; }
        .activity-row { display: flex; align-items: center; gap: 8px;
                          padding: 7px 0; border-bottom: 1px solid #f0f4f8;
                          font-size: 12.5px; }
        .activity-row:last-child { border-bottom: none; padding-bottom: 0; }
        .act-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .quick-row { display: flex; align-items: center; gap: 8px; padding: 7px 0;
                      border-bottom: 1px solid #f0f4f8; cursor: pointer;
                      font-size: 13px; text-decoration: none; }
        .quick-row:last-child { border-bottom: none; }
        .quick-row:hover .qr-text { color: #185fa5; }
        .qr-icon { width: 28px; height: 28px; border-radius: 6px;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 14px; flex-shrink: 0; }
        .qr-text { color: #1a1a19; flex: 1; }

        /* Flash messages */
        .flash-success { background: #eaf3de; border: 1px solid #97c459;
                          border-radius: 8px; padding: .75rem 1rem;
                          font-size: 13.5px; color: #3b6d11; display: flex;
                          align-items: center; gap: 8px; }
        .flash-error   { background: #fcebeb; border: 1px solid #f09595;
                          border-radius: 8px; padding: .75rem 1rem;
                          font-size: 13.5px; color: #a32d2d; display: flex;
                          align-items: center; gap: 8px; }

        /* Footer */
        .footer-main { background: #1e3a5f; padding: .75rem 1.5rem;
                         font-size: 11px; color: #7aa7cc; }
    </style>
    @yield('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar-main d-flex align-items-center justify-content-between">
    <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none">
        <div class="nav-logo"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
            <div class="nav-brand-title">ARU Student System</div>
            <div class="nav-brand-sub">ระบบสารสนเทศนักศึกษา</div>
        </div>
    </a>
    <div class="d-flex gap-1">
        <a href="{{ url('/') }}"
           class="nav-link-main {{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house-fill"></i> หน้าหลัก
        </a>
        <a href="{{ url('/faculties') }}"
              class="nav-link-main {{ request()->is('faculties*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> คณะ
        </a>
        <a href="{{ url('/programs') }}"
              class="nav-link-main {{ request()->is('programs*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> สาขาวิชา
        </a>
        <a href="{{ url('/students') }}"
           class="nav-link-main {{ request()->is('students*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> นักศึกษา
        </a>
        <a href="{{ url('/teachers') }}"
           class="nav-link-main {{ request()->is('teachers*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> อาจารย์
        </a>
        <a href="{{ url('/subjects') }}"
           class="nav-link-main {{ request()->is('subjects*') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i> รายวิชา
        </a>
        <a href="{{ route('subject-teachers.index') }}"
           class="nav-link-main {{ request()->is('subject-teachers*') ? 'active' : '' }}">
            <i class="bi bi-person-video3"></i> กำหนดผู้สอน
        </a>
        {{-- <a href="{{ route('registrations.index') }}"
           class="nav-link-main {{ request()->routeIs('registrations.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-check-fill"></i> ลงทะเบียน
        </a> --}}
    </div>
    <div class="d-flex align-items-center gap-2">
        @if(Auth::guard('teacher')->check())
            <span class="text-white small opacity-75 d-none d-md-inline">
                <i class="bi bi-person-circle me-1"></i>{{ Auth::guard('teacher')->user()->teacher_name }}
            </span>
        @endif
        <a href="{{ route('admin.logout') }}" class="btn-login-nav text-danger">
            <i class="bi bi-box-arrow-right"></i> ออกจากระบบ
        </a>
    </div>
</nav>

{{-- Hero Section (แสดงเฉพาะหน้าแรก) --}}
@hasSection('hero')
<div class="hero-section">
    <div class="hero-deco"></div>
    <div class="hero-deco2"></div>
    <div class="position-relative">
        @yield('hero')
    </div>
</div>
@endif

{{-- Stats Bar (แสดงเฉพาะหน้าแรก) --}}
@hasSection('stats')
<div class="stats-bar">
    <div class="d-flex overflow-auto">
        @yield('stats')
    </div>
</div>
@endif

{{-- Flash Messages --}}
<div class="container-fluid px-4 pt-3">
    @if(session('success'))
    <div class="flash-success mb-3">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash-error mb-3">
        <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
    </div>
    @endif
</div>

{{-- Page Content --}}
<div class="container-fluid px-4 pb-4">
    @yield('content')
</div>

{{-- Footer --}}
<footer class="footer-main d-flex justify-content-between mt-3">
    <span>© {{ date('Y') }} ARU Student Information System</span>
    <span>พัฒนาด้วย Laravel + Bootstrap 5</span>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>