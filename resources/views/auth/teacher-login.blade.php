<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบอาจารย์ - ARU Student System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root { --navy: #1e3a5f; --navy-light: #2c5282; }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            background: #fff; border-radius: 24px; padding: 2.5rem 2.5rem 2rem;
            width: 100%; max-width: 420px; box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        }
        .login-icon {
            width: 70px; height: 70px; border-radius: 50%; background: var(--navy);
            display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;
        }
        .login-icon i { color: #fff; font-size: 2rem; }
        .login-title { text-align: center; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem; }
        .login-subtitle { text-align: center; color: #6c757d; font-size: 0.9rem; margin-bottom: 1.75rem; }
        .form-control { border-radius: 50px; padding: 0.65rem 1.25rem; border: 1px solid #dee2e6; }
        .form-control:focus { border-color: var(--navy); box-shadow: 0 0 0 0.2rem rgba(30, 58, 95, 0.15); }
        .input-group-pill { position: relative; }
        .input-group-pill .form-control { padding-left: 3rem; }
        .input-group-pill i { position: absolute; left: 1.1rem; top: 50%; transform: translateY(-50%); color: var(--navy); z-index: 5; }
        .toggle-password { position: absolute; right: 1.1rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6c757d; z-index: 5; border: none; background: none; }
        .btn-login { background: var(--navy); color: #fff; border-radius: 50px; padding: 0.65rem; font-weight: 600; border: none; width: 100%; transition: background 0.2s; }
        .btn-login:hover { background: var(--navy-light); color: #fff; }
        .alert-pill { border-radius: 16px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <h4 class="login-title">เข้าสู่ระบบอาจารย์</h4>
        <p class="login-subtitle">ARU Student System — Teacher Panel</p>

        @if (session('error'))
            <div class="alert alert-danger alert-pill py-2 px-3 small">
                <i class="bi bi-exclamation-circle-fill me-1"></i>{{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-pill py-2 px-3 small">
                <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('teacher.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label small fw-semibold text-secondary">ชื่อผู้ใช้</label>
                <div class="input-group-pill">
                    <i class="bi bi-person-fill"></i>
                    <input type="text" name="username" id="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" placeholder="กรอกชื่อผู้ใช้" autofocus required>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold text-secondary">รหัสผ่าน</label>
                <div class="input-group-pill">
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="กรอกรหัสผ่าน" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="bi bi-eye-fill" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label small text-secondary" for="remember">จดจำการเข้าสู่ระบบ</label>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('teacher.register.show') }}" class="small text-muted text-decoration-none">
                ยังไม่มีบัญชี? <span class="fw-semibold" style="color:var(--navy);">สมัครสมาชิก</span>
            </a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="small text-muted text-decoration-none">
                <i class="bi bi-arrow-left"></i> กลับหน้าเลือกประเภทผู้ใช้
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        }
    </script>
</body>
</html>