<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบนักศึกษา | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        .login-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .login-icon i { font-size: 1.8rem; color: #2563eb; }
        .form-control {
            border-radius: 50px;
            padding: 0.65rem 1.2rem;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        }
        .input-group .form-control { border-radius: 50px 0 0 50px; }
        .input-group .btn-toggle {
            border-radius: 0 50px 50px 0;
            border: 1px solid #ced4da;
            border-left: none;
            background: #fff;
        }
        .btn-login {
            background: #2563eb;
            border: none;
            border-radius: 50px;
            padding: 0.65rem;
            font-weight: 600;
            color: #fff;
        }
        .btn-login:hover { background: #1e40af; color: #fff; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center">
            <div class="login-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <h4 class="fw-bold text-primary mb-1">เข้าสู่ระบบนักศึกษา</h4>
            <p class="text-muted small mb-4">ARU Student System</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('student.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">รหัสนักศึกษา</label>
                <div class="input-group">
                    <span class="input-group-text" style="border-radius:50px 0 0 50px;"><i class="bi bi-person"></i></span>
                    <input type="text" name="student_id" value="{{ old('student_id') }}"
                           class="form-control" placeholder="กรอกรหัสนักศึกษา" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">รหัสผ่าน</label>
                <div class="input-group">
                    <span class="input-group-text" style="border-radius:50px 0 0 50px;"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password"
                           class="form-control" placeholder="กรอกรหัสผ่าน" required>
                    <button type="button" class="btn btn-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">จดจำการเข้าสู่ระบบ</label>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="small text-muted text-decoration-none">
                <i class="bi bi-arrow-left"></i> กลับหน้าเลือกประเภทผู้ใช้
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye');
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>
