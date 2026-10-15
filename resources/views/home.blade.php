<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
        }
        .hero {
            text-align: center;
            color: #fff;
            padding: 4rem 1rem 2rem;
        }
        .hero .logo-circle {
            width: 90px; height: 90px; border-radius: 50%;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; font-size: 2.2rem;
        }
        .hero h1 { font-weight: 800; font-size: 2.1rem; margin-bottom: 0.4rem; }
        .hero p { opacity: 0.85; font-size: 1rem; }

        .main-wrap {
            flex: 1;
            max-width: 960px;
            margin: 0 auto;
            width: 100%;
            padding: 1rem 1.25rem 3rem;
        }

        .role-card {
            background: #fff;
            border-radius: 22px;
            padding: 2rem 1.75rem;
            height: 100%;
            box-shadow: 0 20px 45px rgba(0,0,0,0.18);
        }
        .role-icon {
            width: 60px; height: 60px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; margin-bottom: 1rem;
        }
        .role-icon.student { background: #dbeafe; color: #2563eb; }
        .role-icon.teacher { background: #fef3c7; color: #b45309; }
        .role-icon.admin   { background: #e0e7ff; color: #1e3a5f; }

        .role-card h5 { font-weight: 700; margin-bottom: 0.4rem; }
        .role-card p.desc { color: #64748b; font-size: 0.88rem; margin-bottom: 1.5rem; min-height: 42px; }

        .btn-role-login {
            border-radius: 50px; padding: 0.6rem; font-weight: 600;
            border: none; width: 100%; margin-bottom: 0.6rem;
        }
        .btn-role-login.student { background: #2563eb; color: #fff; }
        .btn-role-login.student:hover { background: #1e40af; color: #fff; }
        .btn-role-login.teacher { background: #32f586; color: #fff; }
        .btn-role-login.teacher:hover { background: #2faddb; color: #fff; }
        .btn-role-login.admin { background: #2c5d9e; color: #fff; }
        .btn-role-login.admin:hover { background: #16293f; color: #fff; }

        .btn-role-register {
            border-radius: 50px; padding: 0.55rem; font-weight: 600;
            width: 100%; background: #fff; border: 1.5px solid; font-size: 0.9rem;
        }
        .btn-role-register.student { color: #2563eb; border-color: #bfdbfe; }
        .btn-role-register.student:hover { background: #eff6ff; }
        .btn-role-register.teacher { color: #d97706; border-color: #fde68a; }
        .btn-role-register.teacher:hover { background: #fffbeb; }

        footer {
            text-align: center; color: rgba(255,255,255,0.65);
            font-size: 0.82rem; padding-bottom: 1.5rem;
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="logo-circle"><i class="bi bi-mortarboard-fill"></i></div>
        <h1>ARU Student System</h1>
        <p>ระบบสารสนเทศนักศึกษา คณะและหลักสูตร มหาวิทยาลัย</p>
    </div>

    <div class="main-wrap">
        <div class="row g-4">

            {{-- นักศึกษา --}}
            <div class="col-md-4">
                <div class="role-card text-center">
                    <div class="role-icon student mx-auto"><i class="bi bi-person-badge-fill"></i></div>
                    <h5>นักศึกษา</h5>
                    <p class="desc">เข้าสู่ระบบเพื่อลงทะเบียนเรียน ดูผลการเรียน และเกรดเฉลี่ยสะสม</p>

                    <a href="{{ route('student.login') }}" class="btn btn-role-login student">
                        <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
                        {{-- <a href="#" class="btn btn-role-login student">
                        <i class="bi bi-box-arrow-in-right me-1"></i> --}}
                    </a>
                    <a href="{{ route('student.register.show') }}" class="btn btn-role-register student">
                        สมัครสมาชิกนักศึกษาใหม่
                        {{-- <a href="#" class="btn btn-role-register student">
                        สมัครสมาชิกนักศึกษาใหม่ --}}
                    </a>
                </div>
            </div>

            {{-- อาจารย์ --}}
            <div class="col-md-4">
                <div class="role-card text-center">
                    <div class="role-icon teacher mx-auto"><i class="bi bi-person-workspace"></i></div>
                    <h5>อาจารย์</h5>
                    <p class="desc">เข้าสู่ระบบเพื่อกรอกคะแนน ดูรายวิชาที่รับผิดชอบ และจัดการนักศึกษาในรายวิชา</p>

                    <a href="{{ route('teacher.login') }}" class="btn btn-role-login teacher">
                        <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('teacher.register.show') }}" class="btn btn-role-register teacher">
                        สมัครสมาชิกอาจารย์ใหม่
                    </a>
                </div>
            </div>

            {{-- ผู้ดูแลระบบ --}}
            <div class="col-md-4">
                <div class="role-card text-center">
                    <div class="role-icon admin mx-auto"><i class="bi bi-shield-lock-fill"></i></div>
                    <h5>ผู้ดูแลระบบ</h5>
                    <p class="desc">เข้าสู่ระบบเพื่อจัดการข้อมูลคณะ สาขาวิชา นักศึกษา และอาจารย์ทั้งหมด</p>
                    <a href="{{ route('admin.login') }}" class="btn btn-role-login admin">
                        <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบผู้ดูแลระบบ
                    </a>
                </div>
            </div>

        </div>
    </div>

    <footer>
        &copy; {{ date('Y') + 543 }} ARU Student System — ระบบสารสนเทศนักศึกษา
    </footer>

</body>
</html>