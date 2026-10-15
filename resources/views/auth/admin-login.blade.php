<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบผู้ดูแลระบบ - ARU Student System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --admin-dark: #0f172a;
            --admin-navy: #1e293b;
            --admin-blue: #2563eb;
            --admin-accent: #38bdf8;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1e293b 100%);
            font-family: 'Segoe UI', sans-serif;
            padding: 1.5rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.75rem 2.25rem 2.25rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
            position: relative;
            overflow: hidden;
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #2563eb, #38bdf8, #1e3a5f);
        }
        .login-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #1e3a5f, #0f172a);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            color: #38bdf8;
            font-size: 2.2rem;
            box-shadow: 0 10px 25px rgba(30, 58, 95, 0.3);
        }
        .login-title {
            text-align: center;
            font-weight: 800;
            color: #0f172a;
            font-size: 1.5rem;
            margin-bottom: 0.35rem;
        }
        .login-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1.75rem;
        }
        .form-control {
            border-radius: 50px;
            padding: 0.7rem 1.25rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }
        .input-group-pill {
            position: relative;
        }
        .input-group-pill .form-control {
            padding-left: 3rem;
            padding-right: 2.75rem;
        }
        .input-group-pill i.input-icon {
            position: absolute;
            left: 1.15rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
            z-index: 5;
        }
        .toggle-password {
            position: absolute;
            right: 1.15rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            z-index: 5;
            border: none;
            background: none;
            padding: 0;
        }
        .toggle-password:hover {
            color: #1e293b;
        }
        .btn-login {
            background: linear-gradient(135deg, #1e3a5f, #0f172a);
            color: #fff;
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            width: 100%;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.25);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #2563eb, #1e3a5f);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
        }
        .alert-pill {
            border-radius: 14px;
            font-size: 0.88rem;
        }
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-link a {
            color: #64748b;
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.15s;
        }
        .back-link a:hover {
            color: #0f172a;
        }
        .role-hint {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 0.6rem 0.85rem;
            font-size: 0.8rem;
            color: #475569;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h4 class="login-title">เข้าสู่ระบบผู้ดูแลระบบ</h4>
        <p class="login-subtitle">ARU Student System — Administrator</p>

        @if (session('status'))
            <div class="alert alert-success alert-pill py-2 px-3 small">
                <i class="bi bi-check-circle-fill me-1"></i>{{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-pill py-2 px-3 small">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-pill py-2 px-3 small">
                <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $errors->first() }}
            </div>
        @endif

        <div class="role-hint">
            <i class="bi bi-info-circle-fill text-primary"></i>
            <span>เข้าสู่ระบบด้วยชื่อผู้ใช้อาจารย์ที่มีสิทธิ์ผู้ดูแลระบบ (<strong>t_role = 0</strong>)</span>
        </div>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label small fw-semibold text-secondary">ชื่อผู้ใช้ (Username)</label>
                <div class="input-group-pill">
                    <i class="bi bi-person-fill input-icon"></i>
                    <input type="text" name="username" id="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" placeholder="กรอกชื่อผู้ใช้สำหรับ Admin" autofocus required>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold text-secondary">รหัสผ่าน (Password)</label>
                <div class="input-group-pill">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="กรอกรหัสผ่าน" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()" title="แสดง/ซ่อนรหัสผ่าน">
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

        <div class="back-link">
            <a href="{{ route('home') }}">
                <i class="bi bi-arrow-left me-1"></i> กลับไปยังหน้าแรก
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

